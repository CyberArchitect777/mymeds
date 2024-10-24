<?php

include "base-top.php";

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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (! isset($_POST["username"]) || ! isset($_POST["password"])) {
            $error_code = 1; 
        }
        else {
            $passed_username = $_POST["username"];
            $passed_password = $_POST["password"];
            
            // Check if login information given matches what is in the database

            $login_check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :passed_username AND password = :passed_password");
            $login_check->execute(["passed_username" => $passed_username, "passed_password" => $passed_password]);
            $login_count = $login_check->fetchColumn();

            if ($login_count > 0) {
                echo "<p class='text-white'>Correct user account detected</p>";
            } else {
                echo "<p class='text-white'>Incorrect login details</p>";
            }   
        }
    }
    else {
        echo "<p>No form data detected</p>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

include "base-bottom.php";