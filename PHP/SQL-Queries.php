<?php


/*
 *
 *  This file includes functions for often-used SQL querries, thus giving the HTML-pages better readability
 *
 *
 */


/*
 *
 *  These are all the used querries
 *
 */



$QueryTopCategories = <<<EOT


select top 10 Rubriek.RB_Naam, COUNT(BOD_voorwerpnummer) as aantal1, COUNT(VW_voorwerpnummer) as aantal2, RB_Nummer
 from Voorwerp
  LEFT OUTER JOIN Bod ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Voorwerp_Rubriek ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Rubriek ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
GROUP BY Rubriek.RB_Naam, RB_Nummer
ORDER BY COUNT(BOD_voorwerpnummer)DESC , COUNT(VW_voorwerpnummer) DESC


EOT;




$QueryTop2 = <<<EOT

SELECT
--Vul hier je TOP X hoeveelheid in
  TOP 2
  VW_voorwerpnummer,
  VW_titel,
  --Laat het hoogste bod zien op het voorwerpnummer
(COALESCE ((SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC), (select DISTINCT VW_startprijs from Voorwerp where VW_voorwerpnummer = VW_voorwerpnummer)))  as prijs,
  --Tijdsverschil tussen nu en het einde van de veiling
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  VW_looptijdEinde,
  COUNT(*)                                       AS Biedingen,
  --Selecteerd het eerste filepath die hij vind voor het voorwerpnummer
(SELECT TOP 1 BES_filenaam
   FROM Bestand
   WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath
FROM Voorwerp
  INNER JOIN BOD
    ON Voorwerp.VW_voorwerpnummer = BOD_voorwerpnummer
--Vul hier de minimum en maximum tijd over in
WHERE DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) < 1000 AND DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) > 2 AND
VW_voorwerpnummer IN (SELECT BOD_voorwerpnummer
                            FROM Rubriek
--Lees de de Innerjoins van achter naar voren(onder naar boven). Begin bij STAP 1 op regel 81.
--STAP 4: De overgebleven Rubrieken worden nog een keer gekoppeld aan hun parent zodat de Hoogste parent verkregen is.
INNER JOIN
(SELECT
                                 Rubriek.RB_Parent,
                                 BOD_voorwerpnummer,
                                 aantal
                                 --STAP 3: De geselecteerde rubrieken met daarbij de aantallen per rubriek worden gekoppeld aan de eerste parent
                               FROM Rubriek
                                 INNER JOIN (SELECT
                                               RB_Parent,
                                               COUNT(BOD_voorwerpnummer) AS aantal,
                                               BOD_voorwerpnummer
                                             FROM Voorwerp_Rubriek
--STAP 2: Het Rubriek nummer wordt gekoppeld aan zijn rij in de tabel Rubriek
                                               INNER JOIN Rubriek
                                                 ON Rubriek.RB_Nummer =
    Voorwerp_Rubriek.VR_Rubriek_Nummer
    --STAP 1: Biedingen worden gekoppeld aan een RubriekNummer
                                               INNER JOIN Bod
                                                 ON Voorwerp_Rubriek.VR_Voorwerp_Nummer =
    Bod.BOD_voorwerpnummer
                                             GROUP BY RB_Parent, BOD_voorwerpnummer) eerste
                                   ON Rubriek.RB_Volgnummer = eerste.RB_Parent
                               GROUP BY Rubriek.RB_Parent, aantal, BOD_voorwerpnummer) tweede
                                ON Rubriek.RB_Volgnummer = tweede.RB_Parent
                            WHERE Rubriek.RB_Parent = -1
                            GROUP BY Rubriek.RB_Naam, BOD_voorwerpnummer)
GROUP BY VW_voorwerpnummer, VW_looptijdEinde, VW_titel
ORDER BY tijd ASC,Biedingen DESC

EOT;


$QueryFromBestCategory = <<< EOT


SELECT
  TOP 3
  VW_voorwerpnummer,
  VW_titel,
  (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
              FROM Bod
              WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                                       FROM Bod
                                       WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                       ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
              ORDER BY BOD_Bodbedrag DESC), VW_startprijs ))  as prijs,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  COUNT(*)                                       AS Biedingen,
  VW_looptijdEinde,
  (SELECT TOP 1 BES_filenaam
   FROM Bestand
   WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath
FROM Voorwerp
  --Inner join naar Bod zodat per Voorwerp het aantal biedingen bekeken kan worden.
  INNER JOIN Bod
    ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
--Where statement om te kijken of het Voorwerp nummer in de belangrijkste categorie zit.
WHERE VW_voorwerpnummer IN (
  SELECT DISTINCT BOD_voorwerpnummer
  --Selecteerd de naam van de Hoofdcategorie per voorwerpnummer
  FROM Bod
    INNER JOIN Voorwerp_Rubriek
      ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
    INNER JOIN Rubriek
      ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
  WHERE RB_Naam != 'root' AND RB_Naam IN (
    select top 1 Rubriek.RB_Naam from Voorwerp
      LEFT OUTER JOIN Bod ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
      LEFT OUTER JOIN Voorwerp_Rubriek ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
      LEFT OUTER JOIN Rubriek ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
    GROUP BY Rubriek.RB_Naam
    ORDER BY COUNT(BOD_voorwerpnummer)DESC , COUNT(VW_voorwerpnummer) DESC
  )
) --TODO AND Verkoper van voorwerp in top van de gebruikerreviews
GROUP BY VW_voorwerpnummer, VW_titel, VW_looptijdEinde, VW_startprijs
ORDER BY Biedingen DESC



EOT;


/* Work in progress! */

$QueryAllAuctions = <<<EOT

SELECT
  VW_voorwerpnummer,
  VW_titel,
  (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC), (select DISTINCT VW_startprijs from Voorwerp where VW_voorwerpnummer = VW_voorwerpnummer)))  as prijs,
  BES_filenaam,
      VW_looptijdEinde,

FROM Voorwerp
RIGHT OUTER JOIN Bestand ON Voorwerp.VW_voorwerpnummer = Bestand.BES_voorwerpnummer

EOT;

$QuerySearchProducts;

$QueryQualityNew = <<<EOT

SELECT
VW_voorwerpnummer,VW_titel,
DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
(COALESCE ((SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC), (select DISTINCT VW_startprijs from Voorwerp where VW_voorwerpnummer = VW_voorwerpnummer)))  as prijs,
    VW_looptijdEinde,
   (SELECT TOP 1 BES_filenaam
   FROM Bestand
   WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath
FROM Voorwerp
INNER JOIN Voorwerp_Rubriek
ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
INNER JOIN Rubriek
ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
INNER JOIN Rubriek r1
ON r1.RB_Nummer = Rubriek.RB_Parent
INNER JOIN Rubriek r2
ON r2.RB_Nummer = r1.RB_Parent
GROUP BY VW_voorwerpnummer, VW_titel, VW_looptijdStart, VW_looptijdEinde
ORDER BY VW_looptijdStart ASC


EOT;



/* Query landen ophalen registratie form */
$GetLandenQuerie = <<<EOT

SELECT LAN_landcode, LAN_landnaam FROM Landen
EOT;


/* Query landen ophalen registratie form */
$GetVragenQuerie = <<<EOT
SELECT * FROM Vraag
EOT;


/* Query nieuwe registratie */
$SetRegistratie = <<<EOT

INSERT INTO Registreer(REG_email, REG_code) VALUES (:email, :code)
EOT;

/* Query voor paginanummering op resultaten.php */

$GetResultatenPagina = <<<EOT
SELECT * FROM Voorwerp
ORDER BY VW_voorwerpnummer
OFFSET 3 ROWS
FETCH NEXT 10 ROWS ONLY
EOT;



/* query voor de voorwerppagina */

$QueryDetailsFromItem = <<<EOT

SELECT
  DISTINCT VW_voorwerpnummer,
  VW_titel,
  (SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag IN (SELECT TOP 1 BOD_Bodbedrag
                           FROM Bod
                           WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                           ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC)                        AS prijs,
  DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) AS tijd,
  VW_looptijdStart,
  VW_looptijdEinde,
  VW_betalingswijze,
  VW_beschrijving,
  VW_plaatsnaam,
  VW_land,
  VW_looptijdStart,
  VW_verkoper,
  VW_thumbnail,
  VW_veilinggesloten,
  VW_koper,
  VW_verkoopprijs,
  VW_verzendinstructies,
  VW_verzendkosten
FROM Voorwerp
  LEFT OUTER JOIN Bod ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Voorwerp_Rubriek ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Rubriek ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
  LEFT OUTER JOIN Rubriek r1 ON r1.RB_Nummer = Rubriek.RB_Parent
  LEFT OUTER JOIN Rubriek r2 ON r2.RB_Nummer = r1.RB_Parent
  LEFT OUTER JOIN Rubriek r3 ON r3.RB_Nummer = r2.RB_Parent
  LEFT OUTER JOIN Rubriek r4 ON r4.RB_Nummer = r3.RB_Parent
WHERE VW_voorwerpnummer = 


EOT;

/* query for getting the images from an item*/

$QueryImagesFromItem = <<<EOT

SELECT BES_filenaam
FROM Bestand, Voorwerp
WHERE Bestand.BES_voorwerpnummer =

EOT;


?>