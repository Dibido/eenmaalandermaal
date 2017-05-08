USE master

GO

DROP DATABASE EA

GO

CREATE DATABASE EA
Go
Use EA
GO

CREATE TABLE Betalingswijze
(
btw_Wijze VarChar(24) NOT NULL,
CONSTRAINT PK_Betalingswijze PRIMARY KEY (btw_Wijze)
)

CREATE TABLE Landen
(
Lnd_Code VarChar(3) NOT NULL, --ISO 3166
Lnd_Naam VarChar(100),--Langste landnaam = 49Char
CONSTRAINT PK_Landen PRIMARY KEY (Lnd_Code),
CONSTRAINT UQ_Landnaam UNIQUE (Lnd_Naam)
)

CREATE TABLE Voorwerp
(
Voorwerpnummer BIGINT IDENTITY NOT NULL, --APP C, blz 10 (genereert zelf nummer)
Titel VarChar(64) NOT NULL, --Meer dan MArktplaats
Beschrijving VarChar(MAX) NOT NULL, --Geen reden tot beperking
Startprijs NUMERIC(9,2) NOT NULL, --Bedrag in de miljoenen
Betalingswijze VarChar(24) NOT NULL DEFAULT 'Bank/Giro',
--Plaatsnaam
Land VarChar(3) NOT NULL DEFAULT 'NLD',
Looptijd TINYINT NOT NULL DEFAULT 7, --APP C, blz 10 DEFAULT = 7
StartMoment DATETIME NOT NULL DEFAULT GETDATE(), -- AFRONDEN? Chk op ingangsdatum  App C
EindMoment AS DATEADD(DAY,Looptijd,StartMoment),

CONSTRAINT PK_Voorwerp PRIMARY KEY (Voorwerpnummer),
CONSTRAINT CHK_Titel CHECK (LEN(RTRIM(LTRIM(Titel))) >=2),
CONSTRAINT CHK_Beschrijving CHECK (LEN(RTRIM(LTRIM(Beschrijving))) >=2),
CONSTRAINT CHK_Startprijs CHECK (Startprijs >= 1.00), --App B, blz
CONSTRAINT FK_Betalingswijze FOREIGN KEY (Betalingswijze)
	REFERENCES Betalingswijze (btw_Wijze), --Keuzelijst
CONSTRAINT FK_Landen FOREIGN KEY (Land)
	REFERENCES Landen (Lnd_Code), --Keuzelijst
CONSTRAINT CHK_Looptijd CHECK (Looptijd IN(1,3,5,7,10)),
)

GO

INSERT Betalingswijze
(btw_Wijze)
VALUES
('Bank/Giro')

INSERT Landen 
(Lnd_Code, Lnd_Naam)
VALUES 
('NLD', 'Nederland')

INSERT Voorwerp
(Titel, Beschrijving, Startprijs)
VALUES
('Testproduct', 'Dit is een testproduct', 100)

GO


SELECT * FROM Voorwerp
