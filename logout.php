<?php 
include "session-code.php";
$pagename = "logout";
include "base-top.php";
$_SESSION["logout-token"] = random_int(10000000, 99999999);
?>

<h1 class="main-text">Logout</h1>
<p class="main-text">Are you sure you want to logout?</p>
<form id="login" method="POST" action="logout-process.php">
    <input type="hidden" name="token" value="<?php echo $_SESSION["logout-token"] ?>">
    <div class="d-flex justify-content-center mt-5">    
        <input class="blue-button" type="submit" value="Logout">
    </div>
</form>

<?php
include "base-bottom.php";

?>