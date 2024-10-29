<?php

try {

    // Connect to the database

    // Database connection variables
    $database_dsn = getenv("DB_DSN");
    $database_username = getenv("DB_USER");
    $database_password = getenv("DB_PASSWORD");

    // Create a PHP data object for the database
    $pdo = new PDO($database_dsn, $database_username, $database_password);

    // Set error mode to exception to handle errors properly
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set an error variable to 0 to assume no initial errors

    $error_code = 0;
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (! isset($_POST["username"]) || ! isset($_POST["password"])) {
            $error_code = 1;
        }
        else {
            $passed_username = $_POST["username"];
            $passed_password = $_POST["password"];
            
            // Pull the password for this user account from the database

            $account_pull = $pdo->prepare("SELECT user_id, password FROM users WHERE username = :passed_username");  
            $account_pull->execute(["passed_username" => $passed_username]);

            while ($row = $account_pull->fetch(PDO::FETCH_ASSOC)) {
                $password_hash = $row['password'];
                $user_id = $row['user_id'];
            }

            // Check if login information given matches what is in the database

            if (password_verify($passed_password, $password_hash )) {
                // Re-hash password with new default algorithm if it's needed
                if (password_needs_rehash($password_hash, PASSWORD_DEFAULT)) {
                    $new_password_hash = password_hash($passed_password, PASSWORD_DEFAULT);
                    $insert_query = $pdo->prepare("UPDATE users SET password = :passed_password WHERE username = :passed_username;");
                    $insert_query->execute( ["passed_username"=> $passed_username, "passed_password" => $passed_password]);
                }
                session_start();
                $_SESSION["user_id"] = $user_id;
                $message = "<p class='text-white'>Correct user account detected: " . (string)$user_id . "</p>";
            } else {
                $message = "<p class='text-white'>Incorrect login details</p>";
            }
        }
    }
    else {
        echo "<p>No form data detected</p>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

include "base-top.php";

echo $message;

include "base-bottom.php";
