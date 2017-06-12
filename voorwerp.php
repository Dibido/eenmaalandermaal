<?php

session_start();

require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
require('PHP/connection.php');

$ItemID = $_GET['ItemID'];

$ItemInfo = GetItemDetails($ItemID);
$ItemInfo = $ItemInfo[0];

$ItemImages = GetItemImages($ItemID);
$minimumBod = $ItemInfo["VW_minimalenieuwebod"];


/* making sure an image is available */
if (count($ItemImages) == 0 && empty($ItemImages[0])){
    $ItemImages[0]["BES_filenaam"] = "/images/no-image-available.jpg";
}


/* making sure the properties are available*/

if(empty($ItemInfo["VW_plaatsnaam"])){
    $ItemInfo["VW_plaatsnaam"] = 'Onbekende plaatsnaam';
}
if(empty($ItemInfo["VW_looptijdStart"])){
    $ItemInfo["VW_looptijdStart"] = 'Onbekende plaatsingstijd';
}
if(empty($ItemInfo["VW_conditie"])){
    $ItemInfo["VW_conditie"] = 'Onbekende conditie';
}
if(empty($ItemInfo["VW_verzendkosten"])){
    $ItemInfo["VW_verzendkosten"] = 'Onbekende verzendkosten';
}
if(empty($ItemInfo["VW_verzendinstructies"])){
    $ItemInfo["VW_verzendinstructies"] = 'Onbekende verzendinstructies';
}
if(empty($ItemInfo["VW_betalingsinstructie"])){
    $ItemInfo["VW_betalingsinstructie"] = 'Onbekende betalingsinstructie';
}


/* de functie voor het bieden */

/* gewoon bieden */
$error = [False, ''];
$bod = $_POST["bod"];


// testing if the input is an int or a float
if (isset($bod) AND !empty($bod)) {
    if (!checkVeilingAfgelopen($ItemInfo["VW_voorwerpnummer"])[0]) {

        if (!isset($_SESSION["Username"])) {
            header('Location: login.php?bieden=True');
        }
        if (filter_input(INPUT_POST, "bod", FILTER_VALIDATE_INT)
            OR filter_input(INPUT_POST, "bod", FILTER_VALIDATE_FLOAT)
        ) {

            //cleaning the input for html
            $bod = cleanInput($bod);

            //checking if the user does not try to place an offer on his own advert
            if ($_SESSION["Username"] == $ItemInfo["VW_verkoper"]) {
                $error = [True, 'U kunt niet op uw eigen veilingen bieden.'];

                //checking if the offer is greater than the last offer
            } else if ($bod >= $minimumBod AND $bod <= 999999999.99) {

                //inserting the offer
                insertBod($ItemID, $_SESSION["Username"], $bod);
                header('Location: voorwerp.php?ItemID=' . $ItemID);

            } else {
                $error = [True, 'Vul alstublieft een geldig bod in.'];
            }
        } else {
            $error = [True, 'Vul alstublieft een getal in.'];
        }

    } else {
        $error = [True, 'Deze veiling is gesloten, u kunt helaas niet meer bieden. '];
    }

    //returning the errors
    if ($error[0]) {
        echo "<script type='text/javascript'>alert('$error[1]');</script>";
    }
}


/* snelbieden */
$snelBod = $_GET["snelbod"];

// testing if the input is an int or a float
if (isset($snelBod) AND !empty($snelBod)) {
    if (!isset($_SESSION["Username"])) {
        header('Location: login.php?bieden=True');
    }
    if ($_SESSION["Username"] == $ItemInfo["VW_verkoper"]) {
        $error = [True, 'U kunt niet op uw eigen veilingen bieden.'];

    } else {
        //inserting the offer
        insertBod($ItemID, $_SESSION["Username"], $minimumBod);

        header('Location: voorwerp.php?ItemID=' . $ItemID);

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

<ol class="breadcrumb" style="position: absolute; top: 50px; display: block; width: 100%;">
    <li><a href="#" onclick="history.go(-1)"><span id="lastPage">Vorige pagina</span></a></li>
    <li><a href="#"><?php echo $ItemInfo["VW_titel"] ?></a></li>
</ol>


<div class="container" style="margin-top: 40px;">
    <div class="row">
        <div class="col-md-12" style="padding-left: 30px; padding-right: 30px;">
            <div class="HeaderTitle text-center"><?php echo $ItemInfo["VW_titel"] ?></div>
        </div>
    </div>


    <!-- Carousel -->


    <div class="col-md-8 col-sm-12">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

                <?php

                for($i = 1; count($ItemImages) > $i; $i++ ){
                    echo "<li data-target=\"#myCarousel\" data-slide-to=\" " . $i . " \"></li>";
                }

                ?>

            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">

                <?php

                $firstTime = True;

                foreach ($ItemImages as $image){
                    $image["BES_filenaam"] = "http://iproject3.icasites.nl" . $image["BES_filenaam"];

                    if($firstTime){
                        $firstTime = False;

                        echo "
                            <div class=\"item active\">
                                <div class=\"AuctionImage\" style=\"background-image: url(" . $image["BES_filenaam"] . ")\"></div>
                            </div>";

                    } else {

                        echo "
                            <div class=\"item\">
                                <div class=\"AuctionImage\" style=\"background-image: url( " . $image["BES_filenaam"] . " )\"></div>
                            </div>";
                    }
                }

                ?>

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

        <!-- Rubrieken panel -->

        <div class="panel panel-default Details-wrapper">
            <div class="rubrieken">
                <ol class="breadcrumb">
                    <li><b>Rubriek: </b></li>
                    <?php
                    $categories = GetAboveCategories($ItemInfo["VR_Rubriek_Nummer"]);
                    for ($i = count($categories) - 1; $i >= 0; $i = $i - 1) {
                        echo "<li><a href=\"resultaten.php?rubriek=";
                        echo $categories[$i]["RB_Nummer"];
                        echo "\">";
                        echo $categories[$i][0];
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>
                </ol>
            </div>
        </div>

        <!-- Rubrieken panel END -->

        <!-- Description panel -->

        <div class="panel panel-default " id="Description-Wrapper">
            <div class="panel-heading text-center">Beschrijving</div>
            <div class="panel-body" style="height:100%;">
                <div style="height:100%;">
                    <iframe src="http://iproject3.icasites.nl/voorwerpDescription.php?ItemID=<?php echo $ItemID ?>"
                            id="Description"></iframe>
                </div>
            </div>
        </div>

        <!-- Description end -->

        <!-- Details panel -->

        <div class="panel panel-default Details-wrapper">
            <div class="panel-heading text-center">Kenmerken</div>
            <div class="Details">
                <?php
                $category = GetCategoryPerAuction($ItemInfo["VW_voorwerpnummer"]);
                $category = $category[0];
                ?>

                <div class="Detail"><b class="text-left">Locatie:</b><span
                            class="text-left"><?php echo $ItemInfo["VW_plaatsnaam"]; ?></span></div>
                <div class="Detail "><b class="text-center">geplaatst:</b><span
                            class="text-center"><?php echo $ItemInfo["VW_looptijdStart"]; ?></span></div>
                <div class="Detail"><b class="text-right">conditie:</b><span
                            class="text-right"> <?php echo $ItemInfo["VW_conditie"]; ?></span></div>
                <div class="Detail"><b class="text-left">verzendkosten:</b><span
                            class="text-left"> <?php echo $ItemInfo["VW_verzendkosten"]; ?></span></div>
                <div class="Detail"><b class="text-center">verzendinstructie:</b><span
                            class="text-center"> <?php echo $ItemInfo["VW_verzendinstructies"]; ?></span></div>
                <div class="Detail"><b class="text-right">betalingsinstructie:</b><span
                            class="text-right"> <?php echo $ItemInfo["VW_betalingsinstructie"]; ?></span></div>

            </div>
        </div>


        <!-- panel end -->

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

                if (isset($auctions[0]) AND !empty($auctions)) {
                    foreach ($auctions as $auction) {
                        DrawItemAuction($auction);
                    }
                } else {
                    echo "Deze gebruiker heeft geen andere advertenties.";
                }


                ?>

            </div>
        </div>

        <!-- einde gelijksoortige advertenties -->


    </div>

</div>

<script type="text/javascript">

    (function () {


        var open = $("#MoreOffers").hasClass("collapse in");
        var hasFocus = ($("#bodInput").is(":focus"));
        var text = $('#bodInput').val();

        //getting the panel
        $.get("voorwerpPanel.php?ItemID=<?php echo $ItemID;?>", function (data) {
            $("#dynamicPanel").html(data);
            if (open) {
                $("#MoreOffers").addClass("collapse in");
            } else $("#MoreOffers").addClass("collapse");

            //resetting the focus to the input
            if (hasFocus) {
                $("#bodInput").focus();
            }
            //getting the value from the previous page load
            if (text == '') {
                $('#bodInput').val(<?php echo $minimumBod;?>);

            } else if (typeof text == 'undefined') {
                $('#bodInput').val(<?php echo $minimumBod;?>);

            } else if (parseFloat(text) < <?php echo $minimumBod;?> || parseFloat(text) == <?php echo $minimumBod;?>) {
                $('#bodInput').val(<?php echo $minimumBod;?>);
            }
            else {
                $('#bodInput').val(text);
            }
        });
        setTimeout(arguments.callee, 5000);
    })();


</script>


</div>

<?php include('footer.html'); ?>

</body>