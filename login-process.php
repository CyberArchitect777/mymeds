<?php

include "session-code.php"; // Start new session if one hasn't been
include "utility.php"; // Utility class containing stand-alone functions useful in all code

try {

    // Connect to the database

    // Database connection variables
    $database_dsn = getenv("DB_DSN");
    $database_username = getenv("DB_USER");
    $database_password = getenv("DB_PASSWORD");

    // Create a PHP data object for the database
    $pdo = new PDO($database_dsn, $database_username, $database_password);

    // Set error mode to exception in order to handle errors properly
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set an error variable to 0 to assume no initial errors

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if ($_POST["token"] == $_SESSION["login-token"]) { // If POST data came from the correct form
            if (isset($_POST["username"]) || isset($_POST["password"])) {
                $passed_username = $_POST["username"];
                $passed_password = $_POST["password"];
                
                // Pull the password for this user account from the database

                $account_pull = $pdo->prepare("SELECT user_id, password FROM users WHERE username = :passed_username");  
                $account_pull->execute(["passed_username" => $passed_username]);

                while ($row = $account_pull->fetch(PDO::FETCH_ASSOC)) {
                    // Acquire the password and user_id
                    $password_hash = $row['password'];
                    $user_id = $row['user_id'];
                }

                // Check if login information given matches what is in the database by verifying the password against the hash

                if (password_verify($passed_password, $password_hash )) {
                    // Re-hash password with new default algorithm if it's needed
                    if (password_needs_rehash($password_hash, PASSWORD_DEFAULT)) {
                        $new_password_hash = password_hash($passed_password, PASSWORD_DEFAULT);
                        // And then update it in the database
                        $insert_query = $pdo->prepare("UPDATE users SET password = :passed_password WHERE username = :passed_username;");
                        $insert_query->execute( ["passed_username"=> $passed_username, "passed_password" => $passed_password]);
                    }
                    // Set user variables
                    $_SESSION["user_id"] = $user_id;
                    $_SESSION["username"] = $passed_username;
                } else {
                    // If wrong password, inform the user of the incorrect login details
                    $message = "<p class='text-white'>Incorrect login details</p>";
                }
            }
        } else {
            redirectToIndex(); // Redirect back to the index page after an error
        }
    }
    else {
        redirectToIndex();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_SESSION["user_id"])) { // If the user is logged in, load MedHub. If not, the login form.
    $pagename = "medhub";
    include "base-top.php";
    include "medhub-section.php";
} else {
    $pagename = "login";
    include "base-top.php";
    echo '<p id="register-alert">Incorrect username/password entered</p>';
    include "login-section.php";
    $pagename = "login";
}
 
include "base-bottom.php";
