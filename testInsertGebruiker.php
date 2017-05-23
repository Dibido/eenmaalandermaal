<?php

require('PHP/connection.php');
//require('PHP/Functions.php');
//require('PHP/SQL-Queries.php');


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

print_r($stmt);

$stmt->execute();


?>