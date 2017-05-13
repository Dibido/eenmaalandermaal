--Laat het aantal biedingen zien per categorie
SELECT
  TOP 10
  RB_Naam,
  --Selecteer de top hoeveelheid categoriën die moet worden laten zien
  SUM(tweede.aantal) AS AantalBiedingenPerCategorie
FROM Rubriek
  --Lees de de Innerjoins van achter naar voren.

  INNER JOIN
  (SELECT
     Rubriek.RB_Parent,
     eerste.aantal
   FROM Rubriek
     INNER JOIN (SELECT
                   RB_Parent,
                   COUNT(BOD_voorwerpnummer) AS aantal
                 FROM Voorwerp_Rubriek
                   INNER JOIN Rubriek
                     ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                   INNER JOIN Bod
                     ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
                 GROUP BY RB_Parent)
                eerste ON Rubriek.RB_Volgnummer = eerste.RB_Parent
   GROUP BY Rubriek.RB_Parent, aantal) tweede ON Rubriek.RB_Volgnummer = tweede.RB_Parent
WHERE Rubriek.RB_Parent = 0
GROUP BY Rubriek.RB_Naam
ORDER BY MAX(aantal) DESC

--Aantal biedingen per voorwerp

SELECT
  BOD_voorwerpnummer,
  COUNT(*) AS Biedingen
FROM Bod
GROUP BY BOD_voorwerpnummer
ORDER BY Biedingen DESC

--

SELECT
  --Vul hier je TOP X hoeveelheid in
  VW_voorwerpnummer,
  VW_titel,
  (SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC)                  AS prijs,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  COUNT(*)                                       AS Biedingen,
  (SELECT TOP 1 BES_filenaam
   FROM Bestand
   WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath
FROM Voorwerp
  INNER JOIN BOD
    ON Voorwerp.VW_voorwerpnummer = BOD_voorwerpnummer
WHERE DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) < 1000 AND DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) > 2 AND
      --Vul hier de minimum en maximum tijd over in
      VW_voorwerpnummer IN (SELECT BOD_voorwerpnummer
                            FROM Bod
                              LEFT JOIN Voorwerp_Rubriek
                                ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
                              LEFT JOIN Rubriek
                                ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                              LEFT JOIN Rubriek r1
                                ON r1.RB_Nummer = Rubriek.RB_Parent
                              LEFT JOIN Rubriek r2
                                ON r2.RB_Nummer = r1.RB_Parent
                            WHERE r2.RB_Naam IN (SELECT TOP 3
                                                   RB_Naam --Vul hier de top X categoriën in waarvan producten moeten worden laten zien.
                                                 FROM Rubriek
                                                   LEFT JOIN
                                                   (SELECT
                                                      Rubriek.RB_Parent,
                                                      aantal
                                                    FROM Rubriek
                                                      LEFT JOIN (SELECT
                                                                   RB_Parent,
                                                                   COUNT(BOD_voorwerpnummer) AS aantal
                                                                 FROM Voorwerp_Rubriek
                                                                   LEFT JOIN Rubriek
                                                                     ON Rubriek.RB_Nummer =
                                                                        Voorwerp_Rubriek.VR_Rubriek_Nummer
                                                                   LEFT JOIN Bod
                                                                     ON Voorwerp_Rubriek.VR_Voorwerp_Nummer =
                                                                        Bod.BOD_voorwerpnummer
                                                                 GROUP BY RB_Parent) eerste
                                                        ON Rubriek.RB_Volgnummer = eerste.RB_Parent
                                                    GROUP BY Rubriek.RB_Parent, aantal) tweede
                                                     ON Rubriek.RB_Volgnummer = tweede.RB_Parent
                                                 GROUP BY Rubriek.RB_Naam
                                                 ORDER BY MAX(aantal) DESC)
                            GROUP BY BOD_voorwerpnummer, r2.RB_Naam)
GROUP BY VW_voorwerpnummer, VW_looptijdEinde, VW_titel
ORDER BY Biedingen DESC

--Nieuwe advertenties met gebruikers die een goede beoordeling hebben

SELECT
  VW_voorwerpnummer,
  VW_looptijdStart
FROM Voorwerp
--WHERE VW_voorwerpnummer IN --Lijst met goede beoordeelde gebruikers
ORDER BY VW_looptijdStart DESC

--Belangrijkste Categorie met daarbij de gebruikers met de hoogste rating en daarna meeste per voorwerp biedingen

SELECT TOP 3
  VW_voorwerpnummer,
  VW_titel,
  (SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC)                  AS prijs,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  COUNT(*)                                       AS Biedingen,
  (SELECT TOP 1 BES_filenaam
   FROM Bestand
   WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath
FROM Voorwerp
WHERE VW_voorwerpnummer IN (
  SELECT DISTINCT BOD_voorwerpnummer
  --Selecteerd de naam van de Hoofdcategorie per voorwerpnummer
  FROM Bod
    INNER JOIN Voorwerp_Rubriek
      ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
    INNER JOIN Rubriek
      ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
    INNER JOIN Rubriek r1
      ON r1.RB_Nummer = Rubriek.RB_Parent
    INNER JOIN Rubriek r2
      ON r2.RB_Nummer = r1.RB_Parent
  WHERE r2.RB_Naam != 'root' AND r2.RB_Naam IN (
    --Selecteerd de top 1 categoriën door te kijken naar de hoeveelheid biedingen
    SELECT
      TOP 1 RB_Naam
    FROM Rubriek
      --Lees de de Innerjoins van achter naar voren.
      INNER JOIN
      --Selecteerd de tweede laag van de categoriën
      (SELECT
         Rubriek.RB_Parent,
         aantal
       FROM Rubriek
         INNER JOIN
         --Selecteerd de hoeveelheid biedingen per categorie op de onderstelaag
         (SELECT
            RB_Parent,
            COUNT(BOD_voorwerpnummer) AS aantal
          FROM Voorwerp_Rubriek
            INNER JOIN Rubriek
              ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
            INNER JOIN Bod
              ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
          GROUP BY RB_Parent)
         eerste ON Rubriek.RB_Volgnummer = eerste.RB_Parent
       GROUP BY Rubriek.RB_Parent, aantal) tweede ON Rubriek.RB_Volgnummer = tweede.RB_Parent
    WHERE Rubriek.RB_Parent = 0
    GROUP BY Rubriek.RB_Naam
    ORDER BY MAX(aantal) DESC)
) --TODO AND Verkoper van voorwerp in top van de gebruikerreviews
GROUP BY VW_voorwerpnummer, VW_titel, VW_looptijdEinde
