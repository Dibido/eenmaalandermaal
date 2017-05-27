<?php

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');


/* form validation for when a user tries to login */

$errorMessage = [False];


if($_POST["formSend"] == 'True'){

    $username = $_POST["username"];
    $password = $_POST["password"];

    if(isset($username) AND !empty($username)){
        if(isset($password) AND !empty($password)){
            checkCredentials($username, $password);
        }else{
            $errorMessage = [True, 'Geef alstublieft een wachtwoord op.'];
        }
    }else{
        $errorMessage = [True, 'Geef alstublieft een gebruikersnaam op.'];
    }
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
include "navbar.html";
?>


<!-- Login form -->
<div class="col-md-4 col-md-push-4 center-block" id="loginWrapper">
    <div class="panel panel-default" id="loginPanel">
        <div class="panel-heading">
            EeemaalAndermaal beheerders login
        </div>
        <div class="panel-body">
            <form action="BeheerLogin.php" method="POST">

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

                if($errorMessage[0]){

                    echo "<div class=\"alert alert-danger alert-dismissable\">
                             <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                             <strong>Error!</strong> " . $errorMessage[1] . "
                          </div>";

                }

                ?>


            </form>
        </div>
    </div>
</div>


</body>