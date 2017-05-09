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
											VW_land, VW_looptijd,  VW_verzendkosten, VW_verzendinstructies, VW_verkoper, VW_koper)
VALUES ('Testproduct1', 'beschrijving1', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
												'Arnhem', 'NLD', 3, 14.20, 'test', 'kees', 'tinus')


INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (1,4.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (1,14.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (1,40.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (1,45.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (1,63.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (1,156.01,'tiasd')


INSERT INTO Voorwerp (VW_titel, VW_beschrijving, VW_startprijs, VW_betalingswijze, VW_betalingsinstructie, VW_plaatsnaam,
											VW_land, VW_looptijd, VW_looptijdStart,  VW_verzendkosten, VW_verzendinstructies, VW_verkoper, VW_koper)
VALUES ('Testproduct2', 'beschrijving2', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
												'Arnhem', 'NLD', 3,'2017-05-19 06:03:12',  14.20, 'test', 'kees', 'tinus')


INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (2,4.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (2,14.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (2,40.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (2,45.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (2,63.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (2,156.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (2,174.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (2,204.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (2,431.01,'tiasd')

INSERT INTO Voorwerp (VW_titel, VW_beschrijving, VW_startprijs, VW_betalingswijze, VW_betalingsinstructie, VW_plaatsnaam,
											VW_land, VW_looptijd, VW_looptijdStart,  VW_verzendkosten, VW_verzendinstructies, VW_verkoper, VW_koper)
VALUES ('Testproduct3', 'beschrijving3', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
												'Arnhem', 'NLD', 3, '2017-05-27 08:03:12', 14.20, 'test', 'kees', 'tinus')


INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,4.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,14.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,40.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,45.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,63.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,156.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,174.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,204.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,431.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,1174.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,1204.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (3,1431.01,'tiasd')


INSERT INTO Voorwerp (VW_titel, VW_beschrijving, VW_startprijs, VW_betalingswijze, VW_betalingsinstructie, VW_plaatsnaam,
											VW_land, VW_looptijd, VW_looptijdStart,  VW_verzendkosten, VW_verzendinstructies, VW_verkoper, VW_koper)
VALUES ('Testproduct4', 'beschrijving4', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
												'Arnhem', 'NLD', 3,'2017-05-25 04:03:12', 14.20, 'test', 'kees', 'tinus')


INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,4.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,14.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,40.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,45.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,63.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,156.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,174.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,204.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,431.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,1174.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,1204.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,1431.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,2174.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,2204.01,'tiasd')
INSERT INTO Bod(BOD_voorwerpnummer, BOD_bodbedrag, BOD_gebruiker) VALUES (4,2431.01,'tiasd')




INSERT INTO Categorie(CAT_ID, CAT_Naam)
VALUES
	(1,		'Antiek en Kunst'),
	(2,		'Audio, Tv en Foto'),
	(3,		'Auto''s'),
	(4,		'Auto-onderdelen'),
	(5,		'Auto diversen'),
	(6,		'Boeken'),
	(7,		'Caravans en Kamperen'),
	(8,		'Cd''s en Dvd''s'),
	(9,		'Computers en Software'),
	(10,	'Contacten en Berichten'),
	(11,	'Diensten en Vakmensen'),
	(12,	'Dieren en Toebehoren'),
	(13,	'Doe-het-zelf en Verbouw'),
	(14,	'Fietsen en Brommers'),
	(15,	'Hobby en Vrije tijd'),
	(16,	'Huis en Inrichting'),
	(17,	'Huizen en Kamers'),
	(18,	'Kinderen en Baby''s'),
	(19,	'Kleding | Dames'),
	(20,	'Kleding | Heren'),
	(21,	'Motoren'),
	(22,	'Muziek en Instrumenten'),
	(23,	'Postzegels en Munten'),
	(24,	'Sieraden, Tassen en Uiterlijk'),
	(25,	'Spelcomputers en Games'),
	(26,	'Sport en Fitness'),
	(27,	'Telecommunicatie'),
	(28,	'Tickets en Kaartjes'),
	(29,	'Tuin en Terras'),
	(30,	'Vacatures'),
	(31,	'Vakantie'),
	(32,	'Verzamelen'),
	(33,	'Watersport en Boten'),
	(34,	'Witgoed en Apparatuur'),
	(35,	'Zakelijke goederen'),
	(36,	'Diversen')


INSERT INTO Subcategorie(SCAT_ID, SCAT_Naam, SCAT_PAR_ID)
VALUES
	(1,		'Antiek | Eetgerei',				1),
	(2,		'Antiek | Gebruiksvoorwerpen',		1),
	(3,		'Antiek | Meubels',					1),
	(4,		'Curiosa en Brocante',				1),
	(5,		'Edelsmeden en Sieradenmakers',		1),
	(6,		'Fotografen',						1),
	(7,		'Kunst',							1),
	(8,		'Kunst | Schilderijen',				1),
	(9,		'Kunstenaars en Portretschilders',	1),
	(10,	'Reparatie en Onderhoud',			1),
	(11,	'Timmerlieden en Meubelmakers',		1),
	(12,	'Accessoires',						2),
	(13,	'Audio',							2),
	(14,	'Audio | Draagbaar',				2),
	(15,	'Film, Video en Tv',				2),
	(16,	'Film- en Videobewerking',			2),
	(17,	'Fotografen',						2),
	(18,	'Fotografie',						2),
	(19,	'Optische apparatuur',				2),
	(20,	'Reparaties',						2),
	(21,	'Overige',							2),
	(22,	'Koopauto''s',						3),
	(23,	'Huurauto''s',						3),
	(24,	'Oldtimers',						3),
	(25,	'Auto-onderdelen',					4),
	(26,	'Vrachtwagen-onderdelen',			4)

INSERT INTO Rubriek(RUB_ID, RUB_Naam, RUB_PAR_ID)
VALUES
	(1,		'Bestek'							,1),
	(2,		'Schalen'							,1),
	(3,		'Servies compleet'					,1),
	(4,		'Servies los' 						,1),
	(5,		'Antiek | Gebruiksvoorwerpen'		,2),
	(6,		'Antiek | Meubels'					,3),
	(7,		'Curiosa en Brocante'				,4),
	(8,		'Edelsmeden en Sieradenmakers'		,5),
	(9,		'Fotografen'						,6),
	(10,	'Kunst'								,7),
	(11,	'Kunst | Schilderijen'				,8),
	(12,	'Kunstenaars en Portretschilders'	,9),
	(13,	'Reparatie en Onderhoud'			,10),
	(14,	'Timmerlieden en Meubelmakers'		,11),
	(15,	'Accu''s en Batterijen'				,12),
	(16,	'Afstandsbedieningen'				,12),
	(17,	'Koptelefoons en Headsets'			,12),
	(18,	'Opladers'							,12),
	(19,	'Audio'								,13),
	(20,	'Audio | Draagbaar'					,14),
	(21,	'Film, Video en Tv'					,15),
	(22,	'Film- en Videobewerking'			,16),
	(23,	'Fotografen'						,17),
	(24,	'Fotografie'						,18),
	(25,	'Optische apparatuur'				,19),
	(26,	'Reparaties'						,20),
	(27,	'Overige'							,21),
	(28,	'Aixam'								,22),
	(29,	'Alfa Romeo'						,22),
	(30,	'Aston Martin'						,22),
	(31,	'Audi'								,22),
	(32,	'Bentley'							,22),
	(33,	'Bestelauto''s'						,22),
	(34,	'BMW'								,22),
	(35,	'Buick'								,22),
	(36,	'Cadillac'							,22),
	(37,	'Chevrolet'							,22),
	(38,	'Chrysler'							,22),
	(39,	'Citroën'							,22),
	(40,	'Dacia'								,22),
	(41,	'Daewoo'							,22),
	(42,	'Daihatsu'							,22),
	(43,	'Dodge'								,22),
	(44,	'Ferrari'							,22),
	(45,	'Fiat'								,22),
	(46,	'Fisker'							,22),
	(47,	'Ford'								,22),
	(48,	'Ford Usa'							,22),
	(49,	'Honda'								,22),
	(50,	'Hummer'							,22),
	(51,	'Hyundai'							,22),
	(52,	'Infiniti'							,22),
	(53,	'Jaguar'							,22),
	(54,	'Jeep'								,22),
	(55,	'Kia'								,22),
	(56,	'Lada'								,22),
	(57,	'Lamborghini'						,22),
	(58,	'Lancia'							,22),
	(59,	'Land Rover'						,22),
	(60,	'Landwind'							,22),
	(61,	'Lexus'								,22),
	(62,	'Lincoln'							,22),
	(63,	'Lotus'								,22),
	(64,	'Maserati'							,22),
	(65,	'Mazda'								,22),
	(66,	'Mercedes-Benz'						,22),
	(67,	'Mercury'							,22),
	(68,	'MG'								,22),
	(69,	'Mini'								,22),
	(70,	'Mitsubishi'						,22),
	(71,	'Nissan'							,22),
	(72,	'Oldsmobile'						,22),
	(73,	'Opel'								,22),
	(74,	'Peugeot'							,22),
	(75,	'Pontiac'							,22),
	(76,	'Porsche'							,22),
	(77,	'Renault'							,22),
	(78,	'Rolls-Royce'						,22),
	(79,	'Rover'								,22),
	(80,	'Saab'								,22),
	(81,	'Seat'								,22),
	(82,	'Skoda'								,22),
	(83,	'Smart'								,22),
	(84,	'Ssangyong'							,22),
	(85,	'Subaru'							,22),
	(86,	'Suzuki'							,22),
	(87,	'Tesla'								,22),
	(88,	'Toyota'							,22),
	(89,	'Triumph'							,22),
	(90,	'Volkswagen'						,22),
	(91,	'Volvo'								,22),
	(92,	'Vrachtwagens'						,22),
	(93,	'Overige Auto''s'					,22),
	(94,	'Green'								,23),
	(95,	'Fun'								,23),
	(96,	'Luxe'								,23),
	(97,	'Family'							,23),
	(98,	'Aixam'								,24),
	(99,	'Alfa Romeo'						,24),
	(100,	'Aston Martin'						,24),
	(101,	'Audi'								,24),
	(102,	'Bentley'							,24),
	(103,	'Bestelauto''s'						,24),
	(104,	'BMW'								,24),
	(105,	'Buick'								,24),
	(106,	'Cadillac'							,24),
	(107,	'Chevrolet'							,24),
	(108,	'Chrysler'							,24),
	(109,	'Citroën'							,24),
	(110,	'Dacia'								,24),
	(111,	'Daewoo'							,24),
	(112,	'Daihatsu'							,24),
	(113,	'Dodge'								,24),
	(114,	'Ferrari'							,24),
	(115,	'Fiat'								,24),
	(116,	'Fisker'							,24),
	(117,	'Ford'								,24),
	(118,	'Ford Usa'							,24),
	(119,	'Honda'								,24),
	(120,	'Hummer'							,24),
	(121,	'Hyundai'							,24),
	(122,	'Infiniti'							,24),
	(123,	'Jaguar'							,24),
	(124,	'Jeep'								,24),
	(125,	'Kia'								,24),
	(126,	'Lada'								,24),
	(127,	'Lamborghini'						,24),
	(128,	'Lancia'							,24),
	(129,	'Land Rover'						,24),
	(130,	'Landwind'							,24),
	(131,	'Lexus'								,24),
	(132,	'Lincoln'							,24),
	(133,	'Lotus'								,24),
	(134,	'Maserati'							,24),
	(135,	'Mazda'								,24),
	(136,	'Mercedes-Benz'						,24),
	(137,	'Mercury'							,24),
	(138,	'MG'								,24),
	(139,	'Mini'								,24),
	(140,	'Mitsubishi'						,24),
	(141,	'Nissan'							,24),
	(142,	'Oldsmobile'						,24),
	(143,	'Opel'								,24),
	(144,	'Peugeot'							,24),
	(145,	'Pontiac'							,24),
	(146,	'Porsche'							,24),
	(147,	'Renault'							,24),
	(148,	'Rolls-Royce'						,24),
	(149,	'Rover'								,24),
	(150,	'Saab'								,24),
	(151,	'Seat'								,24),
	(152,	'Skoda'								,24),
	(153,	'Smart'								,24),
	(154,	'Ssangyong'							,24),
	(155,	'Subaru'							,24),
	(156,	'Suzuki'							,24),
	(157,	'Tesla'								,24),
	(158,	'Toyota'							,24),
	(159,	'Triumph'							,24),
	(160,	'Volkswagen'						,24),
	(161,	'Volvo'								,24),
	(162,	'Vrachtwagens'						,24),
	(163,	'Overige Auto''s'					,24),
	(164,	'Accu''s en Toebehoren'				,25),
	(165,	'Airco en Verwarming'				,25),
	(166,	'Banden en Velgen'					,25),
	(167,	'Besturing'							,25),
	(168,	'Brandstofsystemen'					,25),
	(169,	'Carrosserie en Plaatwerk'			,25),
	(170,	'Dashboard en Schakelaars'			,25),
	(171,	'Elektronica en Kabels'				,25),
	(172,	'Filters'							,25),
	(173,	'Interieur en Bekleding'			,25),
	(174,	'Klein materiaal'					,25),
	(175,	'Motor en Toebehoren'				,25),
	(176,	'Ophanging en Onderstel'			,25),
	(177,	'Remmen en Aandrijving'				,25),
	(178,	'Ruiten en Toebehoren'				,25),
	(179,	'Spiegels'							,25),
	(180,	'Transmissie en Toebehoren'			,25),
	(181,	'Uitlaatsystemen'					,25),
	(182,	'Verlichting'						,25),
	(183,	'Overige onderdelen'				,25),
	(184,	'Accu''s en Toebehoren'				,26),
	(185,	'Airco en Verwarming'				,26),
	(186,	'Banden en Velgen'					,26),
	(187,	'Besturing'							,26),
	(188,	'Brandstofsystemen'					,26),
	(189,	'Carrosserie en Plaatwerk'			,26),
	(190,	'Dashboard en Schakelaars'			,26),
	(191,	'Elektronica en Kabels'				,26),
	(192,	'Filters'							,26),
	(193,	'Interieur en Bekleding'			,26),
	(194,	'Klein materiaal'					,26),
	(195,	'Motor en Toebehoren'				,26),
	(196,	'Ophanging en Onderstel'			,26),
	(197,	'Remmen en Aandrijving'				,26),
	(198,	'Ruiten en Toebehoren'				,26),
	(199,	'Spiegels'							,26),
	(200,	'Transmissie en Toebehoren'			,26),
	(201,	'Uitlaatsystemen'					,26),
	(202,	'Verlichting'						,26),
	(203,	'Overige onderdelen'				,26)
