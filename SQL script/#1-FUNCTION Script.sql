--This function checks when the auction is closed.
/*
Input: @voorwerpnummer is the number that we check.
Return: If the auction has closed.
 */
IF OBJECT_ID('dbo.FN_VeilingAfgelopen') IS NOT NULL
  DROP FUNCTION [dbo].[FN_VeilingAfgelopen]
GO
--Functie checks if the auction has ended.
CREATE FUNCTION FN_VeilingAfgelopen
  (@Voorwerpnummer BIGINT)
  RETURNS BIT
AS
  BEGIN
    IF (GETDATE() > (SELECT VW_looptijdEinde
                     FROM Voorwerp
                     WHERE VW_voorwerpnummer = @Voorwerpnummer))
      RETURN 1
    RETURN 0
  END

--Function too find a random user.
--Variabels:
--@Identifier, a unique identity.
--Return:
--A random user name.
IF OBJECT_ID('dbo.FN_GenereerRandomgebruiker') IS NOT NULL
  DROP FUNCTION [dbo].[FN_GenereerRandomgebruiker]
GO

CREATE FUNCTION FN_GenereerRandomgebruiker
  (@Identifier UNIQUEIDENTIFIER)
  RETURNS VARCHAR(64)
AS
  BEGIN
    --Selects a random user according too a random identity and rownumber.
    RETURN (SELECT TOP 1 GEB_gebruikersnaam
            FROM (SELECT
                    GEB_gebruikersnaam,
                    ROW_NUMBER()
                    OVER (
                      ORDER BY GEB_gebruikersnaam ) AS regel
                  FROM Gebruiker
                 ) AS regels
            WHERE regels.regel = (SELECT ((ABS(CHECKSUM(@Identifier))) % (SELECT count(*) + 1
                                                                          FROM Gebruiker)) + 1))
  END
GO

--Function to return the number of files.
GO
IF OBJECT_ID('dbo.FN_aantalBestandenPervoorwerpnummer') IS NOT NULL
  IF OBJECT_ID('dbo.Bestand') IS NOT NULL
    DROP TABLE [dbo].[Bestand]
DROP FUNCTION [dbo].[FN_aantalBestandenPerVoorwerpnummer]
GO
CREATE FUNCTION FN_aantalBestandenPerVoorwerpnummer(
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

--Function that checks if the new offer is higher then the old one.

IF OBJECT_ID('FN_BodhogerdanMinimaalBod') IS NOT NULL
  IF OBJECT_ID('dbo.Bod') IS NOT NULL
    DROP TABLE [dbo].[Bod]
DROP FUNCTION [dbo].[FN_BodhogerdanMinimaalBod]
GO

CREATE FUNCTION FN_BodhogerdanMinimaalBod
  (@Voorwerp  BIGINT,
   @Bodbedrag NUMERIC(9, 2)
  )
  RETURNS BIT
  BEGIN
    IF (@Bodbedrag >= (SELECT VW_minimalenieuwebod
                       FROM Voorwerp
                       WHERE VW_voorwerpnummer = @Voorwerp))
      RETURN 1

    RETURN 0
  END
GO

--Function that check if a user isnt bidding on his own auction.
IF OBJECT_ID('dbo.FN_nietEigenVoorwerp') IS NOT NULL
  IF OBJECT_ID('dbo.Bod') IS NOT NULL
    DROP TABLE [dbo].[Bod]
DROP FUNCTION [dbo].[FN_nietEigenVoorwerp]
GO

CREATE FUNCTION FN_nietEigenVoorwerp(
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
GO

--Function that makes a value NUMERIC(9,2).
IF OBJECT_ID('FN_Maaknumeric') IS NOT NULL
  DROP FUNCTION [dbo].[FN_Maaknumeric]
GO
CREATE FUNCTION FN_Maaknumeric(@Prijs NUMERIC(9, 2))
  RETURNS NUMERIC(9, 2)
  BEGIN
    DECLARE @PrijsNumeric NUMERIC(9, 2);
    SET @PrijsNumeric = (CAST(@Prijs AS NUMERIC(9, 2)));
    IF (@PrijsNumeric <= 1.00)
      SET @PrijsNumeric = 1.50
    RETURN @PrijsNumeric
  END
GO


--Function to convert currencies too the euro standard.
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
GO

--Function that removes HTML description.
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

IF OBJECT_ID('FN_RubriekIsAfstammelingVan') IS NOT NULL
  DROP FUNCTION [dbo].[FN_RubriekIsAfstammelingVan]
GO
--Function that checks if the child column is in the parent.
create FUNCTION [dbo].[FN_RubriekIsAfstammelingVan](
  @KindRubriek INT,
  @SuperRubriek INT
)
  RETURNS BIT
  BEGIN
    IF @KindRubriek = @SuperRubriek OR @kindRubriek IS NULL OR @SuperRubriek IS NULL
      RETURN 0

    DECLARE @ParentVanKind INT = (SELECT TOP 1 RB_Parent FROM Rubriek WHERE Rubriek.RB_Nummer = @KindRubriek)
    IF @ParentVanKind = @SuperRubriek
      RETURN 1

    RETURN dbo.FN_RubriekIsAfstammelingVan(@ParentVanKind,@SuperRubriek)

  END


--Niet meer nodig ivm VW_minimaalnieuwbod
/*CREATE FUNCTION FN_bodHogerDanStartprijs(
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
GO*/