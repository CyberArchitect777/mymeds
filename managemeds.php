<?php

// Include files to generate webpage: ensure session is started then include header, main and footer HTML sections.

include "session-code.php";

$pagename = "managemeds"; 
include "base-top.php"; 

include "managemeds-section.php";
    
include "base-bottom.php";