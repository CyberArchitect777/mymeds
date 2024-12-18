<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>MyMeds</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">MyMeds</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($pagename === 'index') { echo 'active'; } ?>" aria-current="page" href="index.php">Home</a>
                        </li>
                        <?php
                        if (isset($_SESSION["user_id"]) == false) {
                            echo '
                            <li class="nav-item">
                                <a class="nav-link ' . ($pagename === "login" ? "active" : "") . '" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ' . ($pagename === "register" ? "active" : "") . '" href="register.php">Register</a>
                            </li>';
                        } else {
                            echo '
                            <li class="nav-item">
                                <a class="nav-link ' . ($pagename === "medhub" ? "active" : "") . '" href="medhub.php">MedHub</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ' . ($pagename === "logout" ? "active" : "") . '" href="logout.php">Logout</a>
                            </li>';
                        } ?> 
                    </ul>
                </div>
            </div>
        </nav>
        <div class="d-flex justify-content-center align-items-center" id="login-status">
            <?php
            if (isset($_SESSION["user_id"]) == false) {
                echo "<p>Not logged in</p>";
            } else {
                echo "<p>Signed in as " . $_SESSION["username"] . "</p>";
            }
            ?>
        </div>
    </header>
    <main>