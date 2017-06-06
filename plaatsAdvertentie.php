<?php
session_start();

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

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

<input id="fileopen" type="file" value=""/>
<button id="clear">Clear</button>

<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active">Registreren - Stap 2</li>
</ol>

<div class="well container">
    <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
        <div class="list-group-item panel-collapse collapse in">
            <?php
            $rubriek = 13353;
            printCategoriesAdvertentiePagina($rubriekQuery, $rubriek);
            ?>
        </div>
    </div>
    <div class="col-md-5 col-sm-5 col-xs-5 col-xs-push-2 right">
        <form method="POST">
            <h1>Voorwerp details</h1>
            <hr size="5">
            <div class="form-group">
                <label for="Titel"><h4>Titel Voorwerp*</h4></label>
                <input name="Titel" id="Titel" type="text" placeholder="Titel" maxlength="90"
                       class="form-control" required value="<?php if (!empty($waardes['Titel'])) {
                    echo $waardes['Titel'];
                } ?>">
            </div>

            <div class="form-group">
                <label for="Beschrijving"><h4>Beschrijving*</h4></label>
                <textarea name="Beschrijving" id="Beschrijving" placeholder="Achternaam"
                          class="form-control" required rows="5"
                          value="<?php if (!empty($waardes['Beschrijving'])) {
                              echo $waardes['Beschrijving'];
                          } ?>"></textarea>
            </div>

            <div class="form-group" id="ThumbnailUpload">
                <label for="Thumbnail"><h4>Thumbnail*</h4></label><br>
                <label class="btn btn-warning btn-lg"> <span class="glyphicon glyphicon-cloud-upload"></span> Upload
                    hier je thumbnail!
                    <input name="thumbnail" id="thumbnail" type="file" style="display:none"
                           value="<?php
                           if (empty($Thumbnail)) {
                               echo $waardes['Thumbnail'];
                           } ?>"
                           class="form-control">

                </label>
                <p id="ThumbnailName">
                    Please select a file.
                </p>

            </div>
            <div class="form-group" id="AfbeeldingUpload">
                <label for="Afbeelding"><h4>Extra afbeeldingen*</h4></label><br>
                <label class="btn btn-warning btn-lg"> <span class="glyphicon glyphicon-cloud-upload"></span> Upload
                    hier maximaal 3 extra afbeeldingen!
                    <input name="afbeelding" id="afbeelding" type="file" style="display:none" multiple
                           value="<?php
                           if (empty($Thumbnail)) {
                               echo $waardes['Thumbnail'];
                           } ?>"
                           class="form-control">

                </label>
                <div id="AfbeeldingName">
                    Selecteer drie extra afbeeldingen!
                </div>


            </div>
                <label for="looptijd"><h4>Looptijd veiling*</h4></label><br>

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


            <div class="form-group">
                <label for="adres1">Adresregel 1*</label>
                <input name="adres1" id="adres1" type="text" placeholder="Adresregel 1"
                       class="form-control" required="true" maxlength="255"
                       value="<?php if (!empty($waardes['adres1'])) {
                           echo $waardes['adres1'];
                       } ?>">
            </div>

            <div class="form-group">
                <label for="adres2">Adresregel 2</label>
                <input name="adres2" id="adres2" type="text" placeholder="Adresregel 2"
                       class="form-control" maxlength="255"
                       value="<?php if (!empty($waardes['adres2'])) {
                           echo $waardes['adres2'];
                       } ?>">
            </div>

            <div class="form-group">
                <label for="postcode">Postcode*</label>
                <input name="postcode" id="postcode" type="text" placeholder="1234 AB"
                       class="form-control" required="true" maxlength="12"
                       value="<?php if (!empty($waardes['postcode'])) {
                           echo $waardes['postcode'];
                       } ?>">
            </div>

            <div class="form-group">
                <label for="woonplaats">Woonplaats*</label>
                <input name="woonplaats" id="woonplaats" type="text" placeholder="Woonplaats"
                       class="form-control" required="true" maxlength="85"
                       value="<?php if (!empty($waardes['woonplaats'])) {
                           echo $waardes['woonplaats'];
                       } ?>">
            </div>

            <div class="form-group">
                <label for="land">Land*</label>
                <select name="land" id="land" type="text"
                        class="form-control" required="true">
                    <?php
                    printLanden($Landen);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="geboortedatum">Geboortedatum*</label>
                <input name="geboortedatum" id="geboortedatum" type="text" data-provide="datepicker"
                       data-date-format="yyyy-mm-dd"
                       placeholder="Geboortedatum"
                       class="form-control" required="true" value="<?php if (!empty($waardes['geboortedatum'])) {
                    echo $waardes['geboortedatum'];
                } ?>">
            </div>

            <hr>

            <div class="form-group">
                <label for="gebruikersnaam">Gebruikersnaam*</label>
                <input name="gebruikersnaam" id="gebruikersnaam" type="text"
                       placeholder="Gebruikersnaam" maxlength="64"
                       class="form-control" required="true" value="<?php if (!empty($waardes['gebruikersnaam'])) {
                    echo $waardes['gebruikersnaam'];
                } ?>">
            </div>

            <div class="form-group">
                <label for="wachtwoord">Wachtwoord*</label>
                <input name="wachtwoord" id="wachtwoord" type="password" placeholder="Wachtwoord"
                       maxlength="60"
                       class="form-control" required="true">
            </div>

            <div class="form-group">
                <label for="wachtwoord2">Bevestig wachtwoord*</label>
                <input name="wachtwoord2" id="wachtwoord2" type="password" maxlength="60"
                       placeholder="Herhaal wachtwoord"
                       class="form-control" required="true">
            </div>

            <hr>

            <div class="form-group">
                <label for="geheimevraag">Geheime vraag*</label>
                <select name="geheimevraag" id="geheimevraag" type="text"
                        placeholder="Kies een geheime vraag"
                        class="form-control" required="true">
                    <?php
                    printVragen($Vragen);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="antwoord">Antwoord op je geheime vraag*</label>
                <input name="antwoord" id="antwoord" type="text"
                       placeholder="Antwoord op je geheime vraag"
                       class="form-control" required="true" maxlength="16">
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-push-3 text-center">
                    <button type="submit" class="btn btn-primary">Registreer!</button>
                </div>
            </div>


        </form>
    </div>
</div>

<input id="fileopen" type="file" value=""/>
<button id="clear">Clear</button>
<script>
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

    jQuery(function ($) {
        $('#thumbnail').change(function () {
            if ($(this).val()) {
                var filename = $(this).val().replace(/^.*[\\\/]/, '');
                $(this).closest('#ThumbnailUpload').find('#ThumbnailName').html(filename);
            }
            var total = this.files[0].size
            var maxMB = 5;
            if ((total/1000/1024)  > maxMB) {
                alert("U heeft de maximum grootte van 15MB overschreden. Uw foto's zijn: " + (total /1000/1024).toFixed(2) + "MB");
                $("#afbeelding").val("");
                $("#AfbeeldingName").html("Selecteer drie extra afbeeldingen!");
            }
        });
    });

    jQuery(function ($) {
        $('#afbeelding').change(function () {
            var filenames = '';
            for (var i = 0; i < this.files.length; i++) {
                filenames += '<p>' + this.files[i].name + '</p>';
            }
            var total = 0;
            $("#afbeelding").each(function() {
                for (var i = 0; i < this.files.length; i++) {
                    total += this.files[i].size;
                }
            });
            $("#AfbeeldingName").html(filenames);
            if ($("#afbeelding")[0].files.length > 3) {
                alert("You can select only 3 images");
                $("#afbeelding").val("");
                $("#AfbeeldingName").html("Selecteer drie extra afbeeldingen!");
            }
            var maxMB = 15;
            if (total / 1000 / 1024  > maxMB) {
                alert("U heeft de maximum grootte van 15MB overschreden. Uw foto's zijn: " + (total /1000/1024).toFixed(2) + "MB");
                $("#afbeelding").val("");
                $("#AfbeeldingName").html("Selecteer drie extra afbeeldingen!");
            }
        });
    });
</script>


</body>
</html>
