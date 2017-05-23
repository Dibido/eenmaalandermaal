<?php
session_start();

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

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

?>


































