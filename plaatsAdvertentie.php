<?php

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
Session_START();
$Betalingswijzen = SendToDatabase($GetBethaalMethodesQuerie);
$Landen = SendToDatabase($GetLandenQuerie);
$Landnamen = SendToDatabase2($GetLandnaamQuerie);
$rubriek = '';
//$Looptijden = SendToDatabase($GetLooptijdenQuerie);
if (isset($_GET['rubriek']) && !empty($_GET['rubriek'])) {
    $rubriek = ($_GET['rubriek']);
    if(!is_numeric($rubriek)){
        $rubriek = 38;
    }
    $_POST['rubriek'] = $rubriek;
}
$waardes = $_POST;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = 'upload/';
    $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]);
    $errorResults = checkPlaatsenVoorwerp($Betalingswijzen, $Landnamen);
    if ($errorResults[sizeof($errorResults) - 1] != true) {
        $veilingInput = prepareveilingInput($waardes,$_SESSION);
        plaatsAdvertentie($veilingInput);
        print_r(getLastID());
        $lastID = getLastID();

        $stmt = $connection->prepare($plaatsVeilingInRubriekQuery);


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


<h1 class="text-center">Plaats Advertente!</h1>
<br>

<div class="well container">

    <?php
    if (!empty($errorResults)) {
        echo '<div class="col-xs-12" ><div class="alert alert-danger alert-dismissable fade in center-block col-md-6 col-md-push-3">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h2 class="center-text alert-danger" ><strong>Niet alles is goed ingevuld!</strong></h2><br>';
        echo drawErrorResult($errorResults);
        echo '</div></div>';
    } ?>
    <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-xs-push-1">
        <h2>Kies eerst uw rubriek!</h2>
        <hr>
        <br>
        <div class="list-group-item panel-collapse collapse in">
            <?php
            printCategoriesAdvertentiePagina($rubriekQuery, $rubriek);
            ?>
        </div>
    </div>
    <div class="col-md-5 col-sm-5 col-xs-5 col-xs-push-2 right">
        <form method="POST" enctype="multipart/form-data">
            <?php
            if (!isset($_GET['rubriek'])) {
                echo "<fieldset disabled>";
            }
            ?>
            <h2>Voorwerp details</h2>
            <hr>
            <br>
            <div class="form-group">
                <h4>Titel Voorwerp*</h4>
                <input name="Titel" id="Titel" type="text" placeholder="Titel" maxlength="90"
                       class="form-control" value="<?php if (!empty($waardes['Titel'])) {
                    echo $waardes['Titel'];
                } ?>">
            </div>

            <div class="form-group">
                <label for="Beschrijving"></label><h4>Beschrijving*</h4>
                <textarea name="Beschrijving" id="Beschrijving"
                          placeholder="Vul hier de beschrijving van je voorwerp in!"
                          class="form-control" rows="5" value="
                          "><?php if (!empty($waardes['Beschrijving'])) {
                        echo $waardes['Beschrijving'];
                    } ?></textarea>
            </div>

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
            <div class="col-md-6 nopadding">
                <h4>Startprijs*</h4>

                <div class="input-group">

                <span class="input-group-addon" id="basic-addon1"> <i
                            class="glyphicon glyphicon-euro"></i></span>
                    <input name="startprijs" id="startprijs" type="number" placeholder="Startprijs"
                           class="form-control" ="true" maxlength="9"
                    value="<?php if (!empty($waardes['startprijs'])) {
                        echo $waardes['startprijs'];
                    } ?>">
                </div>
            </div>
            <div class="col-md-6 nopadding1">
                <h4>Betalingswijze*</h4>
                <div class="form-group">
                    <select name="betalingswijze" id="betalingswijze"
                            class="form-control" ="true">
                    <?php
                    printBetalingswijzen($Betalingswijzen);
                    ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <h4>Betalingsinstructie*</h4>
                <textarea name="Betalingsinstructie" id="Betalingsinstructie"
                          placeholder="Vul hier jouw betalingsinstructie in!"
                          class="form-control" rows="5"><?php if (!empty($waardes['Betalingsinstructie'])) {
                        echo $waardes['Betalingsinstructie'];
                    } ?></textarea>
            </div>

            <h2>Locatie</h2>
            <hr>
            <br>
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
            <div class="col-md-6 nopadding1">
                <h4>Land*</h4>
                <div class="form-group">
                    </label>
                    <select name="land" id="land" type="text"
                            class="form-control">
                        <?php
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
            <div class="form-group">
                <h4>Verzendkosten*</h4>
                <input name="verzendkosten" id="verzendkosten" type="number"
                       placeholder="Vul hier je verzendkosten in" maxlength="64"
                       class="form-control" value="<?php if (!empty($waardes['verzendkosten'])) {
                    echo $waardes['verzendkosten'];
                } ?>">
            </div>

            <div class="form-group">
                <h4>Verzendinstructies*</h4>

                <textarea name="verzendinstructies" id="verzendinstructies"
                          placeholder="Vul hier jouw verzendinstructies in!"
                          class="form-control" rows="5"><?php if (!empty($waardes['verzendinstructies'])) {
                        echo $waardes['verzendinstructies'];
                    } ?></textarea>
            </div>
            <br>
            <button class="btn-primary btn-lg center-block" type="submit">
                Plaats advertentie!
            </button>
            <?php if (!isset($_GET['rubriek'])) {
                echo '</fieldset>';
            }
            ?>
            <input type="hidden" name="rubriek" value="
               <?php
                echo $rubriek;
                ?>">
        </form>
    </div>
</div>

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
            if ((total / 1000 / 1024) > maxMB) {
                alert("U heeft de maximum grootte van" + maxMB + "MB overschreden. Uw foto's zijn: " + (total / 1000 / 1024).toFixed(2) + "MB");
                $("#thumbnail").val("");
                $("#ThumbnailName").html("Selecteer een afbeelding!");
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
            $("#afbeelding").each(function () {
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
            if (total / 1000 / 1024 > maxMB) {
                alert("U heeft de maximum grootte van" + maxMB + "MB overschreden. Uw foto's zijn: " + (total / 1000 / 1024).toFixed(2) + "MB");
                $("#afbeelding").val("");
                $("#AfbeeldingName").html("Selecteer drie extra afbeeldingen!");
            }
        });
    });
</script>

</body>
</html>
