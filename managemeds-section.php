<?php

include "session-code.php";

$pagename = "managemeds";

$drugs_output = ""; // Variable to hold HTML information for output to webpage.

// Create a random token for form verification later
$_SESSION["managemeds-token"] = random_int(10000000, 99999999);

function returnCard($medication_id, $name, $dosage, $frequency_type, $frequency_number, $last_taken) {
    $frequency_text = "";
    switch($frequency_type) {
        case 0:
            $frequency_text = "hour";
            break;
        case 1:
            $frequency_text = "day";
            break;
        case 2:
            $frequency_text = "week";
            break;
        case 3:
            $frequency_text = "month";
            break;
        case 4:
            $frequency_text = "year";
            break;
    }
    if ($frequency_number != 1) {
            $frequency_text .= "s";
    }
    return '
        <!-- Delete medication item modal -->
        <section class="modal" id="delete-med-item" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Medication Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Are you sure you want to delete this medication item?</p>
                    </div>
                    <div class="modal-footer">
                        <!-- PHP performs the delete function if yes is pressed -->
                        <form class="mx-auto" action="deletemed-process.php" method="POST">
                            <input type="hidden" name="token" value="' . $_SESSION["managemeds-token"] . '">
                            <input type="hidden" name="medboxid" id="medboxid" value="medboxid' . (string)$medication_id . '">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">' . $name . '</h5>
                <p class="card-text text-center">Dosage: ' . $dosage . '</p>
                <p class="card-text text-center">Taken Every: ' . (string)$frequency_number . " " . $frequency_text . '</p>
                <p class="card-text text-center">Last Taken: ' . ($last_taken == "" ? "Not known" : $last_taken) . '</p>
                <form class="mt-4 d-flex justify-content-between" method="POST" action="managemeds-process.php">
                    <input type="hidden" name="token" value="' . $_SESSION["managemeds-token"] . '">
                    <input type="submit" name="medboxbutton" value="Edit" class="btn-fixed-width btn btn-success">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#delete-med-item" class="btn-fixed-width btn btn-danger">Delete</a>
                    <input type="hidden" name="medboxid" id="medboxid" value="medboxid' . (string)$medication_id . '">
                </form>
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
        $drugs_output .= '<div class="d-flex justify-content-center flex-wrap mb-4">' . returnCard($first_row["medication_id"], $first_row["medication_name"], $first_row["dosage"], $first_row["frequency_type"], $first_row["frequency_number"], $first_row["last_taken"] );
        while ($more_rows = $drugs_pull->fetch(PDO::FETCH_ASSOC)) { // Go through all remaining rows
            $drugs_output .= returnCard($more_rows["medication_id"], $more_rows["medication_name"], $more_rows["dosage"], $more_rows["frequency_type"], $more_rows["frequency_number"], $more_rows["last_taken"]);
        }
        $drugs_output .= "</div>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<h1 class="main-text">MyMeds Medication Management</h1>
<h2 class="main-text">You can add, change or remove individual medications below</h2>
<section id="drugs-display" class="mx-auto mt-5">
    <div class="d-flex justify-content-center align-items-center mb-5">
        <a class="d-flex justify-content-center align-items-center blue-button large-button" href="medhub.php">Return to MedHub</a>
    </div>
    <?php echo $drugs_output; // Output HTML code generated in the above section ?>
</section>
