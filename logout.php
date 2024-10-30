<?php 
include "session-code.php";
$pagename = "logout";
include "base-top.php";
?>

<h1 class="main-text">Logout</h1>
<p class="main-text">Are you sure you want to logout?</p>
<form id="login" method="POST" action="logout-process.php">
    <div class="d-flex justify-content-center mt-5">
        <input class="blue-button me-4" type="submit" value="Logout">
    </div>
</form>

<?php
include "base-bottom.php";

?>