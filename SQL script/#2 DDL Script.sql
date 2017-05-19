USE eenmaalandermaal

IF OBJECT_ID('dbo.Voorwerp_Rubriek') IS NOT NULL
  DROP TABLE dbo.Voorwerp_Rubriek
IF OBJECT_ID('dbo.Rubriek') IS NOT NULL
  DROP TABLE dbo.Rubriek
IF OBJECT_ID('dbo.Bestand') IS NOT NULL
  DROP TABLE dbo.Bestand
IF OBJECT_ID('dbo.Voorwerp') IS NOT NULL
  DROP TABLE dbo.Voorwerp
IF OBJECT_ID('dbo.Gebruikerstelefoon') IS NOT NULL
  DROP TABLE dbo.Gebruikerstelefoon
IF OBJECT_ID('dbo.Gebruiker') IS NOT NULL
  DROP TABLE dbo.Gebruiker
IF OBJECT_ID('dbo.Landen') IS NOT NULL
  DROP TABLE dbo.Landen
IF OBJECT_ID('dbo.Betalingswijzen') IS NOT NULL
  DROP TABLE dbo.Betalingswijzen
IF OBJECT_ID('dbo.Bod') IS NOT NULL
  DROP TABLE dbo.Bod
IF OBJECT_ID('dbo.Vraag') IS NOT NULL
  DROP TABLE dbo.Vraag


CREATE TABLE Betalingswijzen (
  BW_betalingswijze VARCHAR(25) NOT NULL, --Keuze betalingswijzen
  CONSTRAINT PK_Betalingswijze PRIMARY KEY (BW_betalingswijze),
);

CREATE TABLE Landen (
  LAN_landcode CHAR(2)     NOT NULL, --Zie ISO 3166/1 alpha-2
  LAN_landnaam VARCHAR(50) NOT NULL, --De langste naam is 50 karakters
  CONSTRAINT PK_landen PRIMARY KEY (LAN_landcode),
  CONSTRAINT UQ_landnaam UNIQUE (LAN_landnaam), --In het nederlands
);

CREATE TABLE Vraag (
  VR_vraagnummer TINYINT NOT NULL, --Niet meer dan 255 vragen
  VR_tekstvraag  VARCHAR(255), --Goede lengte voor de vragen
  CONSTRAINT PK_Vraag PRIMARY KEY (VR_vraagnummer)
);

CREATE TABLE Gebruiker (
  GEB_gebruikersnaam VARCHAR(64)            NOT NULL, --Zie RFC 5321.
  GEB_voornaam       VARCHAR(16)            NOT NULL, --Normale lengte van nederlandse voornaam
  GEB_achternaam     VARCHAR(16)            NOT NULL, --Normale lengte van nederlandse achternaam inclusief tussenvoegsel
  GEB_adresregel_1   VARCHAR(255)           NOT NULL, --Normale lengte van een adresregel
  GEB_adresregel_2   VARCHAR(255)           NULL, --Normale lengte van een adresregel
  GEB_postcode       VARCHAR(12)            NOT NULL, --Maximale Lengte van een postcode: ISO_3166
  GEB_plaatsnaam     VARCHAR(85)            NOT NULL, --Langste plaatsnaam zie: "https://en.wikipedia.org/wiki/List_of_long_place_names"
  GEB_Land           CHAR(2) DEFAULT 'NL'   NOT NULL, --Landcode uit de landen tabel
  GEB_geboortedag    DATE                   NOT NULL,
  GEB_mailbox        VARCHAR(256)           NOT NULL, --Mailadres lengte volgens RFC 5321
  GEB_wachtwoord     CHAR(60)               NOT NULL, --BCRYPT dmv password_hash()
  GEB_vraag          TINYINT                NOT NULL, --Nummer uit de Vraag tabel
  GEB_antwoordtekst  VARCHAR(16)            NOT NULL, --Antwoord op de vraag,  TODO:(case sensitive?)
  GEB_verkoper       BIT DEFAULT 0          NOT NULL, --Of de gebruiker een verkoper is of niet, standaard is de gebruiker geen verkoper
  GEB_rating         NUMERIC(4, 1)          NULL, --Rating van de gebruiker 0.0 - 100.0
  CONSTRAINT PK_GebruikerGebruikersnaam PRIMARY KEY (GEB_gebruikersnaam),
  CONSTRAINT FK_VraagVraagnummer FOREIGN KEY (GEB_vraag) REFERENCES Vraag (VR_vraagnummer),
  --TODO: vragen of deze moet: CONSTRAINT FK_GebruikerstelefoonGebruiker FOREIGN KEY (GEB_gebruikersnaam) REFERENCES Gebruikerstelefoon (TEL_gebruiker),
  CONSTRAINT FK_LandenLandcode FOREIGN KEY (GEB_Land) REFERENCES Landen (LAN_landcode),
  CONSTRAINT CHK_LegitiemeMailbox CHECK (GEB_mailbox LIKE '%_@__%.__%'),
  CONSTRAINT CHK_LegitiemeGeboortedag CHECK (GEB_geboortedag < getdate())
  --TODO: check bouwen voor de lengte van het wachtwoord (bepaalde tekens verplicht maken?)
);

CREATE TABLE Gebruikerstelefoon (
  TEL_volgnr    INT IDENTITY NOT NULL, --Wordt verhoogd als er een nieuw nummer toegevoegd word
  TEL_gebruiker VARCHAR(64)  NOT NULL, --gebruiker uit de gebruiker tabel
  TEL_telefoon  CHAR(15)     NOT NULL, --Zie ITU-T recommendation E.164
  CONSTRAINT PK_GebruikerstelefoonVolgnr PRIMARY KEY (TEL_volgnr),
  CONSTRAINT FK_GebruikerGebruikersnaam FOREIGN KEY (TEL_gebruiker) REFERENCES Gebruiker (GEB_gebruikersnaam)
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
);

CREATE TABLE Voorwerp (
  VW_voorwerpnummer      BIGINT        NOT NULL IDENTITY, --Genereerd zelf nummer, zo veel mogelijk voorwerpen
  VW_titel               VARCHAR(60)   NOT NULL, --Hetzelfde als marktplaats
  VW_beschrijving        VARCHAR(MAX)  NOT NULL, --Geen reden tot beperken
  VW_startprijs          NUMERIC(9, 2) NOT NULL, --Bedrag in de miljoenen
  VW_betalingswijze      VARCHAR(25)   NOT NULL DEFAULT 'Bank / Giro', --Korte keuzes (d.m.v. dropdown)
  VW_betalingsinstructie VARCHAR(255)  NULL, --Korte instructie
  VW_plaatsnaam          VARCHAR(85)   NOT NULL, --Langste plaatsnaam is 85 tekens
  VW_land                CHAR(2)       NOT NULL DEFAULT 'NL', --Zie ISO 3166/1 alpha-2
  VW_looptijd            TINYINT       NOT NULL DEFAULT 7, --Aantal dagen
  VW_looptijdStart       DATETIME      NOT NULL DEFAULT GETDATE(), --Normaal de huidige datum met daarbij de tijd
  VW_verzendkosten       NUMERIC(5, 2) NULL, --Bedrag mag 2 getallen achter de komma hebben en mag er maximaal 3 voor de komma hebben
  VW_verzendinstructies  VARCHAR(255)  NULL, --Korte instructie
  VW_verkoper            VARCHAR(64)   NOT NULL, --Zie RFC 5321.
  VW_conditie            VARCHAR(255)  NULL, --Korte beschrijving.
  VW_thumbnail           VARCHAR(260)  NOT NULL, --Bestandpadlengte hetzelfde als in Bestand
  VW_koper               VARCHAR(64)   NULL, --Zie RFC 5321.
  VW_looptijdEinde                              AS DATEADD(DAY, VW_looptijd, VW_looptijdStart), --Bereken de einddatum
  VW_veilinggesloten     BIT           NOT NULL DEFAULT 0, --Veiling gesloten of open
  VW_verkoopprijs        NUMERIC(9, 2) NULL, --Prijs waarvoor het voorwerp verkocht is

  CONSTRAINT PK_Voorwerp PRIMARY KEY (VW_voorwerpnummer),
  CONSTRAINT FK_Betaalwijze FOREIGN KEY (VW_betalingsWijze) REFERENCES Betalingswijzen (BW_betalingswijze),
  CONSTRAINT FK_Land FOREIGN KEY (VW_land) REFERENCES Landen (LAN_landcode)
    ON UPDATE CASCADE --Voor als de landnamen worden aangepast
    ON DELETE NO ACTION,
  CONSTRAINT FK_VoorwerpGebruikerGebruikersnaam FOREIGN KEY (VW_koper) REFERENCES Gebruiker (GEB_gebruikersnaam)
    ON UPDATE CASCADE --Voor als de gebruikersnaam wordt aangepast
    ON DELETE NO ACTION,
  CONSTRAINT CHK_TitelNietLeeg CHECK (LEN(RTRIM(LTRIM(VW_titel))) >= 2), --Kan niet leeg zijn
  CONSTRAINT CHK_BeschrijvingNietLeeg CHECK (LEN(RTRIM(LTRIM(VW_titel))) >= 2), --Kan niet leeg zijn
  CONSTRAINT CHK_PlaatsnaamNietLeeg CHECK (LEN(RTRIM(LTRIM(VW_plaatsnaam))) >= 2), --Kan niet leeg zijn
  CONSTRAINT CHK_LooptijdEenGegevenTijd CHECK (VW_looptijd IN
                                               (1, 3, 5, 7, 10)), --De looptijd mag enkel 1,3,5,7,10 zijn zoals aangegeven in Appendix B
  CONSTRAINT CHK_LooptijdBegindagInHetVerleden CHECK (VW_looptijdStart >=
                                                      GETDATE()), --De begin datum van een veiling mag niet voor de huidige datum liggen.
  CONSTRAINT CHK_StartprijsHogerDan1 CHECK (VW_startprijs >= 1.00), --Appendix B, Mindstends een euro
  CONSTRAINT CHK_VerkoopprijsGroterOfGelijk CHECK (VW_verkoopprijs >=
                                                   VW_startprijs), --Kijkt of de verkoop prijs wel groter is dan de start prijs
  --TODO: CONSTRAINT FK_verkoper naar verkopers tabel
)


CREATE TABLE Rubriek (
  RB_Nummer     INT          NOT NULL, -- MOET MAX 3 worden
  RB_Naam       VARCHAR(100) NOT NULL,
  RB_Parent     INT          NULL,
  RB_volgnummer INT          NOT NULL, -- MOET MAX 2 worden
  CONSTRAINT PK_RB_Nummer PRIMARY KEY (RB_Nummer),
  CONSTRAINT FK_Parent FOREIGN KEY (RB_Parent) REFERENCES Rubriek (RB_Nummer)
);


CREATE TABLE Voorwerp_Rubriek (
  VR_Voorwerp_Nummer BIGINT NOT NULL,
  VR_Rubriek_Nummer  INT    NOT NULL,
  CONSTRAINT PK_Voorwerp_Rubriek PRIMARY KEY (VR_Voorwerp_Nummer, VR_Rubriek_Nummer),
  CONSTRAINT FK_VR_ID FOREIGN KEY (VR_Voorwerp_Nummer) REFERENCES Voorwerp (VW_Voorwerpnummer)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT FK_VR_RUB FOREIGN KEY (VR_Rubriek_Nummer) REFERENCES Rubriek (RB_Nummer)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE Bestand (
  BES_filenaam       VARCHAR(260) NOT NULL, --Maximum lengte van file path is volgens microsoft 260 tekens.
  BES_voorwerpnummer BIGINT       NOT NULL,
  CONSTRAINT PK_Filenaam PRIMARY KEY (BES_filenaam),
  CONSTRAINT FK_Voorwerpnummer FOREIGN KEY (BES_voorwerpnummer) REFERENCES Voorwerp (VW_voorwerpnummer)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT CHK_AantalBestanden CHECK (dbo.aantalBestandenPerVoorwerpnummer(BES_voorwerpnummer) <= 4)
);

CREATE TABLE Bod (
  BOD_voorwerpnummer BIGINT        NOT NULL,
  BOD_bodbedrag      NUMERIC(9, 2) NOT NULL,
  BOD_gebruiker      VARCHAR(64)   NOT NULL, --Zie RFC 5321.
  BOD_bodTijdEnDag   DATETIME      NOT NULL DEFAULT GETDATE(),
  CONSTRAINT PK_BodVoorwerpnummer PRIMARY KEY (BOD_voorwerpnummer, BOD_bodbedrag),
  CONSTRAINT FK_BodVoorwerpnummer FOREIGN KEY (BOD_voorwerpnummer) REFERENCES Voorwerp (VW_voorwerpnummer)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT FK_BodGebruikerGebruikersnaam FOREIGN KEY (BOD_gebruiker) REFERENCES Gebruiker (GEB_gebruikersnaam)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  CONSTRAINT CHK_HogerDanStartprijs CHECK (dbo.bodHogerDanStartprijs(BOD_voorwerpnummer, BOD_bodbedrag) = 1),
  --TODO: Hoeft nog niet voor deze sprint
  --CONSTRAINT CHK_BodBedrag CHECK (dbo.bodHoogGenoeg(voorwerpnummer, bodbedrag) = 1),
  CONSTRAINT CHK_NietEigenVoorwerp CHECK (dbo.nietEigenVoorwerp(BOD_voorwerpnummer, BOD_gebruiker) = 1)
);


CREATE TABLE Registreer (
  REG_email			VARCHAR(255) NOT NULL,
  REG_code			VARCHAR(255) NOT NULL,
  REG_tijd			DATETIME     NOT NULL DEFAULT GETDATE(),
  REG_gevalideerd	BIT		NULL DEFAULT 0
)

--TODO: Valt buiten de eerste sprint en wordt verder aan gewerkt in een latere sprint
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
        IF @huidigeHoogsteBod BETWEEN 50 AND 499.99 --TODO vragen of het 50 of 49.99 moet zijn
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

