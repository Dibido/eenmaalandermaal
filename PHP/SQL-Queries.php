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
  (COALESCE((SELECT TOP 1 BOD_Bodbedrag
             FROM Bod
             WHERE BOD_Bodbedrag IN (SELECT TOP 1 BOD_Bodbedrag
                                     FROM Bod
                                     WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                     ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
             ORDER BY BOD_Bodbedrag DESC), (SELECT DISTINCT VW_startprijs
                                            FROM Voorwerp
                                            WHERE VW_voorwerpnummer = VW_voorwerpnummer))) AS prijs,
  --Tijdsverschil tussen nu en het einde van de veiling
  VW_looptijdEinde                                                                         AS tijd,
  VW_looptijdEinde,
    VW_thumbnail       AS ImagePath,
  COUNT(*)                                                                                 AS Biedingen
--Selecteerd het eerste filepath die hij vind voor het voorwerpnummer

FROM Voorwerp
  INNER JOIN BOD
    ON Voorwerp.VW_voorwerpnummer = BOD_voorwerpnummer
--Vul hier de minimum en maximum tijd over in

WHERE DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) < 1000 AND DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) > 2 AND
  VW_voorwerpnummer IN (SELECT VW_voorwerpnummer
                        FROM Voorwerp
                          INNER JOIN Voorwerp_Rubriek
                            ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
                        WHERE VR_Rubriek_Nummer IN (
                          SELECT TOP 30 Rubriek.RB_Nummer
                          FROM Voorwerp
                            LEFT OUTER JOIN Bod ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
                            LEFT OUTER JOIN Voorwerp_Rubriek
                              ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
                            LEFT OUTER JOIN Rubriek ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                          GROUP BY Rubriek.RB_Nummer, VW_voorwerpnummer
                          ORDER BY COUNT(BOD_voorwerpnummer) DESC
                        )
  )
GROUP BY VW_voorwerpnummer, VW_looptijdEinde, VW_titel,VW_thumbnail
ORDER BY tijd ASC, Biedingen DESC

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
WHERE VW_titel NOT LIKE '%Testpro%' AND VW_voorwerpnummer IN (
  SELECT DISTINCT BOD_voorwerpnummer
  --Selecteerd de naam van de Hoofdcategorie per voorwerpnummer
  FROM Bod
    INNER JOIN Voorwerp_Rubriek
      ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
    INNER JOIN Rubriek
      ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
  WHERE RB_Naam != 'root' AND RB_Naam IN (
    select top 5 Rubriek.RB_Naam from Voorwerp
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
  TOP 40
  VW_voorwerpnummer,VW_titel,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
              FROM Bod
              WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                                       FROM Bod
                                       WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                       ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
              ORDER BY BOD_Bodbedrag DESC), (select TOP 1 VW_startprijs from Voorwerp where VW_voorwerpnummer = VW_voorwerpnummer)))  as prijs,
  VW_looptijdEinde,
  (SELECT TOP 1 BES_filenaam
   FROM Bestand
   WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath
FROM Voorwerp
  INNER JOIN Voorwerp_Rubriek
    ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
GROUP BY VW_voorwerpnummer, VW_titel, VW_looptijdStart, VW_looptijdEinde
ORDER BY VW_looptijdStart ASC
EOT;

$QuerySearchProducts;

$QueryQualityNew = <<<EOT
SELECT
  TOP 40
  VW_voorwerpnummer,VW_titel,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
              FROM Bod
              WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                                       FROM Bod
                                       WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                       ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
              ORDER BY BOD_Bodbedrag DESC), (select TOP 1 VW_startprijs from Voorwerp where VW_voorwerpnummer = VW_voorwerpnummer)))  as prijs,
  VW_looptijdEinde,
  VW_thumbnail AS ImagePath
FROM Voorwerp
  INNER JOIN Voorwerp_Rubriek
    ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
GROUP BY VW_voorwerpnummer, VW_titel, VW_looptijdStart, VW_looptijdEinde, VW_thumbnail
ORDER BY VW_looptijdStart ASC, VW_titel

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


/* query voor het zoeken van een user*/
$QueryFindUser = <<<EOT

SELECT GEB_gebruikersnaam
FROM Gebruiker
WHERE GEB_gebruikersnaam = ?
EOT;

/* query voor het zoeken van een user en checken van gebruikersnaam*/
$QueryCheckCredentials = <<<EOT

SELECT GEB_gebruikersnaam, GEB_wachtwoord
FROM Gebruiker
WHERE GEB_gebruikersnaam = ?
EOT;

$rubriekQuery = <<<EOT
SELECT A.RB_Naam AS HoofdRubriek, B.RB_Naam AS Rubriek, C.RB_Naam AS SubRubriek, D.RB_Naam as SubSubRubriek, E.RB_Naam as SubSubSubRubriek, F.RB_Naam as SubSubSubSubRubriek, A.RB_Nummer as HoofdRubriekNummer, B.RB_Nummer as RubriekNummer, C.RB_Nummer AS SubRubriekNummer, D.RB_Nummer as SubSubRubriekNummer, E.RB_Nummer as SubSubSubRubriekNummer,F.RB_Nummer as SubSubSubSubRubriekNummer
                        FROM Rubriek A
						FULL OUTER JOIN Rubriek B
						on B.RB_Parent = A.RB_Nummer
						FULL OUTER JOIN Rubriek C
						on C.RB_Parent = B.RB_Nummer
						FULL OUTER JOIN Rubriek D
						on D.RB_Parent = c.RB_Nummer
						FULL OUTER JOIN Rubriek E
						on E.RB_Parent = D.RB_Nummer
						FULL OUTER JOIN Rubriek F
						on F.RB_Parent = E.RB_Nummer          
                        WHERE A.RB_Parent = -1
                        GROUP BY F.RB_Naam,E.RB_Naam,D.RB_Naam, C.RB_Naam,B.RB_Naam,A.RB_Naam, F.RB_Nummer, E.RB_Nummer,D.RB_Nummer,C.RB_Nummer,B.RB_Nummer,A.RB_Nummer
                        ORDER BY A.RB_Naam, B.RB_Naam, C.RB_Naam,D.RB_Naam,E.RB_Naam, F.RB_Nummer
EOT;

$betalingsMethodeQuery = <<<EOT
select * 
from Betalingswijzen 
ORDER BY BW_betalingswijze desc
EOT;

?>