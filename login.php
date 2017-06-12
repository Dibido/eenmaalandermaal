<?php
session_start();
require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

/* Backend for logging in an admin user */

$errorMessage = [False];
$successMessage = [False];

//testing if the user tried to log in, or only accessed the page
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["formSend"]) && $_POST["formSend"] == 'True') {

        $username = $_POST["username"];
        $password = $_POST["password"];

        //form validation
        if (isset($username) AND !empty($username)) {
            if (isset($password) AND !empty($password)) {
                //finding a user with the given username
                $foundUser = FindUser($username);

                if (isset($foundUser[0]) AND !empty($foundUser[0])) {
                    //checking if the user is active
                    if($foundUser["GEB_actief"]){
                        //if found, checking the password
                        $foundPassword = CheckCredentials($username, $password);
                        if ($foundPassword) {
                            $_SESSION["Username"] = $foundUser[0];
                            header('Location: index.php');
                        } else {
                            $errorMessage = [True, 'Incorrect wachtwoord voor gebruiker: ' . $foundUser[0]];
                        }
                    } else {
                        $errorMessage = [True, 'Deze gebruiker is niet actief: ' . $foundUser[0]];
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
if (isset($_GET["loggedOut"]) && $_GET["loggedOut"] == 'True') {

    //delete the session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    unset($_SESSION['Username']);
    session_destroy();
    session_commit();
    $successMessage = [True, 'Successvol uitgelogged.'];
}

/* checking if the user tried to place an offer on an advert*/
if (isset($_GET["bieden"]) && $_GET["bieden"] == 'True') {
    $errorMessage = [True, 'U moet inloggen om een bod te plaatsen.'];
}
/* checking if the user tried to open an unauthorised page */
if (isset($_GET["unauthorised"]) && $_GET["unauthorised"] == 'True'){
    $errorMessage = [True, 'U moet inloggen om deze pagina te bezoeken.'];
}
/* checking if the user tried to upgrade his account */
if (isset($_GET["seller"]) && $_GET["seller"] == 'True'){
    $errorMessage = [True, 'U bent al een verkoper.'];
}



?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="I-Project - Groep 3">


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
    <link rel="stylesheet" href="CSS/footer.css">


</head>

<body>

<?php
include "navbar.php";
?>

<!-- Breadcrumb -->
<ol class="breadcrumb " style="position: fixed; top: 50px; display: block; width: 100%;">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active">Login</li>
</ol>

<!-- Login form -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-10 col-xs-push-1 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4 center-block"
             id="loginWrapper">
            <div class="panel panel-default" id="loginPanel">
                <div class="panel-heading">
                    EeemaalAndermaal login
                </div>

                <div class="panel-body">

                    <!-- Alerts -->

                    <?php

                    /* checking if any alerts of success messages need to be displayed */
                    if ($errorMessage[0]) {

                        echo "<div class=\"alert alert-danger alert-dismissable\">
                             <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                             <strong>Fout!</br></strong> " . $errorMessage[1] . "
                          </div>";
                    } else if ($successMessage[0]) {
                        echo "<div class=\"alert alert-success alert-dismissable\">
                             <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                             <strong>Success!</br></strong> " . $successMessage[1] . "
                          </div>";
                    }


                    ?>

                    <form action="login.php" method="POST">

                        <!-- gebruikersnaam input -->

                        <div class="form-group">
                            <div class="input-group">
                                <input name="username" type="text" class="form-control" placeholder="gebruikersnaam"
                                       required>
                                <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                            </div>
                        </div>

                        <!-- Wachtwoord input -->

                        <div class="form-group">
                            <div class="input-group">
                                <input name="password" type="password" class="form-control" placeholder="wachtwoord"
                                       required>
                                <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                            </div>
                        </div>

                        <!-- hidden input so no allerts are send when the page is first loaded -->
                        <input type="hidden" name="formSend" value="True">

                        <!-- login button -->
                        <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="loginButton">Log in</button>
                        </div>

                    </form>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 col-md-push-3">
                    <p class="text-center">Wilt u een account aanmaken? Klik dan <a href="registreer1.php">hier</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>