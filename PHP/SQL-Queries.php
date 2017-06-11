<?php

/*
 *
 *  This file includes functions for often-used SQL queries, thus giving the HTML-pages better readability
 *
 *
 */


/*
 *
 *  These are all the used querries
 *
 */

//Insert de bestand namen in de tabel bestand
$QueryInsertImages = <<<EOT

INSERT INTO BESTAND(BES_filenaam, BES_voorwerpnummer)
VALUES (:filenaam , :voorwerpnummer);

EOT;
//Update de thumbnail omdat bij het inserten van het voorwerp het ID nog niet bekend is en de thumbnail dus niet goed ingesteld kan worden.
$QueryUpdateImages = <<<EOT

update Voorwerp
set VW_thumbnail = :thumbnail
where VW_voorwerpnummer = :voorwerpnummer

EOT;

$QueryFindAuctionsByUser = <<<EOT
    
    SELECT
  TOP 2
  VW_voorwerpnummer,
  VW_titel,
  (COALESCE((SELECT TOP 1 BOD_Bodbedrag
             FROM Bod
             WHERE BOD_Bodbedrag IN (SELECT TOP 1 BOD_Bodbedrag
                                     FROM Bod
                                     WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                     ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
             ORDER BY BOD_Bodbedrag DESC), (SELECT TOP 1 VW_startprijs
                                            FROM Voorwerp
                                            WHERE VW_voorwerpnummer = VW_voorwerpnummer))) AS prijs,
  VW_looptijdEinde                                                                         AS tijd,
  VW_looptijdEinde,
  VW_thumbnail       AS ImagePath,
  COUNT(*)                                                                                 AS Biedingen

FROM Voorwerp
WHERE VW_verkoper = ? 
AND VW_voorwerpnummer != ?
GROUP BY VW_voorwerpnummer,vw_titel,VW_looptijdEinde,VW_thumbnail

EOT;

//Laat de top 15 categorieën zien
//Deze zijn geordend op de sum van VW_bodcount
$QueryTopCategories = <<<EOT


SELECT
  TOP 10
  RB_Naam,
  RB_Nummer,
  sum(VW_bodcount)

FROM Rubriek
  INNER JOIN Voorwerp_Rubriek
  ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
  INNER JOIN Voorwerp
  ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
  GROUP BY RB_Naam, RB_Nummer, VW_bodcount
ORDER BY sum(Voorwerp.VW_bodcount) DESC



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
             ORDER BY BOD_Bodbedrag DESC), (VW_startprijs))) AS prijs,
  --Tijdsverschil tussen nu en het einde van de veiling
  VW_looptijdEinde,
  VW_thumbnail       AS ImagePath

FROM Voorwerp
WHERE VW_veilinggesloten != 1 AND DATEDIFF(minute,GETDATE(),VW_looptijdEinde) > 3
GROUP BY VW_voorwerpnummer, VW_looptijdEinde, VW_titel,VW_thumbnail,VW_startprijs, VW_bodcount
ORDER BY VW_looptijdEinde ASC, VW_bodcount DESC, VW_titel ASC


EOT;


$QueryFromBestCategory = <<< EOT

SELECT
  TOP 3
  VW_voorwerpnummer,
  VW_titel,
  (COALESCE((SELECT TOP 1 BOD_Bodbedrag
             FROM Bod
             WHERE BOD_Bodbedrag IN (SELECT TOP 1 BOD_Bodbedrag
                                     FROM Bod
                                     WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                     ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
             ORDER BY BOD_Bodbedrag DESC), VW_startprijs)) AS prijs,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)              AS tijd,
  VW_bodcount                                                 AS Biedingen,
  VW_looptijdEinde,
  --Selecteerd het eerste filepath die hij vind voor het voorwerpnummer
  (SELECT TOP 1 BES_filenaam
   FROM Bestand
   WHERE BES_voorwerpnummer = VW_voorwerpnummer)           AS ImagePath
FROM Voorwerp
--Where statement om te kijken of het Voorwerp nummer in de belangrijkste categorie zit.
WHERE VW_titel NOT LIKE '%Testpro%' AND VW_voorwerpnummer IN (
  SELECT DISTINCT VW_voorwerpnummer
  --Selecteerd de naam van de Hoofdcategorie per voorwerpnummer
  FROM Voorwerp
    FULL OUTER JOIN Voorwerp_Rubriek
      ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = VW_voorwerpnummer
    FULL OUTER JOIN Rubriek
      ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
  WHERE RB_Nummer IN (
    SELECT TOP 1 RB_Nummer
FROM Rubriek
INNER JOIN Voorwerp_Rubriek
ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
INNER JOIN Voorwerp
ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
GROUP BY RB_Nummer
ORDER BY sum(VW_bodcount) DESC
  )
) and VW_veilinggesloten != 1
GROUP BY VW_voorwerpnummer, VW_titel, VW_looptijdEinde, VW_startprijs,VW_bodcount
ORDER BY Biedingen DESC, VW_titel ASC

EOT;

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
              ORDER BY BOD_Bodbedrag DESC), (SELECT TOP 1 VW_startprijs FROM Voorwerp WHERE VW_voorwerpnummer = VW_voorwerpnummer)))  AS prijs,
  VW_looptijdEinde,
  VW_looptijdStart,
  VW_thumbnail AS ImagePath
FROM Voorwerp
WHERE VW_veilinggesloten != 1
GROUP BY VW_voorwerpnummer, VW_titel, VW_looptijdStart, VW_looptijdEinde, VW_thumbnail, VW_looptijdStart
ORDER BY VW_looptijdStart DESC, VW_titel

EOT;



/* Query landen ophalen registratie form */
$GetLandenQuerie = <<<EOT

SELECT LAN_landcode, LAN_landnaam FROM Landen
EOT;

$GetLandnaamQuerie = <<<EOT

SELECT LAN_landcode FROM Landen
EOT;

/* Query om de betaalmethode op te halen */

$GetBethaalMethodesQuerie = <<<EOT
SELECT * FROM Betalingswijzen ORDER BY BW_Betalingswijze DESC
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
WHERE VW_voorwerpnummer = ?


EOT;

/* query for getting the images from an item*/

$QueryImagesFromItem = <<<EOT

SELECT BES_filenaam
FROM Bestand, Voorwerp
WHERE Bestand.BES_voorwerpnummer = ?

EOT;


/* query voor het zoeken van een user*/
$QueryFindUser = <<<EOT

SELECT GEB_gebruikersnaam
FROM Gebruiker
WHERE GEB_gebruikersnaam = ?
EOT;

/* Query voor het zoeken van user info*/
$QueryFindUserInfo = <<<EOT
SELECT
  GEB_gebruikersnaam,
  GEB_voornaam,
  GEB_achternaam,
  GEB_adresregel_1,
  GEB_adresregel_2,
  GEB_postcode,
  GEB_plaatsnaam,
  GEB_geboortedag,
  GEB_mailbox,
  GEB_verkoper,
  GEB_rating,
  GEB_actief,
  (SELECT Landen.LAN_landnaam FROM Landen WHERE LAN_landcode = Gebruiker.GEB_Land) AS GEB_Land
FROM Gebruiker
WHERE GEB_gebruikersnaam = ?

EOT;

//producten van gebruikers voor profiel pagina
$QueryUserAds = <<<EOT
SELECT
  TOP 40
  VW_voorwerpnummer,VW_titel, VW_verkoper,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
              FROM Bod
              WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                                       FROM Bod
                                       WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                       ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
              ORDER BY BOD_Bodbedrag DESC), (SELECT TOP 1 VW_startprijs FROM Voorwerp WHERE VW_voorwerpnummer = VW_voorwerpnummer)))  AS prijs,
  VW_looptijdEinde,
  VW_thumbnail AS ImagePath
FROM Voorwerp

  INNER JOIN Voorwerp_Rubriek
    ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
  
GROUP BY VW_voorwerpnummer, VW_titel, VW_verkoper, VW_looptijdStart, VW_looptijdEinde, VW_thumbnail
HAVING VW_verkoper = ?
ORDER BY VW_looptijdStart ASC, VW_titel

EOT;

// Biedingen van gebruikers voor profiel pagina
$QueryUserBod = <<<EOT
SELECT DISTINCT TOP 40 BOD_voorwerpnummer AS VW_voorwerpnummer, VW_titel, b.BOD_gebruiker, (select distinct TOP 1  BOD_bodTijdEnDag from bod) as tijd1,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
              FROM Bod
              WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                                       FROM Bod
                                       WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                       ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
              ORDER BY BOD_Bodbedrag DESC), (SELECT TOP 1 VW_startprijs FROM Voorwerp WHERE VW_voorwerpnummer = VW_voorwerpnummer)))  AS prijs,
  VW_looptijdEinde,
  VW_thumbnail AS ImagePath,
  BOD_bodTijdEnDag
FROM bod b
INNER JOIN Voorwerp v ON v.VW_voorwerpnummer = b.BOD_voorwerpnummer
WHERE BOD_gebruiker = ?
GROUP BY BOD_voorwerpnummer,vw_voorwerpnummer, BOD_bodTijdEnDag, VW_titel, BOD_gebruiker, VW_looptijdStart, VW_looptijdEinde, VW_thumbnail
order by BOD_bodTijdEnDag desc
EOT;
// Gewonnen ads van gebruiker voor profiel pagina

$QueryUserWin = <<<EOT
SELECT
  TOP 40
  VW_voorwerpnummer,VW_titel, VW_verkoper,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
              FROM Bod
              WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                                       FROM Bod
                                       WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                       ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
              ORDER BY BOD_Bodbedrag DESC), (SELECT TOP 1 VW_startprijs FROM Voorwerp WHERE VW_voorwerpnummer = VW_voorwerpnummer)))  AS prijs,
  VW_looptijdEinde,
  VW_thumbnail AS ImagePath
FROM Voorwerp

  INNER JOIN Voorwerp_Rubriek
    ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
  
GROUP BY VW_voorwerpnummer, VW_titel, VW_verkoper,VW_Koper, VW_looptijdStart, VW_looptijdEinde, VW_thumbnail
HAVING VW_koper IS NOT NULL  AND VW_Koper = ?
ORDER BY VW_looptijdEinde DESC, VW_titel
EOT;


/* query voor het zoeken van een Admin*/
$QueryFindAdmin = <<<EOT

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
SELECT A.RB_Naam AS HoofdRubriek, B.RB_Naam AS Rubriek, C.RB_Naam AS SubRubriek, D.RB_Naam AS SubSubRubriek, E.RB_Naam AS SubSubSubRubriek, F.RB_Naam AS SubSubSubSubRubriek, A.RB_Nummer AS HoofdRubriekNummer, B.RB_Nummer AS RubriekNummer, C.RB_Nummer AS SubRubriekNummer, D.RB_Nummer AS SubSubRubriekNummer, E.RB_Nummer AS SubSubSubRubriekNummer,F.RB_Nummer AS SubSubSubSubRubriekNummer
                        FROM Rubriek A
						FULL OUTER JOIN Rubriek B
						ON B.RB_Parent = A.RB_Nummer
						FULL OUTER JOIN Rubriek C
						ON C.RB_Parent = B.RB_Nummer
						FULL OUTER JOIN Rubriek D
						ON D.RB_Parent = c.RB_Nummer
						FULL OUTER JOIN Rubriek E
						ON E.RB_Parent = D.RB_Nummer
						FULL OUTER JOIN Rubriek F
						ON F.RB_Parent = E.RB_Nummer          
                        WHERE A.RB_Parent = -1
                        GROUP BY F.RB_Naam,E.RB_Naam,D.RB_Naam, C.RB_Naam,B.RB_Naam,A.RB_Naam, F.RB_Nummer, E.RB_Nummer,D.RB_Nummer,C.RB_Nummer,B.RB_Nummer,A.RB_Nummer
                        ORDER BY A.RB_Naam, B.RB_Naam, C.RB_Naam,D.RB_Naam,E.RB_Naam, F.RB_Nummer
EOT;

$betalingsMethodeQuery = <<<EOT
select BW_betalingswijze as betalingswijze
from Betalingswijzen 
ORDER BY BW_betalingswijze desc
EOT;

$plaatsVeilingQuery = <<<EOT

INSERT into Voorwerp
  (VW_titel,
   VW_beschrijving,
   VW_startprijs,
   VW_betalingswijze,
   VW_betalingsinstructie,
   VW_plaatsnaam,
   VW_land,
   Vw_looptijd,
   VW_verzendkosten,
   VW_verzendinstructies,
   VW_verkoper,
   VW_conditie,
   VW_thumbnail,
   VW_hoogstebod)
   values
   (
   :VW_titel,
   :VW_beschrijving,
   :VW_startprijs,
   :VW_betalingswijze,
   :VW_betalingsinstructie,
   :VW_plaatsnaam,
   :VW_land,
   :Vw_looptijd,
   :VW_verzendkosten,
   :VW_verzendinstructies,
   :VW_verkoper,
   :VW_conditie,
   :VW_thumbnail,
   :VW_hoogstebod
)
EOT;

$QueryInsertRubriek = <<<EOT
INSERT INTO Voorwerp_Rubriek values(:voorwerpnummer, :rubriek)

EOT;

$getVoorwerpNummerQuery = <<<EOT
select top 1 @@IDENTITY from Voorwerp
EOT;

$rubriekNummerAfstammelingVanRoot = <<<EOT
select dbo.FN_RubriekIsAfstammelingVan(:Rubriek, -1)
EOT;

$QuerygebruikerIsVerkoper = <<<EOT
select VER_gebruiker from Verkoper where VER_gebruiker = :gebruiker
EOT;

?>