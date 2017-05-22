--Functie om te het aantal bestanden te returnen
GO
IF OBJECT_ID('dbo.aantalBestandenPervoorwerpnummer') IS NOT NULL
  IF OBJECT_ID('dbo.Bestand') IS NOT NULL
    DROP TABLE [dbo].[Bestand]
DROP FUNCTION [dbo].[aantalBestandenPerVoorwerpnummer]
GO
CREATE FUNCTION aantalBestandenPerVoorwerpnummer(
  @voorwerpnummer BIGINT
)
  RETURNS INT
  BEGIN
    RETURN (
      SELECT COUNT(BES_voorwerpnummer)
      FROM Bestand
      WHERE BES_voorwerpnummer = @voorwerpnummer
    )
  END
GO


--Functie om te kijken of het bod hoger is dan de opgegeven startprijs
IF OBJECT_ID('dbo.bodHogerDanStartprijs') IS NOT NULL
  IF OBJECT_ID('dbo.Bod') IS NOT NULL
    DROP TABLE [dbo].[Bod]
DROP FUNCTION [dbo].[bodHogerDanStartprijs]
GO

CREATE FUNCTION bodHogerDanStartprijs(
  @voorwerpnummer BIGINT,
  @Bodbedrag      NUMERIC(9, 2)
)
  RETURNS BIT
  BEGIN
    RETURN (
      CASE WHEN @Bodbedrag >= (SELECT VW_startprijs
                               FROM Voorwerp
                               WHERE VW_voorwerpnummer = @voorwerpnummer)
        THEN 1
      ELSE 0
      END
    )
  END
GO


--Functie om te kijken of je niet op je eigen voorwerp gaat bieden

IF OBJECT_ID('dbo.nietEigenVoorwerp') IS NOT NULL
  IF OBJECT_ID('dbo.Bod') IS NOT NULL
    DROP TABLE [dbo].[Bod]
DROP FUNCTION [dbo].[nietEigenVoorwerp]
GO

CREATE FUNCTION nietEigenVoorwerp(
  @voorwerpnummer BIGINT,
  @gebruiker      VARCHAR(40)
)
  RETURNS BIT
  BEGIN
    RETURN (
      CASE WHEN @gebruiker IN (SELECT VW_verkoper
                               FROM Voorwerp
                               WHERE VW_voorwerpnummer = @voorwerpnummer)
        THEN 0
      ELSE 1
      END
    )
  END

