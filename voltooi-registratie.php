<?php
session_start();

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

function doRegistratie()
{

    if (isset($_SESSION['voornaam'])) {

        $gebruikersnaam = $_SESSION['gebruikersnaam'];
        $voornaam = $_SESSION['voornaam'];
        $achternaam = $_SESSION['achternaam'];
        $adres1 = $_SESSION['adres1'];
        $adres2 = $_SESSION['adres2'];
        $postcode = $_SESSION['postcode'];
        $woonplaats = $_SESSION['woonplaats'];
        $land = $_SESSION['land'];
        $geboortedatum = $_SESSION['geboortedatum'];
        $email = $_SESSION['email'];
        $wachtwoord = $_SESSION['wachtwoord'];
        $geheimevraag = $_SESSION['geheimevraag'];
        $antwoord = $_SESSION['antwoord'];

        echo $gebruikersnaam;
        echo '</br>';
        echo $voornaam;
        echo '</br>';
        echo $achternaam;
        echo '</br>';
        echo $adres1;
        echo '</br>';
        echo $adres2;
        echo '</br>';
        echo $postcode;
        echo '</br>';
        echo $woonplaats;
        echo '</br>';
        echo $land;
        echo '</br>';
        echo $geboortedatum;
        echo '</br>';
        echo $email;
        echo '</br>';
        echo $wachtwoord;
        echo '</br>';
        echo $geheimevraag;
        echo '</br>';
        echo $antwoord;


        echo "</br></br>stap 1</br></br>";


        $sql = <<<EOT
        INSERT INTO Gebruiker ( GEB_gebruikersnaam,  GEB_voornaam,   GEB_achternaam,   GEB_adresregel_1, GEB_adresregel_2,   GEB_postcode,   GEB_plaatsnaam,   GEB_Land,   GEB_geboortedag,    GEB_mailbox,  GEB_wachtwoord,   GEB_vraag,      GEB_antwoordtekst,  GEB_verkoper)
        VALUES        ( :gebruikersnaam,     :voornaam,      :achternaam,      :adres1,          :adres2,            :postcode,      :woonplaats,      :land   ,   :geboortedatum ,    :email,       :wachtwoord,      :geheimevraag,  :antwoord,          '0')
EOT;

        GLOBAL $connection;
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
        $stmt->bindParam(':voornaam', $voornaam);
        $stmt->bindParam(':achternaam', $achternaam);
        $stmt->bindParam(':adres1', $adres1);
        $stmt->bindParam(':adres2', $adres2);
        $stmt->bindParam(':postcode', $postcode);
        $stmt->bindParam(':woonplaats', $woonplaats);
        $stmt->bindParam(':land', $land);
        $stmt->bindParam(':geboortedatum', $geboortedatum);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':wachtwoord', $wachtwoord);
        $stmt->bindParam(':geheimevraag', $geheimevraag);
        $stmt->bindParam(':antwoord', $antwoord);
        $stmt->execute();

//session_destroy();

    }
}

?>

<!doctype HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Verifieer Emailadres</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="I-Project - Groep 3">

    <!-- Theme colors mobile -->
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#F6D155">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#F6D155">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#F6D155">

    <!-- setting browser icon -->
    <link rel="icon" href="images/Site-logo.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <link rel="stylesheet" href="CSS/BootstrapXL.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
        </div>
    </div>
</div>


</body>
</html>






























