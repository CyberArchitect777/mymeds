<?php

include "session-code.php";

// Ensure errors are not displayed on the page, but can be seen in logs
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Set variable so the navbar shows what section the user is in on the site
$pagename = "index"; 

// Display the header, main and footer files in order

include "base-top.php"; 

include "index-section.php";
    
include "base-bottom.php";