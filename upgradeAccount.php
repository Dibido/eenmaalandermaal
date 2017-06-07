<?php
session_start();
require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

print_r($_SESSION);
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


</head>

<body>

<?php
include "navbar.php";
?>


<!-- Login form -->
<div class="col-xs-10 col-xs-push-1 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4 center-block" id="loginWrapper">
    <div class="panel panel-default" id="loginPanel">
        <div class="panel-heading">
            EeemaalAndermaal beheerders login
        </div>
        <div class="panel-body">
            <form action="BeheerLogin.php" method="POST">

                <!-- telefoonnummer input -->

                <div class="form-group">
                    <div class="input-group">
                        <input name="telefoonnummer" type="text" class="form-control" placeholder="telefoonnummer" required>
                        <div class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></div>
                    </div>
                </div>

                <!-- banknaam input -->

                <div class="form-group">
                    <div class="input-group">
                        <input name="banknaam" type="text" class="form-control" placeholder="banknaam" required>
                        <div class="input-group-addon"><i class="glyphicon glyphicon-"></i></div>
                    </div>
                </div>


                <!-- login button -->

                <button type="submit" class="btn btn-primary" id="loginButton">Log in</button>

                <!-- Alerts -->

                <?php

                /* checking if any alerts of success messages need to be displayed */
                if ($errorMessage[0]){

                    echo "<div class=\"alert alert-danger alert-dismissable\">
                             <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                             <strong>Error!</strong> " . $errorMessage[1] . "
                          </div>";

                } else if($successMessage[0]){
                    echo "<div class=\"alert alert-success alert-dismissable\">
                             <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                             <strong>Success!</strong> " . $successMessage[1] . "
                          </div>";
                }

                ?>
            </form>
        </div>
    </div>
</div>


</body>