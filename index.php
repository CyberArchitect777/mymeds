<?php

include "session-code.php";

// Ensure errors are not displayed on the page, but can be seen in logs
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

$pagename = "index"; 
include "base-top.php"; 

include "index-section.php";
    
include "base-bottom.php";