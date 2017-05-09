use eenmaalandermaal


IF OBJECT_ID('dbo.Voorwerp_Rubriek') IS NOT NULL
  drop table [dbo].Voorwerp_Categorie
IF OBJECT_ID('dbo.Rubriek') IS NOT NULL
  drop table [dbo].Rubriek
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
  BW_betalingswijze VARCHAR(25) NOT NULL, --Keuze betalingswijzen
  CONSTRAINT PK_Betalingswijze PRIMARY KEY (BW_betalingswijze),
);

CREATE TABLE Landen (
  LAN_landcode CHAR(3)     NOT NULL, --ISO 3166/1
  LAN_landnaam VARCHAR(50) NOT NULL, --De langste naam
  CONSTRAINT PK_landen PRIMARY KEY (LAN_landcode),
  CONSTRAINT UQ_landnaam UNIQUE (LAN_landnaam), --In het nederlands
);

CREATE TABLE Voorwerp (
  VW_voorwerpnummer        BIGINT        NOT NULL IDENTITY,             --Genereerd zelf nummer
  VW_titel                 VARCHAR(60)   NOT NULL,                      --Hetzelfde dan marktplaats
  VW_beschrijving          VARCHAR(MAX)  NOT NULL,                      --Geen reden tot beperken
  VW_startprijs            NUMERIC(9, 2) NOT NULL,                      --Bedrag in de miljoenen
  VW_betalingswijze        VARCHAR(25)   NOT NULL DEFAULT 'Bank / Giro', --Korte keuzes (dropdown)
  VW_betalingsinstructie   VARCHAR(255)  NULL,                          --todo
  VW_plaatsnaam            VARCHAR(85)   NOT NULL,                      --Langste plaatsnaam is 85 tekens.
  VW_land                  CHAR(3)       NOT NULL DEFAULT 'NLD',        --ISO 3166/1
  VW_looptijd              TINYINT       NOT NULL DEFAULT 7,            --Aantal dagen
  VW_looptijdStart         DATETIME      NOT NULL DEFAULT GETDATE(),     --Normaal de huidige datum met daarbij de tijd
  VW_verzendkosten         NUMERIC(5,2) NULL,                          --Bedrag mag 2 getallen achter de komma hebben en mag er maximaal 3 voor de komma hebben
  VW_verzendinstructies    VARCHAR(255)  NULL,                          --todo
  VW_verkoper              VARCHAR(40)   NOT NULL,                      --Marktplaats heeft 36 wij 4 meer dus 40
  VW_koper                 VARCHAR(40)   NULL,                          --Marktplaats heeft 36 wij 4 meer dus 40
  VW_looptijdeindeDag      AS DATEADD(DAY, VW_looptijd, VW_looptijdStart), --Bereken de einddatum
  VW_veilinggesloten       BIT           NOT NULL DEFAULT 0,            --Veiling gesloten of open
  VW_verkoopprijs          NUMERIC(9, 2) NULL,                          --huidige bod todo eventueel vragen of Verkoopprijs niet begint met de startprijs

  CONSTRAINT PK_Voorwerp PRIMARY KEY (VW_voorwerpnummer),
  CONSTRAINT FK_Betaalwijze FOREIGN KEY (VW_betalingsWijze) REFERENCES Betalingswijzen (BW_betalingswijze),
  CONSTRAINT FK_Land FOREIGN KEY (VW_land) REFERENCES Landen (LAN_landcode) ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT CHK_TitelNietLeeg CHECK (LEN(RTRIM(LTRIM(VW_titel))) >= 2),            --Kan niet leeg zijn
  CONSTRAINT CHK_BeschrijvingNietLeeg CHECK (LEN(RTRIM(LTRIM(VW_titel))) >= 2),     --Kan niet leeg zijn
  CONSTRAINT CHK_PlaatsnaamNietLeeg CHECK (LEN(RTRIM(LTRIM(VW_plaatsnaam))) >= 2),  --Kan niet leeg zijn
  CONSTRAINT CHK_LooptijdEenGegevenTijd CHECK (VW_looptijd IN (1,3,5,7,10)),                        --De looptijd mag enkel 1,3,5,7,10 zijn zoals aangegeven in Appendix B
  CONSTRAINT CHK_LooptijdBegindagInHetVerleden CHECK (VW_looptijdStart >= GETDATE()), --De begin datum van een veiling mag niet voor de huidige datum liggen.
  CONSTRAINT CHK_StartprijsHogerDan1 CHECK (VW_startprijs >= 1.00), --Appendix B, Mindstends een euro
  CONSTRAINT CHK_VerkoopprijsGroterOfGelijk CHECK (VW_verkoopprijs >= VW_startprijs) --Kijkt of de verkoop prijs wel groter is dan de start prijs
  --todo CONSTRAINT FK_verkoper naar verkopers tabel
  --todo CONSTRAINT FK_koper naar gebruikers tabel
)


CREATE TABLE Rubriek(
  RB_Nummer INT NOT NULL, -- MOET MAX 3 worden
  RB_Naam VARCHAR(100) NOT NULL,
  RB_Parent INT,
  RB_volgnummer INT NOT NULL, -- MOET MAX 2 worden
  CONSTRAINT PK_RB_Nummer PRIMARY KEY (RB_Nummer),
  CONSTRAINT FK_PARENT FOREIGN KEY (RB_Parent) REFERENCES Rubriek (RB_Nummer)
 )

GO

CREATE TABLE Voorwerp_Rubriek(
	VR_Voorwerp_Nummer BIGINT NOT NULL,
	VR_Rubriek_Nummer INT NOT NULL,
	CONSTRAINT  PK_Voorwerp_Rubriek PRIMARY KEY (VR_Voorwerp_Nummer, VR_Rubriek_Nummer),
	CONSTRAINT FK_VR_ID FOREIGN KEY (VR_Voorwerp_Nummer) REFERENCES Voorwerp (VW_Voorwerpnummer) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT FK_VR_RUB FOREIGN KEY (VR_Rubriek_Nummer) REFERENCES Rubriek(RB_Nummer) ON UPDATE CASCADE ON DELETE CASCADE
)

CREATE TABLE Bestand(
  BES_filenaam       VARCHAR(260) NOT NULL,     --Maximum lengte van file path is volgens microsoft 260 tekens.
  BES_voorwerpnummer BIGINT       NOT NULL,
  CONSTRAINT PK_Filenaam PRIMARY KEY (BES_filenaam),
  CONSTRAINT FK_Voorwerpnummer FOREIGN KEY (BES_voorwerpnummer) REFERENCES Voorwerp(VW_voorwerpnummer) ON UPDATE CASCADE ON DELETE CASCADE ,
  CONSTRAINT CHK_AantalBestanden CHECK (dbo.aantalBestandenPerVoorwerpnummer(BES_voorwerpnummer) <= 4)
)

CREATE TABLE Bod (
  BOD_voorwerpnummer BIGINT          NOT NULL,
  BOD_bodbedrag      NUMERIC(9,2)    NOT NULL,
  BOD_gebruiker      VARCHAR(40)     NOT NULL,
  BOD_bodTijdEnDag    DATETIME       NOT NULL DEFAULT GETDATE(),
  CONSTRAINT PK_BodVoorwerpnummer PRIMARY KEY (BOD_voorwerpnummer, BOD_bodbedrag),
  CONSTRAINT FK_BodVoorwerpnummer FOREIGN KEY (BOD_voorwerpnummer) REFERENCES Voorwerp(VW_voorwerpnummer) ON UPDATE CASCADE ON DELETE CASCADE,
  --todo foreign key voor gebruiker
  CONSTRAINT CHK_HogerDanStartprijs CHECK(dbo.bodHogerDanStartprijs(BOD_voorwerpnummer, BOD_bodbedrag) = 1),
  --CONSTRAINT CHK_BodBedrag CHECK (dbo.bodHoogGenoeg(voorwerpnummer, bodbedrag) = 1),
  CONSTRAINT CHK_NietEigenVoorwerp CHECK(dbo.nietEigenVoorwerp(BOD_voorwerpnummer,BOD_gebruiker) = 1)
)

/*GO
CREATE TRIGGER bodHoogGenoeg
  ON Bod
FOR INSERT, UPDATE
AS
  BEGIN
    DECLARE @Voorwerpnummer BIGINT
    SET @Voorwerpnummer = (SELECT TOP 1 BOD_Voorwerpnummer
                           FROM inserted)
    DECLARE @Bodbedrag NUMERIC(9, 2)
    SET @Bodbedrag = (SELECT TOP 1 BOD_bodbedrag
                      FROM inserted)
    DECLARE @huidigeHoogsteBod NUMERIC(9, 2)
    SET @huidigeHoogsteBod = (SELECT TOP 1 BOD_Bodbedrag FROM Bod WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag FROM Bod WHERE BOD_voorwerpnummer = @Voorwerpnummer ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = @Voorwerpnummer ORDER BY BOD_Bodbedrag DESC)
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
*/

