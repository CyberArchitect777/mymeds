<h1 class="main-text">Welcome to MyMeds</h1>
<h2 class="main-text">Your companion for managing and tracking your essential medications effortlessly</h2>
<p class="main-text">Please choose an option below to continue</p>
<section class="d-flex justify-content-center mt-5">
    <?php 
    // If user_id detected, show logged in elements. Otherwise, show logged out elements
    if (isset($_SESSION["user_id"])) {
        echo '
        <a class="blue-button me-3" href="medhub.php">MedHub</a>
        <a class="blue-button ms-3" href="logout.php">Logout</a>
        ';
    } else {
        echo '
        <a class="blue-button me-3" href="login.php">Login</a>
        <a class="blue-button ms-3" href="register.php">Register</a>
        ';
    }
    ?>
</section>