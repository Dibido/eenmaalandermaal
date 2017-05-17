<?php

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['voornaam'])) {
        $voornaam = $_POST['voornaam'];
    }

    if (isset($_POST['achternaam'])) {
        $achternaam = $_POST['achternaam'];
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    if (isset($_POST['adres1'])) {
        $adres1 = $_POST['adres1'];
    }

    if (isset($_POST['adres2'])) {
        $adres2 = $_POST['adres2'];
    }

    if (isset($_POST['postcode'])) {
        $postcode = $_POST['postcode'];
    }

    if (isset($_POST['land'])) {
        $land = $_POST['land'];
    }

    if (isset($_POST['geboortedatum'])) {
        $geboortedatum = $_POST['geboortedatum'];
    }

    if (isset($_POST['gebruikersnaam'])) {
        $gebruikersnaam = $_POST['gebruikersnaam'];
    }

    if (isset($_POST['wachtwoord'])) {
        $wachtwoord = $_POST['wachtwoord'];
    }

    if (isset($_POST['wachtwoord2'])) {
        $wachtwoord2 = $_POST['wachtwoord2'];
    }

    if (isset($_POST['geheimevraag'])) {
        $geheimevraag = $_POST['geheimevraag'];
    }

    if (isset($_POST['antwoord'])) {
        $antwoord = $_POST['antwoord'];
    }

    echo $voornaam . $achternaam . $email . $adres1 . $adres2 . $postcode . $land . $geboortedatum . $gebruikersnaam . $wachtwoord . $wachtwoord2 . $geheimevraag . $antwoord;


    // Wachtwoord check!!
    $registreerQuerie = " ";

}


SendToDatabase();



?>


































