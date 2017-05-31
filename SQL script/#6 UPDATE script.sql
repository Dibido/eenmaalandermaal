--Dit script kan gebruikt worden om de data die al in de database staat te updaten.


IF OBJECT_ID('SP_UpdateLooptijd', 'P') IS NOT NULL
  DROP PROCEDURE SP_UpdateLooptijd;
GO
IF OBJECT_ID('SP_UpdateBiedingen') IS NOT NULL
  DROP PROCEDURE SP_UpdateBiedingen
GO

--Procedure om de starttijden en looptijden van de voorwerpen te updaten.
--Parameters:
--Range van de random datums voor de looptijdstart, moet later of gelijk zijn aan getdate().
CREATE PROCEDURE SP_UpdateLooptijd
    @FromDate DATE = getdate(), --default begindatum random datum.
    @ToDate   DATE = dateADD(DAY, getdate(), 14) -- default einddatum random datum.
AS
--Tijdelijke tabel om random looptijden te kunnen selecteren.
  CREATE TABLE TEMP_LooptijdWaardes (
    ID       TINYINT NOT NULL IDENTITY,
    Looptijd TINYINT NOT NULL --1, 3, 5, 7, 10
  )
  --Looptijden inserten.
  INSERT INTO TEMP_LooptijdWaardes VALUES (1), (3), (5), (7), (10);

  UPDATE Voorwerp
  SET VW_looptijdStart = (SELECT DATEADD(
      MINUTE,
      ABS(CHECKSUM(NEWID())) % DATEDIFF(MINUTE, @FromDate, @ToDate) + DATEDIFF(MINUTE, 0, @FromDate),
      0
  )),
    --Doet een random waarde modulo het verschil tussen de min en max waarde van de range en voegt dan de begintijd toe.
    VW_looptijd        = (SELECT Looptijd
                          FROM TEMP_LooptijdWaardes
                          WHERE ID = (Items.ID % ((SELECT count(*)
                                                   FROM TEMP_LooptijdWaardes) + 1) + 1))
  --Pakt het ID en doet modulo op het aantal van de tabel + 1 wat een range van 0 - 4 geeft. We tellen er een bij op om de 1 - 5 van de identity te krijgen.

  --Tijdelijke tabel opruimen.
  IF OBJECT_ID('dbo.TEMP_LooptijdWaardes') IS NOT NULL
    DROP TABLE dbo.TEMP_LooptijdWaardes
GO

--Tijdelijke functie om een random gebruiker te vinden
--Variabelen:
--@Identifier, een unieke identity in de tabel.
--@Verkoper, De verkoper van het product.

CREATE FUNCTION TEMP_FN_Randomgebruiker
  (@Identifier UNIQUEIDENTIFIER,
   @Verkoper   VARCHAR(64))
  RETURNS VARCHAR(64)
AS
  BEGIN
    --Selecteer een random gebruiker aan de hand van de random identifier en het regelnummer.
    RETURN (SELECT TOP 1 GEB_gebruikersnaam
                                      FROM (SELECT
                                              GEB_gebruikersnaam,
                                              ROW_NUMBER()
                                              OVER (
                                                ORDER BY GEB_gebruikersnaam ) AS regel
                                            FROM Gebruiker
                                           ) AS regels
                                      WHERE regels.regel = (SELECT ((ABS(CHECKSUM(@Identifier))) % (SELECT count(*) + 1
                                                                                                    FROM Gebruiker )) + 1))
    --Als de gebruiker hetzelfde is als de verkoper, genereer een nieuwe gebruiker. (mag niet op eigen producten bieden)
    --IF @Gebruiker != @Verkoper
     -- RETURN @Gebruiker
    /*ELSE
      RETURN dbo.TEMP_FN_Randomgebruiker(@Identifier, @Verkoper)
    RETURN
    */
  END
GO

CREATE PROCEDURE SP_UpdateBiedingen
    @Daterange INT = 14
AS
--INSERT INTO Bod (BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker, BOD_bodTijdEnDag)
  SELECT
    v.VW_voorwerpnummer                                      AS BOD_voorwerpnummer,
    v.VW_startprijs + 50 + (ABS(Checksum(NewID()) % 10) + 1) AS BOD_bodbedrag,
    --De huidige waarde plus 50 (het hoogste minimale bod) en een random waarde van 1 tot 10
    (dbo.TEMP_FN_Randomgebruiker(newID(), v.VW_verkoper))   AS BOD_gebruiker,
    (SELECT DATEADD(
        MINUTE,
        ABS(CHECKSUM(NEWID())) % DATEDIFF(MINUTE, v.VW_looptijdStart, DATEADD(DAY, 14, v.VW_looptijdStart)) +
        DATEDIFF(MINUTE, 0, v.VW_looptijdStart),
        0
    ))                                                       AS BOD_bodTijdEnDag -- Tijd binnen een bepaalde range.
  FROM Voorwerp v
  ORDER BY BOD_gebruiker ASC
GO

  --Hulpfunctie opruimen
  IF OBJECT_ID('TEMP_FN_Randomgebruiker') IS NOT NULL
    DROP FUNCTION TEMP_FN_Randomgebruiker
GO

select * from Voorwerp where VW_verkoper is null



select count(*) from Bod

EXEC SP_UpdateBiedingen

DROP PROCEDURE SP_UpdateBiedingen