<?php

require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
require('PHP/connection.php');

$ItemID = $_GET['ItemID'];

$ItemInfo = GetItemDetails($ItemID);
$ItemInfo = $ItemInfo[0];


?>


<!doctype html>

<!-- onzin comment voor pushes nr2 -->

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>EenmaalAndermaal - Beste veilingssite van Nederland</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="Iproject - Groep 3">

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



    <?php



    $LastOffers = GetLastOffers($ItemInfo["VW_voorwerpnummer"]);

    if (!isset($LastOffers[0]) or empty($LastOffers[0])) {
        echo "<div class=\"OldOffer\">Er zijn nog geen biedingen, wees de eerste om een bod uit te brengen!</div>";
        echo "</div>";
    } else {
        $Bod = 0;
        foreach ($LastOffers as $lastOffer) {
            $Bod++;
            $Bodtijd = ConvertTime($lastOffer["BOD_bodTijdEnDag"]);
            echo "<div class=\"OldOffer\"><div class=\"OldOfferUserName\">" . $Bod . '. ' . $lastOffer["BOD_gebruiker"] . "</div><div class=\"OldOfferPrice\">" . $Bodtijd . "</div><div class=\"OldOfferPrice\">&euro;" . $lastOffer["BOD_bodbedrag"] . "</div></div>";

            if ($Bod == 4) {
                echo "<div id=\"MoreOffers\" class=\"collapse\">";
            }
        }

        echo "</div>";

        if($Bod >= 4){
            echo "<button data-toggle=\"collapse\" data-target=\"#MoreOffers\" class=\"btn btn-default MoreOffers collapsed\" value=\"Meer biedingen\"></button>";
            echo "</div>";
        }
    }


    ?>


    <!-- Biedknop

    <div class="panel-heading text-center">Bieden</div>
    <div class="panel-body">
        <form class="form-inline">
            <div class="input-group InputBod">
                <div class="input-group-addon">&euro;</div>
                <input type="text" class="form-control" placeholder="voer hier uw bod in"
                       value="<?php echo ""; ?>">
            </div>
            <button type="submit" class="btn btn-primary SubmitButton">Bied</button>
        </form>
    </div>


-->

</body>