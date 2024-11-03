<?php

function redirectToIndex() {
    header("Location: index.php");
    exit();
}

function writeConsole($message) {
    echo "<script>console.log('" . $message . "');</script>";
}

function writeAlert($message) {
    echo "<script>alert('" . $message . "');</script>";
}