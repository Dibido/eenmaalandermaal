--Dit bestand bevat alle conversiescripts om de

use eenmaalandermaal
--Conversiescript rubrieken
BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Rubriek
  SELECT ID AS RB_Nummer,
         name AS RB_naam,
         parent AS RB_parent,
         ID AS RB_volgnummer
  FROM veilingsite.dbo.Categorieen
COMMIT

--Conversiescript Items
BEGIN TRANSACTION
INSERT INTO eenmaalandermaal.dbo.Voorwerp
    SELECT
      ID AS VW_Voowerpnummer,
      Titel AS VW_titel,
      Beschrijving AS VW_titel,
      Postcode AS ,
      Locatie AS ,
      Land AS VW_land,
      Verkoper AS ,
      Prijs AS ,
      Valuta AS ,
      Conditie AS ,
      Thumbnail AS ,
  FROM veilingssite.dbo.Items
INSERT INTO eenmaalandermaal.dbo.Gebruiker
    SELECT
    FROM veilingssite.dbo.Items
INSERT INTO eenmaalandermaal.dbo.Voorwerp_Rubriek
    SELECT
      Categorie AS ,
FROM veilingssite.dbo.Items
COMMIT

select * from eenmaalandermaal.dbo.Gebruiker