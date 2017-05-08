--Alle insert scripts voor de tabellen
use eenmaalandermaal


--Alle Betalingswijzen
INSERT INTO Betalingswijzen (betalingswijze) VALUES ('Bank / Giro'), ('Contant'), ('Anders');



--Alle landnamen met 3 letterige landcode  volgens ISO 3166-1
INSERT INTO Landen(landcode, landnaam) VALUES('ABW', 'Aruba'),('AFG', 'Afghanistan'),('AGO', 'Angola'),('AIA', 'Anguilla'),('ALA', 'Åland'),('ALB', 'Albanië'),('AND', 'Andorra'),('ARE', 'Verenigde Arabische Emiraten'),('ARG', 'Argentinië')
INSERT INTO Landen(landcode, landnaam) VALUES('ARM', 'Armenië'),('ASM', 'Amerikaans-Samoa'),('ATA', 'Antarctica'),('ATF', 'Franse Zuidelijke en Antarctische Gebieden'),('ATG', 'Antigua en Barbuda'),('AUS', 'Australië'),('AUT', 'Oostenrijk')
INSERT INTO Landen(landcode, landnaam) VALUES('AZE', 'Azerbeidzjan'),('BDI', 'Burundi'),('BEL', 'België'),('BEN', 'Benin'),('BES', 'Bonaire, Sint Eustatius en Saba'),('BFA', 'Burkina Faso'),('BGD', 'Bangladesh'),('BGR', 'Bulgarije')
INSERT INTO Landen(landcode, landnaam) VALUES('BHR', 'Bahrein'),('BHS', 'Bahamas'),('BIH', 'Bosnië en Herzegovina'),('BLM', 'Saint Barthélemy'),('BLR', 'Wit-Rusland'),('BLZ', 'Belize'),('BMU', 'Bermuda'),('BON', 'Bolivia'),('BRA', 'Brazilië')
INSERT INTO Landen(landcode, landnaam) VALUES('BRB', 'Barbados'),('BRN', 'Brunei'),('BTN', 'Bhutan'),('BVT', 'Bouveteiland'),('BWA', 'Botswana'),('CAF', 'Centraal-Afrikaanse Republiek'),('CAN', 'Canada'),('CCK', 'Cocoseilanden')
INSERT INTO Landen(landcode, landnaam) VALUES('CHE', 'Zwitserland'),('CHL', 'Chili'),('CHN', 'China'),('CIV', 'Ivoorkust'),('CMR', 'Kameroen'),('COD', 'Congo-Kinshasa'),('COG', 'Congo-Brazzaville'),('COK', 'Cookeilanden'),('COL', 'Colombia')
INSERT INTO Landen(landcode, landnaam) VALUES('COM', 'Comoren'),('CPV', 'Kaapverdië'),('CRI', 'Costa Rica'),('CUB', 'Cuba'),('CUW', 'Curaçao'),('CXR', 'Christmaseiland'),('CYM', 'Kaaimaneilanden'),('CYP', 'Cyprus'),('CZE', 'Tsjechië')
INSERT INTO Landen(landcode, landnaam) VALUES('DEU', 'Duitsland'),('DJI', 'Djibouti'),('DMA', 'Dominica'),('DNK', 'Denemarken'),('DOM', 'Dominicaanse Republiek'),('DZA', 'Algerije'),('ECU', 'Ecuador'),('EGY', 'Egypte'),('ERI', 'Eritrea')
INSERT INTO Landen(landcode, landnaam) VALUES('ESH', 'Westelijke Sahara'),('ESP', 'Spanje'),('EST', 'Estland'),('ETH', 'Ethiopië'),('FIN', 'Finland'),('FJI', 'Fiji'),('FLK', 'Falklandeilanden'),('FRA', 'Frankrijk'),('FRO', 'Faeröer')
INSERT INTO Landen(landcode, landnaam) VALUES('FSM', 'Micronesia'),('GAB', 'Gabon'),('GBR', 'Verenigd Koninkrijk'),('GEO', 'Georgië'),('GGY', 'Guernsey'),('GHA', 'Ghana'),('GIB', 'Gibraltar'),('GIN', 'Guinee'),('GLP', 'Guadeloupe')
INSERT INTO Landen(landcode, landnaam) VALUES('GMB', 'Gambia'),('GNB', 'Guinee-Bissau'),('GNQ', 'Equatoriaal-Guinea'),('GRC', 'Griekenland'),('GRD', 'Grenada'),('GRL', 'Groenland'),('GTM', 'Guatemala'),('GUF', 'Frans-Guyana'),('GUM', 'Guam')
INSERT INTO Landen(landcode, landnaam) VALUES('GUY', 'Guyana'),('HKG', 'Hong Kong'),('HMD', 'Heard en McDonaldeilanden'),('HND', 'Honduras'),('HRV', 'Kroatië'),('HTI', 'Haïti'),('HUN', 'Hongarije'),('IDN', 'Indonesië'),('IMN', 'Mam')
INSERT INTO Landen(landcode, landnaam) VALUES('IND', 'India'),('IOT', 'Britse Indische Oceaan Territorium'),('IRL', 'Ierland'),('IRN', 'Iran'),('IRQ', 'Irak'),('ISL', 'IJsland'),('ISR', 'Israël'),('ITA', 'Italië'),('JAM', 'Jamaica')
INSERT INTO Landen(landcode, landnaam) VALUES('JEY', 'Jersey'),('JOR', 'Jordan'),('JPN', 'Japan'),('KAZ', 'Kazachstan'),('KEN', 'Kenia'),('KGZ', 'Kirgizië'),('KHM', 'Cambodja'),('KIR', 'Kiribati'),('KNA', 'Saint Kitts en Nevis')
INSERT INTO Landen(landcode, landnaam) VALUES('KOR', 'Zuid-Korea'),('KWT', 'Koeweit'),('LAO', 'Democratische Republiek Laos'),('LBN', 'Libanon'),('LBR', 'Liberia'),('LBY', 'Libië'),('LCA', 'Saint Lucia'),('LIE', 'Liechtenstein')
INSERT INTO Landen(landcode, landnaam) VALUES('LKA', 'Sri Lanka'),('LSO', 'Lesotho'),('LTU', 'Litouwen'),('LUX', 'Luxemburg'),('LVA', 'Letland'),('MAC', 'Macau'),('MAF', 'Sint-Maarten'),('MAR', 'Marokko'),('MCO', 'Monaco'),('MDA', 'Moldavië')
INSERT INTO Landen(landcode, landnaam) VALUES('MDG', 'Madagascar'),('MDV', 'Maldiven'),('MEX', 'Mexico'),('MHL', 'Marshalleilanden'),('MKD', 'Macedonië'),('MLI', 'Mali'),('MLT', 'Malta'),('MMR', 'Myanmar'),('MNE', 'Montenegro')
INSERT INTO Landen(landcode, landnaam) VALUES('MNG', 'Mongolië'),('MNP', 'Noordelijke Marianen'),('MOZ', 'Mozambique'),('MRT', 'Mauritanië'),('MSR', 'Montserrat'),('MTQ', 'Martinique'),('MUS', 'Mauritius'),('MWI', 'Malawi'),('MYS', 'Maleisië')
INSERT INTO Landen(landcode, landnaam) VALUES('MYT', 'Mayotte'),('NAM', 'Namibië'),('NCL', 'Nieuw-Caledonië'),('NER', 'Niger'),('NFK', 'Norfolk'),('NGA', 'Nigeria'),('NIC', 'Nicaragua'),('NIU', 'Niue'),('NLD', 'Nederland'),('NOR', 'Noorwegen')
INSERT INTO Landen(landcode, landnaam) VALUES('NPL', 'Nepal'),('NRU', 'Nauru'),('NZL', 'Nieuw-Zeeland'),('OMN', 'Oman'),('PAK', 'Pakistan'),('PAN', 'Panama'),('PCN', 'Pitcairneilanden'),('PER', 'Peru'),('PHL', 'Filippijnen'),('PLW', 'Palau')
INSERT INTO Landen(landcode, landnaam) VALUES('PNG', 'Papoea-Nieuw-Guinea'),('POL', 'Polen'),('PRI', 'Puerto Rico'),('PRK', 'Noord-Korea'),('PRT', 'Portugal'),('PRY', 'Paraguay'),('PSE', 'Palestina'),('PYF', 'Frans-Polynesië'),('QAT', 'Qatar')
INSERT INTO Landen(landcode, landnaam) VALUES('REU', 'Réunion'),('ROU', 'Roemenië'),('RUS', 'Rusland'),('RWA', 'Rwanda'),('SAU', 'Saoedi-Arabië'),('SDN', 'Sudan'),('SEN', 'Senegal'),('SGP', 'Singapore')
INSERT INTO Landen(landcode, landnaam) VALUES('SGS', 'Zuid-Georgia en de Zuidelijke Sandwicheilanden'),('SHN', 'Sint-Helena, Ascension en Tristan da Cunha'),('SJM', 'Spitsbergen en Jan Mayen'),('SLB', 'Salomonseilanden'),('SLE', 'Sierra Leone')
INSERT INTO Landen(landcode, landnaam) VALUES('SLV', 'El Salvador'),('SMR', 'San Marino'),('SOM', 'Somalië'),('SPM', 'Saint-Pierre en Miquelon'),('SRB', 'Servië'),('SSD', 'South Sudan'),('STP', 'Sao Tomé en Principe'),('SUR', 'Suriname')
INSERT INTO Landen(landcode, landnaam) VALUES('SVK', 'Slowakije'),('SVN', 'Slovenië'),('SWE', 'Sweden'),('SWZ', 'Swaziland'),('SXM', 'Sint Maarten'),('SYC', 'Seychellen'),('SYR', 'Syrië'),('TCA', 'Turks- en Caicoseilanden'),('TCD', 'Tsjaad')
INSERT INTO Landen(landcode, landnaam) VALUES('TGO', 'Togo'),('THA', 'Thailand'),('TJK', 'Tadzjikistan'),('TKL', 'Tokelau'),('TKM', 'Turkmenistan'),('TLS', 'Oost-Timor'),('TON', 'Tonga'),('TTO', 'Trinidad en Tobago'),('TUN', 'Tunesië')
INSERT INTO Landen(landcode, landnaam) VALUES('TUR', 'Turkije'),('TUV', 'Tuvalu'),('TWB', 'Taiwan'),('TZA', 'Tanzania'),('UGA', 'Oeganda'),('UKR', 'Oekraïne'),('UMI', 'Kleine afgelegen eilanden van de Verenigde Staten'),('URY', 'Uruguay')
INSERT INTO Landen(landcode, landnaam) VALUES('USA', 'Verenigde Staten'),('UZB', 'Uzbekistan'),('BTW', 'Vaticaanstad'),('VCT', 'Saint Vincent en de Grenadines'),('VEN', 'Venezuela'),('VGB', 'Britse Maagdeneilanden')
INSERT INTO Landen(landcode, landnaam) VALUES('VIR', 'Amerikaanse Maagdeneilanden'),('VNM', 'Vietnam'),('VUT', 'Vanuatu'),('WLF', 'Wallis en Futuna'),('WSM', 'Samoa'),('YEM', 'Jemen'),('ZAF', 'Zuid-Afrika'),('ZWE', 'Zimbabwe'),('ZMB', 'Zambia')


--Normaal insert statement zonder aangepaste begin tijd
INSERT INTO Voorwerp (titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
                      land, looptijd,  verzendkosten, verzendinstructies, verkoper, koper)
VALUES ('Testproduct1', 'beschrijving1', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
                        'Arnhem', 'NLD', 3, 14.20, 'test', 'kees', 'tinus')


INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (1,4.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (1,14.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (1,40.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (1,45.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (1,63.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (1,156.01,'tiasd')


INSERT INTO Voorwerp (titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
                      land, looptijd,  verzendkosten, verzendinstructies, verkoper, koper)
VALUES ('Testproduct2', 'beschrijving2', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
                        'Arnhem', 'NLD', 3, 14.20, 'test', 'kees', 'tinus')


INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (2,4.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (2,14.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (2,40.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (2,45.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (2,63.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (2,156.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (2,174.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (2,204.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (2,431.01,'tiasd')

INSERT INTO Voorwerp (titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
                      land, looptijd,  verzendkosten, verzendinstructies, verkoper, koper)
VALUES ('Testproduct3', 'beschrijving3', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
                        'Arnhem', 'NLD', 3, 14.20, 'test', 'kees', 'tinus')


INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,4.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,14.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,40.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,45.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,63.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,156.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,174.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,204.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,431.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,1174.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,1204.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (3,1431.01,'tiasd')

INSERT INTO Voorwerp (titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
                      land, looptijd,  verzendkosten, verzendinstructies, verkoper, koper)
VALUES ('Testproduct4', 'beschrijving4', 4, 'Bank / Giro', 'Maak 500 euro over naar NLINGB#030493032039384',
                        'Arnhem', 'NLD', 3, 14.20, 'test', 'kees', 'tinus')


INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,4.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,14.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,40.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,45.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,63.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,156.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,174.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,204.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,431.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,1174.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,1204.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,1431.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,2174.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,2204.01,'tiasd')
INSERT INTO Bod(voorwerpnummer, bodbedrag, gebruiker) VALUES (4,2431.01,'tiasd')



