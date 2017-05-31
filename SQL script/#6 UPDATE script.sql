--Dit script kan gebruikt worden om de data die al in de database staat te updaten.

--Updaten voorwerp startdatum en looptijd.
IF OBJECT_ID('SP_UpdateLooptijd', 'P') IS NOT NULL
  DROP PROCEDURE SP_UpdateLooptijd;
GO

--Procedure om de starttijden en looptijden van de voorwerpen te updaten.
--Parameters:
--Range van de random datums voor de looptijdstart, moet later of gelijk zijn aan getdate().
CREATE PROCEDURE SP_UpdateLooptijd
  @FromDate DATE = getdate(), --default begindatum random datum.
  @ToDate DATE = dateADD(DAY, getdate(), 14) -- default einddatum random datum.
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
                          WHERE ID = ((Items.ID % 5) + 1))
  --Pakt het ID en doet modulo 5 wat een range van 0 - 4 geeft. We tellen er een bij op om de 1 - 5 van de identity te krijgen.

  --Tijdelijke tabel opruimen.
  IF OBJECT_ID('dbo.TEMP_LooptijdWaardes') IS NOT NULL
    DROP TABLE dbo.TEMP_LooptijdWaardes
GO

