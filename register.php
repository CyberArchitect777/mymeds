<?php 
$pagename = "register";
include "base-top.php"; 
include "register-alert.html";

?>

<h1 class="main-text">Register</h1>
<p class="main-text">Please register for a new account using the form below.</p>
<form id="register" onsubmit="registerFormCheck()" method="POST" action="register-process.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <label for="confirm-password">Confirm Password:</label>
    <input type="password" id="confirm-password" name="confirm-password">
    <div class="d-flex justify-content-center mt-5">
        <input class="blue-button me-4" type="submit" value="OK">
        <input class="blue-button ms-4" type="reset">
    </div>
</form>
<?php include "base-bottom.php"; ?>