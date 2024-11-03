<h1 class="main-text">Login</h1>
<p class="main-text">Please log in to your account using the form below.</p>
<form id="login" method="POST" action="login-process.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <div class="d-flex justify-content-center mt-5">
        <input class="blue-button me-4" type="submit" value="OK">
        <input class="blue-button ms-4" type="reset">
    </div>
</form>