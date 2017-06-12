--This piece of sql reads the triggers and deletes them.
DECLARE @DropTriggers NVARCHAR(MAX) = ''
SELECT @DropTriggers += 'DROP TRIGGER ' + [so].[name] + CHAR(13)
FROM sysobjects AS [so]
  INNER JOIN sysobjects AS so2 ON so.parent_obj = so2.Id
WHERE [so].[type] = 'TR'
PRINT @DropTriggers
EXEC sp_executesql @DropTriggers
GO

--Trigger to keep track of the highest bid on a voorwerp.
CREATE TRIGGER TR_HoogsteBod
  ON Bod
FOR INSERT, UPDATE, DELETE
AS
  BEGIN
    --Updates the highest bid price..
    UPDATE Voorwerp
    SET VW_hoogstebod =
    (COALESCE((SELECT TOP 1 BOD_Bodbedrag
               FROM Bod
               WHERE BOD_Bodbedrag IN (SELECT TOP 1 BOD_Bodbedrag
                                       FROM Bod
                                       WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                       ORDER BY BOD_Bodbedrag DESC) AND
                     BOD_voorwerpnummer = VW_voorwerpnummer
               ORDER BY BOD_Bodbedrag DESC), VW_startprijs
    ))
  END
GO
--Trigger to calculate the minimal bid.
CREATE TRIGGER TR_minimalenieuwebod
  ON Bod
FOR INSERT, UPDATE, DELETE
AS
  BEGIN
    UPDATE dbo.Voorwerp
    SET Voorwerp.VW_minimalenieuwebod =
    (
      CASE
      WHEN VW_hoogstebod BETWEEN 1 AND 49.99
        THEN (VW_hoogstebod + 0.50)
      WHEN VW_hoogstebod BETWEEN 50 AND 499.99
        THEN (VW_hoogstebod + 1.00)
      WHEN VW_hoogstebod BETWEEN 500 AND 999.99
        THEN (VW_hoogstebod + 5.00)
      WHEN VW_hoogstebod BETWEEN 1000 AND 4999.99
        THEN (VW_hoogstebod + 10.00)
      WHEN VW_hoogstebod > 5000
        THEN (VW_hoogstebod + 50.00)
      END
    )
  END
GO

--Trigger to calculate the number of voorwerpen in a rubric.
CREATE TRIGGER TR_ComputedCount
  ON Voorwerp_Rubriek
FOR INSERT, UPDATE, DELETE
AS
  BEGIN
    --Update number of voorwerpen ina  rubric.
    --Only when there are references too VoorwerpInRubriek.
    UPDATE Rubriek
    SET RB_voorwerpcount =
    (
      SELECT COUNT(*)
      FROM Voorwerp_Rubriek
      WHERE Voorwerp_Rubriek.VR_Rubriek_Nummer = RB_Nummer
    )
    WHERE EXISTS(SELECT *
                 FROM Voorwerp_Rubriek
                 WHERE Voorwerp_Rubriek.VR_Rubriek_Nummer = RB_Nummer)
  END
GO


CREATE TRIGGER TR_BodCount
  ON Bod
FOR INSERT, UPDATE, DELETE
AS
  BEGIN
    --Update number of bids for each voorwerp.
    --Only when there references to Bod.
    UPDATE Voorwerp
    SET VW_BodCount =
    (
      COALESCE((SELECT count(BOD_voorwerpnummer)
                FROM Bod
                WHERE Bod.BOD_voorwerpnummer = VW_voorwerpnummer
                GROUP BY BOD_voorwerpnummer), 0)
    )
  END
GO

-- Trigger that deletes registrationcodes older then 24 hours.
CREATE TRIGGER TR_ActivatieVerlopen
  ON dbo.Registreer
FOR INSERT, UPDATE
AS
  BEGIN
    DELETE FROM Registreer
    WHERE REG_tijd < DATEADD(HOUR, -4, GETDATE())
  END
GO

--Trigger that deletes the update code after a week.
CREATE TRIGGER TR_UpgradeVerlopen
  ON dbo.Upgrade
FOR INSERT, UPDATE
AS
  BEGIN
    DELETE FROM Upgrade
    WHERE UPG_tijd < DATEADD(WEEK, -1, GETDATE())
  END
GO