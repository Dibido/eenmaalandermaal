<?php
session_start();

require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
require('PHP/connection.php');

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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/footer.css">
</head>

<body>

<!-- Navigation -->

<?php
require('navbar.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>


    <!-- Carousel -->

    <div class="col-md-8 col-sm-12">
        <div class="panel panel-default Details-wrapper">
            <div class="list-group-item active text-center">Persoonlijke Beschrijving</div>
            
                    <p> HIER KOMT "EEN PERSOONlijkE BESCHRIJVING"</p>
    
            
        </div>
    </div>


    <!-- START Sidebar -->
    <div class="col-md-4 col-xs-12">
        <div class="panel panel-default">
            <div class="list-group-item active text-center">Gegevens</div>
            <div class="panel-body">

               <div class="list-group-item">Naam:</div>
               <div class="list-group-item">Geboortedatum:</div>
               <div class="list-group-item">Land:</div>   
               <div class="list-group-item">Plaats:</div>
               <div class="list-group-item">Type account:</div>
                
            <div class="panel-heading text-center">Gebruikers informatie</div>
                <div class="panel-body">
                <div class="UserContainer">
                <div id="User" style="background-image:url(images/User.png)"></div>
                <div class="UserInfo">fonorama</div>
            </div>
            <div id="UserRating" class="text-center">
                <div>
                    <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i> 
                </div>
            </div>
        </div>

    </div>

             
            </div>
        </div>
    </div>

</div>


</div>

<?php include('footer.html'); ?>

</body>