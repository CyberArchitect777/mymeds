<?php

include "session-code.php";

$pagename = "medhub";

$drugs_output = ""; // Variable to hold HTML information for output to webpage.

function returnCard($name, $dosage, $frequency_type, $frequency_number, $last_taken) {
    $frequency_text = "";
    switch($frequency_type) {
        case 0:
            $frequency_text = "hours";
            break;
        case 1:
            $frequency_text = "days";
            break;
        case 2:
            $frequency_text = "weeks";
            break;
        case 3:
            $frequency_text = "months";
            break;
    }
    return '
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">' . $name . '</h5>
                <p class="card-text text-center">Dosage: ' . $dosage . '</p>
                <p class="card-text text-center">Taken Every: ' . (string)$frequency_number . " " . $frequency_text . '</p>
                <p class="card-text text-center">Last Taken: ' . ($last_taken == "" ? "Not known" : $last_taken) . '</p>
                <div class="d-flex justify-content-between">
                    <a href="#" class="btn btn-primary">Edit</a>
                    <a href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    ';
}

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
        $drugs_output .= '<div class="d-flex justify-content-center flex-wrap">' . returnCard($first_row["medication_name"], $first_row["dosage"], $first_row["frequency_type"], $first_row["frequency_number"], $first_row["last_taken"] );
        while ($more_rows = $drugs_pull->fetch(PDO::FETCH_ASSOC)) { // Go through all remaining rows
            $drugs_output .= returnCard($more_rows['medication_name'], $more_rows['dosage'], $first_row["frequency_type"], $first_row["frequency_number"], $first_row["last_taken"]);
        }
        $drugs_output .= "</div>";
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
