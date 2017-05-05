use eenmaalandermaal
IF OBJECT_ID('dbo.Voorwerp') IS NOT NULL
  drop table [dbo].[Voorwerp]
IF OBJECT_ID('dbo.Landen') IS NOT NULL
  drop table [dbo].[Landen]
IF OBJECT_ID('dbo.Betalingswijzen') IS NOT NULL
  drop table [dbo].[Betalingswijzen]
IF OBJECT_ID('dbo.Bestand') IS NOT NULL
  drop table [dbo].[Bestand]

CREATE TABLE Bestand(
  filenaam       VARCHAR(260) NOT NULL,     --Maximum lengte van file path is volgens microsoft 260 tekens.
  voorwerpnummer BIGINT       NOT NULL,
  CONSTRAINT PK_filenaam PRIMARY KEY (filenaam),
  CONSTRAINT FK_voorweprnummer FOREIGN KEY (voorwerpnummer) REFERENCES Voorwerp(voorwerpnummer),
  CONSTRAINT CHK_voorwerpnummer CHECK ([dbo].[aantalBestandenPerVoorwerpnummer](voorwerpnummer) <= 4)
)

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
  CONSTRAINT CHK_TITEL_NOT_EMPTY CHECK (LEN(RTRIM(LTRIM(titel))) >= 2),            --Kan niet leeg zijn
  CONSTRAINT CHK_BESCHRIJVING_NOT_EMPTY CHECK (LEN(RTRIM(LTRIM(titel))) >= 2),     --Kan niet leeg zijn
  CONSTRAINT CHK_PLAATSNAAM_NOT_EMPTY CHECK (LEN(RTRIM(LTRIM(plaatsnaam))) >= 2),  --Kan niet leeg zijn
  CONSTRAINT CHK_LOOPTIJD_ONE_OF_THE_GIVEN_TIMES CHECK (looptijd IN (1,3,5,7,10)),                        --De looptijd mag enkel 1,3,5,7,10 zijn zoals aangegeven in Appendix B
  CONSTRAINT CHK_LOOPTIJDBEGINDAG_NOT_IN_THE_PAST CHECK (CONVERT(DATE, looptijdBeginDag) >= CONVERT(DATE,GETDATE())), --De begin datum van een veiling mag niet voor de huidige datum liggen.
  CONSTRAINT CHK_LOOPTIJDBEGINTIJDSTIP_NOT_IN_THE_PAST CHECK (
    CASE WHEN CONVERT(DATE, looptijdBeginDag) = CONVERT(DATE, GETDATE())           --Is de ingegeven dag de huidige dag
      THEN
        CASE WHEN CONVERT(TIME, looptijdBeginTijdstip) >= CONVERT(TIME, GETDATE())  --Wanneer het de huidige dag is, is de ingegeven tijd na of de huidige tijd
          THEN 1
        ELSE 0
        END
    ELSE
      CASE WHEN CONVERT(DATE, looptijdBeginDag) > CONVERT(DATE, GETDATE())           --Is de ingegeven dag niet de huidige dag dan wordt er gekeken of de dag wel na de huidige dag valt.
        THEN 1
      END
    END = 1
  ),
  CONSTRAINT CHK_STARTPRIJS_GREATER_THAN_1 CHECK (Startprijs >= 1.00), --Appendix B, Mindstends een euro
  CONSTRAINT CHK_VERKOOPPRIJS_GREATER_OR_EQUALS_STARTPRIJS CHECK (verkoopprijs >= startprijs), --Kijkt of de verkoop prijs wel groter is dan de start prijs
  CONSTRAINT FK_BETAALWIJZE FOREIGN KEY (betalingsWijze) REFERENCES Betalingswijzen (betalingswijze),
  CONSTRAINT FK_LAND FOREIGN KEY (land) REFERENCES Landen (landcode)
  --todo CONSTRAINT FK_verkoper naar verkopers tabel
  --todo CONSTRAINT FK_koper naar gebruikers tabel
)


