CREATE TABLE Betalingswijzen (
  betalingswijze VARCHAR(25) NOT NULL, --Keuze betalingswijzen
  CONSTRAINT PK_Betalingswijze PRIMARY KEY (betalingswijze),
);

CREATE TABLE Landen (
  landcode CHAR(2)     NOT NULL, --ISO 3166/1
  landnaam VARCHAR(50) NOT NULL, --De langste naam
  CONSTRAINT PK_landen PRIMARY KEY (landcode),
  CONSTRAINT UQ_landnaam UNIQUE (landnaam), --In het nederlands
);

INSERT Betalingswijzen (betalingswijze) VALUES ('Bank/Giro'), ('Paypal'), ('Creditcard');
INSERT Landen (landcode, landnaam) VALUES ('NL', 'Nederland');

CREATE TABLE Voorwerp (
  voorwerpnummer      BIGINT        NOT NULL IDENTITY, --Genereerd zelf nummer
  titel               VARCHAR(60)   NOT NULL, --Hetzelfde dan marktplaats
  beschrijving        VARCHAR(MAX)  NOT NULL, --Geen reden tot beperken
  Startprijs          NUMERIC(9, 2) NOT NULL, --Bedrag in de miljoenen
  betalingswijze      VARCHAR(25)   NOT NULL DEFAULT 'Bank/Giro', --Korte keuzes (dropdown)
  betalingsinstructie CHAR(9)       NOT NULL, --
  land                CHAR(2)       NOT NULL DEFAULT 'NL',
  plaatsnaam          VARCHAR(255)  NOT NULL,
  looptijd            TINYINT       NOT NULL DEFAULT 7, --Aantal dagen
  startmoment         DATETIME      NOT NULL DEFAULT GETDATE(), --Standaard het huidige moment
  eindmoment                                 AS DATEADD(DAY, looptijd, startmoment), --bereken het eindmoment
  huidigbod           NUMERIC(9, 2) NOT NULL, --huidige bod
  CONSTRAINT PK_PRIMARY_KEY PRIMARY KEY (voorwerpnummer),
  CONSTRAINT CHK_TITEL_NOT_EMPTY CHECK (LEN(RTRIM(LTRIM(titel))) >= 2), --Kan niet leeg zijn
  CONSTRAINT CHK_BESCHRIJVING_NOT_EMPTY CHECK (LEN(RTRIM(LTRIM(titel))) >= 2), --Er moet een beschrijving zijn
  CONSTRAINT CHK_STARTPRIJS_GREATER_THAN_0 CHECK (Startprijs >= 1.00), --Appendix B, Mindstends een euro
  CONSTRAINT FK_BETAALWIJZE FOREIGN KEY (betalingsWijze) REFERENCES Betalingswijzen (betalingswijze),
  CONSTRAINT FK_LAND FOREIGN KEY (land) REFERENCES Landen (landcode),
  CONSTRAINT CHK_LOOPTIJD CHECK (looptijd IN (1, 3, 5, 7, 10)),
  CONSTRAINT CHK_STARTMOMENT CHECK (startmoment >= GETDATE()),
);

CREATE FUNCTION FN_CHECK_BOD_TOEGESTAAN(

)

INSERT INTO Voorwerp (titel, beschrijving, Startprijs, betalingswijze, betalingsinstructie, land, looptijd, startmoment)
VALUES ('Testproduct', 'beschrijving', 5, 'Bank/Giro', '12345', 'NL', 5, GETDATE())