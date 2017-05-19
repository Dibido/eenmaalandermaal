<?php

//require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

$response = NULL;

?>

<!doctype html>

<!-- onzin comment voor pushes nr2 -->

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
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/voorwerp.css">


</head>

<body>

<!-- Navigation -->

<?php
require('navbar.html');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="HeaderTitle text-center">Titel van het te verkopen voorwerp</div>
        </div>
    </div>


    <!-- Carousel -->


    <div class="col-md-8 col-sm-12">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="AuctionImage" style="background-image: url(images/ModelS.jpeg);"></div>
                </div>

                <div class="item">
                    <div class="AuctionImage" style="background-image: url(images/ModelX.jpeg);"></div>
                </div>

                <div class="item">
                    <div class="AuctionImage" style="background-image: url(images/Model3.jpeg);"></div>
                </div>

                <div class="item">
                    <div class="AuctionImage" style="background-image: url(images/Roadster.jpg);"></div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </div>


    <!-- Sidebar -->


    <div class="col-md-4 col-xs-12">

        <div class="panel panel-default">
            <div class="panel-heading text-center">Overgebleven Tijd</div>
            <div class="panel-body">
                <div class="TimeLeft">
                    <span class="Time">7D 23:59:59</span>
                    <div id="Clock" style="background-image:url(images/Clock.png)"></div>
                </div>
            </div>
            <div class="panel-heading text-center">Prijs</div>
            <div class="panel-body">
                <span id="Price" class="text-center"><i class="glyphicon glyphicon-euro"></i> 20000.00</span>
            </div>

            <!-- Recent offers -->

            <div class="panel-heading text-center">Recente boden</div>
            <div class="panel-body">
                <div class="OldOffer"><div class="OldOfferUserName">1. Athan88</div><div class="OldOfferPrice">&euro; 20000</div></div>
                <div class="OldOffer"><div class="OldOfferUserName">2. Leroy Jenkings</div><div class="OldOfferPrice">&euro; 15</div></div>
                <div class="OldOffer"><div class="OldOfferUserName">3. User120009128</div><div class="OldOfferPrice">&euro; 10</div></div>


                <!-- Extra offers -->

                <div id="MoreOffers" class="collapse">
                    <div class="OldOffer"><div class="OldOfferUserName">4. Athan88</div><div class="OldOfferPrice">&euro; 20000</div></div>
                    <div class="OldOffer"><div class="OldOfferUserName">5. Leroy Jenkings</div><div class="OldOfferPrice">&euro; 15</div></div>
                    <div class="OldOffer"><div class="OldOfferUserName">6. User120009128</div><div class="OldOfferPrice">&euro; 10</div></div>
                    <div class="OldOffer"><div class="OldOfferUserName">7. Athan88</div><div class="OldOfferPrice">&euro; 20000</div></div>
                    <div class="OldOffer"><div class="OldOfferUserName">8. Leroy Jenkings</div><div class="OldOfferPrice">&euro; 15</div></div>
                    <div class="OldOffer"><div class="OldOfferUserName">9. User120009128</div><div class="OldOfferPrice">&euro; 10</div></div>
                    <div class="OldOffer"><div class="OldOfferUserName">10. Athan88</div><div class="OldOfferPrice">&euro; 20000</div></div>
                </div>

                <button data-toggle="collapse" data-target="#MoreOffers" class="btn btn-default MoreOffers collapsed" value="Meer boden"></button>

                <script type="text/javascript">


                    function handleClick()
                    {
                        this.value = (this.value == 'Meer boden' ? 'Minder boden' : 'Meer boden');
                    }
                    document.getElementById('MoreOffers').onclick=handleClick;

                </script>

            </div>

            <!-- Biedknop -->

            <div class="panel-heading text-center">Bieden</div>
            <div class="panel-body">
                <form class="form-inline">
                    <div class="input-group InputBod">
                        <div class="input-group-addon">&euro;</div>
                        <input type="text" class="form-control"  placeholder="voer hier uw bod in">
                    </div>
                    <button type="submit" class="btn btn-primary SubmitButton">Bied</button>
                </form>
            </div>
            <div class="panel-heading text-center">Gebruikers informatie</div>
            <div class="panel-body">
                <div class="UserContainer">
                    <div id="User" style="background-image:url(images/User.png)"></div>
                    <span class="UserInfo">Gebruiker 20016</span>
                </div>
                <div id="UserRating" class="text-center">
                    <div>
                        <i class="glyphicon glyphicon-star"></i>
                        <i class="glyphicon glyphicon-star"></i>
                        <i class="glyphicon glyphicon-star"></i>
                        <i class="glyphicon glyphicon-star"></i>
                        <i class="glyphicon glyphicon-star-empty"></i>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


<script>
    $(".Categoriën").css({'height': ($(".BijnaGesloten").height() + 'px')});
    $(".VeilingShowcase").css({'height': ($(".BijnaGesloten").height() + 'px')});
</script>


</div>

</body>