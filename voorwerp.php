<?php
session_start();

require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
require('PHP/connection.php');

$ItemID = $_GET['ItemID'];

$ItemInfo = GetItemDetails($ItemID);
$ItemInfo = $ItemInfo[0];

$ItemImages = GetItemImages($ItemID);


/* making sure an image is available */
if (!isset($ItemInfo["VW_thumbnail"]) OR empty($ItemInfo["VW_thumbnail"])) {
    $ItemInfo["VW_thumbnail"] = "images/no-image-available.jpg";
}
for ($i = 0; $i < 3; $i++) {
    if (!isset($ItemImages[$i]["BES_filenaam"]) OR empty($ItemImages[$i]["BES_filenaam"])) {
        $ItemImages[$i]["BES_filenaam"] = "images/no-image-available.jpg";
    } else {
        $ItemImages[$i]["BES_filenaam"] = "http://iproject3.icasites.nl/pics/" . $ItemImages[$i]["BES_filenaam"];
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
    <link rel="stylesheet" href="CSS/voorwerp.css">
    <link rel="stylesheet" href="CSS/footer.css">


</head>

<body>

<!-- Navigation -->

<?php
require('navbar.php');
?>

<ol class="breadcrumb">
    <li><a href="#" onclick="history.go(-1)"><span id="lastPage">Vorige pagina</span>
        <script type="text/javascript">

            var elem = window.history.previous.href;
            $("#lastPage").append(elem);

        </script>
        </a></li>

    <li><a href="#"><?php echo $ItemInfo["VW_titel"] ?></a></li>
</ol>


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
                    <div class="AuctionImage"
                         style="background-image: url(<?php echo $ItemImages[0]["BES_filenaam"]; ?>)"></div>
                </div>

                <div class="item">
                    <div class="AuctionImage"
                         style="background-image: url(<?php echo $ItemImages[1]["BES_filenaam"]; ?>)"></div>
                </div>

                <div class="item">
                    <div class="AuctionImage"
                         style="background-image: url(<?php echo $ItemImages[2]["BES_filenaam"]; ?>)"></div>
                </div>

                <div class="item">
                    <div class="AuctionImage"
                         style="background-image: url(<?php echo "http://iproject3.icasites.nl/thumbnails/" . $ItemInfo["VW_thumbnail"]; ?>)"></div>
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
                <?php
                $category = GetCategoryPerAuction($ItemInfo["VW_voorwerpnummer"]);
                $category = $category[0];
                ?>
                <div class="rubrieken">
                    <ol class="breadcrumb">
                    <?php

                    $categories = GetAboveCategories($ItemInfo["VR_Rubriek_Nummer"]);
                    for ($i = count($categories)-1; $i >= 0; $i = $i-1){
                        echo "<li><a href=\"resultaten.php?rubriek=";
                        echo $categories[$i]["RB_Nummer"];
                        echo "\">";
                        echo $categories[$i][0];
                        echo "</a>";
                        echo "</li>";
                    }

                    ?>
                    </ol></div>

                <div class="Detail"><b>Locatie:</b> <?php echo $ItemInfo["VW_plaatsnaam"]; ?></div>
                <div class="Detail text-center"><b>geplaatst:</b> <?php echo $ItemInfo["VW_looptijdStart"]; ?></div>
                <div class="Detail"><b>conditie:</b> <?php echo $ItemInfo["VW_conditie"]; ?></div>
            </div>
        </div>

        <!-- panel end -->

        <!-- Description panel -->

        <div class="panel panel-default " id="Description-Wrapper">
            <div class="panel-heading text-center">Kenmerken</div>
            <div class="panel-body" style="height:100%;">
                <div style="height:100%;">
                    <iframe src="http://iproject3.icasites.nl/voorwerpDescription.php?ItemID=<?php echo $ItemID?>" id="Description"></iframe>
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
                    <p class="Time" id="<?php echo $ItemInfo["VW_voorwerpnummer"]; ?>"></p>
                    <?php
                    createTimer($ItemInfo["tijd"], $ItemInfo["VW_titel"], $ItemInfo["VW_voorwerpnummer"]);
                    ?>
                    <div id="Clock" style="background-image:url(images/Clock.png)"></div>
                </div>
            </div>
        </div>


        <div id="dynamicPanel"></div>


        <!-- gelijksoortige advertenties -->

        <div class="panel panel-default">
            <div class="panel-heading text-center">Andere advertenties van deze gebruiker</div>
            <div class="panel-body">
                <?php


                $auctions = findAuctionsByUser($ItemInfo["VW_verkoper"], $ItemID);

                if(isset($auctions[0]) AND !empty($auctions)){
                    foreach ($auctions as $auction){
                        DrawItemAuction($auction);
                    }
                }else{
                    echo "Deze gebruiker heeft geen andere advertenties.";
                }


                ?>

            </div>
        </div>

        <!-- einde gelijksoortige advertenties -->


    </div>

</div>

<script type="text/javascript">

    (function(){
        var open = $("#MoreOffers").hasClass("collapse in");
        var hasFocus = ($("#bodInput").is(":focus"));
        var text = $('#bodInput').val();

        $.get( "voorwerpPanel.php?ItemID=<?php echo $ItemID;?>", function( data ) {
            $( "#dynamicPanel" ).html( data );
            if (open)
            {
                $("#MoreOffers").addClass( "collapse in");
            } else $("#MoreOffers").addClass("collapse");

            if (hasFocus){
                $("#bodInput").focus();
            }
            $('#bodInput').val(text);

        });
        setTimeout(arguments.callee, 5000);
    })();


</script>


</div>

<?php include('footer.html'); ?>

</body>