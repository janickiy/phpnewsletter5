ALTER TABLE `%prefix%aut` ADD `name` VARCHAR(255) DEFAULT NULL AFTER `login`;
ALTER TABLE `%prefix%aut` ADD `description` TEXT DEFAULT NULL AFTER `password`;
ALTER TABLE `%prefix%settings` ADD `replacement_chars_subject` ENUM('no','yes') NOT NULL DEFAULT 'no' AFTER `random`;
ALTER TABLE `%prefix%settings` ADD `replacement_chars_body` ENUM('no','yes') NOT NULL DEFAULT 'no' AFTER `random`;