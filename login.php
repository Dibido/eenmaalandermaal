<?php

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');


/* Backend for logging in an admin user */

$errorMessage = [False];
$successMessage = [False];

//testing if the user tried to login, or only accessed the page
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["formSend"]) && $_POST["formSend"] == 'True') {

        $username = $_POST["username"];
        $password = $_POST["password"];

        //form validation
        if (isset($username) AND !empty($username)) {
            if (isset($password) AND !empty($password)) {
                //finding a user with the given username
                $foundUser = FindUser($username)[0];

                if (isset($foundUser) AND !empty($foundUser)) {
                    //if found, checking the password
                    $foundPassword = CheckCredentials($username, $password);
                    if ($foundPassword) {
                        session_start();
                        $_SESSION["Username"] = $foundUser;
                        echo 'U bent ingelogd';
                    } else {
                        $errorMessage = [True, 'Incorrect wachtwoord voor gebruiker: ' . $foundUser];
                    }
                } else {
                    $errorMessage = [True, 'Onbekende gebruiker: ' . $username];
                }
            } else {
                $errorMessage = [True, 'Geef alstublieft een wachtwoord op.'];
            }
        } else {
            $errorMessage = [True, 'Geef alstublieft een gebruikersnaam op.'];
        }
    }
}


/* checking if the user just came back from beheer/index.php or logged out*/
if (isset($_GET["noLogin"]) && ($_GET["noLogin"] == 'True')) {
    $errorMessage = [True, 'Inloggen is vereist voor het bezoeken van de beheerpagina.'];
} else if (isset($_GET["loggedOut"]) && $_GET["loggedOut"] == 'TRUE') {

    //delete the session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    unset($_SESSION['adminUsername']);
    session_destroy();
    session_commit();
    $successMessage = [True, 'Successvol uitgelogged.'];
}


?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>EenmaalAndermaal - Beste veilingssite van Nederland</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="Iproject - Groep 3">


    <!-- Theme colours for mobile -->

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#F6D155">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#F6D155">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#F6D155">


    <!-- setting the browser icon -->
    <link rel="icon" href="images/Site-logo.png">


    <!-- bootstrap !-->


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <link rel="stylesheet" href="CSS/BootstrapXL.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/BeheerLogin.css">


</head>

<body>

<?php
include "navbar.php";
?>


<!-- Login form -->
<div class="col-xs-10 col-xs-push-1 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4 center-block" id="loginWrapper">
    <div class="panel panel-default" id="loginPanel">
        <div class="panel-heading">
            EeemaalAndermaal login
        </div>
        <div class="panel-body">
            <form action="login.php" method="POST">

                <!-- gebruikersnaam input -->

                <div class="form-group">
                    <div class="input-group">
                        <input name="username" type="text" class="form-control" placeholder="gebruikersnaam" required>
                        <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                    </div>
                </div>

                <!-- Wachtwoord input -->

                <div class="form-group">
                    <div class="input-group">
                        <input name="password" type="password" class="form-control" placeholder="wachtwoord" required>
                        <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                    </div>
                </div>

                <!-- hidden input so no allerts are send when the page is first loaded -->
                <input type="hidden" name="formSend" value="True">

                <!-- login button -->

                <button type="submit" class="btn btn-primary" id="loginButton">Log in</button>

                <!-- Alerts -->

                <?php

                /* checking if any alerts of success messages need to be displayed */
                if ($errorMessage[0]) {

                    echo "<div class=\"alert alert-danger alert-dismissable\">
                             <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                             <strong>Error!</strong> " . $errorMessage[1] . "
                          </div>";

                } else if ($successMessage[0]) {
                    echo "<div class=\"alert alert-success alert-dismissable\">
                             <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                             <strong>Success!</strong> " . $successMessage[1] . "
                          </div>";
                }

                ?>
            </form>
            <hr>
            <p class="text-center">Wilt u een account aanmaken? Klik dan <a href="registreer1.php">hier</a>.</p>
        </div>
    </div>
</div>


</body>