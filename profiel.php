<?php
session_start();

require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
require('PHP/connection.php');

//$ItemInfo = GetItemDetails(fonorama);
$username = $_SESSION['Username']; 
$userinfo = findUserInfo($username)[0];
$userads = findUserAds($username)[0];
print_r($userinfo);


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
        <div class="col-md-12"></div>
    </div>


    <!-- Carousel -->

    <div class="col-md-8 col-sm-12">
        <div class="panel panel-default Details-wrapper">
                <div class="list-group-item active text-center">Persoonlijke Beschrijving</div>
                    <div class="panel-body">
                        <p><span class="glyphicon glyphicon-user"></span> Voornaam + Achternaam: <b><?php echo $userinfo["GEB_voornaam"] . ' ' . $userinfo["GEB_achternaam"]?></b></p>
                        <p><span class="glyphicon glyphicon-gift"></span> Geboortedatum: <b><?php echo $userinfo["GEB_voornaam"]?></b></p>
                        <p><span class="glyphicon glyphicon-envelope"></span> Email-adres: <b><?php echo $userinfo["GEB_mailbox"]?></b></p>
                        <p><span class="glyphicon glyphicon-map-marker"></span> Postcode + Plaats : <b><?php echo $userinfo["GEB_postcode"] . ' ' . $userinfo["GEB_plaatsnaam"]?></b></p>
                        <p><span class="glyphicon glyphicon-globe"></span> Land: <b><?php echo $userinfo["GEB_Land"]?></b></p>
                        <p><span class="glyphicon glyphicon-shopping-cart"></span> Type account: <b><?php if ($userinfo["GEB_verkoper"] == 0) {echo "Geen verkoper";} else echo "Verkoper" ?></b></p>
                    </div>
        </div>
    </div>




    <!-- START Sidebar -->
    <div class="col-md-4 col-xs-12">
        <div class="panel panel-default">
            <div class="list-group-item active text-center">Gegevens</div>
            <div class="panel-body">

               <div class="list-group-item "><span class="glyphicon glyphicon-user"></span> Username: <b><?php echo "$username" ?> </b></div>
               <div class="list-group-item"><span class="glyphicon glyphicon-shopping-cart"></span> Type account: <b><?php if ($userinfo["GEB_verkoper"] == 0) {echo "Geen verkoper";} else echo "Verkoper" ?></b></div>
               <a href="#"><button class="btn btn-primary center-block btn-lg " type="button" style="margin-top: 10px;">
                            <span class="glyphicon glyphicon-repeat"></span><?php if ($userinfo["GEB_verkoper"] == 0) {echo " UPGRADE ACCOUNT!";} else echo "DOWNGRADEN"?></button></a> <!-- MISCHIEN KNOP WEGLATEN BIJ VERKOPER of DOWNGRADEn -->
               
                

                 <!-- gebruikersinformatie -->

                    <div class="panel-heading text-center">Gebruikers informatie</div>
                <div class="panel-body">
                    <div class="UserContainer">
                        <div id="User" style="background-image:url(images/User.png)"></div>
                        <div class="UserInfo"><?php echo $userinfo["GEB_gebruikersnaam"] ?></div>
                    </div>
                    <div id="UserRating" class="text-center">
                        <div>
                            <?php

        

                            $rating = floor($userinfo[14]["GEB_rating"]) / 10;

                            for($i = 0; $i < $rating/2; $i++){
                                echo " <i class=\"glyphicon glyphicon-star\"></i>";
                            }

                            //TODO: aantal sterren uitrekenen van range 0.0 - 100.0
                            ?>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADS -->
<div class="container-fluid"> 
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-default Details-wrapper">
            <div class="list-group-item active text-center">Mijn EenMaalAndermaal</div>
     
                <div class="panel-body">

                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Mijn advertenties</a></li>
                    <li><a data-toggle="tab" href="#menu1">Mijn biedingen</a></li>
                    <li><a data-toggle="tab" href="#menu2">Gewonnen veilingen</a></li>
                  </ul>

                  <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                      <h3>Mijn advertenties</h3>
                 
                    </div>
                    <div id="menu1" class="tab-pane fade">
                      <h3>Mijn biedingen</h3>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                      <h3>Gewonnen veilingen</h3>
                      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                    </div>
                  </div>
                </div>
        </div>
    </div>
</div>
</div>

<?php include('footer.html'); ?>

</body>