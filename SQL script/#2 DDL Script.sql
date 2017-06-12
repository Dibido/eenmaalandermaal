--Collects the foreign keys and removes them.
DECLARE @DropForeignkeys NVARCHAR(MAX) = ''
SELECT @DropForeignkeys += 'ALTER TABLE ' + C.TABLE_NAME + ' DROP CONSTRAINT ' + C.CONSTRAINT_NAME + CHAR(13)
FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS C INNER JOIN INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS R
    ON C.CONSTRAINT_NAME = R.CONSTRAINT_NAME
  INNER JOIN INFORMATION_SCHEMA.TABLES T ON C.TABLE_NAME = T.TABLE_NAME
PRINT @DropForeignkeys
EXEC sp_executesql @DropForeignkeys

--Drops all tables.
DECLARE @DropTable NVARCHAR(MAX) = ''
SELECT @DropTable += 'DROP TABLE ' + TABLE_NAME + CHAR(13)
FROM INFORMATION_SCHEMA.TABLES
PRINT @DropTable
EXEC sp_executesql @DropTable

--Maakt de landen tabel aan.
CREATE TABLE Landen (
  LAN_landcode CHAR(2)     NOT NULL, --See ISO 3166/1 alpha-2
  LAN_landnaam VARCHAR(50) NOT NULL, --The longest name is 50 characters.
  CONSTRAINT PK_landen PRIMARY KEY (LAN_landcode),
  CONSTRAINT UQ_landnaam UNIQUE (LAN_landnaam), --In Dutch
);
--maakt de vraag tabel aan
CREATE TABLE Vraag (
  VR_vraagnummer TINYINT IDENTITY NOT NULL, --A maximum of 255 questions, they number automatically.
  VR_tekstvraag  VARCHAR(255), --Nice length for questions.
  CONSTRAINT PK_Vraag PRIMARY KEY (VR_vraagnummer)
);
--maakt de gebruiker tabel aan.
CREATE TABLE Gebruiker (
  GEB_gebruikersnaam VARCHAR(64)            NOT NULL, --See RFC 5321.
  GEB_voornaam       VARCHAR(16)            NOT NULL, --Normal lenth for a Dutch firstname.
  GEB_achternaam     VARCHAR(16)            NOT NULL, --Normal lenth for a Dutch lastname including the insertion.
  GEB_adresregel_1   VARCHAR(255)           NOT NULL, --Normal length for a address.
  GEB_adresregel_2   VARCHAR(255)           NULL,     --Normal length for a address
  GEB_postcode       VARCHAR(12)            NOT NULL, --Max lenth for a postal code: ISO_3166
  GEB_plaatsnaam     VARCHAR(85)            NOT NULL, --Longest name, see: "https://en.wikipedia.org/wiki/List_of_long_place_names"
  GEB_Land           CHAR(2) DEFAULT 'NL'   NOT NULL, --Landcode from the landen table.
  GEB_geboortedag    DATE                   NOT NULL,
  GEB_mailbox        VARCHAR(256)           NOT NULL, --Mailaddress length according too RFC 5321
  GEB_wachtwoord     VARCHAR(255)           NOT NULL, --BCRYPT by using a password_hash()
  GEB_vraag          TINYINT                NOT NULL, --Number form the vraag table.
  GEB_antwoordtekst  VARCHAR(255)           NOT NULL, --Answer for the question, hashed and case insensative
  GEB_verkoper       BIT DEFAULT 0          NOT NULL, --Checks if the user is a seller, default is a user that isn't a seller.
  GEB_rating         NUMERIC(4, 1)          NULL, --User rating: 0.0 - 100.0. TODO: build a check for when it can be altered.
  GEB_actief         BIT                    NOT NULL DEFAULT 1, --Checks if the user is active at the moment.
  CONSTRAINT PK_GebruikerGebruikersnaam PRIMARY KEY (GEB_gebruikersnaam),
  CONSTRAINT FK_VraagVraagnummer FOREIGN KEY (GEB_vraag) REFERENCES Vraag (VR_vraagnummer),
  CONSTRAINT FK_LandenLandcode FOREIGN KEY (GEB_Land) REFERENCES Landen (LAN_landcode),
  CONSTRAINT CHK_LegitiemeMailbox CHECK (GEB_mailbox LIKE '%_@__%.__%'), --Checks if the address is according to the mailaddress standard.
  CONSTRAINT CHK_LegitiemeGeboortedag CHECK (GEB_geboortedag <=
                                             getdate()), --Birthday must be in the past.
);
--Maakt de administratoren tabel aan.
CREATE TABLE Administratoren (
  ADM_gebruikersnaam VARCHAR(64) NOT NULL, --gebruikersnaam from gebruiker table.
  CONSTRAINT FK_AdministratorGebruikersnaam FOREIGN KEY (ADM_gebruikersnaam) REFERENCES Gebruiker (GEB_gebruikersnaam)
)

--Maakt gebruikerstelefoon tabel aan.
CREATE TABLE Gebruikerstelefoon (
  TEL_volgnr    INT IDENTITY NOT NULL, --Adds 1 to last number when a new one is inserted.
  TEL_gebruiker VARCHAR(64)  NOT NULL, --gebruiker from the gebruiker table.
  TEL_telefoon  CHAR(15)     NOT NULL, --See ITU-T recommendation E.164
  CONSTRAINT PK_GebruikerstelefoonVolgnr PRIMARY KEY (TEL_volgnr),
  CONSTRAINT FK_GebruikerGebruikersnaam FOREIGN KEY (TEL_gebruiker) REFERENCES Gebruiker (GEB_gebruikersnaam)
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
);
--Maakt controleopties table aan.
CREATE TABLE Controleopties (
  CON_controleoptie VARCHAR(24), --Reasonable length
  CONSTRAINT PK_controleoptie PRIMARY KEY (CON_controleoptie)
)
--Maakt verkopers tabel aan.
CREATE TABLE Verkoper (
  VER_gebruiker     VARCHAR(64),
  VER_bank          VARCHAR(24),
  VER_bankrekening  VARCHAR(31), --longest is 31 : zie https://en.wikipedia.org/wiki/International_Bank_Account_Number
  VER_controleoptie VARCHAR(24),
  VER_creditcard    VARCHAR(19), --Longest number is: zie https://en.wikipedia.org/wiki/Payment_card_number
  CONSTRAINT PK_verkopergebruiker PRIMARY KEY (VER_gebruiker),
  CONSTRAINT FK_verkopercontroleopties FOREIGN KEY (VER_controleoptie) REFERENCES Controleopties (CON_controleoptie)
)

--Tabel om de valide looptijden in op te slaan.
CREATE TABLE LooptijdWaardes (
  LOP_ID       TINYINT IDENTITY NOT NULL,
  LOP_looptijd TINYINT          NOT NULL --1, 3, 5, 7, 10
    CONSTRAINT PK_Looptijd PRIMARY KEY (LOP_looptijd)
);

--Mogelijke betalingswijzen
CREATE TABLE Betalingswijzen (
  BW_betalingswijze VARCHAR(25) NOT NULL, --Choose betalingswijzen.
  CONSTRAINT PK_Betalingswijze PRIMARY KEY (BW_betalingswijze),
);
--Maakt voorwerp tabel aan.
CREATE TABLE Voorwerp (
  VW_voorwerpnummer      BIGINT                                      NOT NULL                                                                                                                                                                                                                                             IDENTITY, --Genereerd zelf nummer, zo veel mogelijk voorwerpen
  VW_titel               VARCHAR(90)                                 NOT NULL, --The longest title is 86 characters long, to have some marge we made it 90.
  VW_beschrijving        VARCHAR(MAX)                                NOT NULL, --No reason to limit.
  VW_startprijs          NUMERIC(9, 2)                               NOT NULL, --A price high price is insertable.
  VW_betalingswijze      VARCHAR(25)                                 NOT NULL                                                                                                                                                                                                                                             DEFAULT 'Bank / Giro', --Korte keuzes (d.m.v. dropdown)
  VW_betalingsinstructie VARCHAR(255)                                NULL,     --Short instruction.
  VW_plaatsnaam          VARCHAR(85)                                 NOT NULL, --Longest town/city name is 85 characters.
  VW_land                CHAR(2)                                     NOT NULL  --Land code                                                                                                                                                                                                                                           DEFAULT 'NL', --Zie ISO 3166/1 alpha-2
  VW_looptijd            TINYINT                                     NOT NULL                                                                                                                                                                                                                                             DEFAULT 7, --Aantal dagen
  VW_looptijdStart       DATETIME                                    NOT NULL                                                                                                                                                                                                                                             DEFAULT GETDATE(), --Normaal de huidige datum met daarbij de tijd
  VW_verzendkosten       NUMERIC(5, 2)                               NULL,     --Price may have 2 characters after the comma and 3 before it.
  VW_verzendinstructies  VARCHAR(255)                                NULL,     --short instruction.
  VW_verkoper            VARCHAR(64)                                 NOT NULL, --See RFC 5321.
  VW_conditie            VARCHAR(255)                                NULL,     --Short description.
  VW_thumbnail           VARCHAR(260)                                NOT NULL, --File path length has to be the same as in the file.
  VW_koper               VARCHAR(64)                                 NULL,     --See RFC 5321.
  VW_looptijdEinde                                                                                                                                                                                                                                                                                                        AS DATEADD(
      DAY, VW_looptijd,
      VW_looptijdStart), --Calculate the enddate.
  VW_veilinggesloten     BIT                                         NOT NULL                                                                                                                                                                                                                                             DEFAULT 0, --Veiling gesloten of open
  VW_verkoopprijs        NUMERIC(9, 2)                               NULL,     --Final price of the product.
  VW_hoogstebod          NUMERIC(9, 2)                               NOT NULL, --Calculates column by using a trigger.
  VW_minimaalnieuwbod    NUMERIC(9, 2) DEFAULT 0                     NULL,
  VW_bodcount            NUMERIC(9) DEFAULT 0                        NOT NULL,

  CONSTRAINT PK_Voorwerp PRIMARY KEY (VW_voorwerpnummer),
  CONSTRAINT FK_Betaalwijze FOREIGN KEY (VW_betalingsWijze) REFERENCES Betalingswijzen (BW_betalingswijze),
  CONSTRAINT FK_Land FOREIGN KEY (VW_land) REFERENCES Landen (LAN_landcode)
    ON UPDATE CASCADE --when countrynames get changed.
    ON DELETE NO ACTION,
  CONSTRAINT FK_VoorwerpGebruikerGebruikersnaam FOREIGN KEY (VW_koper) REFERENCES Gebruiker (GEB_gebruikersnaam)
    ON UPDATE CASCADE --When a gebruikersnaam gets changed.
    ON DELETE NO ACTION,
  CONSTRAINT FK_VoorwerpLooptijd FOREIGN KEY (VW_looptijd) REFERENCES LooptijdWaardes (LOP_looptijd), --The looptijd can only be 1,3,5,7,10 according to apendix B.
  CONSTRAINT FK_VoorwerpVerkoper FOREIGN KEY (VW_verkoper) REFERENCES Verkoper (VER_gebruiker), --The verkoper must be a seller.
  CONSTRAINT CHK_TitelNietLeeg CHECK (LEN(RTRIM(LTRIM(VW_titel))) >= 2), --Can't be empty.
  CONSTRAINT CHK_BeschrijvingNietLeeg CHECK (LEN(RTRIM(LTRIM(VW_titel))) >= 2), --Can't be empty.
  CONSTRAINT CHK_PlaatsnaamNietLeeg CHECK (LEN(RTRIM(LTRIM(VW_plaatsnaam))) >= 2), --Can't be empty.
  CONSTRAINT CHK_LooptijdBegindagInDeToekomst CHECK (VW_looptijdStart >=
                                                     GETDATE()), --The startdate can't be in the past when the auction is made.
  CONSTRAINT CHK_StartprijsHogerDan1 CHECK (VW_startprijs >= 1.00), --Appendix B, At least one euro.
  CONSTRAINT CHK_VerkoopprijsGroterOfGelijk CHECK (VW_verkoopprijs >=
                                                   VW_startprijs), --Checks if the verkoopprijs is higher then the startprijs.
)

CREATE TABLE Bestand (
  BES_filenaam       VARCHAR(260) NOT NULL, --Maximum length of a path is 260 characters according too Microsoft.
  BES_voorwerpnummer BIGINT       NOT NULL,
  CONSTRAINT PK_Filenaam PRIMARY KEY (BES_filenaam),
  CONSTRAINT FK_Voorwerpnummer FOREIGN KEY (BES_voorwerpnummer) REFERENCES Voorwerp (VW_voorwerpnummer)
    ON UPDATE CASCADE --When the product gets changed, change it on all places.
    ON DELETE CASCADE, --When the product gets changed, delete.
  CONSTRAINT CHK_AantalBestanden CHECK (dbo.FN_aantalBestandenPerVoorwerpnummer(BES_voorwerpnummer) <= 4)
);


CREATE TABLE Rubriek (
  RB_Nummer        INT          NOT NULL, -- Max is 3.
  RB_Naam          VARCHAR(100) NOT NULL,
  RB_Parent        INT          NULL,
  RB_volgnummer    INT          NOT NULL, -- Max is 3.
  RB_voorwerpcount INT          NULL, --Total of voorwerpen in rubriek.
  CONSTRAINT PK_RB_Nummer PRIMARY KEY (RB_Nummer),
  CONSTRAINT FK_Parent FOREIGN KEY (RB_Parent) REFERENCES Rubriek (RB_Nummer)
);

--Maakt voorwerp_rubriek tabal aan.
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
--Maakt de bod tabel aan.
CREATE TABLE Bod (
  BOD_voorwerpnummer BIGINT        NOT NULL,
  BOD_bodbedrag      NUMERIC(9, 2) NOT NULL,
  BOD_gebruiker      VARCHAR(64)   NOT NULL, --See RFC 5321.
  BOD_bodTijdEnDag   DATETIME      NOT NULL DEFAULT GETDATE(),
  CONSTRAINT PK_BodVoorwerpnummer PRIMARY KEY (BOD_voorwerpnummer, BOD_bodbedrag),
  CONSTRAINT FK_BodVoorwerpnummer FOREIGN KEY (BOD_voorwerpnummer) REFERENCES Voorwerp (VW_voorwerpnummer)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT FK_BodGebruikerGebruikersnaam FOREIGN KEY (BOD_gebruiker) REFERENCES Gebruiker (GEB_gebruikersnaam)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  CONSTRAINT CHK_BodHogerdanMinimaalBod CHECK (dbo.FN_BodhogerdanMinimaalBod(BOD_voorwerpnummer, BOD_bodbedrag
                                               ) = 1
  ), --Bodbedrag must be higher then minimaalbod.
  CONSTRAINT CHK_NietEigenVoorwerp CHECK (dbo.FN_nietEigenVoorwerp(BOD_voorwerpnummer, BOD_gebruiker) =
                                          1), --Not allowed to bid on own product.
  CONSTRAINT CHK_VeilingNietAfgelopen CHECK (dbo.FN_VeilingAfgelopen(BOD_voorwerpnummer) = 0) --Can't bid on closed auctions.
);
--Maakt registreer tabel.
CREATE TABLE Registreer (
  REG_email VARCHAR(255) NOT NULL,
  REG_code  VARCHAR(16)  NOT NULL,
  REG_tijd  DATETIME     NOT NULL DEFAULT GETDATE(),
  CONSTRAINT PK_Registreer PRIMARY KEY (REG_email)
)
--Maakt upgrade tabel.
CREATE TABLE Upgrade (
  UPG_gebruikersnaam VARCHAR(64) NOT NULL,
  UPG_code           VARCHAR(16) NOT NULL,
  UPG_tijd           DATETIME    NOT NULL DEFAULT GETDATE(),
  CONSTRAINT PK_Upgrade PRIMARY KEY (UPG_gebruikersnaam)
)