USE master

GO

DROP DATABASE EA

GO

CREATE DATABASE EA
Go
Use EA
GO


CREATE TABLE Categorie(
CAT_ID INT NOT NULL, 
CAT_Naam VARCHAR(100) NOT NULL,
CONSTRAINT PK_Categorie_ID PRIMARY KEY (CAT_ID)
)

GO

CREATE TABLE Subcategorie(
SCAT_ID INT NOT NULL,
SCAT_Naam VARCHAR(100) NOT NULL,
SCAT_PAR_ID INT NOT NULL,
CONSTRAINT PK_Subcategorie_ID PRIMARY KEY (SCAT_ID),
CONSTRAINT FK_Subcategorie_Par_ID FOREIGN KEY (SCAT_PAR_ID) REFERENCES Categorie(CAT_ID)
)

GO

CREATE TABLE Rubriek(
RUB_ID INT NOT NULL,
RUB_Naam VARCHAR(100) NOT NULL,
RUB_PAR_ID INT NOT NULL,
CONSTRAINT PK_Rubriek_ID PRIMARY KEY (RUB_ID),
CONSTRAINT FK_Rubriek_Par_ID FOREIGN KEY (RUB_PAR_ID) REFERENCES Subcategorie(SCAT_ID)
)


GO


CREATE TABLE Voorwerp_Categorie(
VC_ID INT NOT NULL,
VC_CAT INT NOT NULL,
VC_SCAT INT,
VC_RUB INT
)


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
	(39,	'Citro�n'							,22),
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
	(109,	'Citro�n'							,24),
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


	SELECT * FROM Categorie
	SELECT * FROM Subcategorie
	SELECT * FROM Rubriek
	SELECT * FROM Voorwerp_Categorie



