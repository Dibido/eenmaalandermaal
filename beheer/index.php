<?php

//checking if the user is logged in
session_start();
if(isset($_SESSION["adminUsername"]) AND !empty($_SESSION["adminUsername"])){
    $errorMessage = [True, 'Logged in as: ' . $_SESSION["adminUsername"]];
}else{
    header('Location: http://iproject3.icasites.nl/BeheerLogin.php?noLogin=True');
    die();
}

require('../PHP/connection.php');
require('../PHP/Functions.php');
require('../PHP/SQL-Queries.php');


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
    <link rel="icon" href="../images/Site-logo.png">


    <!-- bootstrap !-->


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/theme.css">
    <link rel="stylesheet" href="../CSS/BootstrapXL.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/navigation.css">
    <link rel="stylesheet" href="../CSS/BeheerLogin.css">


</head>

<body>

<?php
include "../navbar.php";

?>

<!-- end navbar -->

<!-- Login form -->
<div class="col-sm-4 col-sm-push-4 center-block" id="loginWrapper">
    <div class="panel panel-default" id="loginPanel">
        <div class="panel-heading">
            EeemaalAndermaal beheerders login
        </div>
            <div class="panel-body">

                    <!-- Alerts -->

                    <?php

                    if ($errorMessage[0]){

                        echo "<div class=\"alert alert-success alert-dismissable\">
                                 <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                                 <strong>Success!</strong> " . $errorMessage[1] . "
                              </div>";

                    }

                    ?>
            </div>
            <div class="panel-heading">Beheerders tools: </div>
                <div class="panel-body">
                    <button type="submit" class="btn btn-info" id="loginButton"><i class="glyphicon glyphicon-trash"></i> Drop Database <i class="glyphicon glyphicon-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>


</body>