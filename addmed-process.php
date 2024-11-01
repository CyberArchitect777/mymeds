<?php

include "session-code.php";

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
        $med_name = $_POST["medname"];
        $med_dosage = $_POST["dosage"];
        $frequency_number = $_POST["frequency-number"];
        $frequency_type = $_POST["frequency-type"];
            
        // Pull the password for this user account from the database

        $medication_add = $pdo->prepare("INSERT INTO medication (medication_name, dosage, user_id, frequency_type, frequency_number) VALUES (:medname, :med_dosage, :user_id, :frequency_number, :frequency_type);");
        $medication_add->execute(["medname" => $med_name, "med_dosage" => $med_dosage, "user_id" => $_SESSION["user_id"], "frequency_number" => $frequency_number, "frequency_type" => $frequency_type]);
    }
    else {
        echo "<p>No form data detected</p>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$pagename = "medhub";

include "base-top.php";

include "medhub-section.php";

include "base-bottom.php";
