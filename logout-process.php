<?php

include "session-code.php";

session_unset(); // Unsets all session variables
session_destroy(); // Ends the user session

$pagename = "index";

include "base-top.php";

include "index-section.php";

include "base-bottom.php";
