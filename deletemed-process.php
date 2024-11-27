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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["token"] == $_SESSION["managemeds-token"]) { // Confirm the request came from the right page
            $med_id = str_replace("medboxid", "", $_POST["medboxid"]);
            print("MedID" . $med_id);
                
            // Delete the medication record from the database

            $medication_delete = $pdo->prepare("DELETE FROM medication WHERE user_id = :user_id AND medication_id = :med_id;");
            $medication_delete->execute(["user_id" => $_SESSION["user_id"], "med_id" => $med_id]);
        } else {
            redirectToIndex(); // If the form is not where the request came from, redirect to index
        }
    } else {
        redirectToIndex();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$pagename = "managemeds"; // Set a variable so that the navbar knows which section the user is on

// Show the page elements

include "base-top.php";

include "managemeds-section.php";

include "base-bottom.php";
