<?php

// Include files to generate webpage: ensure session is started then include header, main and footer HTML sections.

include "session-code.php";

$pagename = "medhub"; 
include "base-top.php"; 

include "medhub-section.php";
    
include "base-bottom.php";