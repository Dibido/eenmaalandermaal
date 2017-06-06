<?php

require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
require('PHP/connection.php');

$ItemID = $_GET['ItemID'];

$ItemInfo = GetItemDetails($ItemID);
$ItemInfo = $ItemInfo[0];

$minimumBod = $ItemInfo["VW_minimalenieuwebod"];
session_start();


?>


<!doctype html>

<!-- onzin comment voor pushes nr2 -->

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>EenmaalAndermaal - Beste veilingssite van Nederland</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="Iproject - Groep 3">


</head>

<body>

    <div class="panel panel-default">


        <!-- dynamically loading the price -->

        <div class="panel-heading text-center">Prijs</div>
        <div class="panel-body">
            <span id="Price" class="text-center"><i
                        class="glyphicon glyphicon-euro"></i><?php echo " " . $ItemInfo["prijs"]; ?></span>
        </div>

        <!-- dynamically loading the offers -->

        <div class="panel-heading text-center">Recente biedingen</div>
        <div class="panel-body">
            <?php



            $LastOffers = GetLastOffers($ItemInfo["VW_voorwerpnummer"]);

            if (!isset($LastOffers[0]) or empty($LastOffers[0])) {
                echo "<div class=\"OldOffer\">Wees de eerste om een bod uit te brengen</div>";
                echo "</div>";
            } else {
                $Bod = 0;
                foreach ($LastOffers as $lastOffer) {
                    $Bod++;
                    $Bodtijd = ConvertTime($lastOffer["BOD_bodTijdEnDag"]);


                    // build the surrounding div for the offers
                    echo "<div class=\"OldOffer\"";

                    //border-bottom: #e5e5e5 solid 2px;

                    //checking if the offer is owned by the current user
                    if($_SESSION["Username"] == $lastOffer["BOD_gebruiker"]) {
                        echo "style=\"border-bottom: #524BAB solid 2px; \" ";
                    }

                    //building the inside of the offer
                    echo "><div class=\"OldOfferUserName\">" . $Bod . '. ' . $lastOffer["BOD_gebruiker"] . "</div><div class=\"OldOfferPrice\">" . $Bodtijd . "</div><div class=\"OldOfferPrice\">&euro;" . $lastOffer["BOD_bodbedrag"] . "</div></div>";

                    if ($Bod == 4) {
                        echo "<div id=\"MoreOffers\" class=\"collapse\">";
                    }
                }

                echo "</div>";

                if($Bod >= 4){
                    echo "<button data-toggle=\"collapse\" data-target=\"#MoreOffers\" class=\"btn btn-default MoreOffers collapsed\" value=\"Meer biedingen / Minder biedingen\">Meer / Minder biedingen</button>";
                    echo "</div>";
                }
            }


            ?>


        <!-- Biedknop -->

        <div class="panel-heading text-center">Bieden</div>
        <div class="panel-body">
            <form id="bodForm" class="form-inline" method="POST" action="voorwerp.php?ItemID=<?php echo $ItemID; ?>">
                <div class="input-group InputBod">
                    <div class="input-group-addon">&euro;</div>
                    <input form="bodForm" type="number" step=".01" class="form-control" id="bodInput" name="bod" min="<?php echo $minimumBod; ?>" max="999999999.99" autofocus>
                </div>
                <button type="submit" class="btn btn-primary SubmitButton">Bied</button>
            </form>
        </div>


         <!-- gebruikersinformatie -->

        <div class="panel-heading text-center">Gebruikers informatie</div>
        <div class="panel-body">
            <div class="UserContainer">
                <div id="User" style="background-image:url(images/User.png)"></div>
                <div class="UserInfo"><?php echo $ItemInfo["VW_verkoper"] ?></div>
            </div>
            <div id="UserRating" class="text-center">
                <div>
                    <?php

                    $Userinfo = GetUserInfoPerAuction($ItemInfo["VW_verkoper"]);

                    $rating = floor($Userinfo[0]["GEB_rating"]) / 10;

                    for($i = 0; $i < $rating/2; $i++){
                        echo " <i class=\"glyphicon glyphicon-star\"></i>";
                    }

                    //TODO: aantal sterren uitrekenen van range 0.0 - 100.0
                    ?>
                </div>
            </div>
        </div>

    </div>








</body>