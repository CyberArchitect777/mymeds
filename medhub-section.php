<?php

include "session-code.php";

$pagename = "medhub";

$drugs_output = ""; // Variable to hold HTML information for output to webpage.

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

    $current_id = $_SESSION["user_id"];
    // Pull all medication from the database for the logged in user
    $drugs_pull = $pdo->prepare("SELECT * FROM medication WHERE user_id = :current_id GROUP BY medication.medication_id");
    $drugs_pull->execute(["current_id" => $current_id]);
    $first_row = $drugs_pull->fetch(PDO::FETCH_ASSOC); // Pull first row only just to check there is an initial record
    if ($first_row == false) {
        $drugs_output = '<p class="main-text">No medication is on record</p>';
    } else {
        $drugs_output = "<div class='d-flex justify-content-center'><ul>";
        $drugs_output .= "<li class='rowdata'>" . "Medication: " . $first_row["medication_name"] . " - Dose: " . $first_row["dosage"] . "</li>";
        while ($more_rows = $drugs_pull->fetch(PDO::FETCH_ASSOC)) { // Go through all remaining rows
            $medication_name = $more_rows['medication_name'];
            $medication_dosage = $more_rows['dosage'];
            $drugs_output .= "<li class='rowdata'>" . "Medication: " . $medication_name . " - Dose: " . $medication_dosage . "</li>";
        }
        $drugs_output .= "</ul></div>";
    }
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<h1 class="main-text">Welcome to your MedHub</h1>
<h2 class="main-text">You can manage your medication below</h2>
<section id="drugs-display" class="mx-auto mt-5">
    <div class="d-flex justify-content-center align-items-center mb-5">
        <a class="d-flex justify-content-center align-items-center blue-button large-button" href="addmed.php">Add Medication</a>
    </div>
    <?php echo $drugs_output; // Output HTML code generated in the above section ?>
</section>
