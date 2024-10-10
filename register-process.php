<?php

include "base-top.php";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["username"])) {
            $new_username = $_POST["username"];
            $new_password = $_POST["password"];

            // Database connection variables
            $database_dsn = getenv("DB_DSN");
            $database_username = getenv("DB_USER");
            $database_password = getenv("DB_PASSWORD");

            // Create a PHP data object for the database)
            $pdo = new PDO($database_dsn, $database_username, $database_password);

            // Set error mode to exception to handle errors properly
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL query
            //$sql_query = "SELECT * FROM users WHERE username = " . $new_usename . ";";
            $sql_query = "SELECT * FROM users;";
            
            // Execute query
            $query_outcome = $pdo->query($sql_query);

            // Fetch and display the results
            while ($row = $query_outcome->fetch(PDO::FETCH_ASSOC)) {
                echo "<p>Username: " . $row['username'] . "<br><p>";
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