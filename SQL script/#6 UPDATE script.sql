--Dit script kan gebruikt worden om de data die al in de database staat te updaten.


IF OBJECT_ID('SP_UpdateLooptijd', 'P') IS NOT NULL
  DROP PROCEDURE SP_UpdateLooptijd;
GO
IF OBJECT_ID('SP_UpdateBiedingen', 'P') IS NOT NULL
  DROP PROCEDURE SP_UpdateBiedingen
GO

--Procedure om de starttijden en looptijden van de voorwerpen te updaten.
--Parameters:
--Range van de random datums voor de looptijdstart, moet later of gelijk zijn aan getdate().
CREATE PROCEDURE [dbo].[SP_UpdateLooptijd]
    @FromDate DATE, --begindatum random datum.
    @ToDate   DATE  --einddatum random datum.
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
                          WHERE ID = (Voorwerp.VW_voorwerpnummer % ((SELECT count(*)
                                                                     FROM TEMP_LooptijdWaardes) + 1) + 1))
  --Pakt het ID en doet modulo op het aantal van de tabel + 1 wat een range van 0 - 4 geeft. We tellen er een bij op om de 1 - 5 van de identity te krijgen.
  --Tijdelijke tabel opruimen.
  IF OBJECT_ID('dbo.TEMP_LooptijdWaardes') IS NOT NULL
    DROP TABLE dbo.TEMP_LooptijdWaardes
GO


CREATE PROCEDURE [dbo].[SP_UpdateBiedingen]
    @Daterange INT = 14,
    @NrTimes   TINYINT = 3
AS
  DECLARE @LoopCount INT = 0
  WHILE (@LoopCount < @NrTimes)
    BEGIN
      PRINT 'looping again' + CAST(@LoopCount AS VARCHAR)
      INSERT INTO Bod (BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker, BOD_bodTijdEnDag)
        SELECT
          BOD_voorwerpnummer,
          BOD_bodbedrag,
          BOD_gebruiker,
          BOD_bodTijdEnDag
        FROM
          (
            SELECT
              --Random nummer om random op random voorwerpen boden te plaatsen.
                RandNr = ROW_NUMBER()
              OVER (
                ORDER BY newID() ),
              v.VW_verkoper,
                v.VW_voorwerpnummer                                      AS BOD_voorwerpnummer,
              v.VW_startprijs,
                ISNULL((SELECT TOP 1 b.BOD_bodbedrag
                        FROM Bod b
                        WHERE b.BOD_voorwerpnummer = v.VW_voorwerpnummer
                        ORDER BY b.BOD_bodbedrag DESC)
                , v.VW_startprijs)
                + 50.0 + (ABS(Checksum(NewID()) % 10) + 1)               AS BOD_bodbedrag,
              --De huidige waarde plus 50 (het hoogste minimale bod) en een random waarde van 1 tot 10
                (dbo.FN_GenereerRandomgebruiker(newID(), v.VW_verkoper)) AS BOD_gebruiker,
                (SELECT DATEADD(
                    MINUTE,
                    ABS(CHECKSUM(NEWID())) % DATEDIFF(MINUTE, ISNULL((SELECT TOP 1 b.BOD_bodTijdEnDag
                                                                      FROM Bod b
                                                                      WHERE b.BOD_voorwerpnummer = v.VW_voorwerpnummer
                                                                      ORDER BY b.BOD_bodTijdEnDag DESC),
                                                                     v.VW_looptijdStart),
                                                      DATEADD(DAY, @Daterange, ISNULL((SELECT TOP 1 b.BOD_bodTijdEnDag
                                                                                       FROM Bod b
                                                                                       WHERE b.BOD_voorwerpnummer =
                                                                                             v.VW_voorwerpnummer
                                                                                       ORDER BY
                                                                                         b.BOD_bodTijdEnDag DESC),
                                                                                      v.VW_looptijdStart))) +
                    DATEDIFF(MINUTE, 0, ISNULL((SELECT TOP 1 b.BOD_bodTijdEnDag
                                                FROM Bod b
                                                WHERE b.BOD_voorwerpnummer = v.VW_voorwerpnummer
                                                ORDER BY b.BOD_bodTijdEnDag DESC), v.VW_looptijdStart)),
                    0
                ))                                                       AS BOD_bodTijdEnDag -- Tijd binnen een bepaalde range.
            FROM Voorwerp v
          ) Biedingen
        --De gebruiker mag niet op zijn eigen voorwerpen bieden.
        WHERE VW_verkoper <> BOD_gebruiker
              AND ISNULL((SELECT TOP 1 b.BOD_bodbedrag
                          FROM Bod b
                          WHERE b.BOD_voorwerpnummer = Biedingen.BOD_voorwerpnummer
                          ORDER BY b.BOD_bodbedrag DESC), Biedingen.VW_startprijs) < 9999960 /*Prevent overflow*/
              --Alleen random voorwerpen.
              AND Biedingen.RandNr % 3 = 0
      SET @LoopCount += 1
    END
GO