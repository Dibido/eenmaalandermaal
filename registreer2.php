<?php
session_start();

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

$Landen = SendToDatabase($GetLandenQuerie);
$Vragen = SendToDatabase($GetVragenQuerie);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['voornaam']) && ($_POST['achternaam']) && ($_POST['email']) && ($_POST['adres1']) && ($_POST['adres2']) && ($_POST['postcode']) && ($_POST['woonplaats']) && ($_POST['land']) && ($_POST['geboortedatum']) && ($_POST['gebruikersnaam']) && ($_POST['wachtwoord']) && ($_POST['wachtwoord2']) && ($_POST['geheimevraag']) && ($_POST['antwoord'])) {
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $email = $_POST['email'];
        $adres1 = $_POST['adres1'];
        $adres2 = $_POST['adres2'];
        $postcode = $_POST['postcode'];
        $woonplaats = $_POST['woonplaats'];
        $land = $_POST['land'];
        $geboortedatum = $_POST['geboortedatum'];
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];
        $wachtwoord2 = $_POST['wachtwoord2'];
        $geheimevraag = $_POST['geheimevraag'];
        $antwoord = $_POST['antwoord'];

        if ($wachtwoord == $wachtwoord2) {

            $_SESSION["voornaam"] = $voornaam;
            $_SESSION["achternaam"] = $achternaam;
            $_SESSION["email"] = $email;
            $_SESSION["adres1"] = $adres1;
            $_SESSION["adres2"] = $adres2;
            $_SESSION["postcode"] = $postcode;
            $_SESSION["woonplaats"] = $woonplaats;
            $_SESSION["land"] = $land;
            $_SESSION["geboortedatum"] = $geboortedatum;
            $_SESSION["gebruikersnaam"] = $gebruikersnaam;
            $_SESSION["wachtwoord"] = $wachtwoord;
            $_SESSION["geheimevraag"] = $geheimevraag;
            $_SESSION["antwoord"] = $antwoord;

            header('Location: voltooi-registratie.php');
        } else {
            echo 'wachtwoorden niet identiek';
        }

    }
} else {
    $emailadres = validateHash();
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

        <!-- Theme colors mobile -->
        <!-- Chrome, Firefox OS and Opera -->
        <meta name="theme-color" content="#F6D155">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#F6D155">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#F6D155">


        <!-- setting the browser icon -->
        <link rel="icon" href="images/Site-logo.png">


        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="CSS/theme.css">
        <link rel="stylesheet" href="CSS/BootstrapXL.css">
        <!-- Datepicker -->
        <link rel="stylesheet"
              href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css"/>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Datepicker -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>


        <!-- CSS -->
        <link rel="stylesheet" href="CSS/HomePage.css">
        <link rel="stylesheet" href="CSS/veiling.css">
        <link rel="stylesheet" href="CSS/navigation.css">

    </head>

    <body>

    <!-- Navigation -->

    <?php
    require('navbar.html');
    ?>


    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Registreren - Stap 2</li>
    </ol>


    <div class="container">
        <div class="panel panel-default col-md-6 col-md-push-3">
            <div class="panel-body">

                <div class="row text-center">
                    <div class="col-md-6 col-md-push-3">
                        <h2>Vul hier uw gegevens in.</h2>
                        <h3>Na de registratie en het valideren van uw Emailadres, kunt u direct mee bieden!</h3>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 col-md-push-3">

                        <form method="POST" id="registratieformulier" action="registreer2.php">

                            <div class="form-group">
                                <label for="voornaam">Voornaam*</label>
                                <input name="voornaam" id="voornaam" type="text" placeholder="Voornaam" maxlength="16"
                                       class="form-control" required="true" value="<?php if (!empty($voornaam)) {
                                    echo $voornaam;
                                } ?>">
                            </div>

                            <div class="form-group">
                                <label for="achternaam">Achternaam*</label>
                                <input name="achternaam" id="achternaam" type="text" placeholder="Achternaam"
                                       class="form-control" required="true" maxlength="16"
                                       value="<?php if (!empty($achternaam)) {
                                           echo $achternaam;
                                       } ?>">
                            </div>

                            <div class="form-group">
                                <label for="Email">Email*</label>
                                <input name="email" id="email" type="text"
                                       value="<?php
                                       if (empty($emailadres)) {
                                           echo $email;
                                       } else {
                                           echo $emailadres;
                                       } ?>" readonly
                                       class="form-control" required="true">
                            </div>

                            <div class="form-group">
                                <label for="adres1">Adresregel 1*</label>
                                <input name="adres1" id="adres1" type="text" placeholder="Adresregel 1"
                                       class="form-control" required="true" maxlength="255"
                                       value="<?php if (!empty($adres1)) {
                                           echo $adres1;
                                       } ?>">
                            </div>

                            <div class="form-group">
                                <label for="adres2">Adresregel 2</label>
                                <input name="adres2" id="adres2" type="text" placeholder="Adresregel 2"
                                       class="form-control" maxlength="255"
                                       value="<?php if (!empty($adres2)) {
                                           echo $adres2;
                                       } ?>">
                            </div>

                            <div class="form-group">
                                <label for="postcode">Postcode*</label>
                                <input name="postcode" id="postcode" type="text" placeholder="1234 AB"
                                       class="form-control" required="true" maxlength="12"
                                       value="<?php if (!empty($postcode)) {
                                           echo $postcode;
                                       } ?>">
                            </div>

                            <div class="form-group">
                                <label for="woonplaats">Woonplaats*</label>
                                <input name="woonplaats" id="woonplaats" type="text" placeholder="Woonplaats"
                                       class="form-control" required="true" maxlength="85"
                                       value="<?php if (!empty($woonplaats)) {
                                           echo $woonplaats;
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
                                       data-date-format="dd/mm/yyyy"
                                       placeholder="Geboortedatum"
                                       class="form-control" required="true" value="<?php if (!empty($geboortedatum)) {
                                    echo $geboortedatum;
                                } ?>">
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="gebruikersnaam">Gebruikersnaam*</label>
                                <input name="gebruikersnaam" id="gebruikersnaam" type="text"
                                       placeholder="Gebruikersnaam" maxlength="64"
                                       class="form-control" required="true" value="<?php if (!empty($gebruikersnaam)) {
                                    echo $gebruikersnaam;
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
            </div>
        </div>
    </div>


    </body>
    </html>
