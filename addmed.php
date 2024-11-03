<?php 
include "session-code.php";
$pagename = "medhub";
include "base-top.php";
$_SESSION["addmed-token"] = random_int(10000000, 99999999);
?>

<h1 class="main-text">Add Medication</h1>
<p class="main-text">Please enter details below to add a medicine to your profile.</p>
<form id="login" method="POST" action="addmed-process.php">
    <input type="hidden" name="token" value="<?php echo $_SESSION["addmed-token"] ?>">
    <label for="username">Medication Name:</label>
    <input type="text" id="medname" name="medname" required>
    <label for="dosage">Dosage Taken Each Time:</label>
    <input type="text" id="dosage" name="dosage" required>
    <label for="frequency-number">Taken Every:</label>
    <div id="frequency" class="d-flex">
        <input type="text" id="frequency-number" class="me-2" name="frequency-number" required>
        <select id="frequency-type" name="frequency-type">
            <option value="0" selected>Hours(s)</option>
            <option value="1">Day(s)</option>
            <option value="2">Week(s)</option>
            <option value="3">Month(s)</option>
            <option value="4">Year(s)</option>
        </select>
    </div>
    <div class="d-flex justify-content-center mt-5">
        <input class="blue-button me-4" type="submit" value="Add">
        <input class="blue-button ms-4" type="reset">
    </div>
</form>

<?php
include "base-bottom.php";

?>