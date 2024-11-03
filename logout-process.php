<?php

include "session-code.php";
include "utility.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["token"] == $_SESSION["logout-token"]) {
        session_unset(); // Unsets all session variables
        session_destroy(); // Ends the user session
        $pagename = "index";
        include "base-top.php";
        include "index-section.php";
        include "base-bottom.php";
    } else {
        redirectToIndex();
    }
} else {
    redirectToIndex();
}
