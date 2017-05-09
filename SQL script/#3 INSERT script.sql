--Alle insert scripts voor de tabellen
use eenmaalandermaal


--Alle Betalingswijzen
INSERT INTO Betalingswijzen (BW_betalingswijze) VALUES ('Bank / Giro'), ('Contant'), ('Anders');



--Alle landnamen met 3 letterige LAN_landcode  volgens ISO 3166-1
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('ABW', 'Aruba'),('AFG', 'Afghanistan'),('AGO', 'Angola'),('AIA', 'Anguilla'),('ALA', 'Åland'),('ALB', 'Albanië'),('AND', 'Andorra'),('ARE', 'Verenigde Arabische Emiraten'),('ARG', 'Argentinië')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('ARM', 'Armenië'),('ASM', 'Amerikaans-Samoa'),('ATA', 'Antarctica'),('ATF', 'Franse Zuidelijke en Antarctische Gebieden'),('ATG', 'Antigua en Barbuda'),('AUS', 'Australië'),('AUT', 'Oostenrijk')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('AZE', 'Azerbeidzjan'),('BDI', 'Burundi'),('BEL', 'België'),('BEN', 'Benin'),('BES', 'Bonaire, Sint Eustatius en Saba'),('BFA', 'Burkina Faso'),('BGD', 'Bangladesh'),('BGR', 'Bulgarije')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('BHR', 'Bahrein'),('BHS', 'Bahamas'),('BIH', 'Bosnië en Herzegovina'),('BLM', 'Saint Barthélemy'),('BLR', 'Wit-Rusland'),('BLZ', 'Belize'),('BMU', 'Bermuda'),('BON', 'Bolivia'),('BRA', 'Brazilië')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('BRB', 'Barbados'),('BRN', 'Brunei'),('BTN', 'Bhutan'),('BVT', 'Bouveteiland'),('BWA', 'Botswana'),('CAF', 'Centraal-Afrikaanse Republiek'),('CAN', 'Canada'),('CCK', 'Cocoseilanden')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('CHE', 'Zwitserland'),('CHL', 'Chili'),('CHN', 'China'),('CIV', 'Ivoorkust'),('CMR', 'Kameroen'),('COD', 'Congo-Kinshasa'),('COG', 'Congo-Brazzaville'),('COK', 'Cookeilanden'),('COL', 'Colombia')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('COM', 'Comoren'),('CPV', 'Kaapverdië'),('CRI', 'Costa Rica'),('CUB', 'Cuba'),('CUW', 'Curaçao'),('CXR', 'Christmaseiland'),('CYM', 'Kaaimaneilanden'),('CYP', 'Cyprus'),('CZE', 'Tsjechië')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('DEU', 'Duitsland'),('DJI', 'Djibouti'),('DMA', 'Dominica'),('DNK', 'Denemarken'),('DOM', 'Dominicaanse Republiek'),('DZA', 'Algerije'),('ECU', 'Ecuador'),('EGY', 'Egypte'),('ERI', 'Eritrea')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('ESH', 'Westelijke Sahara'),('ESP', 'Spanje'),('EST', 'Estland'),('ETH', 'Ethiopië'),('FIN', 'Finland'),('FJI', 'Fiji'),('FLK', 'Falklandeilanden'),('FRA', 'Frankrijk'),('FRO', 'Faeröer')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('FSM', 'Micronesia'),('GAB', 'Gabon'),('GBR', 'Verenigd Koninkrijk'),('GEO', 'Georgië'),('GGY', 'Guernsey'),('GHA', 'Ghana'),('GIB', 'Gibraltar'),('GIN', 'Guinee'),('GLP', 'Guadeloupe')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('GMB', 'Gambia'),('GNB', 'Guinee-Bissau'),('GNQ', 'Equatoriaal-Guinea'),('GRC', 'Griekenland'),('GRD', 'Grenada'),('GRL', 'Groenland'),('GTM', 'Guatemala'),('GUF', 'Frans-Guyana'),('GUM', 'Guam')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('GUY', 'Guyana'),('HKG', 'Hong Kong'),('HMD', 'Heard en McDonaldeilanden'),('HND', 'Honduras'),('HRV', 'Kroatië'),('HTI', 'Haïti'),('HUN', 'Hongarije'),('IDN', 'Indonesië'),('IMN', 'Mam')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('IND', 'India'),('IOT', 'Britse Indische Oceaan Territorium'),('IRL', 'Ierland'),('IRN', 'Iran'),('IRQ', 'Irak'),('ISL', 'IJsland'),('ISR', 'Israël'),('ITA', 'Italië'),('JAM', 'Jamaica')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('JEY', 'Jersey'),('JOR', 'Jordan'),('JPN', 'Japan'),('KAZ', 'Kazachstan'),('KEN', 'Kenia'),('KGZ', 'Kirgizië'),('KHM', 'Cambodja'),('KIR', 'Kiribati'),('KNA', 'Saint Kitts en Nevis')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('KOR', 'Zuid-Korea'),('KWT', 'Koeweit'),('LAO', 'Democratische Republiek Laos'),('LBN', 'Libanon'),('LBR', 'Liberia'),('LBY', 'Libië'),('LCA', 'Saint Lucia'),('LIE', 'Liechtenstein')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('LKA', 'Sri Lanka'),('LSO', 'Lesotho'),('LTU', 'Litouwen'),('LUX', 'Luxemburg'),('LVA', 'Letland'),('MAC', 'Macau'),('MAF', 'Sint-Maarten'),('MAR', 'Marokko'),('MCO', 'Monaco'),('MDA', 'Moldavië')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('MDG', 'Madagascar'),('MDV', 'Maldiven'),('MEX', 'Mexico'),('MHL', 'Marshalleilanden'),('MKD', 'Macedonië'),('MLI', 'Mali'),('MLT', 'Malta'),('MMR', 'Myanmar'),('MNE', 'Montenegro')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('MNG', 'Mongolië'),('MNP', 'Noordelijke Marianen'),('MOZ', 'Mozambique'),('MRT', 'Mauritanië'),('MSR', 'Montserrat'),('MTQ', 'Martinique'),('MUS', 'Mauritius'),('MWI', 'Malawi'),('MYS', 'Maleisië')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('MYT', 'Mayotte'),('NAM', 'Namibië'),('NCL', 'Nieuw-Caledonië'),('NER', 'Niger'),('NFK', 'Norfolk'),('NGA', 'Nigeria'),('NIC', 'Nicaragua'),('NIU', 'Niue'),('NLD', 'Nederland'),('NOR', 'Noorwegen')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('NPL', 'Nepal'),('NRU', 'Nauru'),('NZL', 'Nieuw-Zeeland'),('OMN', 'Oman'),('PAK', 'Pakistan'),('PAN', 'Panama'),('PCN', 'Pitcairneilanden'),('PER', 'Peru'),('PHL', 'Filippijnen'),('PLW', 'Palau')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('PNG', 'Papoea-Nieuw-Guinea'),('POL', 'Polen'),('PRI', 'Puerto Rico'),('PRK', 'Noord-Korea'),('PRT', 'Portugal'),('PRY', 'Paraguay'),('PSE', 'Palestina'),('PYF', 'Frans-Polynesië'),('QAT', 'Qatar')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('REU', 'Réunion'),('ROU', 'Roemenië'),('RUS', 'Rusland'),('RWA', 'Rwanda'),('SAU', 'Saoedi-Arabië'),('SDN', 'Sudan'),('SEN', 'Senegal'),('SGP', 'Singapore')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('SGS', 'Zuid-Georgia en de Zuidelijke Sandwicheilanden'),('SHN', 'Sint-Helena, Ascension en Tristan da Cunha'),('SJM', 'Spitsbergen en Jan Mayen'),('SLB', 'Salomonseilanden'),('SLE', 'Sierra Leone')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('SLV', 'El Salvador'),('SMR', 'San Marino'),('SOM', 'Somalië'),('SPM', 'Saint-Pierre en Miquelon'),('SRB', 'Servië'),('SSD', 'South Sudan'),('STP', 'Sao Tomé en Principe'),('SUR', 'Suriname')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('SVK', 'Slowakije'),('SVN', 'Slovenië'),('SWE', 'Sweden'),('SWZ', 'Swaziland'),('SXM', 'Sint Maarten'),('SYC', 'Seychellen'),('SYR', 'Syrië'),('TCA', 'Turks- en Caicoseilanden'),('TCD', 'Tsjaad')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('TGO', 'Togo'),('THA', 'Thailand'),('TJK', 'Tadzjikistan'),('TKL', 'Tokelau'),('TKM', 'Turkmenistan'),('TLS', 'Oost-Timor'),('TON', 'Tonga'),('TTO', 'Trinidad en Tobago'),('TUN', 'Tunesië')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('TUR', 'Turkije'),('TUV', 'Tuvalu'),('TWB', 'Taiwan'),('TZA', 'Tanzania'),('UGA', 'Oeganda'),('UKR', 'Oekraïne'),('UMI', 'Kleine afgelegen eilanden van de Verenigde Staten'),('URY', 'Uruguay')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('USA', 'Verenigde Staten'),('UZB', 'Uzbekistan'),('BTW', 'Vaticaanstad'),('VCT', 'Saint Vincent en de Grenadines'),('VEN', 'Venezuela'),('VGB', 'Britse Maagdeneilanden')
INSERT INTO Landen(LAN_landcode, LAN_landnaam) VALUES('VIR', 'Amerikaanse Maagdeneilanden'),('VNM', 'Vietnam'),('VUT', 'Vanuatu'),('WLF', 'Wallis en Futuna'),('WSM', 'Samoa'),('YEM', 'Jemen'),('ZAF', 'Zuid-Afrika'),('ZWE', 'Zimbabwe'),('ZMB', 'Zambia')

INSERT INTO Voorwerp (VW_titel, VW_beschrijving, VW_startprijs, VW_betalingswijze, VW_betalingsinstructie, VW_plaatsnaam,
											VW_land, VW_looptijd, VW_looptijdStart,  VW_verzendkosten, VW_verzendinstructies, VW_verkoper, VW_koper)
VALUES
	('Testproduct1', 'beschrijving1', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-06-14 04:32:02', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct2', 'beschrijving2', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-19 06:03:12',  14.20, 'test', 'kees', 'tinus'),
	('Testproduct3', 'beschrijving3', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-27 08:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct4', 'beschrijving4', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-25 04:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct5', 'beschrijving5', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-06-14 04:32:02', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct6', 'beschrijving6', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-19 06:03:12',  14.20, 'test', 'kees', 'tinus'),
	('Testproduct7', 'beschrijving7', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-27 08:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct8', 'beschrijving8', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-25 04:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct9', 'beschrijving9', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-06-14 04:32:02', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct10', 'beschrijving10', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-19 06:03:12',  14.20, 'test', 'kees', 'tinus'),
	('Testproduct11', 'beschrijving11', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-27 08:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct12', 'beschrijving12', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-25 04:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct13', 'beschrijving13', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-06-14 04:32:02', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct14', 'beschrijving14', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-19 06:03:12',  14.20, 'test', 'kees', 'tinus'),
	('Testproduct15', 'beschrijving15', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-27 08:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct16', 'beschrijving16', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-25 04:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct17', 'beschrijving17', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-06-14 04:32:02', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct18', 'beschrijving18', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-19 06:03:12',  14.20, 'test', 'kees', 'tinus'),
	('Testproduct19', 'beschrijving19', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-27 08:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct20', 'beschrijving20', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-25 04:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct21', 'beschrijving21', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-06-14 04:32:02', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct22', 'beschrijving22', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-19 06:03:12',  14.20, 'test', 'kees', 'tinus'),
	('Testproduct23', 'beschrijving23', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-27 08:03:12', 14.20, 'test', 'kees', 'tinus'),
	('Testproduct24', 'beschrijving24', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384','Arnhem', 'NLD', 3,'2017-05-25 04:03:12', 14.20, 'test', 'kees', 'tinus')


INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(15,1,'Abdul'),(11,11,'Lucius'),(4,21,'Plato'),(6,31,'Wesley'),(12,41,'Basil'),(10,51,'Asher'),(3,61,'Orson'),(6,71,'Vaughan'),(18,81,'Oliver'),(8,91,'Beau');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(16,101,'Derek'),(1,111,'Hakeem'),(7,121,'Justin'),(6,131,'Neville'),(5,141,'Gil'),(1,151,'Basil'),(15,161,'Reece'),(18,171,'Abel'),(20,181,'Stewart'),(15,191,'Daniel');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(21,201,'Ezekiel'),(1,211,'John'),(13,221,'Stephen'),(4,231,'Dylan'),(8,241,'Uriel'),(24,251,'Howard'),(2,261,'Chaim'),(17,271,'Honorato'),(8,281,'Chadwick'),(8,291,'Prescott');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(24,301,'Allistair'),(9,311,'Forrest'),(9,321,'Dorian'),(9,331,'Arthur'),(16,341,'Beck'),(9,351,'Alfonso'),(11,361,'Mark'),(16,371,'Kamal'),(10,381,'Linus'),(14,391,'Luke');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(18,401,'Harlan'),(11,411,'Xander'),(13,421,'Ignatius'),(9,431,'Raja'),(4,441,'Giacomo'),(17,451,'Kennedy'),(16,461,'Trevor'),(22,471,'Vladimir'),(14,481,'Clarke'),(22,491,'Ethan');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(21,501,'Lyle'),(2,511,'Berk'),(11,521,'Ahmed'),(4,531,'Keegan'),(21,541,'Neville'),(24,551,'Reed'),(10,561,'Fuller'),(3,571,'Chaney'),(21,581,'Blaze'),(7,591,'Kevin');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(19,601,'Bradley'),(6,611,'Jameson'),(1,621,'Yardley'),(24,631,'Prescott'),(10,641,'Yasir'),(20,651,'Jesse'),(7,661,'Nicholas'),(15,671,'Cameron'),(1,681,'Paki'),(1,691,'Brett');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(15,701,'David'),(4,711,'Nasim'),(24,721,'Price'),(20,731,'Reed'),(13,741,'Jack'),(22,751,'Ira'),(21,761,'Carl'),(13,771,'Steel'),(5,781,'Micah'),(21,791,'Hayes');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(17,801,'Hedley'),(11,811,'Griffin'),(11,821,'Xander'),(22,831,'Lester'),(4,841,'Preston'),(6,851,'Davis'),(10,861,'Charles'),(7,871,'Ralph'),(2,881,'Kirk'),(5,891,'Declan');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(10,901,'Hayes'),(18,911,'Dean'),(8,921,'Garth'),(3,931,'Wallace'),(19,941,'Gannon'),(23,951,'Lance'),(5,961,'Donovan'),(3,971,'Silas'),(15,981,'Walter'),(1,991,'Orlando');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(18,991,'Thaddeus'),(3,1001,'Alexander'),(15,1011,'Talon'),(13,1021,'Jackson'),(16,1031,'Bruno'),(9,1041,'Lev'),(5,1051,'Brody'),(7,1061,'Deacon'),(7,1071,'Jesse'),(16,1081,'Demetrius');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(24,1091,'Brent'),(24,1101,'Reed'),(19,1111,'Aidan'),(14,1121,'Neil'),(3,1131,'Beau'),(24,1141,'Quinlan'),(24,1151,'Lewis'),(11,1161,'Hiram'),(16,1171,'Harlan'),(17,1181,'Reuben');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(8,1191,'Brian'),(10,1201,'Anthony'),(6,1211,'Griffith'),(17,1221,'Reece'),(20,1231,'Holmes'),(5,1241,'Zane'),(20,1251,'Harding'),(23,1261,'Daquan'),(8,1271,'Thor'),(23,1281,'Levi');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(14,1291,'Colby'),(22,1301,'Lucius'),(18,1311,'Armand'),(23,1321,'Logan'),(14,1331,'Kermit'),(24,1341,'Merritt'),(15,1351,'Norman'),(20,1361,'Yasir'),(8,1371,'Camden'),(9,1381,'Marshall');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(3,1391,'Quamar'),(18,1401,'Stone'),(1,1411,'Vincent'),(22,1421,'Lance'),(1,1431,'Carson'),(7,1441,'Randall'),(20,1451,'Gabriel'),(2,1461,'Chandler'),(9,1471,'Hunter'),(11,1481,'Fulton');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(2,1491,'Len'),(5,1501,'Elijah'),(7,1511,'Octavius'),(21,1521,'Wesley'),(20,1531,'Joseph'),(20,1541,'Xander'),(3,1551,'Benjamin'),(6,1561,'Wyatt'),(24,1571,'Lucian'),(7,1581,'Nissim');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(10,1591,'Beck'),(22,1601,'Malik'),(17,1611,'Patrick'),(23,1621,'Jonah'),(14,1631,'Orlando'),(10,1641,'Xanthus'),(7,1651,'Ciaran'),(11,1661,'Prescott'),(21,1671,'Matthew'),(7,1681,'Carter');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(20,1691,'Yuli'),(12,1701,'Tanek'),(11,1711,'Francis'),(20,1721,'Chaim'),(9,1731,'Burton'),(6,1741,'Cade'),(1,1751,'Kieran'),(24,1761,'Blaze'),(8,1771,'Philip'),(13,1781,'Hakeem');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(8,1791,'Dale'),(6,1801,'Noah'),(3,1811,'Jared'),(6,1821,'Hilel'),(19,1831,'Ivan'),(20,1841,'Lucius'),(15,1851,'Ali'),(16,1861,'Elliott'),(12,1871,'Yoshio'),(23,1881,'Zachery');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(19,1891,'Asher'),(21,1901,'Chandler'),(14,1911,'Malachi'),(17,1921,'Herman'),(19,1931,'Addison'),(9,1941,'Eaton'),(18,1951,'Kamal'),(13,1961,'Martin'),(11,1971,'Aidan'),(19,1981,'Ivor');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(2,2000,'Macon'),(17,2010,'Erasmus'),(14,2020,'Salvador'),(23,2030,'Buckminster'),(1,2040,'William'),(17,2050,'Hyatt'),(18,2060,'Igor'),(8,2070,'Hayden'),(2,2080,'Howard'),(8,2090,'Carter');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(15,2100,'Lee'),(3,2110,'Vincent'),(4,2120,'Quinlan'),(17,2130,'Hu'),(12,2140,'Vaughan'),(21,2150,'Ferdinand'),(5,2160,'Fuller'),(1,2170,'Mark'),(20,2180,'Jerome'),(10,2190,'Garrison');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(12,2200,'Bevis'),(16,2210,'Griffin'),(7,2220,'Tucker'),(24,2230,'Rudyard'),(12,2240,'Owen'),(21,2250,'Honorato'),(19,2260,'Lars'),(21,2270,'Amos'),(21,2280,'Alfonso'),(4,2290,'Walter');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(8,2300,'Linus'),(7,2310,'Macaulay'),(13,2320,'Felix'),(12,2330,'Drew'),(10,2340,'Lamar'),(14,2350,'Baker'),(16,2360,'Xenos'),(1,2370,'Steel'),(4,2380,'Richard'),(20,2390,'Mannix');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(1,2400,'Stephen'),(15,2410,'Valentine'),(4,2420,'Calvin'),(10,2430,'Hector'),(5,2440,'Paul'),(9,2450,'Yardley'),(18,2460,'Kato'),(8,2470,'Adam'),(23,2480,'Aaron'),(9,2490,'Forrest');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(13,2500,'Norman'),(6,2510,'Stone'),(2,2520,'Jackson'),(24,2530,'Akeem'),(5,2540,'Linus'),(12,2550,'Rajah'),(24,2560,'Colton'),(20,2570,'Elton'),(17,2580,'Amir'),(24,2590,'Kevin');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(13,2600,'Damon'),(18,2610,'Brennan'),(7,2620,'Amery'),(9,2630,'Clark'),(18,2640,'Alvin'),(18,2650,'August'),(5,2660,'Norman'),(8,2670,'Christian'),(23,2680,'Felix'),(3,2690,'Adam');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(19,2700,'Hoyt'),(20,2710,'Oren'),(21,2720,'Neville'),(11,2730,'Guy'),(14,2740,'Avram'),(13,2750,'Cullen'),(3,2760,'Hall'),(13,2770,'Keith'),(17,2780,'Hilel'),(6,2790,'Chancellor');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(23,2800,'Basil'),(6,2810,'Thomas'),(16,2820,'Cadman'),(15,2830,'Callum'),(3,2840,'Brennan'),(2,2850,'Brenden'),(18,2860,'Samson'),(10,2870,'Isaac'),(11,2880,'Odysseus'),(10,2890,'Rigel');
INSERT INTO Bod(BOD_Voorwerpnummer,BOD_bodbedrag,BOD_gebruiker) VALUES(18,2900,'Vladimir'),(21,2910,'Blake'),(23,2920,'Rafael'),(8,2930,'Linus'),(10,2940,'Byron'),(24,2950,'Zeus'),(18,2960,'Cruz'),(12,2970,'Abraham'),(2,2980,'Christian'),(23,2990,'Chester');



INSERT 	INTO	Rubriek	(RB_Nummer, RB_Naam, 	RB_Volgnummer)
VALUES					(0,			'root',	0)

INSERT INTO Rubriek	(RB_Nummer, RB_Naam, 								RB_Parent, RB_Volgnummer)
VALUES				(1,			'Antiek en Kunst',						0,			1),
					(2,			'Audio, Tv en Foto',					0,			2),
					(3,			'Auto''s',								0,			3),
					(4,			'Auto-onderdelen',						0,			4),
					(5,			'Auto diversen',						0,			5),
					(6,			'Boeken',								0,			6),
					(7,			'Caravans en Kamperen',					0,			7),
					(8,			'Cd''s en Dvd''s',						0,			8),
					(9,			'Computers en Software',				0,			9),
					(10,		'Contacten en Berichten',				0,			10),
					(11,		'Diensten en Vakmensen',				0,			11),
					(12,		'Dieren en Toebehoren',					0,			12),
					(13,		'Doe-het-zelf en Verbouw',				0,			13),
					(14,		'Fietsen en Brommers',					0,			14),
					(15,		'Hobby en Vrije tijd',					0,			15),
					(16,		'Huis en Inrichting',					0,			16),
					(17,		'Huizen en Kamers',						0,			17),
					(18,		'Kinderen en Baby''s',					0,			18),
					(19,		'Kleding | Dames',						0,			19),
					(20,		'Kleding | Heren',						0,			20),
					(21,		'Motoren',								0,			21),
					(22,		'Muziek en Instrumenten',				0,			22),
					(23,		'Postzegels en Munten',					0,			23),
					(24,		'Sieraden, Tassen en Uiterlijk',		0,			24),
					(25,		'Spelcomputers en Games',				0,			25),
					(26,		'Sport en Fitness',						0,			26),
					(27,		'Telecommunicatie',						0,			27),
					(28,		'Tickets en Kaartjes',					0,			28),
					(29,		'Tuin en Terras',						0,			29),
					(30,		'Vacatures',							0,			30),
					(31,		'Vakantie',								0,			31),
					(32,		'Verzamelen',							0,			32),
					(33,		'Watersport en Boten',					0,			33),
					(34,		'Witgoed en Apparatuur',				0,			34),
					(35,		'Zakelijke goederen',					0,			35),
					(36,		'Diversen',								0,			36),
					(37,		'Antiek | Eetgerei',					1,			37),
					(38,		'Antiek | Gebruiksvoorwerpen',			1,			38),
					(39,		'Antiek | Meubels',						1,			39),
					(40,		'Curiosa en Brocante',					1,			40),
					(41,		'Edelsmeden en Sieradenmakers',			1,			41),
					(42,		'Fotografen',							1,			42),
					(43,		'Kunst',								1,			43),
					(44,		'Kunst | Schilderijen',					1,			44),
					(45,		'Kunstenaars en Portretschilders',		1,			45),
					(46,		'Reparatie en Onderhoud',				1,			46),
					(47,		'Timmerlieden en Meubelmakers',			1,			47),
					(48,		'Accessoires',							2,			48),
					(49,		'Audio',								2,			49),
					(50,		'Audio | Draagbaar',					2,			50),
					(51,		'Film, Video en Tv',					2,			51),
					(52,		'Film- en Videobewerking',				2,			52),
					(53,		'Fotografen',							2,			53),
					(54,		'Fotografie',							2,			54),
					(55,		'Optische apparatuur',					2,			55),
					(56,		'Reparaties',							2,			56),
					(57,		'Overige',								2,			57),
					(58,		'Koopauto''s',							3,			58),
					(59,		'Huurauto''s',							3,			59),
					(60,		'Oldtimers',							3,			60),
					(61,		'Auto-onderdelen',						4,			61),
					(62,		'Vrachtwagen-onderdelen',				4,			62),
					(63,		'Bestek',								38,			63),
					(64,		'Schalen',								38,			64),
					(65,		'Servies compleet',						38,			65),
					(66,		'Servies los',							38,			66),
					(67,		'Accu''s en Batterijen',				49,			67),
					(68,		'Afstandsbedieningen',					49,			68),
					(69,		'Koptelefoons en Headsets',				49,			69),
					(70,		'Opladers',								49,			70),
					(71,		'Aixam',								59,			71),
					(72,		'Alfa Romeo',							59,			72),
					(73,		'Aston Martin',							59,			73),
					(74,		'Audi',									59,			74),
					(75,		'Bentley',								59,			75),
					(76,		'Bestelauto''s',						59,			76),
					(77,		'BMW',									59,			77),
					(78,		'Buick',								59,			78),
					(79,		'Cadillac',								59,			79),
					(80,		'Chevrolet',							59,			80),
					(81,		'Chrysler',								59,			81),
					(82,		'Citroën',								59,			82),
					(83,		'Dacia',								59,			83),
					(84,		'Daewoo',								59,			84),
					(85,		'Daihatsu',								59,			85),
					(86,		'Dodge',								59,			86),
					(87,		'Ferrari',								59,			87),
					(88,		'Fiat',									59,			88),
					(89,		'Fisker',								59,			89),
					(90,		'Ford',									59,			90),
					(91,		'Ford Usa',								59,			91),
					(92,		'Honda',								59,			92),
					(93,		'Hummer',								59,			93),
					(94,		'Hyundai',								59,			94),
					(95,		'Infiniti',								59,			95),
					(96,		'Jaguar',								59,			96),
					(97,		'Jeep',									59,			97),
					(98,		'Kia',									59,			98),
					(99,		'Lada',									59,			99),
					(100,		'Lamborghini',							59,			100),
					(101,		'Lancia',								59,			101),
					(102,		'Land Rover',							59,			102),
					(103,		'Landwind',								59,			103),
					(104,		'Lexus',								59,			104),
					(105,		'Lincoln',								59,			105),
					(106,		'Lotus',								59,			106),
					(107,		'Maserati',								59,			107),
					(108,		'Mazda',								59,			108),
					(109,		'Mercedes-Benz',						59,			109),
					(110,		'Mercury',								59,			110),
					(111,		'MG',									59,			111),
					(112,		'Mini',									59,			112),
					(113,		'Mitsubishi',							59,			113),
					(114,		'Nissan',								59,			114),
					(115,		'Oldsmobile',							59,			115),
					(116,		'Opel',									59,			116),
					(117,		'Peugeot',								59,			117),
					(118,		'Pontiac',								59,			118),
					(119,		'Porsche',								59,			119),
					(120,		'Renault',								59,			120),
					(121,		'Rolls-Royce',							59,			121),
					(122,		'Rover',								59,			122),
					(123,		'Saab',									59,			123),
					(124,		'Seat',									59,			124),
					(125,		'Skoda',								59,			125),
					(126,		'Smart',								59,			126),
					(127,		'Ssangyong',							59,			127),
					(128,		'Subaru',								59,			128),
					(129,		'Suzuki',								59,			129),
					(130,		'Tesla',								59,			130),
					(131,		'Toyota',								59,			131),
					(132,		'Triumph',								59,			132),
					(133,		'Volkswagen',							59,			133),
					(134,		'Volvo',								59,			134),
					(135,		'Vrachtwagens',							59,			135),
					(136,		'Overige Auto''s',						59,			136),
					(137,		'Green',								60,			137),
					(138,		'Fun',									60,			138),
					(139,		'Luxe',									60,			139),
					(140,		'Family',								60,			140),
					(141,		'Aixam',								61,			141),
					(142,		'Alfa Romeo',							61,			142),
					(143,		'Aston Martin',							61,			143),
					(144,		'Audi',									61,			144),
					(145,		'Bentley',								61,			145),
					(146,		'Bestelauto''s',						61,			146),
					(147,		'BMW',									61,			147),
					(148,		'Buick',								61,			148),
					(149,		'Cadillac',								61,			149),
					(150,		'Chevrolet',							61,			150),
					(151,		'Chrysler',								61,			151),
					(152,		'Citroën',								61,			152),
					(153,		'Dacia',								61,			153),
					(154,		'Daewoo',								61,			154),
					(155,		'Daihatsu',								61,			155),
					(156,		'Dodge',								61,			156),
					(157,		'Ferrari',								61,			157),
					(158,		'Fiat',									61,			158),
					(159,		'Fisker',								61,			159),
					(160,		'Ford',									61,			160),
					(161,		'Ford Usa',								61,			161),
					(162,		'Honda',								61,			162),
					(163,		'Hummer',								61,			163),
					(164,		'Hyundai',								61,			164),
					(165,		'Infiniti',								61,			165),
					(166,		'Jaguar',								61,			166),
					(167,		'Jeep',									61,			167),
					(168,		'Kia',									61,			168),
					(169,		'Lada',									61,			169),
					(170,		'Lamborghini',							61,			170),
					(171,		'Lancia',								61,			171),
					(172,		'Land Rover',							61,			172),
					(173,		'Landwind',								61,			173),
					(174,		'Lexus',								61,			174),
					(175,		'Lincoln',								61,			175),
					(176,		'Lotus',								61,			176),
					(177,		'Maserati',								61,			177),
					(178,		'Mazda',								61,			178),
					(179,		'Mercedes-Benz',						61,			179),
					(180,		'Mercury',								61,			180),
					(181,		'MG',									61,			181),
					(182,		'Mini',									61,			182),
					(183,		'Mitsubishi',							61,			183),
					(184,		'Nissan',								61,			184),
					(185,		'Oldsmobile',							61,			185),
					(186,		'Opel',									61,			186),
					(187,		'Peugeot',								61,			187),
					(188,		'Pontiac',								61,			188),
					(189,		'Porsche',								61,			189),
					(190,		'Renault',								61,			190),
					(191,		'Rolls-Royce',							61,			191),
					(192,		'Rover',								61,			192),
					(193,		'Saab',									61,			193),
					(194,		'Seat',									61,			194),
					(195,		'Skoda',								61,			195),
					(196,		'Smart',								61,			196),
					(197,		'Subaru',								61,			197),
					(198,		'Suzuki',								61,			198),
					(199,		'Toyota',								61,			199),
					(200,		'Triumph',								61,			200),
					(201,		'Volkswagen',							61,			201),
					(202,		'Volvo',								61,			202),
					(203,		'Vrachtwagens',							61,			203),
					(204,		'Overige Auto''s',						61,			204),
					(205,		'Accu''s en Toebehoren',				62,			205),
					(206,		'Airco en Verwarming',					62,			206),
					(207,		'Banden en Velgen',						62,			207),
					(208,		'Besturing',							62,			208),
					(209,		'Brandstofsystemen',					62,			209),
					(210,		'Carrosserie en Plaatwerk',				62,			210),
					(211,		'Dashboard en Schakelaars',				62,			211),
					(212,		'Elektronica en Kabels',				62,			212),
					(213,		'Filters',								62,			213),
					(214,		'Interieur en Bekleding',				62,			214),
					(215,		'Klein materiaal',						62,			215),
					(216,		'Motor en Toebehoren',					62,			216),
					(217,		'Ophanging en Onderstel',				62,			217),
					(218,		'Remmen en Aandrijving',				62,			218),
					(219,		'Ruiten en Toebehoren',					62,			219),
					(220,		'Spiegels',								62,			220),
					(221,		'Transmissie en Toebehoren',			62,			221),
					(222,		'Uitlaatsystemen',						62,			222),
					(223,		'Verlichting',							62,			223),
					(224,		'Overige onderdelen',					62,			224),
					(225,		'Accu''s en Toebehoren',				63,			225),
					(226,		'Airco en Verwarming',					63,			226),
					(227,		'Banden en Velgen',						63,			227),
					(228,		'Besturing',							63,			228),
					(229,		'Brandstofsystemen',					63,			229),
					(230,		'Carrosserie en Plaatwerk',				63,			230),
					(231,		'Dashboard en Schakelaars',				63,			231),
					(232,		'Elektronica en Kabels',				63,			232),
					(233,		'Filters',								63,			233),
					(234,		'Interieur en Bekleding',				63,			234),
					(235,		'Klein materiaal',						63,			235),
					(236,		'Motor en Toebehoren',					63,			236),
					(237,		'Ophanging en Onderstel',				63,			237),
					(238,		'Remmen en Aandrijving',				63,			238),
					(239,		'Ruiten en Toebehoren',					63,			239),
					(240,		'Spiegels',								63,			240),
					(241,		'Transmissie en Toebehoren',			63,			241),
					(242,		'Uitlaatsystemen',						63,			242),
					(243,		'Verlichting',							63,			243),
					(244,		'Overige onderdelen',					63,			244)