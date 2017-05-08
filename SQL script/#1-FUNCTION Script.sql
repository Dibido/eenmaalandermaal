

USE eenmaalandermaal
--Functie om te het aantal bestanden te returnen
GO
IF OBJECT_ID('dbo.aantalBestandenPervoorwerpnummer') IS NOT NULL
  IF OBJECT_ID('dbo.Bestand') IS NOT NULL
    DROP TABLE [dbo].[Bestand]
DROP FUNCTION [dbo].[aantalBestandenPerVoorwerpnummer]
GO
CREATE FUNCTION aantalBestandenPerVoorwerpnummer(
  @field BIGINT
)
  RETURNS INT
  BEGIN
    RETURN (
      SELECT COUNT(voorwerpnummer)
      FROM Bestand
      WHERE voorwerpnummer = @field
    )
  END
GO

--Functie om te kijken of het tijdstip niet in het verleden ligt wanner de datum wel de huidige dag is

IF OBJECT_ID('dbo.tijdstipCheck') IS NOT NULL
  IF OBJECT_ID('dbo.Voorwerp') IS NOT NULL
    DROP TABLE [dbo].[Voorwerp]
DROP FUNCTION [dbo].[tijdstipCheck]
GO

CREATE FUNCTION tijdstipCheck(
  @looptijdBeginDag      DATE,
  @looptijdBeginTijdstip TIME
)
  RETURNS BIT
  BEGIN
    RETURN (
      CASE WHEN CONVERT(DATE, @looptijdBeginDag) = CONVERT(DATE, GETDATE()) --Is de ingegeven dag de huidige dag
        THEN
          CASE WHEN CONVERT(TIME, @looptijdBeginTijdstip) >=
                    CONVERT(TIME, GETDATE()) --Wanneer het de huidige dag is, is de ingegeven tijd na of de huidige tijd
            THEN 1
          ELSE 0
          END
      ELSE
        CASE WHEN CONVERT(DATE, @looptijdBeginDag) > CONVERT(DATE,
                                                             GETDATE()) --Is de ingegeven dag niet de huidige dag dan wordt er gekeken of de dag wel na de huidige dag valt.
          THEN 1
        END
      END
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
      CASE WHEN @Bodbedrag >= (SELECT startprijs
                               FROM Voorwerp
                               WHERE voorwerpnummer = @voorwerpnummer)
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
      CASE WHEN @gebruiker IN (SELECT verkoper
                               FROM Voorwerp
                               WHERE voorwerpnummer = @voorwerpnummer)
        THEN 0
      ELSE 1
      END
    )
  END