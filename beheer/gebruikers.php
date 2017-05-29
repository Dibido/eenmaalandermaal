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
include "../navbar.html";

?>
<!-- accountControls -->

<div class="collapse text-center" id="accountControls">
    <div class="list-group">
        <a href="#" class="list-group-item">Mijn account</a>
        <a href="../BeheerLogin.php?loggedOut=True" class="list-group-item">Log out</a>
    </div>
</div>


<!-- Mobile Buttons -->

<div class="container-fluid collapse text-center" id="MobileButtons" style="font-size: 24px;">
    <div class="row">
        <ul class="nav nav-pills nav-stacked bg-info lead">
            <li><a class="row-md-12" href="#">Mijn account</a></li>
            <li><a class="row-md-12" href="http://iproject3.icasites.nl/BeheerLogin.php?loggedOut=True">Log out</a></li>
        </ul>
    </div>
</div>

<!-- end navbar -->

<!-- Gebruikers beheer -->
<div class="col-md-3 text-center">

</div>
<div class="col-md-4 text-center">
        <form action="gebruikers.php" method="POST">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                    <input name="username" type="text" class="form-control" placeholder="gebruikersnaam" required>
                    <div class="input-group-addon"><i class="glyphicon glyphicon-search"></i></div>
                </div>
            </div>
        </form>
    column 0
</div>
<div class="col-md-5 text-center">
    column 1
</div>





<div>



</div>


</body>