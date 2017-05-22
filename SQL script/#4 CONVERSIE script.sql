--Conversiescript rubrieken
BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Rubriek
  SELECT
    ID     AS RB_Nummer,
    name   AS RB_naam,
    parent AS RB_parent,
    ID     AS RB_volgnummer
  FROM veilingssite.dbo.Categorieen
COMMIT

--Conversiescript Users
BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Gebruiker (GEB_gebruikersnaam, GEB_voornaam, GEB_achternaam, GEB_adresregel_1, GEB_geboortedag, GEB_mailbox, GEB_wachtwoord,
                                            GEB_vraag, GEB_antwoordtekst, GEB_postcode, GEB_plaatsnaam, GEB_Land, GEB_Rating)
  SELECT DISTINCT
    LTRIM(RTRIM(Username))   AS GEB_gebruikersnaam,
    LTRIM(RTRIM('-'))        AS GEB_voornaam,
    LTRIM(RTRIM('-'))        AS GEB_achternaam,
    LTRIM(RTRIM('-'))        AS GEB_adresregel_1,
    getdate()                AS GEB_geboortedag,
    'Geen_mailadres@nope.nl' AS GEB_mailbox,
    'P@ssw0rd'               AS GEB_wachtwoord,
    1                        AS GEB_vraag,
    --Default vraag
    'Defaultantwoord'        AS GEB_antwoordtekst,
    LTRIM(RTRIM(Postalcode)) AS GEB_postcode,
    LTRIM(RTRIM(Location))   AS GEB_plaatsnaam,
    LTRIM(RTRIM(Country))    AS GEB_Land,
    --Als er dubbele gebruikers zijn pakken we de gebruiker met de hoogste rating
    (SELECT TOP 1 Rating
     FROM veilingssite.dbo.Users u
     WHERE u.Username = Username
     ORDER BY Rating DESC)   AS GEB_Rating
  FROM veilingssite.dbo.Users
COMMIT

--Conversiescript Items
BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Voorwerp (VW_voorwerpnummer, VW_titel, VW_beschrijving, VW_land, VW_verkoper, VW_conditie, VW_thumbnail)
  SELECT
    ID           AS VW_voorwerpnummer,
    Title        AS VW_titel,
    Beschrijving AS VW_beschrijving,
    --HTML tags filteren
    Land         AS VW_land,
    Verkoper     AS VW_verkoper,
    Conditie     AS VW_conditie,
    Thumbnail    AS VW_thumbnail
  FROM veilingssite.dbo.Items

INSERT INTO eenmaalandermaal.dbo.Bod (BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker, BOD_bodTijdEnDag)
  SELECT
    ID        AS BOD_voorwerpnummer,
    Prijs     AS BOD_bodbedrag,
    --Prijs omzetten naar euro aan de hand van een wisselkoers
    Verkoper  AS BOD_gebruiker,
    getdate() AS BOD_bodTijdEnDag
  FROM veilingssite.dbo.Items

INSERT INTO eenmaalandermaal.dbo.Gebruiker (GEB_postcode)
  SELECT Postcode AS GEB_postcode
  FROM veilingssite.dbo.Items

INSERT INTO eenmaalandermaal.dbo.Voorwerp_Rubriek
  SELECT
    Categorie AS VR_Voorwerp_Nummer,
    ID        AS VR_Rubriek_Nummer
  FROM veilingssite.dbo.Items
COMMIT


/*
Conversie script voor de illustraties naar de bestand tabel.
Voor dat dit runbaar is moeten er eerst voorwerpen zijn met hetzelfde VW_voorwerpnummer als het BES_voorwerpnummer.
Deze query zorgt ervoor dat van ieder voorwerp uit de verkregen database 3 afbeeldingen krijgt wanneer er 3 afbeeldingen beschikbaar zijn.
*/

BEGIN TRANSACTION
INSERT INTO Bestand (BES_filenaam, BES_voorwerpnummer)
  SELECT
    IllustratieFile AS BES_filenaam,
    ItemID          AS BES_voorwerpnummer
  FROM (
         SELECT
           ItemID,
           IllustratieFile,
           Rank()
           OVER ( PARTITION BY ItemID --OVER voegt informatie samen zonder te groeperen
             ORDER BY IllustratieFile DESC ) AS Rank
         FROM veilingssite.dbo.Illustraties
       ) rs
  WHERE Rank <= 3 --Selecteerd de top 3
        AND EXISTS(SELECT * --Als het voorwerp bestaat.
                   FROM Voorwerp V
                   WHERE v.VW_voorwerpnummer = ItemID)
COMMIT