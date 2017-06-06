--Trigger om het hoogste bod op een voorwerp bij te houden
IF OBJECT_ID('TR_HoogsteBod') IS NOT NULL
  DROP TRIGGER [dbo].[TR_HoogsteBod]
GO
CREATE TRIGGER TR_HoogsteBod
  ON Bod
FOR INSERT, UPDATE, DELETE
AS
  BEGIN
    --Bijwerken hoogste bodprijs voorwerp.
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

--Trigger om het minimale nieuwe bod te berekenen
IF OBJECT_ID('TR_minimalenieuwebod') IS NOT NULL
  DROP TRIGGER [dbo].[TR_minimalenieuwebod]
GO
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

--Trigger om het aantal voorwerpen per rubriek te berekenen.
IF OBJECT_ID('TR_ComputedCount') IS NOT NULL
  DROP TRIGGER [dbo].[TR_ComputedCount]
GO
CREATE TRIGGER TR_ComputedCount
  ON Voorwerp_Rubriek
FOR INSERT, UPDATE, DELETE
AS
  BEGIN
    --Bijwerken aantal voorwerpen per categorie
    --Alleen als er wijzigingen zijn aan VoorwerpInRubriek
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

IF OBJECT_ID('TR_BodCount') IS NOT NULL
  DROP TRIGGER [dbo].[TR_BodCount]
GO
CREATE TRIGGER TR_BodCount ON Bod
FOR INSERT,UPDATE,DELETE
AS
  BEGIN
    --Bijwerken aantal biedingen per voorwerp
    --Alleen als er wijzigingen zijn aan Bod
    UPDATE Voorwerp
    SET VW_BodCount =
    (
      select count(BOD_voorwerpnummer) from Bod group by BOD_voorwerpnummer

    )
  END

-- Trigger die registratiecodes die ouder dan 24 uur zijn verwijderd.
IF OBJECT_ID('TR_ActivatieVerlopen') IS NOT NULL
  DROP TRIGGER [dbo].[TR_ActivatieVerlopen]
GO

CREATE TRIGGER TR_ActivatieVerlopen
  ON dbo.Registreer
FOR INSERT, UPDATE
AS
  BEGIN
    DELETE FROM Registreer
    WHERE REG_tijd < DATEADD(HOUR, -4, GETDATE())
  END
GO

CREATE TRIGGER TR_ComputedCountParentCategories on Voorwerp_Rubriek
  FOR INSERT,UPDATE,DELETE
AS
  BEGIN
    UPDATE Rubriek
      SET RB_voorwerpcount =
      (
        SELECT SUM(RB_voorwerpcount)
      )
  END