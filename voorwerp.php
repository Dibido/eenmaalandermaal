<?php

//require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
require('PHP/connection.php');

$ItemID = $_GET['ItemID'];

$ItemInfo = GetItemDetails($ItemID);
$ItemInfo = $ItemInfo[0];

$ItemImages = GetItemImages($ItemID);


/* making sure an image is available */
if (!isset($ItemInfo["VW_thumbnail"]) OR empty($ItemInfo["VW_thumbnail"])){
    $ItemInfo["VW_thumbnail"] = "images/no-image-available.jpg";
}
for ($i = 0; $i < 3; $i++) {
    if (!isset($ItemImages[$i]["BES_filenaam"]) OR empty($ItemImages[$i]["BES_filenaam"])) {
        $ItemImages[$i]["BES_filenaam"] = "images/no-image-available.jpg";
    } else {
        $ItemImages[$i]["BES_filenaam"] = "http://iproject3.icasites.nl/pics/" . $ItemImages[$i]["BES_filenaam"];
    }
}

print_r($ItemInfo);

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
    <link rel="stylesheet" href="CSS/footer.css">


</head>

<body>

<!-- Navigation -->

<?php
require('navbar.html');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="HeaderTitle text-center"><?php echo $ItemInfo["VW_titel"] ?></div>
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
                    <div class="AuctionImage" style="background-image: url(<?php echo $ItemImages[0]["BES_filenaam"]; ?>)"></div>
                </div>

                <div class="item">
                    <div class="AuctionImage" style="background-image: url(<?php echo $ItemImages[1]["BES_filenaam"]; ?>)"></div>
                </div>

                <div class="item">
                    <div class="AuctionImage" style="background-image: url(<?php echo $ItemImages[2]["BES_filenaam"]; ?>)"></div>
                </div>

                <div class="item">
                    <div class="AuctionImage" style="background-image: url(<?php echo "http://iproject3.icasites.nl/thumbnails/" . $ItemInfo["VW_thumbnail"]; ?>)"></div>
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


        <!--  carousel end -->

        <!-- Details panel -->

        <div class="panel panel-default Details-wrapper">
            <div class="panel-heading text-center">Kenmerken</div>
            <div class="Details">
                <div class="Detail"><b>Categorie:</b> <?php echo 'categorie query is dood :('; ?></div>
                <div class="Detail"><b>Locatie:</b> <?php echo $ItemInfo["VW_plaatsnaam"];?></div>
                <div class="Detail"><b>geplaatst:</b>  <?php echo $ItemInfo["VW_looptijdStart"];?></div>
                <div class="Detail"><b>conditie:</b> <?php echo $ItemInfo["VW_conditie"]; ?></div>
            </div>
        </div>

        <!-- panel end -->

        <!-- Description panel -->

        <div class="panel panel-default ">
            <div class="panel-heading text-center">Kenmerken</div>
                <div class="panel-body">
                    <div>
                        <?php echo $ItemInfo["VW_beschrijving"]?>

                    </div>
                </div>
        </div>

        <!-- Description end -->


        <!-- end of left col -->

    </div>


    <!-- Sidebar -->


    <div class="col-md-4 col-xs-12">

        <div class="panel panel-default">
            <div class="panel-heading text-center">Overgebleven Tijd</div>
            <div class="panel-body">
                <div class="TimeLeft">
                    <p class="Time" id="<?php  echo $ItemInfo["VW_voorwerpnummer"];?>"></p>
                    <?php
                    createTimer($ItemInfo["tijd"], $ItemInfo["VW_titel"], $ItemInfo["VW_voorwerpnummer"]);
                    ?>
                    <div id="Clock" style="background-image:url(images/Clock.png)"></div>
                </div>
            </div>
            <div class="panel-heading text-center">Prijs</div>
            <div class="panel-body">
                <span id="Price" class="text-center"><i class="glyphicon glyphicon-euro"></i> <?php  echo $ItemInfo["prijs"];?></span>
            </div>

            <!-- Recent offers -->

            <div class="panel-heading text-center">Recente boden</div>
            <div class="panel-body">

                <?php


                $LastOffers = GetLastOffers($ItemInfo["VW_voorwerpnummer"]);

                if (!isset($LastOffers[0]) or empty($LastOffers[0])){
                    echo "<div class=\"OldOffer\">Er zijn nog geen boden</div>";
                } else{                    $Bod = 0;
                    foreach($LastOffers as $lastOffer){
                        $Bod++;
                        echo "<div class=\"OldOffer\"><div class=\"OldOfferUserName\">" . $Bod .'.'. $lastOffer["BOD_gebruiker"] . "</div><div class=\"OldOfferPrice\">". $lastOffer["BOD_bodTijdEnDag"] ."</div><div class=\"OldOfferPrice\">&euro;". $lastOffer["BOD_bodbedrag"]  ."</div></div>";

                        if($Bod = 4){
                            echo "<div id=\"MoreOffers\" class=\"collapse\">";
                        }
                    }

                    echo "</div>";
                    echo "<button data-toggle=\"collapse\" data-target=\"#MoreOffers\" class=\"btn btn-default MoreOffers collapsed\" value=\"Meer boden\"></button>";
                }




                ?>




            </div>

            <!-- Biedknop -->

            <div class="panel-heading text-center">Bieden</div>
            <div class="panel-body">
                <form class="form-inline">
                    <div class="input-group InputBod">
                        <div class="input-group-addon">&euro;</div>
                        <input type="text" class="form-control"  placeholder="voer hier uw bod in" value="<?php echo""; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary SubmitButton">Bied</button>
                </form>
            </div>
            <div class="panel-heading text-center">Gebruikers informatie</div>
            <div class="panel-body">
                <div class="UserContainer">
                    <div id="User" style="background-image:url(images/User.png)"></div>
                    <div class="UserInfo"><?php echo $ItemInfo["VW_verkoper"]?></div>
                </div>
                <div id="UserRating" class="text-center">
                    <div>
                        <?php

                        $Userinfo = GetUserInfoPerAuction($ItemInfo["VW_verkoper"]);


                        ?>
                        <i class="glyphicon glyphicon-star"></i>
                        <i class="glyphicon glyphicon-star"></i>
                        <i class="glyphicon glyphicon-star"></i>
                        <i class="glyphicon glyphicon-star"></i>
                        <i class="glyphicon glyphicon-star-empty"></i>
                    </div>
                </div>
            </div>

        </div>


        <!-- gelijksoortige advertenties -->

        <div class="panel panel-default">
            <div class="panel-heading text-center">Gelijksoortige advertenties</div>
            <div class="panel-body">

            </div>
        </div>

        <!-- einde gelijksoortige advertenties -->

    </div>

</div>


<script>
    $(".Categoriën").css({'height': ($(".BijnaGesloten").height() + 'px')});
    $(".VeilingShowcase").css({'height': ($(".BijnaGesloten").height() + 'px')});
</script>


</div>

<?php include('footer.html') ?>

</body>