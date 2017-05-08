use eenmaalandermaal
IF OBJECT_ID('dbo.Voorwerp') IS NOT NULL
  drop table [dbo].[Voorwerp]
IF OBJECT_ID('dbo.Landen') IS NOT NULL
  drop table [dbo].[Landen]
IF OBJECT_ID('dbo.Betalingswijzen') IS NOT NULL
  drop table [dbo].[Betalingswijzen]
IF OBJECT_ID('dbo.Bestand') IS NOT NULL
  drop table [dbo].[Bestand]
IF OBJECT_ID('dbo.Bod') IS NOT NULL
  drop table [dbo].[Bod]

CREATE TABLE Betalingswijzen (
  betalingswijze VARCHAR(25) NOT NULL, --Keuze betalingswijzen
  CONSTRAINT PK_Betalingswijze PRIMARY KEY (betalingswijze),
);

CREATE TABLE Landen (
  landcode CHAR(3)     NOT NULL, --ISO 3166/1
  landnaam VARCHAR(50) NOT NULL, --De langste naam
  CONSTRAINT PK_landen PRIMARY KEY (landcode),
  CONSTRAINT UQ_landnaam UNIQUE (landnaam), --In het nederlands
);

CREATE TABLE Voorwerp (
  voorwerpnummer        BIGINT        NOT NULL IDENTITY,             --Genereerd zelf nummer
  titel                 VARCHAR(60)   NOT NULL,                      --Hetzelfde dan marktplaats
  beschrijving          VARCHAR(MAX)  NOT NULL,                      --Geen reden tot beperken
  startprijs            NUMERIC(9, 2) NOT NULL,                      --Bedrag in de miljoenen
  betalingswijze        VARCHAR(25)   NOT NULL DEFAULT 'Bank / Giro', --Korte keuzes (dropdown)
  betalingsinstructie   VARCHAR(255)  NULL,                          --todo
  plaatsnaam            VARCHAR(85)   NOT NULL,                      --Langste plaatsnaam is 85 tekens.
  land                  CHAR(3)       NOT NULL DEFAULT 'NLD',        --ISO 3166/1
  looptijd              TINYINT       NOT NULL DEFAULT 7,            --Aantal dagen
  looptijdBeginDag      DATE          NOT NULL DEFAULT GETDATE(),    --Enkel dag, maand jaar is nodig.
  looptijdbeginTijdstip TIME          NOT NULL DEFAULT GETDATE(),    --Enkel tijdstip is nodig(Uur-Minuten-Seconden)
  verzendkosten         NUMERIC(5,2) NULL,                          --Bedrag mag 2 getallen achter de komma hebben en mag er maximaal 3 voor de komma hebben
  verzendinstructies    VARCHAR(255)  NULL,                          --todo
  verkoper              VARCHAR(40)   NOT NULL,                      --Marktplaats heeft 36 wij 4 meer dus 40
  koper                 VARCHAR(40)   NULL,                          --Marktplaats heeft 36 wij 4 meer dus 40
  looptijdeindeDag      AS DATEADD(DAY, looptijd, looptijdBeginDag), --Bereken de einddatum
  looptijdeindeTijdstip AS looptijdbeginTijdstip,                    --Eindtijdstip
  veilinggesloten       BIT           NOT NULL DEFAULT 0,            --Veiling gesloten of open
  verkoopprijs          NUMERIC(9, 2) NULL,                          --huidige bod todo eventueel vragen of Verkoopprijs niet begint met de startprijs

  CONSTRAINT PK_Voorwerp PRIMARY KEY (voorwerpnummer),
  CONSTRAINT FK_Betaalwijze FOREIGN KEY (betalingsWijze) REFERENCES Betalingswijzen (betalingswijze),
  CONSTRAINT FK_Land FOREIGN KEY (land) REFERENCES Landen (landcode) ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT CHK_TitelNietLeeg CHECK (LEN(RTRIM(LTRIM(titel))) >= 2),            --Kan niet leeg zijn
  CONSTRAINT CHK_BeschrijvingNietLeeg CHECK (LEN(RTRIM(LTRIM(titel))) >= 2),     --Kan niet leeg zijn
  CONSTRAINT CHK_PlaatsnaamNietLeeg CHECK (LEN(RTRIM(LTRIM(plaatsnaam))) >= 2),  --Kan niet leeg zijn
  CONSTRAINT CHK_LooptijdEenGegevenTijd CHECK (looptijd IN (1,3,5,7,10)),                        --De looptijd mag enkel 1,3,5,7,10 zijn zoals aangegeven in Appendix B
  CONSTRAINT CHK_LooptijdBegindagNietInHetVerleden CHECK (CONVERT(DATE, looptijdBeginDag) >= CONVERT(DATE,GETDATE())), --De begin datum van een veiling mag niet voor de huidige datum liggen.
  CONSTRAINT CHK_LooptijdBeginTijdstipNietInHetVerleden CHECK (dbo.tijdstipCheck(looptijdBeginDag,looptijdbeginTijdstip) = 1),
  CONSTRAINT CHK_StartprijsHogerDan1 CHECK (Startprijs >= 1.00), --Appendix B, Mindstends een euro
  CONSTRAINT CHK_VerkoopprijsGroterOfGelijk CHECK (verkoopprijs >= startprijs) --Kijkt of de verkoop prijs wel groter is dan de start prijs
  --todo CONSTRAINT FK_verkoper naar verkopers tabel
  --todo CONSTRAINT FK_koper naar gebruikers tabel
)

CREATE TABLE Bestand(
  filenaam       VARCHAR(260) NOT NULL,     --Maximum lengte van file path is volgens microsoft 260 tekens.
  voorwerpnummer BIGINT       NOT NULL,
  CONSTRAINT PK_Filenaam PRIMARY KEY (filenaam),
  CONSTRAINT FK_Voorwerpnummer FOREIGN KEY (voorwerpnummer) REFERENCES Voorwerp(voorwerpnummer) ON UPDATE CASCADE ON DELETE CASCADE ,
  CONSTRAINT CHK_AantalBestanden CHECK (dbo.aantalBestandenPerVoorwerpnummer(voorwerpnummer) <= 4)
)

CREATE TABLE Bod (
  voorwerpnummer BIGINT        NOT NULL,
  bodbedrag      NUMERIC(9,2) NOT NULL,
  gebruiker      VARCHAR(40)   NOT NULL,
  bodDag         DATE          NOT NULL DEFAULT GETDATE(),
  bodTijdstip    TIME          NOT NULL DEFAULT GETDATE(),
  CONSTRAINT PK_BodVoorwerpnummer PRIMARY KEY (voorwerpnummer, bodbedrag),
  CONSTRAINT FK_BodVoorwerpnummer FOREIGN KEY (voorwerpnummer) REFERENCES Voorwerp(voorwerpnummer) ON UPDATE CASCADE ON DELETE CASCADE,
  --todo foreign key voor gebruiker
  CONSTRAINT CHK_HogerDanStartprijs CHECK(dbo.bodHogerDanStartprijs(voorwerpnummer, bodbedrag) = 1),
  --CONSTRAINT CHK_BodBedrag CHECK (dbo.bodHoogGenoeg(voorwerpnummer, bodbedrag) = 1),
  CONSTRAINT CHK_NietEigenVoorwerp CHECK(dbo.nietEigenVoorwerp(voorwerpnummer,gebruiker) = 1)
)

GO
CREATE TRIGGER bodHoogGenoeg
  ON Bod
FOR INSERT, UPDATE
AS
  BEGIN
    DECLARE @Voorwerpnummer BIGINT
    SET @Voorwerpnummer = (SELECT TOP 1 Voorwerpnummer
                           FROM inserted)
    DECLARE @Bodbedrag NUMERIC(9, 2)
    SET @Bodbedrag = (SELECT TOP 1 bodbedrag
                      FROM inserted)
    DECLARE @huidigeHoogsteBod NUMERIC(9, 2)
    SET @huidigeHoogsteBod = (SELECT TOP 1 Bodbedrag FROM Bod WHERE Bodbedrag NOT IN (SELECT TOP 1 Bodbedrag FROM Bod WHERE voorwerpnummer = @Voorwerpnummer ORDER BY Bodbedrag DESC) AND voorwerpnummer = @Voorwerpnummer ORDER BY Bodbedrag DESC)
    IF @huidigeHoogsteBod > 0.0
      BEGIN
        IF @huidigeHoogsteBod BETWEEN 1 AND 49.99
          BEGIN
            IF @Bodbedrag - @huidigeHoogsteBod < 0.50
              BEGIN
                ROLLBACK
              END
          END
        IF @huidigeHoogsteBod BETWEEN 50 AND 499.99 --todo vragen of het 50 of 49.99 moet zijn
          BEGIN
            IF (@Bodbedrag - (@huidigeHoogsteBod) < 1)
              BEGIN
                ROLLBACK
              END
          END
        IF @huidigeHoogsteBod BETWEEN 500.00 AND 999.99
          BEGIN
            IF @Bodbedrag - (@huidigeHoogsteBod) < 5
              BEGIN
                ROLLBACK
              END
          END
        IF @huidigeHoogsteBod BETWEEN 1000.00 AND 4999.99
          BEGIN
            IF @Bodbedrag - (@huidigeHoogsteBod) < 10
              BEGIN
                ROLLBACK
              END
          END
        IF @huidigeHoogsteBod > 5000
          BEGIN
            IF @Bodbedrag - (@huidigeHoogsteBod) < 50
              BEGIN
                ROLLBACK
              END
          END
      END
  END


