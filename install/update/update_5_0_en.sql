ALTER TABLE `%prefix%settings` ADD `remove_subscriber` ENUM('yes','no') NOT NULL DEFAULT 'no' AFTER `dkim_identity`;
ALTER TABLE `%prefix%settings` ADD `remove_subscriber_day` TINYINT NOT NULL DEFAULT 7 AFTER `remove_subscriber`;
CREATE TABLE `%prefix%redirect_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;