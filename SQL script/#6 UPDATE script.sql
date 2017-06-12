--the stored procedures can be used to update the data in the database.
--Drop all procedures
IF OBJECT_ID('SP_UpdateRating', 'P') IS NOT NULL
  DROP PROCEDURE SP_UpdateRating;
GO
IF OBJECT_ID('SP_UpdateLooptijd', 'P') IS NOT NULL
  DROP PROCEDURE SP_UpdateLooptijd;
GO
IF OBJECT_ID('SP_UpdateBiedingen', 'P') IS NOT NULL
  DROP PROCEDURE SP_UpdateBiedingen
GO

-- User rating randomizen
CREATE PROCEDURE [dbo].[SP_UpdateRating]
AS
  UPDATE Gebruiker
  SET GEB_rating = CEILING(RAND(CHECKSUM(NEWID())) * 100)
GO

--Procedure to update the start- en looptijd.
--Parameters:
--Range of the random dates vfor the looptijdstart, has to be equal or higher then getdate().
CREATE PROCEDURE [dbo].[SP_UpdateLooptijd]
    @FromDate DATE, --begindatum random date.
    @ToDate   DATE  --einddatum random date.
AS
--Temporary table to select random looptijden.
  CREATE TABLE TEMP_LooptijdWaardes (
    ID       TINYINT NOT NULL IDENTITY,
    Looptijd TINYINT NOT NULL --1, 3, 5, 7, 10
  )
  --Inserts looptijden.
  INSERT INTO TEMP_LooptijdWaardes VALUES (1), (3), (5), (7), (10);

  UPDATE Voorwerp
  SET VW_looptijdStart = (SELECT DATEADD(
      MINUTE,
      ABS(CHECKSUM(NEWID())) % DATEDIFF(MINUTE, @FromDate, @ToDate) + DATEDIFF(MINUTE, 0, @FromDate),
      0
  )),
    --Makes a random value modulo the difference between min and max of the range and adds it to the begintijd.
    VW_looptijd        = (SELECT Looptijd
                          FROM TEMP_LooptijdWaardes
                          WHERE ID = (Items.ID % ((SELECT count(*)
                                                   FROM TEMP_LooptijdWaardes) + 1) + 1))
  --Grabs the ID and modulo the value of the table +1 on the range of 0 - 4 . Cause we do +1 we get a range of 1 - 5.
  --Drops temporary table.
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
              --Random to number to bid on random products.
                RandNr = ROW_NUMBER()
              OVER (
                ORDER BY newID() ),
              v.VW_verkoper,
                v.VW_voorwerpnummer                        AS BOD_voorwerpnummer,
              v.VW_startprijs,
                ISNULL((SELECT TOP 1 b.BOD_bodbedrag
                        FROM Bod b
                        WHERE b.BOD_voorwerpnummer = v.VW_voorwerpnummer
                        ORDER BY b.BOD_bodbedrag DESC)
                , v.VW_startprijs)
                + 50.0 + (ABS(Checksum(NewID()) % 10) + 1) AS BOD_bodbedrag,
              --Teh current value + 50 (The highest minimal bid) And a random value of 0 - 10.
                (dbo.FN_GenereerRandomgebruiker(newID()))  AS BOD_gebruiker,
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
                ))                                         AS BOD_bodTijdEnDag -- Tijd binnen een bepaalde range.
            FROM Voorwerp v
          ) Biedingen
        --the gebruiker can't bid on his own auctions.
        WHERE VW_verkoper <> BOD_gebruiker
              AND ISNULL((SELECT TOP 1 b.BOD_bodbedrag
                          FROM Bod b
                          WHERE b.BOD_voorwerpnummer = Biedingen.BOD_voorwerpnummer
                          ORDER BY b.BOD_bodbedrag DESC), Biedingen.VW_startprijs) < 9999960  -- Prevent overflow
              --Only random products.
              AND Biedingen.RandNr % 3 = 0
              AND BOD_voorwerpnummer NOT IN (select VW_voorwerpnummer from Voorwerp where VW_veilinggesloten = 1)
      SET @LoopCount += 1
    END
GO