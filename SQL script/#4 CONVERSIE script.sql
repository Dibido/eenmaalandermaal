--Conversiescript rubrieken
BEGIN TRANSACTION
INSERT INTO Rubriek
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
SET IDENTITY_INSERT eenmaalandermaal.dbo.voorwerp ON
INSERT INTO eenmaalandermaal.dbo.Voorwerp (VW_voorwerpnummer, VW_titel, VW_beschrijving, VW_land, VW_verkoper, VW_conditie, VW_thumbnail, VW_startprijs, VW_looptijdStart, VW_looptijd, VW_betalingswijze, VW_plaatsnaam, VW_veilinggesloten)
  SELECT
    ID                                              AS VW_voorwerpnummer,
    (SELECT CASE
            WHEN len(titel) >= 56
              THEN left(titel, 56) + '...'
            ELSE titel END titel)                   AS VW_titel,
    eenmaalandermaal.dbo.FN_StripHTML(Beschrijving) AS VW_beschrijving,
    --HTML tags filteren
    Land                                            AS VW_land,
    Verkoper                                        AS VW_verkoper,
    Conditie                                        AS VW_conditie,
    Thumbnail                                       AS VW_thumbnail,
    1.00                                            AS VW_startprijs,
    '2017-05-24'                                    AS VW_looptijdstart,
    7                                               AS VW_looptijd,
    'Bank / giro'                                   AS VW_betalingswijze,
    CASE WHEN CHARINDEX(',', [locatie]) > 0
      THEN REPLACE(LEFT([locatie], CHARINDEX(',', [locatie])), ',', '')
    ELSE 'Geen plaatsnaam bekend'
    END                                             AS VW_plaatsnaam,
    0                                               AS VW_veilinggesloten
  FROM veilingssite.dbo.Items
SET IDENTITY_INSERT eenmaalandermaal.dbo.voorwerp OFF
GO

BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Bod (BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker, BOD_bodTijdEnDag)
  SELECT
    ID                                                    AS BOD_voorwerpnummer,
    eenmaalandermaal.dbo.FN_Verandervaluta(Valuta, Prijs) AS BOD_bodbedrag,
    --TODO: Prijs omzetten naar euro aan de hand van een wisselkoers en zorgen dat het hoger is dan 1 euro. Afronden checken.
    'kees'                                                AS BOD_gebruiker,
    getdate()                                             AS BOD_bodTijdEnDag
  FROM veilingssite.dbo.Items
GO

BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Voorwerp_Rubriek
  SELECT
    ID        AS VR_Voorwerp_Nummer,
    Categorie AS VR_Rubriek_Nummer
  FROM veilingssite.dbo.Items
COMMIT
GO


/*
Conversie script voor de illustraties naar de bestand tabel.
Voor dat dit runbaar is moeten er eerst voorwerpen zijn met hetzelfde VW_voorwerpnummer als het BES_voorwerpnummer.
Deze query zorgt ervoor dat van ieder voorwerp uit de verkregen database 3 afbeeldingen krijgt wanneer er 3 afbeeldingen beschikbaar zijn.
*/

BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Bestand (BES_filenaam, BES_voorwerpnummer)
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
                   FROM eenmaalandermaal.dbo.Voorwerp V
                   WHERE v.VW_voorwerpnummer = ItemID)
COMMIT

INSERT INTO eenmaalandermaal.dbo.Voorwerp (VW_voorwerpnummer, VW_titel, VW_beschrijving, VW_land, VW_verkoper, VW_conditie, VW_thumbnail)
  SELECT
    ID           AS VW_voorwerpnummer,
    Titel        AS VW_titel,
    Beschrijving AS VW_beschrijving,
    --HTML tags filteren
    Land         AS VW_land,
    Verkoper     AS VW_verkoper,
    Conditie     AS VW_conditie,
    Thumbnail    AS VW_thumbnail
  FROM veilingssite.dbo.Items
SET IDENTITY_INSERT eenmaalandermaal.dbo.Voorwerp OFF