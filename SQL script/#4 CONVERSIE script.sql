--Dit bestand bevat alle conversiescripts om de

USE eenmaalandermaal
--Conversiescript rubrieken
BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Rubriek
  SELECT
    ID     AS RB_Nummer,
    name   AS RB_naam,
    parent AS RB_parent,
    ID     AS RB_volgnummer
  FROM veilingsite.dbo.Categorieen
COMMIT

--Conversiescript Users
BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Gebruiker (GEB_gebruikersnaam, GEB_postcode, GEB_plaatsnaam, GEB_Land, GEB_Rating)
    SELECT
      Username AS GEB_gebruikersnaam,
      Postalcode AS GEB_postcode,
      Location AS GEB_plaatsnaam,
      Country AS GEB_Land,
      Rating AS GEB_Rating
  FROM veilingsite.dbo.Users
COMMIT

--Conversiescript Items
BEGIN TRANSACTION
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

INSERT INTO eenmaalandermaal.dbo.Bod
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
Run dit op veilingsite database
Voor dat dit runbaar is moeten er eerst voorwerpen zijn met hetzelfde VW_voorwerpnummer als het BES_voorwerpnummer.
Deze query zorgt ervoor dat van ieder voorwerp uit de verkregen database 3 afbeeldingen krijgt wanneer er 3 afbeeldingen beschikbaar zijn.
*/

BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Bestand (BES_filenaam, BES_voorwerpnummer)
  SELECT
    IllustratieFile,
    ItemID
  FROM (
         SELECT
           ItemID,
           IllustratieFile,
           Rank()
           OVER ( PARTITION BY ItemID --OVER voegt informatie samen zonder een group by te gebruiken.
             ORDER BY IllustratieFile DESC ) AS Rank
         FROM Illustraties
       ) rs
  WHERE Rank <= 3
        AND EXISTS(SELECT *
                   FROM eenmaalandermaal..Voorwerp V
                   WHERE v.VW_voorwerpnummer = ItemID)
COMMIT