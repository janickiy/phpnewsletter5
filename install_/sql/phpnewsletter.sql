CREATE TABLE `%prefix%attach` (
  `id_attachment` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `id_template` int(9) NOT NULL,
  PRIMARY KEY (`id_attachment`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%aut` (
  `id` int(9) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','moderator','editor') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%category` (
  `id_cat` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%charset` (
  `id_charset` int(5) NOT NULL AUTO_INCREMENT,
  `charset` varchar(32) NOT NULL,
  PRIMARY KEY (`id_charset`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%licensekey` (
  `licensekey` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%log` (
  `id_log` int(9) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_log`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%process` (
  `process` enum('start','pause','stop') NOT NULL DEFAULT 'start'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%ready_send` (
  `id_ready_send` int(10) NOT NULL AUTO_INCREMENT,
  `id_user` int(9) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_template` int(9) NOT NULL,
  `success` enum('yes','no') NOT NULL,
  `errormsg` text NOT NULL,
  `readmail` enum('yes','no') NOT NULL DEFAULT 'no',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_log` int(9) NOT NULL,
  PRIMARY KEY (`id_ready_send`),
  KEY `id_user` (`id_user`),
  KEY `id_send` (`id_template`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%settings` (
  `language` varchar(10) DEFAULT NULL,
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
  `add_dkim` enum('no','yes') DEFAULT 'no',
  `dkim_domain` varchar(255) DEFAULT NULL,
  `dkim_private` varchar(255) DEFAULT NULL,
  `dkim_selector` varchar(255) DEFAULT NULL,
  `dkim_passphrase` varchar(255) DEFAULT NULL,
  `dkim_identity` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%subscription` (
  `id_sub` int(9) NOT NULL AUTO_INCREMENT,
  `id_user` int(9) NOT NULL,
  `id_cat` int(9) NOT NULL,
  PRIMARY KEY (`id_sub`),
  KEY `id_cat` (`id_cat`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%template` (
  `id_template` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `prior` enum('1','2','3') NOT NULL DEFAULT '3',
  `pos` int(9) NOT NULL,
  `id_cat` int(9) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id_template`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `%prefix%users` (
  `id_user` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `token` varchar(64) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('active','noactive') NOT NULL DEFAULT 'noactive',
  `time_send` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;