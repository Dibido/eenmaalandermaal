/* Haal alle voorwerpen op */
SELECT * FROM Voorwerp
/* Zoek in Titel */
SELECT TOP 50 * FROM Voorwerp  WHERE VW_titel LIKE '%$keyWords%' --Koppelen aan Searchbox
/* Zoek in Beschrijving */
SELECT TOP 50 * FROM Voorwerp WHERE VW_beschrijving LIKE '%$keyWords%'
/* Zoek op Titel & Beschrijving */
SELECT TOP 50 * FROM Voorwerp  WHERE VW_titel LIKE '%$keyWords%' AND VW_beschrijving LIKE '%$keyWords%'



/* Haal Rubrieken op */
SELECT * FROM Rubriek
/* Show items gebonden aan Categorie*/
SELECT TOP 50 * FROM Voorwerp JOIN Voorwerp_Rubriek ON VW_voorwerpnummer = VR_Voorwerp_Nummer
/* Zoek in bepaalde Categorie op Titel */
SELECT TOP 50 * FROM Voorwerp JOIN Voorwerp_Rubriek ON VW_voorwerpnummer = VR_Voorwerp_Nummer
WHERE VW_titel LIKE '%$keyWords%' AND VR_Rubriek_Nummer LIKE '$RubriekNummer' -- Var voor categorie
/* Zoek in bepaalde Categorie op Beschrijving */
SELECT TOP 50 * FROM Voorwerp JOIN Voorwerp_Rubriek ON VW_voorwerpnummer = VR_Voorwerp_Nummer
WHERE VW_beschrijving LIKE '%keyWords%' AND VR_Rubriek_Nummer LIKE '$RubriekNummer' -- Var voor categorie


/* Zoek product met verzendinstructie "Verzenden" */
SELECT TOP 50 * FROM Voorwerp  WHERE VW_verzendinstructies LIKE '%Verzenden%'
/* Zoek product met verzendinstructie "Ophalen" */
SELECT TOP 50 * FROM Voorwerp  WHERE VW_verzendinstructies LIKE '%Ophalen%'


/* Zoek product met Prijs tussen X & Y */
SELECT TOP 50 * FROM Voorwerp v
INNER JOIN Bod b ON b.BOD_voorwerpnummer = v.VW_voorwerpnummer
WHERE b.BOD_bodbedrag BETWEEN '$MinPrijs' AND '$MaxPrijs'


/* Haal bestand op bij voorwerp */
SELECT BES_voorwerpnummer, BES_filenaam  FROM Bestand b INNER JOIN Voorwerp v ON v.VW_voorwerpnummer = b.BES_voorwerpnummer




--(SELECT max(BOD_bodbedrag) AS HuidigBod FROM Bod b)
