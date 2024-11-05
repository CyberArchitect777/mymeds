<?php 

$pagename = "register"; // Section identification for user display
$_SESSION["register-token"] = random_int(10000000, 99999999); // Calculate a login token for use in PHP source authentication
?>

<h1 class="main-text">Register</h1>
<p class="main-text">Please register for a new account using the form below.</p>
<form id="register" onsubmit="return registerFormCheck()" method="POST" action="register-process.php">
    <input type="hidden" name="token" value="<?php echo $_SESSION["register-token"] ?>">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <label for="confirm-password">Confirm Password:</label>
    <input type="password" id="confirm-password" name="confirm-password" required>
    <div class="d-flex justify-content-center mt-5">
        <input class="blue-button me-4" type="submit" value="OK">
        <input class="blue-button ms-4" type="reset">
    </div>
</form>