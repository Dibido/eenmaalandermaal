
/* Zoek in Titel */
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp  WHERE VW_titel LIKE '%$keyWords%'

/* Zoek in Beschrijving */
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp WHERE VW_beschrijving LIKE '%keyWords%'

/* Haal Rubrieken op */
SELECT * FROM eenmaalandermaal.dbo.Rubriek

/* Zoek IN bepaalde Categorie*/
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp JOIN eenmaalandermaal.dbo.Voorwerp_Rubriek ON eenmaalandermaal.dbo.Voorwerp.VW_voorwerpnummer = eenmaalandermaal.dbo.Voorwerp_Rubriek.VR_Voorwerp_Nummer





