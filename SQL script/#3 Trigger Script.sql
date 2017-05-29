--Trigger om het aantal voorwerpen per rubriek te berekenen.
IF OBJECT_ID('TR_ComputedCount') IS NOT NULL
  DROP TRIGGER [dbo].[TR_ComputedCount]
GO
CREATE TRIGGER TR_ComputedCount ON Voorwerp_Rubriek
FOR INSERT,UPDATE,DELETE
AS
  BEGIN
    --Bijwerken aantal voorwerpen per categorie
    --Alleen als er wijzigingen zijn aan VoorwerpInRubriek
    UPDATE Rubriek
    SET RB_voorwerpcount =
    (
      SELECT COUNT(*) FROM Voorwerp_Rubriek
      WHERE Voorwerp_Rubriek.VR_Rubriek_Nummer=RB_Nummer
    )
    WHERE EXISTS(SELECT * FROM Voorwerp_Rubriek
    WHERE Voorwerp_Rubriek.VR_Rubriek_Nummer = RB_Nummer)
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
    WHERE  REG_tijd < DATEADD(day, -1, GETDATE())
  END
GO