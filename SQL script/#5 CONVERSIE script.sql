--For running rhis script it is necessary to fill the range of the begindatums in. This needs too be in the future.

--Conversiescript rubrieken
INSERT INTO Rubriek (RB_Nummer, RB_Naam, RB_Parent, RB_volgnummer)
  SELECT
    ID                 AS RB_Nummer,
    LTRIM(RTRIM(name)) AS RB_naam,
    parent             AS RB_parent,
    ID                 AS RB_volgnummer
  FROM Categorieen
GO

--Conversiescript Users
INSERT INTO Gebruiker (GEB_gebruikersnaam, GEB_voornaam, GEB_achternaam, GEB_adresregel_1, GEB_geboortedag, GEB_mailbox, GEB_wachtwoord,
                       GEB_vraag, GEB_verkoper, GEB_antwoordtekst, GEB_postcode, GEB_plaatsnaam, GEB_Land, GEB_Rating)
  SELECT DISTINCT
    LTRIM(RTRIM(Username))   AS GEB_gebruikersnaam,
    ('-')                    AS GEB_voornaam,
    --Unknown.
    ('-')                    AS GEB_achternaam,
    --Unknown.
    ('-')                    AS GEB_adresregel_1,
    -- Unknown.
    getdate()                AS GEB_geboortedag,
    'Geen_mailadres@nope.nl' AS GEB_mailbox,
    -- Unknown.
    'P@ssw0rd'               AS GEB_wachtwoord,
    -- Unknown.
    1                        AS GEB_vraag,
    --Default question
    1                        AS GEB_verkoper,
    'Defaultantwoord'        AS GEB_antwoordtekst,
    LTRIM(RTRIM(Postalcode)) AS GEB_postcode,
    LTRIM(RTRIM(Location))   AS GEB_plaatsnaam,
    LTRIM(RTRIM(Country))    AS GEB_Land,
    --If there are two users with the same username we convert the one with the highest rating.
    (SELECT TOP 1 Rating
     FROM Users u
     WHERE u.Username = Username
     ORDER BY Rating DESC)   AS GEB_Rating
  FROM Users
GO

--Conversiescript verkoper

INSERT INTO Verkoper (VER_gebruiker, VER_bank, VER_bankrekening, VER_controleoptie, VER_creditcard)
  SELECT DISTINCT
    LTRIM(RTRIM(Username)) AS VER_gebruiker,
    'Onbekend'             AS VER_bank,
    --default omdat we de bank niet weten
    'Onbekend'             AS VER_bankrekening,
    'Creditcard'           AS VER_controleoptie,
    'Onbekend'             AS VER_creditcard
  FROM Users
GO

--Conversiescript voorwerp
--Range of random date for looptijdstart must be now or in the future.
DECLARE @FromDate DATE = DATEADD(DAY, 1, getdate()) --begindatum random date.
DECLARE @ToDate DATE = dateADD(DAY, 14, GETDATE()) --Einddatum random date.

SET IDENTITY_INSERT voorwerp ON
INSERT INTO Voorwerp (VW_voorwerpnummer, VW_titel, VW_beschrijving, VW_land, VW_verkoper, VW_conditie, VW_thumbnail, VW_startprijs, VW_minimaalnieuwbod, VW_hoogstebod, VW_looptijdStart, VW_looptijd, VW_betalingswijze, VW_plaatsnaam, VW_veilinggesloten)
  SELECT
    ID                                                       AS VW_voorwerpnummer,
    LTRIM(RTRIM(titel))                                      AS VW_titel,
    Beschrijving                                             AS VW_beschrijving,
    Land                                                     AS VW_land,
    LTRIM(RTRIM(Verkoper))                                   AS VW_verkoper,
    CASE WHEN Conditie = ''
      THEN 'Onbekende conditie'
    ELSE LTRIM(RTRIM(Conditie))
    END
                                                             AS VW_conditie,
    ('/thumbnails/' + Thumbnail)                                  AS VW_thumbnail,
    dbo.FN_Verandervaluta(Valuta, dbo.FN_Maaknumeric(Prijs)) AS VW_startprijs,
    dbo.FN_Verandervaluta(Valuta, dbo.FN_Maaknumeric(Prijs)) AS VW_minimaalnieuwbod,
    dbo.FN_Verandervaluta(Valuta, dbo.FN_Maaknumeric(Prijs)) AS VW_hoogstebod,
    (SELECT DATEADD(
        MINUTE,
        ABS(CHECKSUM(NEWID())) % DATEDIFF(MINUTE, @FromDate, @ToDate) + DATEDIFF(MINUTE, 0, @FromDate),
        0
    ))                                                       AS VW_looptijdstart,
    --Random date in the future between: FromDate and ToDate.
    (SELECT LOP_Looptijd
     FROM LooptijdWaardes
     WHERE LOP_ID = ((Items.ID % 5) + 1))                    AS VW_looptijd,
    -- Random looptijd generete according to id.
    'Bank / giro'                                            AS VW_betalingswijze,
    CASE WHEN CHARINDEX(',', [locatie]) > 0 --When a location is entered delete country.
      THEN REPLACE(LEFT([locatie], CHARINDEX(',', [locatie])), ',', '')
    ELSE 'Geen plaatsnaam bekend'
    END                                                      AS VW_plaatsnaam,
    0                                                        AS VW_veilinggesloten
  FROM Items
SET IDENTITY_INSERT voorwerp OFF
GO

INSERT INTO Voorwerp_Rubriek
  SELECT
    ID        AS VR_Voorwerp_Nummer,
    Categorie AS VR_Rubriek_Nummer
  FROM Items
GO


/*
Conversie script voor de illustraties naar de bestand tabel.
Voor dat dit runbaar is moeten er eerst voorwerpen zijn met hetzelfde VW_voorwerpnummer als het BES_voorwerpnummer.
Deze query zorgt ervoor dat van ieder voorwerp uit de verkregen database 3 afbeeldingen krijgt wanneer er 3 afbeeldingen beschikbaar zijn.
*/
INSERT INTO Bestand (BES_filenaam, BES_voorwerpnummer)
  SELECT
    ('/pics/' + IllustratieFile) AS BES_filenaam,
    ItemID                       AS BES_voorwerpnummer
  FROM (
         SELECT
           ItemID,
           IllustratieFile,
           Rank()
           OVER ( PARTITION BY ItemID --OVER combines data without joining.
             ORDER BY IllustratieFile DESC ) AS Rank
         FROM Illustraties
       ) rs
  WHERE Rank <= 4 --Selects the top 4.
        AND EXISTS(SELECT * --When voorwerp exists.
                   FROM Voorwerp V
                   WHERE v.VW_voorwerpnummer = ItemID)
GO