-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210503143446',	'2021-05-04 08:40:35',	200),
('DoctrineMigrations\\Version20210504073142',	'2021-05-04 08:40:35',	5),
('DoctrineMigrations\\Version20210504083737',	'2021-05-04 08:40:35',	211),
('DoctrineMigrations\\Version20210504092555',	'2021-05-04 09:26:03',	478);

SET NAMES utf8mb4;

INSERT INTO `dump` (`id`, `title`, `latitude_coordinate`, `longitude_coordinate`, `picture1`, `picture2`, `picture3`, `description`, `is_closed`, `created_at`, `updated_at`, `emergency_id`, `user_id`) VALUES
(2,	'coucou les react',	12.1456,	12.1456,	'/tmp/bliblou',	NULL,	NULL,	'My stick is better than bacon.',	0,	'2021-05-04 09:49:16',	NULL,	2,	3),
(3,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.',	123.145,	123.145,	'/tmp/test',	NULL,	NULL,	'Better to remain silent and be thought a fool than to speak out and remove all doubt.The only mystery in life is why the kamikaze pilots wore helmets.',	0,	'2021-05-04 09:49:48',	NULL,	1,	1),
(4,	'The only mystery in life is why the kamikaze pilots wore helmets.',	123.145,	123.145,	'/tmp/tre',	NULL,	NULL,	'It would be nice to spend billions on schools and roads, but right now that money is desperately needed for political ads.Better to remain silent and be thought a fool than to speak out and remove all doubt.',	0,	'2021-05-04 09:50:18',	NULL,	3,	1);


INSERT INTO `emergency` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1,	'Élevée',	'2021-05-04 09:06:44',	NULL),
(2,	'Moyenne',	'2021-05-04 09:06:53',	NULL),
(3,	'Faible',	'2021-05-04 09:07:00',	NULL);

INSERT INTO `removal` (`id`, `date`, `is_finished`, `created_at`, `updated_at`, `dump_id`, `user_id`) VALUES
(2,	'2021-05-14 09:58:18',	0,	'2021-05-04 09:58:18',	NULL,	2,	0),
(3,	'2021-05-04 09:58:32',	0,	'2021-05-04 09:58:32',	NULL,	2,	0),
(4,	'2021-05-04 09:58:40',	0,	'2021-05-04 09:58:40',	NULL,	3,	0);

INSERT INTO `user` (`id`, `email`, `password`, `role`, `username`, `firstname`, `lastname`, `is_banned`, `created_at`, `updated_at`) VALUES
(1,	'user1@user1.user1',	'$argon2id$v=19$m=65536,t=4,p=1$+iVFDeLtDAYhkcS3jHpu+w$A/JRH5frTgLHsF0SlQH9OEeP8knk7i4tapwN5PEKhyg',	'',	'',	'',	'',	0,	'0000-00-00 00:00:00',	NULL),
(2,	'user2@user2.user2',	'$argon2id$v=19$m=65536,t=4,p=1$CcD7vHZA3fi22IQE6CwpmA$xQJDux1qGArypq8xZvYmxLs4xzQCjZrzygDZBBG63s8',	'',	'',	'',	'',	0,	'0000-00-00 00:00:00',	NULL),
(3,	'user3@user3.user3',	'$argon2id$v=19$m=65536,t=4,p=1$cZz4uuJhwQmczbfdau2BgA$wj5jdT3rPhH7p2ahWdFziAMkAe8zjqhj6LGLsafjxic',	'',	'',	'',	'',	0,	'0000-00-00 00:00:00',	NULL);


-- 2021-05-04 11:51:04