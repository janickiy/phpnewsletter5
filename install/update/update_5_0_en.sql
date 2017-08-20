ALTER TABLE `%prefix%settings` ADD `remove_subscriber` ENUM('yes','no') NOT NULL DEFAULT 'no' AFTER `dkim_identity`;
ALTER TABLE `%prefix%settings` ADD `remove_subscriber_days` TINYINT NOT NULL DEFAULT 7 AFTER `dkim_identity`;
CREATE TABLE IF NOT EXISTS `%prefix%redirect_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%сustomheaders` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;