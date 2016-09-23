-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 23 2016 г., 12:51
-- Версия сервера: 10.1.13-MariaDB
-- Версия PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `phpnewsletter5`
--

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_attach`
--

CREATE TABLE `pnl_attach` (
  `id_attachment` int(9) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `id_template` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_aut`
--

CREATE TABLE `pnl_aut` (
  `id` int(9) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','moderator','editor') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_aut`
--

INSERT INTO `pnl_aut` (`id`, `login`, `password`, `role`) VALUES
(1, 'admin', 'b59c67bf196a4758191e42f76670ceba', 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_category`
--

CREATE TABLE `pnl_category` (
  `id_cat` int(9) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_category`
--

INSERT INTO `pnl_category` (`id_cat`, `name`) VALUES
(1, 'Категория 1'),
(2, 'Категория 2'),
(5, 'Категория 3');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_charset`
--

CREATE TABLE `pnl_charset` (
  `id_charset` int(5) NOT NULL,
  `charset` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_charset`
--

INSERT INTO `pnl_charset` (`id_charset`, `charset`) VALUES
(1, 'utf-8'),
(2, 'iso-8859-1'),
(3, 'iso-8859-2'),
(4, 'iso-8859-3'),
(5, 'iso-8859-4'),
(6, 'iso-8859-5'),
(7, 'iso-8859-6'),
(8, 'iso-8859-8'),
(9, 'iso-8859-7'),
(10, 'iso-8859-9'),
(11, 'iso-8859-10'),
(12, 'iso-8859-13'),
(13, 'iso-8859-14'),
(14, 'iso-8859-15'),
(15, 'iso-8859-16'),
(16, 'windows-1250'),
(17, 'windows-1251'),
(18, 'windows-1252'),
(19, 'windows-1253'),
(20, 'windows-1254'),
(21, 'windows-1255'),
(22, 'windows-1256'),
(23, 'windows-1257'),
(24, 'windows-1258'),
(25, 'gb2312'),
(26, 'big5'),
(27, 'iso-2022-jp'),
(28, 'ks_c_5601-1987'),
(29, 'euc-kr'),
(30, 'windows-874'),
(31, 'koi8-r'),
(32, 'koi8-u');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_licensekey`
--

CREATE TABLE `pnl_licensekey` (
  `licensekey` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_licensekey`
--

INSERT INTO `pnl_licensekey` (`licensekey`) VALUES
('DEMO');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_log`
--

CREATE TABLE `pnl_log` (
  `id_log` int(9) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_process`
--

CREATE TABLE `pnl_process` (
  `process` enum('start','pause','stop') NOT NULL DEFAULT 'start'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_process`
--

INSERT INTO `pnl_process` (`process`) VALUES
('stop');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_ready_send`
--

CREATE TABLE `pnl_ready_send` (
  `id_ready_send` int(10) NOT NULL,
  `id_user` int(9) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_template` int(9) NOT NULL,
  `success` enum('yes','no') NOT NULL,
  `errormsg` text NOT NULL,
  `readmail` enum('yes','no') NOT NULL DEFAULT 'no',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_log` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_settings`
--

CREATE TABLE `pnl_settings` (
  `language` varchar(10) DEFAULT NULL,
  `path` varchar(255) NOT NULL,
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

--
-- Дамп данных таблицы `pnl_settings`
--

INSERT INTO `pnl_settings` (`language`, `path`, `email`, `list_owner`, `email_name`, `show_email`, `organization`, `smtp_host`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_aut`, `smtp_secure`, `smtp_timeout`, `how_to_send`, `sendmail`, `id_charset`, `content_type`, `number_days`, `make_limit_send`, `re_send`, `delete_subs`, `newsubscribernotify`, `request_reply`, `email_reply`, `show_unsubscribe_link`, `subjecttextconfirm`, `textconfirmation`, `require_confirmation`, `unsublink`, `interval_type`, `interval_number`, `limit_number`, `precedence`, `return_path`, `sleep`, `random`, `add_dkim`, `dkim_domain`, `dkim_private`, `dkim_selector`, `dkim_passphrase`, `dkim_identity`) VALUES
('ru', '', 'vasya-pupkin@my-domain.com', 'uuu', 'my-domain.com', 'yes', '', 'smtp.gmail.com', '', '', 25, 'no', 'no', 5, 3, '/usr/sbin/sendmail', 1, 2, 0, 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'Подписка на рассылку', 'Здравствуйте, %NAME%\r\n\r\nПолучение рассылки возможно после завершения этапа активации подписки. Чтобы активировать подписку, перейдите по следующей ссылке: %CONFIRM%\r\n\r\nЕсли Вы не производили подписку на данный email, просто проигнорируйте это письмо или перейдите по ссылке: %UNSUB%\r\n\r\nС уважением, \r\nадминистратор сайта %SERVER_NAME%', 'yes', 'Отписаться от рассылки: <a href=%UNSUB%>%UNSUB%</a>', 'no', 0, 100, 'bulk', 'rrrr', 0, 'no', 'no', 'my-domain.com', '', 'phpnewsletter', 'password', '');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_subscription`
--

CREATE TABLE `pnl_subscription` (
  `id_sub` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `id_cat` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_template`
--

CREATE TABLE `pnl_template` (
  `id_template` int(9) NOT NULL,
  `name` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `prior` enum('1','2','3') NOT NULL DEFAULT '3',
  `pos` int(9) NOT NULL,
  `id_cat` int(9) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_users`
--

CREATE TABLE `pnl_users` (
  `id_user` int(7) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `token` varchar(64) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('active','noactive') NOT NULL DEFAULT 'noactive',
  `time_send` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `pnl_attach`
--
ALTER TABLE `pnl_attach`
  ADD PRIMARY KEY (`id_attachment`);

--
-- Индексы таблицы `pnl_aut`
--
ALTER TABLE `pnl_aut`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pnl_category`
--
ALTER TABLE `pnl_category`
  ADD PRIMARY KEY (`id_cat`);

--
-- Индексы таблицы `pnl_charset`
--
ALTER TABLE `pnl_charset`
  ADD PRIMARY KEY (`id_charset`);

--
-- Индексы таблицы `pnl_log`
--
ALTER TABLE `pnl_log`
  ADD PRIMARY KEY (`id_log`);

--
-- Индексы таблицы `pnl_ready_send`
--
ALTER TABLE `pnl_ready_send`
  ADD PRIMARY KEY (`id_ready_send`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_send` (`id_template`);

--
-- Индексы таблицы `pnl_subscription`
--
ALTER TABLE `pnl_subscription`
  ADD PRIMARY KEY (`id_sub`),
  ADD KEY `id_cat` (`id_cat`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `pnl_template`
--
ALTER TABLE `pnl_template`
  ADD PRIMARY KEY (`id_template`);

--
-- Индексы таблицы `pnl_users`
--
ALTER TABLE `pnl_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pnl_attach`
--
ALTER TABLE `pnl_attach`
  MODIFY `id_attachment` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pnl_aut`
--
ALTER TABLE `pnl_aut`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `pnl_category`
--
ALTER TABLE `pnl_category`
  MODIFY `id_cat` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `pnl_charset`
--
ALTER TABLE `pnl_charset`
  MODIFY `id_charset` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT для таблицы `pnl_log`
--
ALTER TABLE `pnl_log`
  MODIFY `id_log` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pnl_ready_send`
--
ALTER TABLE `pnl_ready_send`
  MODIFY `id_ready_send` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pnl_subscription`
--
ALTER TABLE `pnl_subscription`
  MODIFY `id_sub` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pnl_template`
--
ALTER TABLE `pnl_template`
  MODIFY `id_template` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pnl_users`
--
ALTER TABLE `pnl_users`
  MODIFY `id_user` int(7) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
