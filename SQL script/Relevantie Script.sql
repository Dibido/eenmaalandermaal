--Shows the amount of bid for each category.
SELECT
  --Selects the best categories to be shown.
  TOP 10
  RB_Naam,
  SUM(tweede.aantal) AS AantalBiedingenPerCategorie,
  RB_Nummer
FROM Rubriek
  --Reads the joints from the back to the front(down to up). Starts at STAP 1 on row 23.
  --STAP 4: The categories that are left behind will be joined with the parent so we get the highest parent.
  INNER JOIN
  (SELECT
     Rubriek.RB_Parent,
     SUM(eerste.aantal) AS aantal
   FROM Rubriek
     --STAP 3: The selected column with the number for each column gets joined with the first parent.
     INNER JOIN (SELECT
                   RB_Parent,
                   COUNT(BOD_voorwerpnummer) AS aantal
                 FROM Voorwerp_Rubriek
                   --STAP 2: The column number gets joined with the row in the rubriek table.
                   INNER JOIN Rubriek
                     ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                   --STAP 1: Bids get joint with rubriek.
                   INNER JOIN Bod
                     ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
                 GROUP BY RB_Parent)
                eerste ON Rubriek.RB_Volgnummer = eerste.RB_Parent
   GROUP BY Rubriek.RB_Parent, aantal) tweede ON Rubriek.RB_Volgnummer = tweede.RB_Parent
WHERE Rubriek.RB_Parent = 0
GROUP BY Rubriek.RB_Naam, Rubriek.RB_Nummer
ORDER BY MAX(aantal) DESC


--Auctions that almost expire need to be taken out of "important'.
SELECT
  --Fill your top X value in.
  TOP 2
  VW_voorwerpnummer,
  VW_titel,
  --Shows the highest bid on voorwerpnummer.
  (SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC)                  AS prijs,
  --Time difference between now and the end of an auction.
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  COUNT(*)                                       AS Biedingen,
  --Selecteerd het eerste filepath die hij vind voor het voorwerpnummer
  (SELECT TOP 1 BES_filenaam
   FROM Bestand
   WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath
FROM Voorwerp
  INNER JOIN BOD
    ON Voorwerp.VW_voorwerpnummer = BOD_voorwerpnummer
--You can fill the max and min time in.
WHERE DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) < 1000 AND DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) > 2 AND
      VW_voorwerpnummer IN (SELECT BOD_voorwerpnummer
                            FROM Rubriek
                              --Read the innerjoins backwards (low to high). Start at STAP 1 on row 81.
                              --STAP 4: The leftover rubric gets joint with their parent so we get the highest parent.
                              INNER JOIN
                              (SELECT
                                 Rubriek.RB_Parent,
                                 BOD_voorwerpnummer,
                                 aantal
                               --STAP 3: The selected rubric with their numbers are added to the highest rubric.
                               FROM Rubriek
                                 INNER JOIN (SELECT
                                               RB_Parent,
                                               COUNT(BOD_voorwerpnummer) AS aantal,
                                               BOD_voorwerpnummer
                                             FROM Voorwerp_Rubriek
                                               --STAP 2: The rubric number gets joined with the row in the rubric table.
                                               INNER JOIN Rubriek
                                                 ON Rubriek.RB_Nummer =
                                                    Voorwerp_Rubriek.VR_Rubriek_Nummer
                                               --STAP 1: Bids get joined with rubrieknummer.
                                               INNER JOIN Bod
                                                 ON Voorwerp_Rubriek.VR_Voorwerp_Nummer =
                                                    Bod.BOD_voorwerpnummer
                                             GROUP BY RB_Parent, BOD_voorwerpnummer) eerste
                                   ON Rubriek.RB_Volgnummer = eerste.RB_Parent
                               GROUP BY Rubriek.RB_Parent, aantal, BOD_voorwerpnummer) tweede
                                ON Rubriek.RB_Volgnummer = tweede.RB_Parent
                            WHERE Rubriek.RB_Parent = 0
                            GROUP BY Rubriek.RB_Naam, BOD_voorwerpnummer)
GROUP BY VW_voorwerpnummer, VW_looptijdEinde, VW_titel
ORDER BY Biedingen DESC,tijd ASC



--New auctions with users that have a high rating.

--TODO

--Most important catergory with the higest rated users and most bids for each product.

SELECT
  TOP 3
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
  --Inner join between bod and Voorwerp so we can calculate the amount of bids.
  INNER JOIN Bod
    ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
--Where statement to check if voorwerp nummer is in the most important category.
WHERE VW_voorwerpnummer IN (
  SELECT DISTINCT BOD_voorwerpnummer
  --selects the name of the hoofdrubriek for each voorwerpnummer.
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
    --read the inner joins from low to high. Start at STAP 1 on row 157.
    --STAP 5: Selects the parent with the highest amount.
    SELECT
      TOP 1 RB_Naam
    FROM Rubriek
      --STAP 4: The leftover rubrics get joined with their parent so we get the highest parent.
      INNER JOIN
      (SELECT
         Rubriek.RB_Parent,
         aantal
       FROM Rubriek
         INNER JOIN
         --STAP 3: The selected rubric with the number for each rubric so we can join it with the first parent.
         (SELECT
            RB_Parent,
            COUNT(BOD_voorwerpnummer) AS aantal
          FROM Voorwerp_Rubriek
            --STAP 2: The rubric number gets joined with it's row in the table rubric.
            INNER JOIN Rubriek
              ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
            --STAP 1: Voorwerpnummers gets joined with the bids in the Bod table.
            INNER JOIN Bod
              ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
          GROUP BY RB_Parent)
         eerste ON Rubriek.RB_Volgnummer = eerste.RB_Parent
       GROUP BY Rubriek.RB_Parent, aantal) tweede ON Rubriek.RB_Volgnummer = tweede.RB_Parent
    WHERE Rubriek.RB_Parent = 0 --AND DATEDIFF(DAY,BOD_bodTijdEnDag, GETDATE())< 1000
    GROUP BY Rubriek.RB_Naam
    ORDER BY MAX(aantal) DESC)
) --TODO AND Verkoper van voorwerp in top van de gebruikerreviews
GROUP BY VW_voorwerpnummer, VW_titel, VW_looptijdEinde
ORDER BY Biedingen DESC
