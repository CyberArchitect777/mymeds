<?php

session_unset(); // Unsets all session variables
session_destroy(); // Ends the user session

include "session-code.php";

$pagename = "logout";

include "base-top.php";

echo "You have been logged out";

include "base-bottom.php";
