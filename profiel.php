<?php
session_start();

require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
require('PHP/connection.php');


/* check of the user is loggedin, redirect to login.php when username is not set.*/
if (!isset($_SESSION["Username"])){
    header('Location: login.php'); exit();
}

/* getting the userinfo, and determining if the user is looking at his own, or another page*/
$username = $_SESSION['Username'];
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['username'])) {
        $username = cleanInput($_GET['username']);
    }
}




$userinfo = findUserInfo($username)[0];
$userads = findUserAds($username);
$userbod = findBodAds($username);
$userwin = findWinAds($username);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['username'])) {
        $username = cleanInput($_GET['username']);
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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <link rel="stylesheet" href="CSS/HomePage.css">
</head>

<body>

<!-- Navigation -->

<?php
require('navbar.php');
?>

<ol class="breadcrumb " style="position: absolute; top: 50px; display: block; width: 100%;">
    <li><a href="#" onclick="history.go(-1)"><span id="lastPage">Vorige pagina</span>
    <li><a href="#">profielpagina van: <?php echo $username; ?></a></li>
</ol>

<div class="container" style="margin-top: 40px;">
    <div class="row">
        <div class="col-md-12"></div>
    </div>


    <!-- Carousel -->

    <div class="col-md-8 col-sm-12">
        <div class="panel panel-default Details-wrapper">
            <div class="list-group-item active text-center">Persoonlijke Beschrijving</div>
            <div class="panel-body">
                <p><span class="glyphicon glyphicon-user"></span> Voornaam + Achternaam:
                    <b><?php echo $userinfo["GEB_voornaam"] . ' ' . $userinfo["GEB_achternaam"] ?></b></p>
                <p><span class="glyphicon glyphicon-gift"></span> Geboortedatum:
                    <b><?php echo $userinfo["GEB_voornaam"] ?></b></p>
                <p><span class="glyphicon glyphicon-envelope"></span> Email-adres:
                    <b><?php echo $userinfo["GEB_mailbox"] ?></b></p>
                <p><span class="glyphicon glyphicon-map-marker"></span> Postcode + Plaats :
                    <b><?php echo $userinfo["GEB_postcode"] . ' ' . $userinfo["GEB_plaatsnaam"] ?></b></p>
                <p><span class="glyphicon glyphicon-globe"></span> Land: <b><?php echo $userinfo["GEB_Land"] ?></b></p>
                <p><span class="glyphicon glyphicon-shopping-cart"></span> Type account:
                    <b><?php if ($userinfo["GEB_verkoper"] == 0) {
                            echo "Geen verkoper";
                        } else echo "Verkoper" ?></b></p>
            </div>
        </div>
    </div>


    <!-- START Sidebar -->
    <div class="col-md-4 col-xs-12">
        <div class="panel panel-default">
            <div class="list-group-item active text-center">Gegevens</div>
            <div class="panel-body">

                <div class="list-group-item "><span class="glyphicon glyphicon-user"></span> Username:
                    <b><?php echo "$username" ?> </b></div>
                <div class="list-group-item"><span class="glyphicon glyphicon-shopping-cart"></span> Type account:
                    <b><?php if ($userinfo["GEB_verkoper"] == 0) {
                            echo "Geen verkoper";
                        } else echo "Verkoper" ?></b></div>
                <div class="list-group-item "><span class="glyphicon glyphicon-thumbs-up"></span> Mijn Rating: <b><?php

                        $Userinfo = GetUserInfoPerAuction($username);
                        $rating = ceil(($Userinfo[0]["GEB_rating"] / 20)); // Delen door 2. Rating van 0 tot 100, sterren 0 tot 5.
                        $legeSterren = 5 - $rating;
                        for ($i = 0; $i < $rating; $i++) {
                            echo " <i class=\"glyphicon glyphicon-star\"></i>";
                        }
                        for ($i = 0; $i < $legeSterren; $i++) {
                            echo " <i class=\"glyphicon glyphicon-star-empty\"></i>";
                        }

                        ?> </b></div>


                <?php if ($userinfo["GEB_verkoper"] == 0) {
                    echo '<a href="upgradeAccount.php"><button class="btn btn-primary center-block btn-lg " type="button" style="margin-top: 10px;">
                            <span class="glyphicon glyphicon-repeat"></span> UPGRADE ACCOUNT!</button></a>';
                } else echo ' ' ?>
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
                        <?php

                        $auctions = $userads;
                        if (isset($auctions[0]) AND !empty($auctions)) {
                            foreach ($auctions as $auction) {
                                DrawAuction($auction);
                            }
                        } else {
                            echo "U heeft geen geplaatste advertenties.";
                        }


                        ?>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <h3>Mijn biedingen</h3>
                        <?php

                        $auctions = $userbod;
                        if (isset($auctions[0]) AND !empty($auctions)) {
                            foreach ($auctions as $auction) {
                                DrawAuction($auction);
                            }
                        } else {
                            echo "U heeft nog geen bod geplaatst.";
                        }


                        ?>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <h3>Gewonnen veilingen</h3>
                        <?php

                        $auctions = $userwin;
                        if (isset($auctions[0]) AND !empty($auctions)) {
                            foreach ($auctions as $auction) {
                                DrawAuction($auction);
                            }
                        } else {
                            echo "U heeft nog niets gewonnen.";
                        }


                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include('footer.html'); ?>

</body>