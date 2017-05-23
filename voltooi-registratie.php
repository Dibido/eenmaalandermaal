<?php
session_start();

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

if (isset($_SESSION['voornaam'])) {

    $voornaam = $_SESSION['voornaam'];
    $achternaam = $_SESSION['achternaam'];
    $email = $_SESSION['email'];
    $adres1 = $_SESSION['adres1'];
    $adres2 = $_SESSION['adres2'];
    $postcode = $_SESSION['postcode'];
    $woonplaats = $_SESSION['woonplaats'];
    $land = $_SESSION['land'];
    $geboortedatum = $_SESSION['geboortedatum'];
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    $wachtwoord = $_SESSION['wachtwoord'];
    $geheimevraag = $_SESSION['geheimevraag'];
    $antwoord = $_SESSION['antwoord'];

    echo "stap 1";


    $sql = 'INSERT INTO Gebruiker (GEB_gebruikersnaam,  GEB_voornaam,   GEB_achternaam,   GEB_adresregel_1, GEB_adresregel_2,   GEB_postcode,   GEB_plaatsnaam,   GEB_Land,   GEB_geboortedag,    GEB_mailbox,  GEB_wachtwoord,   GEB_vraag,      GEB_antwoordtekst, GEB_verkoper,  GEB_rating)
            VALUES                (\'$gebruikersnaam\', \'$voornaam\',  \'$achternaam\',  \'$adres1\',      \'$adres2\',        \'$postcode\',  \'$woonplaats\',  \'$land\',  \'$geboortedatum\', \'$email\',   \'$wachtwoord\',  $geheimevraag,  \'$antwoord\',      0, )';



    InsertIntoDatabase($sql);

    echo 'inserted into DB';

   // session_destroy();

}

?>


































