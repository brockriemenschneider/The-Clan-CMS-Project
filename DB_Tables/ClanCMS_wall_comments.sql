CREATE TABLE IF NOT EXISTS `ClanCMS_wall_comments` (
`comment_id` bigint( 20 ) NOT NULL AUTO_INCREMENT ,
`wall_owner_id` bigint( 20 ) NOT NULL ,
`commenter_id` bigint( 20 ) NOT NULL ,
`reply_to_id` bigint( 20 ) NOT NULL ,
`comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY ( `comment_id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8;