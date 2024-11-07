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
        if ($_POST["token"] == $_SESSION["addmed-token"]) { // Confirm the request came from the right form
            $med_name = $_POST["medname"];
            $med_dosage = $_POST["dosage"];
            $frequency_number = $_POST["frequency-number"];
            $frequency_type = $_POST["frequency-type"];
                
            // Insert the medication form data into the database

            $medication_add = $pdo->prepare("INSERT INTO medication (medication_name, dosage, user_id, frequency_number, frequency_type) VALUES (:medname, :med_dosage, :user_id, :frequency_number, :frequency_type);");
            $medication_add->execute(["medname" => $med_name, "med_dosage" => $med_dosage, "user_id" => $_SESSION["user_id"], "frequency_number" => $frequency_number, "frequency_type" => $frequency_type]);
        } else {
            redirectToIndex(); // If the form is not where the request came from, redirect to index
        }
    } else {
        redirectToIndex();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$pagename = "medhub"; // Set a variable so that the navbar knows which section the user is on

// Show the page elements

include "base-top.php";

include "medhub-section.php";

include "base-bottom.php";
