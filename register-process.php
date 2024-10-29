<?php

include "base-top.php";
include "errorlog.php";

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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["username"])) {
            $new_username = $_POST["username"];
            $new_password = $_POST["password"];
            
            $confirm_password = $_POST["confirm-password"];
            if ($new_password !== $confirm_password) {
                echo "<p id='register-alert'>Passwords don't match. Please try again</p>";
                include "register-section.php";
            } else {
                
                // Check if username doesn't already exist
                
                $username_check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
                $username_check->execute(["username" => $new_username]);
                $username_count = $username_check->fetchColumn();

                if ($username_count > 0) {
                    echo "<p class='text-white' id='register-alert'>Username already exists</p>";
                    include "register-section.php";
                } else {
                    #PASSWORD_DEFAULT selects the most up to date hashing algorithm
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); 
                    $insert_query = $pdo->prepare("INSERT INTO users (username, password) VALUES (:new_username, :hashed_password);");
                    $insert_query->execute( ["new_username"=> $new_username, "hashed_password" => $hashed_password]);
                    echo "<p class='text-white'>New user account created</p>";
                }   
            }
        }
        else {
            echo "<p>Username field missing</p>";
        }
    }
    else {
        echo "<p>No form data detected</p>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

include "base-bottom.php";