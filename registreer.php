<?php
require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

$query = "SELECT *, dbo.All Animal.Group as allAnimal_Group
            LEFT JOIN dbo.All Animal on dbo.Response.animalGroup = dbo.All Animal.Group
            WHERE dbo.Response.animalGroup = %s";
$db->query($query, $Group);
$r = $db->fetch();

?>


<!doctype HTML>
<html lang="eng">

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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css"/>

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
    <li class="breadcrumb-item active">Registreer</li>
</ol>


<div class="container">


    <div class="row text-center">
        <div class="col-md-6 col-md-push-3">
            <div class="well well-lg ">
                <h2>
                    Vul hier uw gegevens in.
                </h2>
                <h3>
                    Na de registratie en het valideren van uw Emailadres, kunt u direct mee bieden!
                </h3>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6 col-md-push-3">

            <form method="POST" id="registratieformulier">

                <div class="form-group">
                    <label for="voornaam">Voornaam*</label>
                    <input id="voornaam" type="text" placeholder="Voornaam"
                           class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="achternaam">Achternaam*</label>
                    <input id="achternaam" type="text" placeholder="Achternaam"
                           class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="Email">Email*</label>
                    <input id="email" type="text" placeholder="voorbeeld@voorbeeld.com"
                           class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="adres1">Adresregel 1*</label>
                    <input id="adres1" type="text" placeholder="Adresregel 1"
                           class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="adres2">Adresregel 2</label>
                    <input id="adres2" type="text" placeholder="Adresregel 2"
                           class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="postcode">Postcode*</label>
                    <input id="postcode" type="text" placeholder="1234 AB"
                           class="form-control" required="true">
                </div>

                <!-- PHP en DB link fixen -->
                <div class="form-group">
                    <label for="land">Land*</label>
                    <select id="land" type="text" placeholder="Land"
                            class="form-control" required="true">
                        <option value="1">Optie 1</option>
                        <option>Select a type:</option>


                        <?php

                        $Landen = SendToDatabase($GetLandenQuerie);


                        foreach ($Landen as $Land) {
                            ?>
                            <option value="<?php echo $m['Group']; ?>"><?php echo $m['animalGroup']; ?></option>
                            <?php
                        }

                        ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="geboortedatum">Geboortedatum*</label>
                    <input id="geboortedatum" type="text" data-provide="datepicker"
                           data-date-format="dd/mm/yyyy"
                           placeholder="Geboortedatum"
                           class="form-control" required="true">
                </div>

                <hr>

                <div class="form-group">
                    <label for="gebruikersnaam">Gebruikersnaam*</label>
                    <input id="gebruikersnaam" type="text" placeholder="Gebruikersnaam"
                           class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="wachtwoord">Wachtwoord*</label>
                    <input id="wachtwoord" type="password" placeholder="Wachtwoord"
                           class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="wachtwoord2">Bevestig wachtwoord*</label>
                    <input id="wachtwoord2" type="password" placeholder="Herhaal wachtwoord"
                           class="form-control" required="true">
                </div>

                <hr>

                <!-- Vragen ophalen DB-->
                <div class="form-group">
                    <label for="geheimevraag">Geheime vraag*</label>
                    <select id="geheimevraag" type="text" placeholder="Herhaal wachtwoord"
                            class="form-control" required="true">
                        <option value="1">Optie 1</option>
                        <option value="2">Optie 2</option>
                        <option value="3">Optie 3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="antwoord">Antwoord op je geheime vraag*</label>
                    <input id="antwoord" type="text" placeholder="Antwoord op je geheime vraag"
                           class="form-control" required="true">
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


</body>
</html>
