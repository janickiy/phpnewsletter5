CREATE TABLE IF NOT EXISTS `%prefix%attach` (
  `id_attachment` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `id_template` int(7) DEFAULT NULL,
  PRIMARY KEY (`id_attachment`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%aut` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','moderator','editor') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%category` (
  `id_cat` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%charset` (
  `id_charset` int(5) NOT NULL AUTO_INCREMENT,
  `charset` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id_charset`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS`%prefix%licensekey` (
  `licensekey` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%log` (
  `id_log` int(9) NOT NULL AUTO_INCREMENT,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%process` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `process` enum('start','pause','stop') NOT NULL DEFAULT 'start',
  `id_user` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%ready_send` (
  `id_ready_send` int(10) NOT NULL AUTO_INCREMENT,
  `id_user` int(9) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id_template` int(9) DEFAULT NULL,
  `success` enum('yes','no') DEFAULT NULL,
  `errormsg` text,
  `readmail` enum('yes','no') DEFAULT 'no',
  `time` datetime DEFAULT NULL,
  `id_log` int(9) DEFAULT NULL,
  PRIMARY KEY (`id_ready_send`),
  KEY `id_user` (`id_user`),
  KEY `id_send` (`id_template`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%redirect_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%settings` (
  `language` varchar(10) DEFAULT NULL,  
  `path` varchar(255) DEFAULT NULL,  
  `email` varchar(255) DEFAULT NULL,
  `list_owner` varchar(255) DEFAULT NULL,
  `email_name` varchar(255) DEFAULT NULL,
  `show_email` enum('no','yes') DEFAULT 'yes',
  `organization` varchar(200) DEFAULT NULL,
  `smtp_host` varchar(200) DEFAULT NULL,
  `smtp_username` varchar(200) DEFAULT NULL,
  `smtp_password` varchar(200) DEFAULT NULL,
  `smtp_port` int(8) DEFAULT '25',
  `smtp_aut` enum('no','plain','cram-md5') DEFAULT 'no',
  `smtp_secure` enum('no','ssl','tls') DEFAULT NULL,
  `smtp_timeout` int(6) DEFAULT NULL,
  `how_to_send` tinyint(1) DEFAULT NULL,
  `sendmail` varchar(150) DEFAULT NULL,
  `id_charset` tinyint(4) DEFAULT '0',
  `content_type` tinyint(1) DEFAULT NULL,
  `number_days` tinyint(4) DEFAULT NULL,
  `make_limit_send` enum('yes','no') DEFAULT NULL,
  `re_send` enum('yes','no') DEFAULT NULL,
  `delete_subs` enum('yes','no') DEFAULT 'yes',
  `newsubscribernotify` enum('yes','no') DEFAULT 'yes',
  `request_reply` enum('yes','no') DEFAULT NULL,
  `email_reply` varchar(200) DEFAULT NULL,
  `show_unsubscribe_link` enum('yes','no') DEFAULT NULL,
  `subjecttextconfirm` varchar(255) DEFAULT NULL,
  `textconfirmation` text,
  `require_confirmation` enum('yes','no') DEFAULT 'no',
  `unsublink` text,
  `interval_type` enum('no','m','h','d') DEFAULT 'no',
  `interval_number` int(9) DEFAULT NULL,
  `limit_number` int(6) DEFAULT NULL,
  `precedence` enum('no','bulk','junk','list') DEFAULT 'bulk',
  `return_path` varchar(255) DEFAULT NULL,
  `sleep` int(6) DEFAULT NULL,
  `random` enum('no','yes') DEFAULT 'no',   
  `replacement_chars_body` enum('no','yes') DEFAULT 'no',  
  `replacement_chars_subject` enum('no','yes') DEFAULT 'no',  
  `add_dkim` enum('no','yes') DEFAULT 'no',
  `dkim_domain` varchar(255) DEFAULT NULL,
  `dkim_private` varchar(255) DEFAULT NULL,
  `dkim_selector` varchar(255) DEFAULT NULL,
  `dkim_passphrase` varchar(255) DEFAULT NULL,
  `dkim_identity` varchar(255) DEFAULT NULL,
  `remove_subscriber` ENUM('yes','no') NOT NULL DEFAULT 'no',
  `remove_subscriber_days` TINYINT NOT NULL DEFAULT 7
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%subscription` (
  `id_sub` int(9) NOT NULL AUTO_INCREMENT,
  `id_user` int(9) DEFAULT NULL,
  `id_cat` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_sub`),
  KEY `id_cat` (`id_cat`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%сustomheaders` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%template` (
  `id_template` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `body` mediumtext DEFAULT NULL,
  `prior` enum('1','2','3') NOT NULL DEFAULT '3',
  `pos` int(7) DEFAULT NULL,
  `id_cat` int(7) DEFAULT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id_template`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%prefix%users` (
  `id_user` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `status` enum('active','noactive') NOT NULL DEFAULT 'noactive',
  `time_send` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;