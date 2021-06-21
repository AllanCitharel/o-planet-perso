-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210503143446',	'2021-05-04 11:54:38',	434),
('DoctrineMigrations\\Version20210504073142',	'2021-05-04 11:54:38',	17),
('DoctrineMigrations\\Version20210504083737',	'2021-05-04 11:54:38',	858),
('DoctrineMigrations\\Version20210504092555',	'2021-05-04 11:54:39',	381),
('DoctrineMigrations\\Version20210504094357',	'2021-05-04 11:54:39',	8),
('DoctrineMigrations\\Version20210504100602',	'2021-05-04 11:54:39',	165),
('DoctrineMigrations\\Version20210504121235',	'2021-05-04 12:12:43',	503),
('DoctrineMigrations\\Version20210507142404',	'2021-05-07 14:24:16',	250);

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `dump`;
CREATE TABLE `dump` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude_coordinate` double NOT NULL,
  `longitude_coordinate` double NOT NULL,
  `picture1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `emergency_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_476C7125D904784C` (`emergency_id`),
  KEY `IDX_476C7125A76ED395` (`user_id`),
  CONSTRAINT `FK_476C7125A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_476C7125D904784C` FOREIGN KEY (`emergency_id`) REFERENCES `emergency` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dump` (`id`, `title`, `latitude_coordinate`, `longitude_coordinate`, `picture1`, `picture2`, `picture3`, `description`, `is_closed`, `created_at`, `updated_at`, `emergency_id`, `user_id`) VALUES
(64,	'all doubt in user2 h?.',	12.312,	12.312,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	1,	'2021-05-10 16:46:18',	'2021-05-17 13:40:27',	1,	2),
(74,	'Kana !',	43.06888777417,	0,	'dump609a4250653df.jpg',	NULL,	NULL,	'Photo Kana',	1,	'2021-05-11 08:37:33',	'2021-05-18 12:16:10',	1,	2),
(75,	'Better to',	29.535229562948,	35.15625,	'dump609a506db9ea8.jpg',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	1,	'2021-05-11 09:37:49',	'2021-05-18 12:16:51',	2,	2),
(79,	'Better to',	43.644025847699,	5.5810546875,	'dump609a51da0bfe0.jpg',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	0,	'2021-05-11 09:43:53',	'2021-05-17 18:46:06',	2,	2),
(81,	'bidondgft',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	1,	'2021-05-11 11:07:34',	NULL,	1,	1),
(82,	'isclosed vaut 1',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	1,	'2021-05-11 11:09:40',	NULL,	1,	1),
(83,	'latittude string',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	1,	'2021-05-11 11:11:48',	NULL,	1,	1),
(84,	'latittude string',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	1,	'2021-05-11 11:11:54',	NULL,	1,	1),
(86,	'bidon',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	1,	'2021-05-11 11:32:44',	NULL,	1,	1),
(87,	'bidon',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	1,	'2021-05-11 11:32:56',	NULL,	1,	1),
(88,	'bidon',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 11:34:17',	NULL,	1,	1),
(89,	'bidon',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 11:34:19',	NULL,	1,	1),
(90,	'bidon',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 11:39:22',	NULL,	1,	1),
(92,	'dump avec fichier !',	1.545,	2.458,	'dump609a6d252890a.png',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 11:40:21',	NULL,	1,	1),
(93,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	12.312,	12.312,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	1,	'2021-05-11 12:23:55',	'2021-05-18 13:32:05',	1,	2),
(94,	'nouveau titre',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:24:01',	NULL,	1,	1),
(95,	'nouveau titre',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:24:11',	NULL,	1,	1),
(96,	'bidon',	1.545,	2.458,	'dump609a7955bb099.png',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:32:21',	NULL,	1,	1),
(97,	'bidon',	1.545,	2.458,	'dump609a795c25493.png',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:32:28',	NULL,	1,	1),
(98,	'bidonavec fich',	1.545,	2.458,	'dump609a79b596b33.png',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:33:57',	NULL,	1,	1),
(99,	'bidon SANS fichier',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:34:44',	NULL,	1,	1),
(100,	'bidongfdgdf',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:49:12',	NULL,	1,	1),
(101,	'bidongfdgdf',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:49:51',	NULL,	1,	1),
(102,	'bidongfdgdf',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:49:54',	NULL,	1,	1),
(103,	'bidonfdsfsd',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:57:48',	NULL,	1,	1),
(104,	'bidonfdsfsd',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:58:45',	NULL,	1,	1),
(105,	'bidonfdsfsd',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 12:59:03',	NULL,	1,	1),
(106,	'bidongfdgdfgdfggdfgdfgdf',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 13:35:45',	NULL,	1,	1),
(107,	'bidongfdgdfgfdg',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 13:43:24',	NULL,	1,	1),
(108,	'bidongfdgdfgdf',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 13:44:34',	NULL,	1,	1),
(111,	'Post de dump',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon et bidon',	0,	'2021-05-11 17:09:26',	NULL,	2,	1),
(112,	'bidon',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 17:11:54',	NULL,	1,	1),
(113,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	12.312,	12.312,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	1,	'2021-05-11 17:27:41',	'2021-05-17 11:58:00',	1,	2),
(114,	'yipee ?',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-11 17:28:18',	NULL,	1,	1),
(115,	'ggdfgdfgdf',	123.54546,	123.54546,	'gfgd',	NULL,	NULL,	'gdfgdfgdf',	0,	'2021-05-12 09:55:52',	NULL,	2,	17),
(116,	'Better to',	46.3772542051,	6.1083984375,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	0,	'2021-05-12 11:54:18',	'2021-05-17 18:45:42',	2,	2),
(117,	'Better to',	48.370847702384,	-4.39453125,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	0,	'2021-05-12 11:58:11',	'2021-05-17 18:45:12',	2,	2),
(118,	'Better to',	50.007739014637,	2.7685546875,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	0,	'2021-05-12 12:27:37',	'2021-05-17 18:44:49',	2,	2),
(119,	'bidon',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-12 12:30:16',	NULL,	1,	1),
(120,	'bidontreterter',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-12 12:30:52',	NULL,	1,	1),
(121,	'bidontreterter',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-12 12:31:08',	NULL,	1,	1),
(123,	'all doubt in user2 hhh?.',	12.312,	12.312,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	1,	'2021-05-12 12:58:34',	'2021-05-17 11:53:55',	1,	1),
(124,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	12.312,	12.312,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	1,	'2021-05-14 12:49:20',	NULL,	1,	2),
(125,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	12.312,	12.312,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	1,	'2021-05-14 12:53:15',	NULL,	1,	2),
(126,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	12.312,	12.312,	'no picture sent',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	1,	'2021-05-14 12:54:04',	NULL,	1,	2),
(127,	'bidon',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-14 14:40:34',	NULL,	1,	1),
(128,	'gfdgdfgdfgdfgdbidon',	1.545,	2.458,	'dump609e8f552f064.jpg',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-14 14:55:16',	NULL,	1,	1),
(129,	'05/14/2021 05/14/2021',	1.545654,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	1,	'2021-05-14 15:07:20',	'2021-05-14 15:11:42',	2,	2),
(131,	'bidongjdg',	1.545,	2.458,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-17 07:09:15',	NULL,	2,	1),
(132,	'peepoInvasion',	46.7111,	1.7191,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-17 07:46:27',	NULL,	1,	1),
(133,	'Kana !',	46.073230625408,	2.28515625,	'dump60a2250541193.png',	NULL,	NULL,	'Test avec photo kana',	0,	'2021-05-17 08:10:45',	NULL,	3,	1),
(134,	'dump grand est',	48.516604348867,	5.44921875,	'dump60a2326ab5548.png',	NULL,	NULL,	'Ceci est une description bidon grand est',	0,	'2021-05-17 09:07:54',	NULL,	2,	1),
(136,	'bidon Edit',	49.15296965617,	2.724609375,	'dump60a23588bb7fa.png',	NULL,	NULL,	'Edit',	1,	'2021-05-17 09:21:12',	'2021-05-17 09:21:49',	2,	54),
(137,	'bidon2',	46.7111,	1.7191,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-17 09:24:07',	'2021-05-17 09:26:31',	1,	54),
(138,	'JWT',	46.7111,	1.7191,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-17 12:26:45',	NULL,	1,	54),
(139,	'JWT',	46.7111,	1.7191,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-17 12:26:57',	NULL,	1,	54),
(140,	'essaie JWT Axios',	46.7111,	1.7191,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-17 13:07:21',	'2021-05-17 13:39:08',	1,	54),
(142,	'peepoInvasion',	-54.8267990912,	-68.326721191406,	'dump60a27d7529f35.png',	NULL,	NULL,	'( ͡° ͜ʖ ͡°)',	0,	'2021-05-17 14:28:04',	NULL,	1,	54),
(143,	'Décharge de Guernesey',	49.066668395581,	-2.197265625,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon d\'un dump à Guernesey',	1,	'2021-05-17 20:14:19',	'2021-05-18 12:11:13',	2,	54),
(144,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	46.7111,	1.7191,	'dump60a36bd25552c.jpg',	NULL,	NULL,	'My stick is better than bacon.',	0,	'2021-05-18 07:25:04',	NULL,	2,	1),
(145,	'bidon',	45.490945692627,	5.9109392668907,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	0,	'2021-05-18 07:26:52',	NULL,	1,	1),
(146,	'bidon',	46.7111,	1.7191,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	1,	'2021-05-18 11:40:11',	'2021-05-18 11:50:20',	1,	54),
(147,	'Affichage aucun dump en cours...',	46.7111,	1.7191,	'no picture sent',	NULL,	NULL,	'Ceci est une description bidon',	1,	'2021-05-18 12:22:35',	'2021-05-18 12:22:50',	1,	54),
(148,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	45.490945692627,	5.9130980768927,	'000-dump-placeholder.jpg',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt. The only mystery in life is why the kamikaze pilots wore helmets.',	0,	'2021-05-19 08:51:28',	NULL,	1,	1);

DROP TABLE IF EXISTS `dump_waste`;
CREATE TABLE `dump_waste` (
  `dump_id` int(11) NOT NULL,
  `waste_id` int(11) NOT NULL,
  PRIMARY KEY (`dump_id`,`waste_id`),
  KEY `IDX_33B8C6102AE724B8` (`dump_id`),
  KEY `IDX_33B8C610FA6A22C2` (`waste_id`),
  CONSTRAINT `FK_33B8C6102AE724B8` FOREIGN KEY (`dump_id`) REFERENCES `dump` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_33B8C610FA6A22C2` FOREIGN KEY (`waste_id`) REFERENCES `waste` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dump_waste` (`dump_id`, `waste_id`) VALUES
(64,	1),
(64,	3),
(74,	2),
(75,	2),
(79,	2),
(81,	2),
(81,	5),
(82,	2),
(82,	5),
(83,	2),
(83,	5),
(84,	2),
(84,	5),
(86,	2),
(86,	5),
(87,	2),
(87,	5),
(88,	2),
(88,	5),
(89,	2),
(89,	5),
(90,	2),
(90,	5),
(92,	2),
(92,	5),
(93,	1),
(93,	3),
(94,	2),
(94,	5),
(95,	2),
(95,	5),
(96,	2),
(96,	5),
(97,	2),
(97,	5),
(98,	2),
(98,	5),
(99,	2),
(99,	5),
(100,	2),
(100,	5),
(101,	2),
(101,	5),
(102,	2),
(102,	5),
(103,	2),
(103,	5),
(104,	2),
(104,	5),
(105,	2),
(105,	5),
(106,	2),
(106,	5),
(107,	2),
(107,	5),
(108,	2),
(108,	5),
(111,	1),
(111,	2),
(111,	3),
(111,	5),
(111,	6),
(112,	2),
(112,	5),
(113,	1),
(113,	3),
(114,	2),
(114,	5),
(116,	2),
(117,	2),
(118,	2),
(119,	2),
(119,	5),
(120,	2),
(120,	5),
(121,	2),
(121,	5),
(123,	1),
(123,	3),
(124,	2),
(124,	3),
(127,	2),
(127,	5),
(128,	2),
(128,	5),
(129,	6),
(131,	1),
(131,	2),
(131,	3),
(131,	5),
(132,	1),
(132,	2),
(132,	3),
(132,	5),
(132,	6),
(132,	7),
(133,	2),
(133,	5),
(134,	1),
(134,	2),
(134,	3),
(134,	5),
(136,	7),
(137,	2),
(137,	5),
(138,	2),
(138,	5),
(139,	2),
(139,	5),
(140,	2),
(140,	5),
(142,	1),
(142,	2),
(142,	3),
(142,	5),
(142,	6),
(142,	7),
(143,	1),
(143,	6),
(144,	2),
(144,	3),
(145,	7),
(146,	2),
(146,	5),
(147,	2),
(147,	5),
(148,	1);

DROP TABLE IF EXISTS `emergency`;
CREATE TABLE `emergency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `example` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `emergency` (`id`, `name`, `created_at`, `updated_at`, `example`) VALUES
(1,	'Élevée',	'2021-05-04 09:06:44',	NULL,	'Risque d\'empoisonnement des sols'),
(2,	'Moyenne',	'2021-05-04 09:06:53',	NULL,	'Danger pour la faune et les promeneurs'),
(3,	'Faible',	'2021-05-04 09:07:00',	NULL,	'Nuisance esthétique');

DROP TABLE IF EXISTS `removal`;
CREATE TABLE `removal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `is_finished` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `dump_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D4DBB74B2AE724B8` (`dump_id`),
  KEY `IDX_D4DBB74B61220EA6` (`creator_id`),
  CONSTRAINT `FK_D4DBB74B2AE724B8` FOREIGN KEY (`dump_id`) REFERENCES `dump` (`id`),
  CONSTRAINT `FK_D4DBB74B61220EA6` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `removal` (`id`, `date`, `is_finished`, `created_at`, `updated_at`, `dump_id`, `creator_id`) VALUES
(23,	'2021-05-12 09:41:04',	1,	'2021-05-12 09:41:04',	'2021-05-18 12:06:23',	90,	2),
(24,	'2021-05-12 10:03:30',	0,	'2021-05-12 10:03:30',	NULL,	90,	17),
(25,	'2021-05-12 10:03:50',	1,	'2021-05-12 10:03:50',	NULL,	101,	17),
(26,	'2021-05-10 13:23:50',	1,	'2021-05-14 14:51:40',	NULL,	90,	1),
(27,	'2028-01-01 10:10:11',	1,	'2021-05-14 14:52:40',	'2021-05-17 16:12:40',	90,	2),
(28,	'2022-06-10 20:10:00',	0,	'2021-05-14 16:45:12',	NULL,	90,	1),
(61,	'2021-05-21 16:54:00',	0,	'2021-05-17 14:54:05',	NULL,	64,	1),
(63,	'2021-05-23 22:45:00',	0,	'2021-05-17 20:43:15',	NULL,	79,	54),
(64,	'2021-05-19 10:30:00',	0,	'2021-05-18 07:25:41',	NULL,	144,	1),
(65,	'2021-05-22 11:53:00',	1,	'2021-05-18 09:53:39',	'2021-05-18 11:11:43',	64,	54);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `user_alias` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_banned` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `last_connection_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `email`, `password`, `roles`, `user_alias`, `firstname`, `lastname`, `is_banned`, `created_at`, `updated_at`, `last_connection_at`) VALUES
(1,	'user1@user1.user1',	'$argon2id$v=19$m=65536,t=4,p=1$1Ruvze+qK9+BjtJ/J7JWng$T6PpWUwj2SDR3p7PbUElZpFL2cJ8QTyPZYci9Ldndbg',	'[]',	'usgfhgfr1',	'user1s',	'user1l',	0,	'2021-05-04 12:14:00',	'2021-05-12 09:12:16',	NULL),
(2,	'user2@user2.user2',	'$argon2id$v=19$m=65536,t=4,p=1$Sg9ngAc9+q6LkZMc8ZoYpA$mD7z1F4MzufVwe7jT0Ltl/Z4/tHQGDSU4Tdsz28jHU4',	'[]',	'user2',	'user2firstname',	'user2lastname',	0,	'2021-05-04 12:31:46',	'2021-05-14 12:00:55',	NULL),
(3,	'user3@user3.user3',	'$argon2id$v=19$m=65536,t=4,p=1$AxyUQWOGigxDSWGfy7C+ng$cgkLMgZifRR2luDbrensw205kBmCzmPwAetEai+R5b4',	'[\"ROLE_ADMIN\"]',	'user3',	'user3f',	'user3l',	0,	'2021-05-04 12:32:32',	'2021-05-04 16:26:32',	NULL),
(16,	'admin@admin.admin',	'$argon2id$v=19$m=65536,t=4,p=1$5vRvXwJm9GgZQ/0CrmukGw$3QZJ4JEztvNWl4U/mNxcFziNQsFm8o1egaWurVXgSNM',	'[\"ROLE_USER\",\"ROLE_ADMIN\"]',	'admin',	'admin',	'admin',	0,	'2021-05-11 14:54:47',	NULL,	NULL),
(17,	'anonymous@oplanet.fr',	'$argon2id$v=19$m=65536,t=4,p=1$2ZoRwi6zviuQsYkCtBsFQA$TiR/Yl8vdF69Ao3k+QX6Eq79edgzlwfdYvn/78fKhJQ',	'',	'anonymous',	'anonymousF',	'anonymousL',	0,	'2021-05-12 09:50:50',	NULL,	NULL),
(18,	'a@a.a',	'$argon2id$v=19$m=65536,t=4,p=1$H5lPjgEYKubbm2eAC/35Jw$n1waUE4H1uyJQ0Y5x5IUelYKFdqBzbd4xLvKCR2BS7I',	'[]',	'a',	'a',	'a',	0,	'2021-05-12 09:56:57',	'2021-05-14 16:49:36',	NULL),
(20,	'lolo@lolo.com',	'$argon2id$v=19$m=65536,t=4,p=1$9Up+1JP2/TXM6DghOWpSqw$Jm1JmY+CfkU74f4BHi9Q5+o6oQTYIKBr2a8k2Eg9obM',	'[]',	'superlolo',	'lolo',	'vv',	0,	'2021-05-12 13:37:50',	NULL,	NULL),
(24,	'lolo@mail.com',	'$argon2id$v=19$m=65536,t=4,p=1$2ugcCIdnki9JBeOWDNpRlA$PoIeVebHFiLMuRDcHDEyOz+JjlwqqQj1U4/cUyO98/8',	'[]',	'lolo',	'lolo',	'lolo',	0,	'2021-05-12 13:52:26',	NULL,	NULL),
(27,	'ololo@lolo.com',	'$argon2id$v=19$m=65536,t=4,p=1$+0Fy+cz1BvLnKDpQYzYZtw$Qev08ORVF02VIqRNEEIPQT9X9SskkUfZFck1Pf8qw5I',	'[]',	'superlolo',	'lolo',	'vv',	0,	'2021-05-12 16:18:59',	'2021-05-12 16:38:48',	NULL),
(29,	'ololo@lolo1.com',	'$argon2id$v=19$m=65536,t=4,p=1$D0RZ7qLaMkIyWcPPCYavrg$BvELkzf8LyBT5SXMzCKsmHYS8SJMchdWDJdLCsJjkbc',	'[]',	'et moi aussi !',	'je suis modifié aussi !',	'test de modif !!',	0,	'2021-05-12 18:13:12',	'2021-05-12 18:15:28',	NULL),
(37,	'ololoo@lolo.com',	'$argon2id$v=19$m=65536,t=4,p=1$549JJWjUAVdvaPuUBgjbQw$FE0jtBkTp9RuHTbWXIYpLkYvgOLmsVEeoruJDraA6v4',	'[]',	'lolo',	'lolo',	'vv',	0,	'2021-05-12 19:20:55',	NULL,	NULL),
(38,	'sedgtxf@lolo.com',	'$argon2id$v=19$m=65536,t=4,p=1$bZFOFKB8y7lOaxmbpk2kBw$K2QtkJUHclr+qcpw6JmQkF8C+qwRp7dUftnXdc1N6K4',	'[]',	'lolo',	'lolo',	'vv',	0,	'2021-05-12 19:23:40',	NULL,	NULL),
(39,	'ololsedgrfo@lolo.com',	'$argon2id$v=19$m=65536,t=4,p=1$ypO7pcsyYNjq8ju7BNJ6PA$Gg8Soqs6pMajkRBmkzezggobbcbxmEOel13WnT1eg/Q',	'[]',	'lolo',	'lolo',	'vv',	0,	'2021-05-12 19:25:09',	NULL,	NULL),
(44,	'ologfhlo@lolo.com',	'$argon2id$v=19$m=65536,t=4,p=1$ZUXBQFJK9wQ76oI637nXLg$LDKQhJ879sC3EfEopGo+blJm8E5CGP+r5PWvYGp4GzE',	'[]',	'lolo',	'lolo',	'vv',	0,	'2021-05-12 19:40:44',	NULL,	NULL),
(45,	'ololo@dfghjlolo.com',	'$argon2id$v=19$m=65536,t=4,p=1$li23VU+7FQ4dVkq6rkNjOA$pSkhelHJoOySqVXOJEcYN4YRn7EylFVKGKyKDX+Hk0I',	'[]',	'lolo',	'lolo',	'vv',	0,	'2021-05-12 19:44:21',	NULL,	NULL),
(49,	'lolo@lolo.lolo',	'$argon2id$v=19$m=65536,t=4,p=1$qyAJ2OCEYsEr9AJhwsrT7Q$RaNsJGa/JNLTjFQIHiyoF/6oabEkzhQWnvxG/6WNSuI',	'[]',	'et moi aussi !',	'je suis modifié aussi !',	'test de modif !!',	0,	'2021-05-14 07:31:23',	'2021-05-14 09:42:18',	NULL),
(50,	'test@test.test',	'$argon2id$v=19$m=65536,t=4,p=1$Lnn7Q7U6cVZO4s1Z+q4whA$CRMg0LzoUf+c/8oxvpdq5Hzq2h1wrBy6GBwAMIi3UE8',	'[]',	'test',	'test',	'test',	0,	'2021-05-14 08:04:29',	NULL,	NULL),
(51,	'lolo@lolo1.com',	'$argon2id$v=19$m=65536,t=4,p=1$vFSRQrw2MqFRyUOHZrimHQ$9+FDRH6V9y6uh0x5m7d4fYwrRTxD+CQVbBXoaR5m61U',	'[]',	'Laurent',	'Laurent',	'VERDIER',	0,	'2021-05-14 13:55:50',	NULL,	NULL),
(54,	'test@test.test1',	'$argon2id$v=19$m=65536,t=4,p=1$UPUZev6hlo2Ys85J05icyg$OkJDBIEpkcCNRf0KhE/wO81JGb7RvTxDageGBdgrkvE',	'[]',	'test',	'test',	'test',	0,	'2021-05-17 09:07:21',	NULL,	NULL),
(55,	'usermdp@usermdp.usermdp',	'$argon2id$v=19$m=65536,t=4,p=1$16ZoIYvojD199404q6uWUQ$cdzuDdDA0XC2JMZUA98FA5yxeoedDpJOSFV741PlYMU',	'[]',	'usermdp',	'usermdphhfn',	'usermdpn',	0,	'2021-05-18 13:46:00',	'2021-05-18 14:35:27',	NULL);

DROP TABLE IF EXISTS `user_removal`;
CREATE TABLE `user_removal` (
  `user_id` int(11) NOT NULL,
  `removal_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`removal_id`),
  KEY `IDX_8CD6A941A76ED395` (`user_id`),
  KEY `IDX_8CD6A941A00B94E6` (`removal_id`),
  CONSTRAINT `FK_8CD6A941A00B94E6` FOREIGN KEY (`removal_id`) REFERENCES `removal` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_8CD6A941A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_removal` (`user_id`, `removal_id`) VALUES
(2,	23),
(54,	61);

DROP TABLE IF EXISTS `waste`;
CREATE TABLE `waste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `waste` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1,	'Matériaux de chantier',	'2021-05-04 12:16:15',	NULL),
(2,	'Produits chimiques',	'2021-05-04 12:16:22',	NULL),
(3,	'Epave de véhicule',	'2021-05-04 12:16:28',	NULL),
(5,	'Détritus',	'2021-05-04 16:20:00',	NULL),
(6,	'Electroménager / meubles',	'2021-05-04 16:23:30',	'2021-05-04 16:25:12'),
(7,	'Autres',	'2021-05-04 16:36:49',	NULL);

-- 2021-05-19 09:31:41