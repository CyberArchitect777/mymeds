<?php

include "session-code.php";

// Ensure errors are not displayed on the page, but can be seen in logs
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

$pagename = "index"; 
include "base-top.php"; 
?>
    <main>
        <h1 class="main-text">Welcome to MyMeds</h1>
        <h2 class="main-text">Your companion for managing and tracking your essential medications effortlessly</h2>
        <p class="main-text">Please sign-in or register to continue</p>
        <section class="d-flex justify-content-center mt-5">
            <a class="blue-button me-3" href="#">Login</a>
            <a class="blue-button ms-3" href="register.php">Register</a>
        </section>
    </main>
<?php include "base-bottom.php"; ?>