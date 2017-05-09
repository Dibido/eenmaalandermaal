/* Haal alle voorwerpen op */
SELECT * FROM Voorwerp
/* Zoek in Titel */
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp  WHERE VW_titel LIKE '%$keyWords%' --Koppelen aan Searchbox
/* Zoek in Beschrijving */
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp WHERE VW_beschrijving LIKE '%$keyWords%'
/* Zoek op Titel & Beschrijving */
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp  WHERE VW_titel LIKE '%$keyWords%' AND VW_beschrijving LIKE '%$keyWords%'



/* Haal Rubrieken op */
SELECT * FROM eenmaalandermaal.dbo.Rubriek
/* Show items gebonden aan Categorie*/
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp JOIN eenmaalandermaal.dbo.Voorwerp_Rubriek ON eenmaalandermaal.dbo.Voorwerp.VW_voorwerpnummer = eenmaalandermaal.dbo.Voorwerp_Rubriek.VR_Voorwerp_Nummer
/* Zoek in bepaalde Categorie op Titel */
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp JOIN eenmaalandermaal.dbo.Voorwerp_Rubriek ON eenmaalandermaal.dbo.Voorwerp.VW_voorwerpnummer = eenmaalandermaal.dbo.Voorwerp_Rubriek.VR_Voorwerp_Nummer
WHERE VW_titel LIKE '%$keyWords%' AND VR_Rubriek_Nummer LIKE '95' -- Var voor categorie
/* Zoek in bepaalde Categorie op Beschrijving */
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp JOIN eenmaalandermaal.dbo.Voorwerp_Rubriek ON eenmaalandermaal.dbo.Voorwerp.VW_voorwerpnummer = eenmaalandermaal.dbo.Voorwerp_Rubriek.VR_Voorwerp_Nummer
WHERE VW_beschrijving LIKE '%keyWords%' AND VR_Rubriek_Nummer LIKE '95' -- Var voor categorie


/* Zoek product met verzendinstructie "Verzenden" */
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp  WHERE VW_verzendinstructies LIKE '%Verzenden%'
/* Zoek product met verzendinstructie "Ophalen" */
SELECT TOP 50 * FROM eenmaalandermaal.dbo.Voorwerp  WHERE VW_verzendinstructies LIKE '%Ophalen%'