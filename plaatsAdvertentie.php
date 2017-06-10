<?php

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
Session_START();
//Haalt alle verschillende betalingswijzen op uit de database om later mee te vergelijken
$Betalingswijzen = SendToDatabase($GetBethaalMethodesQuerie);
//Haalt alle landcodes en landnamen op uit de database om later te laten zien in een select form
$Landen = SendToDatabase($GetLandenQuerie);
//Haalt alle landcodes op uit de database om later input values mee te vergelijken
$Landnamen = SendToDatabase2($GetLandnaamQuerie);

$rubriek = null;
$waardes = $_POST;
//Wanneer een gebruikers naam in de sessie staat en dus niet ingelogt is gaat hij naar de login pagina.
if (!isset($_SESSION["Username"]) OR empty($_SESSION["Username"])) {
    header("Location: login.php?unauthorised=True");
}
//Om de pagina te bekijken moet de gebruiker een verkoper zijn. In deze functie wordt gekeken of die dat is.
gebruikerIsVerkoperCheck($_SESSION['Username']);

//Voor het invullen van de veiling details moet er eerst een rubriek gekozen zijn deze wordt meegegeven in de url.
if (isset($_GET['rubriek']) && !empty($_GET['rubriek'])) {
    $rubriek = ($_GET['rubriek']);
    //Wanneer iemand zelf tekst in de url geschreven heeft wordt rubriek op null gezet en kan dus nog niet verder met het invullen
    if (!is_numeric($rubriek)) {
        $rubriek = null;
    }
    //Een extra waarde wordt aan de $_POST toegevoegd om later makkelijk te kunnen kijken
    //of de rubriek goed is ingevuld. Dit zodat er niet nog een extra parameter meegegeven wordt.
    $_POST['rubriek'] = $rubriek;
}
//Alle input velden worden hier gecleaned
foreach ($_POST as $key => $value) {
    $_POST[$key] = cleanInput($_POST[$key]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Wanneer de REQUEST METHOD POST IS wordt er gekeken of alles goed is ingevuld
    //De eerste tien waardes uit de array zijn fout meldingen.
    //De laatste waarde van de array is een bit die true is als er iets fout is ingevuld
    //En false is als alles correct is ingevuld
    $errorResults = checkPlaatsenVoorwerp($Betalingswijzen, $Landnamen);
    if ($errorResults[sizeof($errorResults) - 1] == false) {
        //Alle $_POST waardes en de username uit de sessie worden hier in de juiste volgorde ingevuld.
        $veilingInput = prepareveilingInput($_POST, $_SESSION);
        //De zojuist gecreeërde veiling input wordt door deze functie d.m.v een prepared statement in de database geschreven.
        plaatsAdvertentie($veilingInput);
        //getlastID() returned zoals de naam al zegt het ID van het zojuist ingevulde voorwerp.
        //Dit ID wordt later gebruikt in de naam van de plaatjes.
        $lastID = getLastID();
        //Returned de extensies van de afbeeldingen om zo de uit eindelijke naam in de map /upload te maken.
        $extentions = getExtension($_FILES);
        //Returned het aantal plaatjes die geupload zijn als extra afbeelding.
        $aantalplaatjes = sizeof($_FILES['afbeelding']['name']);
        //Insert alle extra afbeeldingen in de database.
        insertExtraAfbeeldingen($lastID[0], $aantalplaatjes, $extentions);
        //Insert de thumbnail in de database.
        insertThumbnail($_FILES, $lastID[0]);
        //Upload de extra afbeeldingen in de /upload map op de server
        uploadExtraAfbeeldingen($_FILES, $lastID, $aantalplaatjes, $extentions);
        //upload de thumbnail in de /upload map op de server
        uploadThumbnail($_FILES, $lastID);
        //insert het gekozen rubriek bij het voorwerpnummer.
        insertRubriek($rubriek, $lastID[0]);
        //Je wordt uiteindelijk verwezen naar je eigen geplaatste voorwerp zodat je hem meteen kan bekijken.
        header('Location: voorwerp.php?ItemID=' . $lastID[0]);
    }
}

?>


<!doctype HTML>
<html lang="en">
<head>
    <meta charset="utf-8">

    <!-- Titel van de pagina in het tabblad-->
    <title>Registreer</title>
    <!-- Description -->
    <meta name="description" content="EenmaalAndermaal">
    <!-- Author -->
    <meta name="author" content="I-Project - Groep 3">

    <meta name="theme-color" content="#F6D155">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#F6D155">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#F6D155">


    <!-- setting the browser icon -->
    <link rel="icon" href="images/Site-logo.png">


    <!-- bootstrap !-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/BootstrapXL.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/HomePage.css">
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">

    <!-- CSS voor price slider -->
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/css/bootstrap-slider.css">
    <link rel="stylesheet" href="CSS/resultaten.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/bootstrap-slider.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

</head>

<body>

<!-- Navigation -->

<?php
require('navbar.php');
?>


<h1 class="text-center">Plaats Veiling!</h1>
<br>

<div class="well container">

    <?php
    //Wanneer de laatste waarde uit de array $erroResults true is is er een fout geweest bij het invullen van het form
    //De foutmeldingen staan in de zelfde array nummer 0 t/m size-1
    if ($errorResults[sizeof($errorResults)] == true) {
        echo '<div class="col-xs-12" ><div class="alert alert-danger alert-dismissable fade in center-block col-md-6 col-md-push-3">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h2 class="center-text alert-danger" ><strong>Niet alles is goed ingevuld!</strong></h2><br>';
        //Maakt van de array met error meldingen een nette opmaak
        echo drawErrorResult($errorResults);
        echo '</div></div>';
    } ?>

    <!-- Lijst met rubrieken-->
    <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-xs-push-1">
        <h2>Kies eerst uw rubriek!</h2>
        <hr>
        <br>
        <div class="list-group-item panel-collapse collapse in">
            <?php
            //Functie die alle categoriën in een overzichtelijke tree presenteerd
            printCategoriesAdvertentiePagina($rubriekQuery, $rubriek);
            ?>
        </div>
    </div>
    <div class="col-md-5 col-sm-5 col-xs-5 col-xs-push-2 right">
        <!-- Form met veiling details -->

        <form method="POST" enctype="multipart/form-data">
            <?php
            //Wanneer de gebruiker nog geen rubriek gekozen heeft staat deze ook nog niet in de $_GET
            //Wanneer dat dus het geval is wordt het hele form op disabled gezet totdat er wel een waarde in de $_GET staat
            if (!isset($_GET['rubriek'])) {
                echo "<fieldset disabled>";
            }
            ?>


            <h2>Voorwerp details</h2>
            <hr>
            <br>


            <!-- Titel van de veiling-->
            <div class="form-group">
                <h4>Titel Voorwerp*</h4>
                <input name="Titel" id="Titel" type="text" placeholder="Titel" maxlength="90"
                       class="form-control" value="
                    <?php
                //Wanneer er al een waarde was ingevuld maar niet alles was correct ingevuld wordt
                //hier het ingevulde terug gezet.
                if (!empty($waardes['Titel'])) {
                    echo $waardes['Titel'];
                } ?>">
            </div>


            <!-- Beschrijving van de veiling -->
            <div class="form-group">
                <label for="Beschrijving"></label><h4>Beschrijving*</h4>
                <textarea name="Beschrijving" id="Beschrijving"
                          placeholder="Vul hier de beschrijving van je voorwerp in!"
                          class="form-control" rows="5" value="
                          ">
                    <?php
                    //Wanneer er al een waarde was ingevuld maar niet alles was correct ingevuld wordt
                    //hier het ingevulde terug gezet.
                    if (!empty($waardes['Beschrijving'])) {
                        echo $waardes['Beschrijving'];
                    } ?></textarea>
            </div>


            <!-- Uploaden van de thumbnail -->
            <div class="form-group" id="ThumbnailUpload">
                <h4>Thumbnail*</h4>
                <label class="btn btn-warning btn-lg"> <span class="glyphicon glyphicon-cloud-upload"></span> Upload
                    hier je thumbnail!
                    <input name="thumbnail" id="thumbnail" type="file" style="display:none" class="form-control">

                </label>
                <p id="ThumbnailName">
                    Selecteer een afbeelding!
                </p>

            </div>
            <!-- Uploaden van extra afbeeldingen -->
            <div class="form-group" id="AfbeeldingUpload">
                <h4>Extra afbeeldingen*</h4>
                <label class="btn btn-warning btn-lg"> <span class="glyphicon glyphicon-cloud-upload"></span> Upload
                    hier maximaal 3 extra afbeeldingen!
                    <input name="afbeelding[]" id="afbeelding" type="file" style="display:none" multiple
                           class="form-control">

                </label>
                <div id="AfbeeldingName">
                    Selecteer drie extra afbeeldingen!
                </div>


            </div>

            <!-- Looptijd slider -->
            <label for="looptijd"></label><h4>Looptijd veiling*</h4>

            <input name="looptijd" id="looptijd" type="text"
                   style="width: 100%;"
                   data-provide="slider"
                   data-slider-ticks="[1,3, 5,7,9]"
                   data-slider-ticks-labels='["1 dag", "3 dagen", "5 dagen", "7 dagen", "10 dagen"]'
                   data-slider-min="1"
                   data-slider-max="10"
                   data-slider-step="2"
                   data-slider-value="7"
                   data-slider-tooltip="hide"/>


            <br>
            <br>
            <h2>Betaling</h2>
            <hr>
            <br>

            <!-- Invullen van de startprijs -->
            <div class="col-md-6 nopadding">
                <h4>Startprijs*</h4>

                <div class="input-group">

                <span class="input-group-addon" id="basic-addon1"> <i
                            class="glyphicon glyphicon-euro"></i></span>
                    <input name="startprijs" id="startprijs" type="number" placeholder="Startprijs"
                           class="form-control" ="true" maxlength="9"
                    value="<?php
                    //Wanneer er al een waarde was ingevuld maar niet alles was correct ingevuld wordt
                    //hier het ingevulde terug gezet.
                    if (!empty($waardes['startprijs'])) {
                        echo $waardes['startprijs'];
                    } ?>">
                </div>
            </div>
            <!-- Invullen van de betalingswijze -->
            <div class="col-md-6 nopadding1">
                <h4>Betalingswijze*</h4>
                <div class="form-group">
                    <select name="betalingswijze" id="betalingswijze"
                            class="form-control" ="true">
                    <?php
                    //Print alle Betalingswijzen die in de database staan
                    printBetalingswijzen($Betalingswijzen);
                    ?>
                    </select>
                </div>
            </div>

            <!-- Invullen van de betalingsinstructie -->
            <div class="form-group">
                <h4>Betalingsinstructie*</h4>
                <textarea name="Betalingsinstructie" id="Betalingsinstructie"
                          placeholder="Vul hier jouw betalingsinstructie in!"
                          class="form-control" rows="5">
                    <?php
                    //Wanneer er al een waarde was ingevuld maar niet alles was correct ingevuld wordt
                    //hier het ingevulde terug gezet.
                    if (!empty($waardes['Betalingsinstructie'])) {
                        echo $waardes['Betalingsinstructie'];
                    } ?></textarea>
            </div>

            <h2>Locatie</h2>
            <hr>
            <br>

            <!-- Invullen van de plaatsnaam waar het product zich bevindt -->
            <div class="col-md-6 nopadding">
                <h4>Plaats*</h4>
                <div class="input-group">

                <span class="input-group-addon" id="basic-addon1"> <i
                            class="glyphicon glyphicon-home"></i></span>
                    <input name="plaats" id="woonplaats" type="text" placeholder="Woonplaats"
                           class="form-control" maxlength="85"
                           value="<?php if (!empty($waardes['plaats'])) {
                               echo $waardes['plaats'];
                           } ?>">
                </div>
            </div>

            <!-- Invullen van het land -->
            <div class="col-md-6 nopadding1">
                <h4>Land*</h4>
                <div class="form-group">
                    </label>
                    <select name="land" id="land" type="text"
                            class="form-control">
                        <?php
                        //Print alle landen die in de database staan uit in het select form
                        printLanden($Landen);
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <br>
            <h2>Verzending</h2>
            <hr>
            <br>

            <!-- Invullen verzendkosten -->
            <div class="form-group">
                <h4>Verzendkosten*</h4>
                <input name="verzendkosten" id="verzendkosten" type="number"
                       placeholder="Vul hier je verzendkosten in" maxlength="64"
                       class="form-control" value="
                    <?php
                //Wanneer er al een waarde was ingevuld maar niet alles was correct ingevuld wordt
                //hier het ingevulde terug gezet.
                if (!empty($waardes['verzendkosten'])) {
                    echo $waardes['verzendkosten'];
                } ?>">
            </div>

            <!-- Invullen van de verzend instructies -->
            <div class="form-group">
                <h4>Verzendinstructies</h4>

                <textarea name="verzendinstructies" id="verzendinstructies"
                          placeholder="Vul hier jouw verzendinstructies in!"
                          class="form-control" rows="5"><?php if (!empty($waardes['verzendinstructies'])) {
                        echo $waardes['verzendinstructies'];
                    } ?></textarea>
            </div>
            <br>
            <!-- Knop waarop de gebuiker kan klikken om de advertentie te plaatsen -->
            <button class="btn-primary btn-lg center-block" type="submit">
                Plaats advertentie!
            </button>


            <?php
            //Wanneer de $_GET van rubriek niet gezet was wordt er boven in de code <fieldset disabled> geprint
            //hier wordt die afgesloten
            if (!isset($_GET['rubriek'])) {
                echo '</fieldset>';
            }
            ?>

            <input type="hidden" name="rubriek" value="
               <?php
            //Hidden input om het rubriek meetegeven met de $_POST
            echo $rubriek;
            ?>">
        </form>
    </div>
</div>

<script>
    //script voor de categorie boom
    $(document).ready(function () {
        $('#list').click(function (event) {
            event.preventDefault();
            $('#products .item').addClass('list-group-item');
        });
        $('#grid').click(function (event) {
            event.preventDefault();
            $('#products .item').removeClass('list-group-item');
            $('#products .item').addClass('grid-group-item');
        });
    });
    $(document).ready(function () {
        $('.tree-toggle').click(function () {
            $(this).parent().children('ul.tree').toggle(200);
        });
    });
    //Script voor het controleren van de thumbnail
    jQuery(function ($) {
        $('#thumbnail').change(function () {
            if ($(this).val()) {
                //De naam van het zojuist geuploade file wordt opgehaald.
                var filename = $(this).val().replace(/^.*[\\\/]/, '');
                //De naam van het zojuist geuploade file wordt in het object met id Thumbnail gezet.
                $(this).closest('#ThumbnailUpload').find('#ThumbnailName').html(filename);
            }
            //  grootte van de file wordt hier gezet
            var total = this.files[0].size
            // maximum grootte van de afbeelding in MegaBytes
            var maxMB = 5;
            // Wanneer de grootte van de afbeelding groter is dan maxMB mag dat niet.
            if ((total / 1000 / 1024) > maxMB) {
                //Gebruiker krijgt alert met melding dat het plaatjes te groot is.
                alert("U heeft de maximum grootte van" + maxMB + "MB overschreden. Uw foto's zijn: " + (total / 1000 / 1024).toFixed(2) + "MB");
                //Plaatje wordt verwijderd.
                $("#thumbnail").val("");
                //De naam van de Thumbnail wordt vervangen door selecteer een afbeelding
                $("#ThumbnailName").html("Selecteer een afbeelding!");
            }
        });
    });
    // JQuery voor het checken van de geuploade afbeeldingen
    jQuery(function ($) {
        $('#afbeelding').change(function () {
            var filenames = '';
            //Filenamen van alle afbeeldingen worden in een variabele gezet.
            for (var i = 0; i < this.files.length; i++) {
                filenames += '<p>' + this.files[i].name + '</p>';
            }
            var total = 0;
            $("#afbeelding").each(function () {
                //Totale grootte van alle afbeeldingen bij elkaar wordt hier in de variabele total gezet.
                for (var i = 0; i < this.files.length; i++) {
                    total += this.files[i].size;
                }
            });
            //Hier wordt de tekst van het object met ID AfbeeldingName vervangen door de filenamen
            $("#AfbeeldingName").html(filenames);
            //Check op het aantal afbeeldingen
            if ($("#afbeelding")[0].files.length > 3) {
                //Gebruiker krijgt alert dat er maximaal 3 afbeeldingen geupload mogen worden
                alert("You can select only 3 images");
                //#afbeelding wordt leeg gemaakt
                $("#afbeelding").val("");
                //De tekst van het object met id afbeeldingname wordt vervangen door Selecteer drie extra afbeeldingen//
                $("#AfbeeldingName").html("Selecteer drie extra afbeeldingen!");
            }
            //Maximale grootte van alle drie de afbeeldingen bij elkaar
            var maxMB = 15;
            //Check of total niet groter is dan max MB
            if (total / 1000 / 1024 > maxMB) {
                //Gebruiker krijgt alert dat de totale grootte van de 3 afbeeldinge te groot is
                alert("U heeft de maximum grootte van" + maxMB + "MB overschreden. Uw foto's zijn: " + (total / 1000 / 1024).toFixed(2) + "MB");
                $("#afbeelding").val("");
                $("#AfbeeldingName").html("Selecteer drie extra afbeeldingen!");
            }
        });
    });
</script>

</body>
</html>
