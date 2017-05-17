INSERT INTO Vraag
VALUES(1, 'Hoe heet je hond')


INSERT INTO Gebruiker
VALUES ('luckhermsen', 'luck', 'hermsen', 'stekkenberg 4', '4', '6561 XJ', 'Groesbeek', 'NL', '1995/01/31', 'luckmatheushermsen@gmail.com', 'wachtwoord',  1, 'Antwoord', 0)



-- Zonder adres 2
INSERT INTO Gebruiker
VALUES ('luckhermsen', 'luck', 'hermsen', 'stekkenberg 4', $adres2, $postcode, PLAATSNAAM, $land, $geboortedatum, $email, $wachtwoord, $geheimevraag, $antwoord, 0)


-- Met adres 2
INSERT INTO Gebruiker
VALUES ($gebruikersnaam, $voornaam, $achternaam, $adres1, $adres2, $postcode, PLAATSNAAM, $land, $geboortedatum, $email, $wachtwoord, $geheimevraag, $antwoord, 0)



SELECT * FROM gebruiker