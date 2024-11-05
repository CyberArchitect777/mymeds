<?php

function redirectToIndex() {
    // Redirect to the index page and exit the calling script
    header("Location: index.php");
    exit();
}

function writeConsole($message) {
    // Write a JavaScript console entry
    echo "<script>console.log('" . $message . "');</script>";
}

function writeAlert($message) {
    // Create a JavaScript popup alert
    echo "<script>alert('" . $message . "');</script>";
}