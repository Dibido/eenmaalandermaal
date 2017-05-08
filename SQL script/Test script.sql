--Test scripts
use eenmaalandermaal

--Normaal insert statement waarbij 4 filenamen ingevuld worden bij één enkel voorwerpnummer
INSERT INTO Bestand VALUES ('a',1),('b',1),('c',1),('d',1)
--Onjuist insert statement waarbij 5 i.p.v de maximale 4 filenamen worden ingevult bij één enkel voorwerpnummer
INSERT INTO Bestand VALUES ('a',1),('b',1),('c',1),('d',1),('e',1)


--Normaal insert statement zonder aangepaste begin tijd
INSERT INTO Voorwerp (titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
                      land, looptijd,  verzendkosten, verzendinstructies, verkoper, koper, verkoopprijs)
VALUES ('Testproduct', 'beschrijving', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
                       'Arnhem', 'NLD', 3, 14.20, 'test', 'kees', 'tinus', 65.20)


--Insert statement met datum in het verleden
INSERT INTO Voorwerp (titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
                      land, looptijd, looptijdBeginDag, looptijdbeginTijdstip,  verzendkosten, verzendinstructies, verkoper, koper, verkoopprijs)
VALUES ('Testproduct', 'beschrijving', 5, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
                       'Arnhem', 'NLD', 3, '2017-05-03', '13:37:00', 14.20, 'test', 'kees', 'tinus', 65.20)

--Insert statement met huidige datum maar met een tijd in het verleden
INSERT INTO Voorwerp (titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
                      land, looptijd, looptijdBeginDag, looptijdbeginTijdstip,  verzendkosten, verzendinstructies, verkoper, koper, verkoopprijs)
VALUES ('Testproduct', 'beschrijving', 6, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
                       'Arnhem', 'NLD', 3, GETDATE(), '00:00:00', 14.20, 'test', 'kees', 'tinus', 65.20)



