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

--Functie om de valuta om te rekenen voor het converteren van de voorwerpen
GO
IF OBJECT_ID('FN_Verandervaluta') IS NOT NULL
  DROP FUNCTION [dbo].[FN_Verandervaluta]
GO
CREATE FUNCTION FN_Verandervaluta
  (@Valuta CHAR(3), @Prijs NUMERIC(9, 2))
  RETURNS NUMERIC
  BEGIN
    IF (@Valuta = 'GBP')
      RETURN (@Prijs / 0.862403667)
    ELSE IF (@Valuta = 'USD')
      RETURN (@Prijs * 1.12128)
    RETURN @Prijs
  END

--Functie om de HTML beschrijving te filteren
GO
IF OBJECT_ID('FN_StripHTML') IS NOT NULL
  DROP FUNCTION [dbo].[FN_StripHTML]
GO
CREATE FUNCTION [dbo].[FN_StripHTML](@HTMLText VARCHAR(MAX))
  RETURNS VARCHAR(MAX) AS
  BEGIN
    DECLARE @Start INT
    DECLARE @End INT
    DECLARE @Length INT
    SET @Start = CHARINDEX('<', @HTMLText)
    SET @End = CHARINDEX('>', @HTMLText, CHARINDEX('<', @HTMLText))
    SET @Length = (@End - @Start) + 1
    WHILE @Start > 0 AND @End > 0 AND @Length > 0
      BEGIN
        SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '')
        SET @Start = CHARINDEX('<', @HTMLText)
        SET @End = CHARINDEX('>', @HTMLText, CHARINDEX('<', @HTMLText))
        SET @Length = (@End - @Start) + 1
      END
    RETURN LTRIM(RTRIM(@HTMLText))
  END
GO