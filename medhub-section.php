<?php

include "session-code.php";

$pagename = "medhub";

$drugs_output = ""; // Variable to hold HTML information for output to webpage.

// Create a random token for form verification later
//$_SESSION["medhub-token"] = random_int(10000000, 99999999);

$all_drugs_to_take = array(); // Array to hold all upcoming medication requirements

function populateMedicationSchedule($all_drugs_to_take) {
    $full_medication_schedule = array();
    foreach ($all_drugs_to_take as $single_drug) {
        if (is_null($single_drug["last_taken"])) {
            $single_drug["last_taken"] = time();
        }
        $finish_flag = false;
        $start_time = $single_drug["last_taken"];
        if (! isset($single_drug["next_dose"])) {
            $single_drug["next_dose"] = $single_drug["last_taken"];
        }
        array_push($full_medication_schedule, $single_drug);
        while ($finish_flag == true) {
            switch($single_drug["frequency_type"]) {
                case 0:
                    $single_drug["next_dose"] += 3600; // Add an hour in seconds
                    break;
                case 1:
                    $single_drug["next_dose"] += 86400; // Add a day in seconds
                    break;
                case 2:
                    $single_drug["next_dose"] += 604800; // Add a week in seconds
                    break;
                case 3:
                    $single_drug["next_dose"] = strtotime("+1 month", $single_drug["next_dose"]);
                    break;
                case 4:
                    $single_drug["next_dose"] = strtotime("+1 year", $single_drug["next_dose"]);
                    break;
            }
            array_push($full_medication_schedule, $single_drug);
            if ($start_time < strtotime("-7 days", $single_drug["next_dose"])) {
                $finish_flag = true;
            }
        }
    }
    return $full_medication_schedule;
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
        $drugs_output = '<p class="main-text">No medication schedule is on record</p>';
    } else {
        $first_drug = array("medication_name" => $first_row["medication_name"], "dosage" => $first_row["dosage"], "frequency_type" => $first_row["frequency_number"], "last_taken" => $first_row["last_taken"]);
        array_push($all_drugs_to_take, $first_drug);
        while ($more_rows = $drugs_pull->fetch(PDO::FETCH_ASSOC)) { // Go through all remaining rows
            $more_drugs = array("medication_name" => $more_rows["medication_name"], "dosage" => $more_rows["dosage"], "frequency_type" => $more_rows["frequency_number"], "last_taken" => $more_rows["last_taken"]);
            array_push($all_drugs_to_take, $more_drugs);
        }
        $medication_schedule = populateMedicationSchedule($all_drugs_to_take);
        // Sorts the array using the function. The spaceship operator returns -1 if value_a is smaller than value_b. 
        // 0 if they are the same and 1 if value_b is smaller than value_a. Usort then sorts the array by next_dose
        usort($medication_schedule, function ($value_one, $value_two) { return $value_one["next_dose"] <=> $value_two["next_dose"]; });
        $drugs_output .= "<ul id='med-schedule'>";
        foreach ($medication_schedule as $medication_dose) {
            $drugs_output .= "<li class='fg-white'>" . $medication_dose["medication_name"] . " - " . $medication_dose["next_dose"] . "</li>";
        }
        $drugs_output .= "</ul>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<h1 class="main-text">Welcome to your MedHub</h1>
<h2 class="main-text">You can manage your medication below</h2>
<section id="drugs-display" class="mx-auto mt-5">
    <div class="d-flex justify-content-center align-items-center mb-5">
        <a class="d-flex justify-content-center align-items-center blue-button large-button" href="managemeds.php">Manage Medication</a>
    </div>
    <h3 class="text-center fg-white mb-4">Medication Schedule</h3>
    <?php echo $drugs_output; // Output HTML code generated in the above section ?>
</section>
