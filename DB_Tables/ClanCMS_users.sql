ALTER TABLE `ClanCMS_users` ADD `can_shout` TINYINT( 1 ) NOT NULL DEFAULT '1',
ADD `can_upload` TINYINT( 1 ) NOT NULL DEFAULT '1',
ADD `has_voice` TINYINT( 1 ) NOT NULL DEFAULT '1'
ADD `can_upload` tinyint(1) NOT NULL DEFAULT '1',
ADD `has_voice` tinyint(1) NOT NULL DEFAULT '1',
ADD `status` text COLLATE utf8_unicode_ci NOT NULL,
ADD `wall_enabled` tinyint(1) NOT NULL DEFAULT '1',
ADD `tournament_wins` bigint(20) NOT NULL,