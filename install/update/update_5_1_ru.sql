CREATE TABLE IF NOT EXISTS `%prefix%сustomheaders` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
ALTER TABLE `%prefix%aut` ADD `name` VARCHAR(255) DEFAULT NULL AFTER `login`;
ALTER TABLE `%prefix%aut` ADD `description` TEXT DEFAULT NULL AFTER `password`;
ALTER TABLE `%prefix%settings` ADD `replacement_chars_subject` ENUM('no','yes') NOT NULL DEFAULT 'no' AFTER `random`;
ALTER TABLE `%prefix%settings` ADD `replacement_chars_body` ENUM('no','yes') NOT NULL DEFAULT 'no' AFTER `random`;