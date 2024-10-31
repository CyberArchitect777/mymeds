<?php

include "session-code.php";

$pagename = "medhub";

$drugs_output = "";

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
    $drugs_pull = $pdo->prepare("SELECT * FROM medication WHERE user_id = :current_id GROUP BY medication.medication_id");
    $drugs_pull->execute(["current_id" => $current_id]);
    $first_row = $drugs_pull->fetch(PDO::FETCH_ASSOC);
    if ($first_row == false) {
        $drugs_output = '<p class="main-text">No medication is on record</p>';
    } else {
        $drugs_output = "<ul>";
        $drugs_output += "<li>" . $first_row['medication_name'] . " - " . (string)$first_row["dosage"] . "</li>";
        while ($more_rows = $drugs_pull->fetch(PDO::FETCH_ASSOC)) {   
            $medication_name = $more_rows['medication_name'];
            $medication_dosage = $more_rows['dosage'];
            $drugs_output += "<li>" . $medication_name . " - " . (string)$medication_dosage . "</li>";
        }
        $drugs_output = "</ul>";
    }
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<main>
    <h1 class="main-text">Welcome to your MedHub</h1>
    <h2 class="main-text">You can manage your medication below</h2>
    <section id="drugs-display" class="mx-auto mt-5">
        <div class="d-flex justify-content-center align-items-center">
            <a class="d-flex justify-content-center align-items-center blue-button large-button" href="addmed.php">Add Medication</a>
        </div>
        <?php echo $drugs_output ?>
    </section>
</main>