-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Окт 22 2016 г., 17:31
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
  `id_attachment` int(7) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `id_template` int(7) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_attach`
--

INSERT INTO `pnl_attach` (`id_attachment`, `name`, `path`, `id_template`) VALUES
(1, 'city_lightning.jpg', 'C:\\server\\htdocs\\site1.ru\\www\\phpnewsletter_5_0_0\\phpnewsletter\\attach\\201609251526200.jpg', 1),
(2, 'city_lightning_2.jpg', 'C:\\server\\htdocs\\site1.ru\\www\\phpnewsletter_5_0_0\\phpnewsletter\\attach\\201609251526201.jpg', 1),
(3, 'city_lightning_3.jpg', 'C:\\server\\htdocs\\site1.ru\\www\\phpnewsletter_5_0_0\\phpnewsletter\\attach\\201609251526202.jpg', 1),
(4, 'cloud_lining.jpg', 'C:\\server\\htdocs\\site1.ru\\www\\phpnewsletter_5_0_0\\phpnewsletter\\attach\\201609251526203.jpg', 1);

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
(1, 'admin', 'b59c67bf196a4758191e42f76670ceba', 'admin'),
(2, 'editor', 'b59c67bf196a4758191e42f76670ceba', 'editor');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_category`
--

CREATE TABLE `pnl_category` (
  `id_cat` int(9) NOT NULL,
  `name` varchar(200) DEFAULT NULL
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
  `charset` varchar(32) DEFAULT NULL
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
  `licensekey` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_licensekey`
--

INSERT INTO `pnl_licensekey` (`licensekey`) VALUES
('GH1321321414');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_log`
--

CREATE TABLE `pnl_log` (
  `id_log` int(9) NOT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_log`
--

INSERT INTO `pnl_log` (`id_log`, `time`) VALUES
(95, '2016-10-19 00:07:52'),
(96, '2016-10-19 00:08:24');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_process`
--

CREATE TABLE `pnl_process` (
  `id` int(10) NOT NULL,
  `process` enum('start','pause','stop') NOT NULL DEFAULT 'start',
  `id_user` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_process`
--

INSERT INTO `pnl_process` (`id`, `process`, `id_user`) VALUES
(1, 'stop', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_ready_send`
--

CREATE TABLE `pnl_ready_send` (
  `id_ready_send` int(10) NOT NULL,
  `id_user` int(9) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id_template` int(9) DEFAULT NULL,
  `success` enum('yes','no') DEFAULT NULL,
  `errormsg` text,
  `readmail` enum('yes','no') DEFAULT 'no',
  `time` datetime DEFAULT NULL,
  `id_log` int(9) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_ready_send`
--

INSERT INTO `pnl_ready_send` (`id_ready_send`, `id_user`, `email`, `id_template`, `success`, `errormsg`, `readmail`, `time`, `id_log`) VALUES
(9612, 6777, 'pligin103@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:07:53', 95),
(9613, 6778, 'shigabutdinov.1997@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:07:54', 95),
(9614, 6779, 'adromed100@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:07:55', 95),
(9615, 6780, 'vitya.sokolov.08@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:07:56', 95),
(9616, 6781, 'dr-saabik2013@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:00', 95),
(9617, 6782, 'vip-massagist@rambler.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:01', 95),
(9618, 6783, 'pligin104@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:02', 95),
(9619, 6784, 'romaniva221086@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:03', 95),
(9620, 6785, 'edelstar1812@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:04', 95),
(9621, 6786, 'syrel@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:05', 95),
(9622, 6787, 'w.s.0562@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:06', 95),
(9623, 6788, 'yarina8585@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:07', 95),
(9624, 6789, 'natali76146@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:08', 95),
(9625, 6790, 'alex2204@list.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:11', 95),
(9626, 6791, 'vovka132rus@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:12', 95),
(9627, 6792, 'azarin2015@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:13', 95),
(9628, 6793, 'firescorpions.2011@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:14', 95),
(9629, 6794, 'nourgouchev@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:15', 95),
(9630, 6795, 'alekc109@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:16', 95),
(9631, 6796, 'm.89144401139@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:17', 95),
(9632, 6797, 'galya111954@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:18', 95),
(9633, 6798, 'yan0292@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:19', 95),
(9634, 6799, 'zhasulan_umarov@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:20', 95),
(9635, 6800, 'kostromin_2016@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:21', 95),
(9636, 6801, 'ru.neptun@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:22', 95),
(9637, 6802, 'lev57.l7@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:23', 95),
(9638, 6803, '7480878@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:25', 96),
(9639, 6804, 'ptktysqrfgecnf@yandex.ua', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:26', 96),
(9640, 6805, 'vip.murzalev@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:27', 96),
(9641, 6806, 'den.selivanov@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:28', 96),
(9642, 6807, 'fart_71@list.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:29', 96),
(9643, 6808, 'men96@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:30', 96),
(9644, 6809, 'dgon34silver@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:31', 96),
(9645, 6810, 'aleks63960@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:32', 96),
(9646, 6811, 'mishanja.ru30@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:33', 96),
(9647, 6812, 'lexalysenko86@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:34', 96),
(9648, 6813, 'ev.popov.80@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:35', 96),
(9649, 6814, 'cool@ya.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:36', 96),
(9650, 6815, 'cergeiydin@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:37', 96),
(9651, 6816, 'tur-45@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:38', 96),
(9652, 6817, 'larisa.melnichuk2@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:39', 96),
(9653, 6818, 'saneiika@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:40', 96),
(9654, 6819, 'felix919@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:41', 96),
(9655, 6820, 'kirshov.2063@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:42', 96),
(9656, 6821, 'salam28891188@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:43', 96),
(9657, 6822, 'nik.burdin.86@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:44', 96),
(9658, 6823, 'alex2005vavilon@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:45', 96),
(9659, 6824, 'premium@inbox.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:46', 96),
(9660, 6825, 'regerat@inbox.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:47', 96),
(9661, 6826, 'n_romashov@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:48', 96),
(9662, 6827, 'dima6082006@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:49', 96),
(9663, 6828, 'rambler000707@meta.ua', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:50', 96),
(9664, 6829, 'cuksha@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:51', 96),
(9665, 6830, 'lolci2015@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:52', 96),
(9666, 6831, 'fursowjeny@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:53', 96),
(9667, 6832, 'prtoreza3876@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:54', 96),
(9668, 6833, 'majahed86@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:55', 96),
(9669, 6834, 'mc_dia@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:56', 96),
(9670, 6835, 'kochetova_elena@list.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:57', 96),
(9671, 6836, 'marisha.101@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:58', 96),
(9672, 6837, 'kolosha84@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:08:59', 96),
(9673, 6838, 'velikzhanin555@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:09:00', 96),
(9674, 6839, 'drujinin1999@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:09:01', 96),
(9675, 6840, 'litniy@mail.ua', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:09:02', 96),
(9676, 6841, 'gew7325@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:09:03', 96),
(9677, 6842, 'denschikov.1997@gmail.com', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:09:04', 96),
(9678, 6843, 'anulik258@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:09:06', 96),
(9679, 6844, '58ai@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:09:07', 96),
(9680, 6845, 'voynov.nike@yandex.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:09:08', 96),
(9681, 6846, 'introduction08@mail.ru', 1, 'no', 'Could not instantiate mail function.', 'no', '2016-10-19 00:09:09', 96);

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_settings`
--

CREATE TABLE `pnl_settings` (
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
('ru', 'http://site1.ru/phpnewsletter_5_0_alfa/', 'vasya-pupkin@my-domain.com', '', 'site1.ru', 'no', '', 'smtp.gmail.com', '', '', 25, 'no', 'no', 5, 1, '/usr/sbin/sendmail', 1, 2, 0, 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'Подписка на рассылку', 'Здравствуйте, %NAME%\r\n\r\nПолучение рассылки возможно после завершения этапа активации подписки. Чтобы активировать подписку, перейдите по следующей ссылке: %CONFIRM%\r\n\r\nЕсли Вы не производили подписку на данный email, просто проигнорируйте это письмо или перейдите по ссылке: %UNSUB%\r\n\r\nС уважением, \r\nадминистратор сайта %SERVER_NAME%', 'yes', 'Отписаться от рассылки: <a href=%UNSUB%>%UNSUB%</a>', 'no', 0, 100, 'bulk', '', 0, 'no', 'no', 'my-domain.com', '', 'phpnewsletter', 'password', '');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_subscription`
--

CREATE TABLE `pnl_subscription` (
  `id_sub` int(9) NOT NULL,
  `id_user` int(9) DEFAULT NULL,
  `id_cat` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_subscription`
--

INSERT INTO `pnl_subscription` (`id_sub`, `id_user`, `id_cat`) VALUES
(20332, 6777, 1),
(20333, 6777, 2),
(20334, 6777, 5),
(20335, 6778, 1),
(20336, 6778, 2),
(20337, 6778, 5),
(20338, 6779, 1),
(20339, 6779, 2),
(20340, 6779, 5),
(20341, 6780, 1),
(20342, 6780, 2),
(20343, 6780, 5),
(20344, 6781, 1),
(20345, 6781, 2),
(20346, 6781, 5),
(20347, 6782, 1),
(20348, 6782, 2),
(20349, 6782, 5),
(20350, 6783, 1),
(20351, 6783, 2),
(20352, 6783, 5),
(20353, 6784, 1),
(20354, 6784, 2),
(20355, 6784, 5),
(20356, 6785, 1),
(20357, 6785, 2),
(20358, 6785, 5),
(20359, 6786, 1),
(20360, 6786, 2),
(20361, 6786, 5),
(20362, 6787, 1),
(20363, 6787, 2),
(20364, 6787, 5),
(20365, 6788, 1),
(20366, 6788, 2),
(20367, 6788, 5),
(20368, 6789, 1),
(20369, 6789, 2),
(20370, 6789, 5),
(20371, 6790, 1),
(20372, 6790, 2),
(20373, 6790, 5),
(20374, 6791, 1),
(20375, 6791, 2),
(20376, 6791, 5),
(20377, 6792, 1),
(20378, 6792, 2),
(20379, 6792, 5),
(20380, 6793, 1),
(20381, 6793, 2),
(20382, 6793, 5),
(20383, 6794, 1),
(20384, 6794, 2),
(20385, 6794, 5),
(20386, 6795, 1),
(20387, 6795, 2),
(20388, 6795, 5),
(20389, 6796, 1),
(20390, 6796, 2),
(20391, 6796, 5),
(20392, 6797, 1),
(20393, 6797, 2),
(20394, 6797, 5),
(20395, 6798, 1),
(20396, 6798, 2),
(20397, 6798, 5),
(20398, 6799, 1),
(20399, 6799, 2),
(20400, 6799, 5),
(20401, 6800, 1),
(20402, 6800, 2),
(20403, 6800, 5),
(20404, 6801, 1),
(20405, 6801, 2),
(20406, 6801, 5),
(20407, 6802, 1),
(20408, 6802, 2),
(20409, 6802, 5),
(20410, 6803, 1),
(20411, 6803, 2),
(20412, 6803, 5),
(20413, 6804, 1),
(20414, 6804, 2),
(20415, 6804, 5),
(20416, 6805, 1),
(20417, 6805, 2),
(20418, 6805, 5),
(20419, 6806, 1),
(20420, 6806, 2),
(20421, 6806, 5),
(20422, 6807, 1),
(20423, 6807, 2),
(20424, 6807, 5),
(20425, 6808, 1),
(20426, 6808, 2),
(20427, 6808, 5),
(20428, 6809, 1),
(20429, 6809, 2),
(20430, 6809, 5),
(20431, 6810, 1),
(20432, 6810, 2),
(20433, 6810, 5),
(20434, 6811, 1),
(20435, 6811, 2),
(20436, 6811, 5),
(20437, 6812, 1),
(20438, 6812, 2),
(20439, 6812, 5),
(20440, 6813, 1),
(20441, 6813, 2),
(20442, 6813, 5),
(20443, 6814, 1),
(20444, 6814, 2),
(20445, 6814, 5),
(20446, 6815, 1),
(20447, 6815, 2),
(20448, 6815, 5),
(20449, 6816, 1),
(20450, 6816, 2),
(20451, 6816, 5),
(20452, 6817, 1),
(20453, 6817, 2),
(20454, 6817, 5),
(20455, 6818, 1),
(20456, 6818, 2),
(20457, 6818, 5),
(20458, 6819, 1),
(20459, 6819, 2),
(20460, 6819, 5),
(20461, 6820, 1),
(20462, 6820, 2),
(20463, 6820, 5),
(20464, 6821, 1),
(20465, 6821, 2),
(20466, 6821, 5),
(20467, 6822, 1),
(20468, 6822, 2),
(20469, 6822, 5),
(20470, 6823, 1),
(20471, 6823, 2),
(20472, 6823, 5),
(20473, 6824, 1),
(20474, 6824, 2),
(20475, 6824, 5),
(20476, 6825, 1),
(20477, 6825, 2),
(20478, 6825, 5),
(20479, 6826, 1),
(20480, 6826, 2),
(20481, 6826, 5),
(20482, 6827, 1),
(20483, 6827, 2),
(20484, 6827, 5),
(20485, 6828, 1),
(20486, 6828, 2),
(20487, 6828, 5),
(20488, 6829, 1),
(20489, 6829, 2),
(20490, 6829, 5),
(20491, 6830, 1),
(20492, 6830, 2),
(20493, 6830, 5),
(20494, 6831, 1),
(20495, 6831, 2),
(20496, 6831, 5),
(20497, 6832, 1),
(20498, 6832, 2),
(20499, 6832, 5),
(20500, 6833, 1),
(20501, 6833, 2),
(20502, 6833, 5),
(20503, 6834, 1),
(20504, 6834, 2),
(20505, 6834, 5),
(20506, 6835, 1),
(20507, 6835, 2),
(20508, 6835, 5),
(20509, 6836, 1),
(20510, 6836, 2),
(20511, 6836, 5),
(20512, 6837, 1),
(20513, 6837, 2),
(20514, 6837, 5),
(20515, 6838, 1),
(20516, 6838, 2),
(20517, 6838, 5),
(20518, 6839, 1),
(20519, 6839, 2),
(20520, 6839, 5),
(20521, 6840, 1),
(20522, 6840, 2),
(20523, 6840, 5),
(20524, 6841, 1),
(20525, 6841, 2),
(20526, 6841, 5),
(20527, 6842, 1),
(20528, 6842, 2),
(20529, 6842, 5),
(20530, 6843, 1),
(20531, 6843, 2),
(20532, 6843, 5),
(20533, 6844, 1),
(20534, 6844, 2),
(20535, 6844, 5),
(20536, 6845, 1),
(20537, 6845, 2),
(20538, 6845, 5),
(20539, 6846, 1),
(20540, 6846, 2),
(20541, 6846, 5),
(20542, 6847, 1),
(20543, 6847, 2),
(20544, 6847, 5),
(20545, 6848, 1),
(20546, 6848, 2),
(20547, 6848, 5),
(20548, 6849, 1),
(20549, 6849, 2),
(20550, 6849, 5),
(20551, 6850, 1),
(20552, 6850, 2),
(20553, 6850, 5),
(20554, 6851, 1),
(20555, 6851, 2),
(20556, 6851, 5),
(20557, 6852, 1),
(20558, 6852, 2),
(20559, 6852, 5),
(20560, 6853, 1),
(20561, 6853, 2),
(20562, 6853, 5),
(20563, 6854, 1),
(20564, 6854, 2),
(20565, 6854, 5),
(20566, 6855, 1),
(20567, 6855, 2),
(20568, 6855, 5),
(20569, 6856, 1),
(20570, 6856, 2),
(20571, 6856, 5),
(20572, 6857, 1),
(20573, 6857, 2),
(20574, 6857, 5),
(20575, 6858, 1),
(20576, 6858, 2),
(20577, 6858, 5),
(20578, 6859, 1),
(20579, 6859, 2),
(20580, 6859, 5),
(20581, 6860, 1),
(20582, 6860, 2),
(20583, 6860, 5),
(20584, 6861, 1),
(20585, 6861, 2),
(20586, 6861, 5),
(20587, 6862, 1),
(20588, 6862, 2),
(20589, 6862, 5),
(20590, 6863, 1),
(20591, 6863, 2),
(20592, 6863, 5),
(20593, 6864, 1),
(20594, 6864, 2),
(20595, 6864, 5),
(20596, 6865, 1),
(20597, 6865, 2),
(20598, 6865, 5),
(20599, 6866, 1),
(20600, 6866, 2),
(20601, 6866, 5),
(20602, 6867, 1),
(20603, 6867, 2),
(20604, 6867, 5),
(20605, 6868, 1),
(20606, 6868, 2),
(20607, 6868, 5),
(20608, 6869, 1),
(20609, 6869, 2),
(20610, 6869, 5),
(20611, 6870, 1),
(20612, 6870, 2),
(20613, 6870, 5),
(20614, 6871, 1),
(20615, 6871, 2),
(20616, 6871, 5),
(20617, 6872, 1),
(20618, 6872, 2),
(20619, 6872, 5),
(20620, 6873, 1),
(20621, 6873, 2),
(20622, 6873, 5),
(20623, 6874, 1),
(20624, 6874, 2),
(20625, 6874, 5),
(20626, 6875, 1),
(20627, 6875, 2),
(20628, 6875, 5),
(20629, 6876, 1),
(20630, 6876, 2),
(20631, 6876, 5),
(20632, 6877, 1),
(20633, 6877, 2),
(20634, 6877, 5),
(20635, 6878, 1),
(20636, 6878, 2),
(20637, 6878, 5),
(20638, 6879, 1),
(20639, 6879, 2),
(20640, 6879, 5),
(20641, 6880, 1),
(20642, 6880, 2),
(20643, 6880, 5),
(20644, 6881, 1),
(20645, 6881, 2),
(20646, 6881, 5),
(20647, 6882, 1),
(20648, 6882, 2),
(20649, 6882, 5),
(20650, 6883, 1),
(20651, 6883, 2),
(20652, 6883, 5),
(20653, 6884, 1),
(20654, 6884, 2),
(20655, 6884, 5),
(20656, 6885, 1),
(20657, 6885, 2),
(20658, 6885, 5),
(20659, 6886, 1),
(20660, 6886, 2),
(20661, 6886, 5),
(20662, 6887, 1),
(20663, 6887, 2),
(20664, 6887, 5),
(20665, 6888, 1),
(20666, 6888, 2),
(20667, 6888, 5),
(20668, 6889, 1),
(20669, 6889, 2),
(20670, 6889, 5),
(20671, 6890, 1),
(20672, 6890, 2),
(20673, 6890, 5),
(20674, 6891, 1),
(20675, 6891, 2),
(20676, 6891, 5),
(20677, 6892, 1),
(20678, 6892, 2),
(20679, 6892, 5),
(20680, 6893, 1),
(20681, 6893, 2),
(20682, 6893, 5),
(20683, 6894, 1),
(20684, 6894, 2),
(20685, 6894, 5),
(20686, 6895, 1),
(20687, 6895, 2),
(20688, 6895, 5),
(20689, 6896, 1),
(20690, 6896, 2),
(20691, 6896, 5),
(20692, 6897, 1),
(20693, 6897, 2),
(20694, 6897, 5),
(20695, 6898, 1),
(20696, 6898, 2),
(20697, 6898, 5),
(20698, 6899, 1),
(20699, 6899, 2),
(20700, 6899, 5),
(20701, 6900, 1),
(20702, 6900, 2),
(20703, 6900, 5),
(20704, 6901, 1),
(20705, 6901, 2),
(20706, 6901, 5),
(20707, 6902, 1),
(20708, 6902, 2),
(20709, 6902, 5),
(20710, 6903, 1),
(20711, 6903, 2),
(20712, 6903, 5),
(20713, 6904, 1),
(20714, 6904, 2),
(20715, 6904, 5),
(20716, 6905, 1),
(20717, 6905, 2),
(20718, 6905, 5),
(20719, 6906, 1),
(20720, 6906, 2),
(20721, 6906, 5),
(20722, 6907, 1),
(20723, 6907, 2),
(20724, 6907, 5),
(20725, 6908, 1),
(20726, 6908, 2),
(20727, 6908, 5),
(20728, 6909, 1),
(20729, 6909, 2),
(20730, 6909, 5),
(20731, 6910, 1),
(20732, 6910, 2),
(20733, 6910, 5),
(20734, 6911, 1),
(20735, 6911, 2),
(20736, 6911, 5),
(20737, 6912, 1),
(20738, 6912, 2),
(20739, 6912, 5),
(20740, 6913, 1),
(20741, 6913, 2),
(20742, 6913, 5),
(20743, 6914, 1),
(20744, 6914, 2),
(20745, 6914, 5),
(20746, 6915, 1),
(20747, 6915, 2),
(20748, 6915, 5),
(20749, 6916, 1),
(20750, 6916, 2),
(20751, 6916, 5),
(20752, 6917, 1),
(20753, 6917, 2),
(20754, 6917, 5),
(20755, 6918, 1),
(20756, 6918, 2),
(20757, 6918, 5),
(20758, 6919, 1),
(20759, 6919, 2),
(20760, 6919, 5),
(20761, 6920, 1),
(20762, 6920, 2),
(20763, 6920, 5),
(20764, 6921, 1),
(20765, 6921, 2),
(20766, 6921, 5),
(20767, 6922, 1),
(20768, 6922, 2),
(20769, 6922, 5),
(20770, 6923, 1),
(20771, 6923, 2),
(20772, 6923, 5),
(20773, 6924, 1),
(20774, 6924, 2),
(20775, 6924, 5),
(20776, 6925, 1),
(20777, 6925, 2),
(20778, 6925, 5),
(20779, 6926, 1),
(20780, 6926, 2),
(20781, 6926, 5),
(20782, 6927, 1),
(20783, 6927, 2),
(20784, 6927, 5),
(20785, 6928, 1),
(20786, 6928, 2),
(20787, 6928, 5),
(20788, 6929, 1),
(20789, 6929, 2),
(20790, 6929, 5),
(20791, 6930, 1),
(20792, 6930, 2),
(20793, 6930, 5),
(20794, 6931, 1),
(20795, 6931, 2),
(20796, 6931, 5),
(20797, 6932, 1),
(20798, 6932, 2),
(20799, 6932, 5),
(20800, 6933, 1),
(20801, 6933, 2),
(20802, 6933, 5),
(20803, 6934, 1),
(20804, 6934, 2),
(20805, 6934, 5),
(20806, 6935, 1),
(20807, 6935, 2),
(20808, 6935, 5),
(20809, 6936, 1),
(20810, 6936, 2),
(20811, 6936, 5),
(20812, 6937, 1),
(20813, 6937, 2),
(20814, 6937, 5),
(20815, 6938, 1),
(20816, 6938, 2),
(20817, 6938, 5),
(20818, 6939, 1),
(20819, 6939, 2),
(20820, 6939, 5),
(20821, 6940, 1),
(20822, 6940, 2),
(20823, 6940, 5),
(20824, 6941, 1),
(20825, 6941, 2),
(20826, 6941, 5),
(20827, 6942, 1),
(20828, 6942, 2),
(20829, 6942, 5),
(20830, 6943, 1),
(20831, 6943, 2),
(20832, 6943, 5),
(20833, 6944, 1),
(20834, 6944, 2),
(20835, 6944, 5),
(20836, 6945, 1),
(20837, 6945, 2),
(20838, 6945, 5),
(20839, 6946, 1),
(20840, 6946, 2),
(20841, 6946, 5),
(20842, 6947, 1),
(20843, 6947, 2),
(20844, 6947, 5),
(20845, 6948, 1),
(20846, 6948, 2),
(20847, 6948, 5),
(20848, 6949, 1),
(20849, 6949, 2),
(20850, 6949, 5),
(20851, 6950, 1),
(20852, 6950, 2),
(20853, 6950, 5),
(20854, 6951, 1),
(20855, 6951, 2),
(20856, 6951, 5),
(20857, 6952, 1),
(20858, 6952, 2),
(20859, 6952, 5),
(20860, 6953, 1),
(20861, 6953, 2),
(20862, 6953, 5),
(20863, 6954, 1),
(20864, 6954, 2),
(20865, 6954, 5),
(20866, 6955, 1),
(20867, 6955, 2),
(20868, 6955, 5),
(20869, 6956, 1),
(20870, 6956, 2),
(20871, 6956, 5),
(20872, 6957, 1),
(20873, 6957, 2),
(20874, 6957, 5),
(20875, 6958, 1),
(20876, 6958, 2),
(20877, 6958, 5),
(20878, 6959, 1),
(20879, 6959, 2),
(20880, 6959, 5),
(20881, 6960, 1),
(20882, 6960, 2),
(20883, 6960, 5),
(20884, 6961, 1),
(20885, 6961, 2),
(20886, 6961, 5),
(20887, 6962, 1),
(20888, 6962, 2),
(20889, 6962, 5),
(20890, 6963, 1),
(20891, 6963, 2),
(20892, 6963, 5),
(20893, 6964, 1),
(20894, 6964, 2),
(20895, 6964, 5),
(20896, 6965, 1),
(20897, 6965, 2),
(20898, 6965, 5),
(20899, 6966, 1),
(20900, 6966, 2),
(20901, 6966, 5),
(20902, 6967, 1),
(20903, 6967, 2),
(20904, 6967, 5),
(20905, 6968, 1),
(20906, 6968, 2),
(20907, 6968, 5),
(20908, 6969, 1),
(20909, 6969, 2),
(20910, 6969, 5),
(20911, 6970, 1),
(20912, 6970, 2),
(20913, 6970, 5),
(20914, 6971, 1),
(20915, 6971, 2),
(20916, 6971, 5),
(20917, 6972, 1),
(20918, 6972, 2),
(20919, 6972, 5),
(20920, 6973, 1),
(20921, 6973, 2),
(20922, 6973, 5),
(20923, 6974, 1),
(20924, 6974, 2),
(20925, 6974, 5),
(20926, 6975, 1),
(20927, 6975, 2),
(20928, 6975, 5),
(20929, 6976, 1),
(20930, 6976, 2),
(20931, 6976, 5),
(20932, 6977, 1),
(20933, 6977, 2),
(20934, 6977, 5),
(20935, 6978, 1),
(20936, 6978, 2),
(20937, 6978, 5),
(20938, 6979, 1),
(20939, 6979, 2),
(20940, 6979, 5),
(20941, 6980, 1),
(20942, 6980, 2),
(20943, 6980, 5),
(20944, 6981, 1),
(20945, 6981, 2),
(20946, 6981, 5),
(20947, 6982, 1),
(20948, 6982, 2),
(20949, 6982, 5),
(20950, 6983, 1),
(20951, 6983, 2),
(20952, 6983, 5),
(20953, 6984, 1),
(20954, 6984, 2),
(20955, 6984, 5),
(20956, 6985, 1),
(20957, 6985, 2),
(20958, 6985, 5),
(20959, 6986, 1),
(20960, 6986, 2),
(20961, 6986, 5),
(20962, 6987, 1),
(20963, 6987, 2),
(20964, 6987, 5),
(20965, 6988, 1),
(20966, 6988, 2),
(20967, 6988, 5),
(20968, 6989, 1),
(20969, 6989, 2),
(20970, 6989, 5),
(20971, 6990, 1),
(20972, 6990, 2),
(20973, 6990, 5),
(20974, 6991, 1),
(20975, 6991, 2),
(20976, 6991, 5),
(20977, 6992, 1),
(20978, 6992, 2),
(20979, 6992, 5),
(20980, 6993, 1),
(20981, 6993, 2),
(20982, 6993, 5),
(20983, 6994, 1),
(20984, 6994, 2),
(20985, 6994, 5),
(20986, 6995, 1),
(20987, 6995, 2),
(20988, 6995, 5),
(20989, 6996, 1),
(20990, 6996, 2),
(20991, 6996, 5),
(20992, 6997, 1),
(20993, 6997, 2),
(20994, 6997, 5),
(20995, 6998, 1),
(20996, 6998, 2),
(20997, 6998, 5),
(20998, 6999, 1),
(20999, 6999, 2),
(21000, 6999, 5),
(21001, 7000, 1),
(21002, 7000, 2),
(21003, 7000, 5),
(21004, 7001, 1),
(21005, 7001, 2),
(21006, 7001, 5),
(21007, 7002, 1),
(21008, 7002, 2),
(21009, 7002, 5),
(21010, 7003, 1),
(21011, 7003, 2),
(21012, 7003, 5),
(21013, 7004, 1),
(21014, 7004, 2),
(21015, 7004, 5),
(21016, 7005, 1),
(21017, 7005, 2),
(21018, 7005, 5),
(21019, 7006, 1),
(21020, 7006, 2),
(21021, 7006, 5),
(21022, 7007, 1),
(21023, 7007, 2),
(21024, 7007, 5),
(21025, 7008, 1),
(21026, 7008, 2),
(21027, 7008, 5),
(21028, 7009, 1),
(21029, 7009, 2),
(21030, 7009, 5),
(21031, 7010, 1),
(21032, 7010, 2),
(21033, 7010, 5),
(21034, 7011, 1),
(21035, 7011, 2),
(21036, 7011, 5),
(21037, 7012, 1),
(21038, 7012, 2),
(21039, 7012, 5),
(21040, 7013, 1),
(21041, 7013, 2),
(21042, 7013, 5),
(21043, 7014, 1),
(21044, 7014, 2),
(21045, 7014, 5),
(21046, 7015, 1),
(21047, 7015, 2),
(21048, 7015, 5),
(21049, 7016, 1),
(21050, 7016, 2),
(21051, 7016, 5),
(21052, 7017, 1),
(21053, 7017, 2),
(21054, 7017, 5),
(21055, 7018, 1),
(21056, 7018, 2),
(21057, 7018, 5),
(21058, 7019, 1),
(21059, 7019, 2),
(21060, 7019, 5),
(21061, 7020, 1),
(21062, 7020, 2),
(21063, 7020, 5),
(21064, 7021, 1),
(21065, 7021, 2),
(21066, 7021, 5),
(21067, 7022, 1),
(21068, 7022, 2),
(21069, 7022, 5),
(21070, 7023, 1),
(21071, 7023, 2),
(21072, 7023, 5),
(21073, 7024, 1),
(21074, 7024, 2),
(21075, 7024, 5),
(21076, 7025, 1),
(21077, 7025, 2),
(21078, 7025, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_template`
--

CREATE TABLE `pnl_template` (
  `id_template` int(9) NOT NULL,
  `name` varchar(200) NOT NULL,
  `body` mediumtext NOT NULL,
  `prior` enum('1','2','3') NOT NULL DEFAULT '3',
  `pos` int(7) NOT NULL,
  `id_cat` int(7) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_template`
--

INSERT INTO `pnl_template` (`id_template`, `name`, `body`, `prior`, `pos`, `id_cat`, `active`) VALUES
(1, 'шаблон 1', '<p>цйуцйуйцйц</p>', '3', 2, 0, 'yes'),
(2, 'тест 2', '<p>у3у32у</p>', '3', 1, 0, 'yes');

-- --------------------------------------------------------

--
-- Структура таблицы `pnl_users`
--

CREATE TABLE `pnl_users` (
  `id_user` int(7) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `status` enum('active','noactive') NOT NULL DEFAULT 'noactive',
  `time_send` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pnl_users`
--

INSERT INTO `pnl_users` (`id_user`, `name`, `email`, `ip`, `token`, `time`, `status`, `time_send`) VALUES
(6777, 'pligin', 'pligin103@gmail.com', NULL, '42eafa7c3137ea2bb17fb9247d6f2333', '2016-10-18 02:01:42', 'active', NULL),
(6778, 'Almazlorda', 'shigabutdinov.1997@mail.ru', NULL, '9ebf77e762fa7fc83db9ce8bce9751cc', '2016-10-18 02:01:42', 'active', NULL),
(6779, 'pastor', 'adromed100@mail.ru', NULL, '5acd11c657add2f6d1a9f739748e2b2a', '2016-10-18 02:01:42', 'active', NULL),
(6780, 'Kaneki', 'vitya.sokolov.08@mail.ru', NULL, 'b2c5eba59253d6bf5611f4588bcbff5a', '2016-10-18 02:01:42', 'active', NULL),
(6781, 'drsaabik', 'dr-saabik2013@yandex.ru', NULL, '2e9d7819533a46e5e1f4cb7b94d7b459', '2016-10-18 02:01:42', 'active', NULL),
(6782, 'Stalkerneo', 'vip-massagist@rambler.ru', NULL, '581dc5f59fc134d8b6ecc164772e6664', '2016-10-18 02:01:42', 'active', NULL),
(6783, 'pligin104', 'pligin104@gmail.com', NULL, 'cd4ff8cd7a943d89a2aac3bc1f1d7453', '2016-10-18 02:01:42', 'active', NULL),
(6784, 'valentina', 'romaniva221086@mail.ru', NULL, 'e84a62f844c52ad71821a8e6fe19a6e2', '2016-10-18 02:01:42', 'active', NULL),
(6785, 'amm1812', 'edelstar1812@gmail.com', NULL, '345541e6dfbf8cea6a7515a69f5f96d7', '2016-10-18 02:01:42', 'active', NULL),
(6786, 'syrel', 'syrel@yandex.ru', NULL, 'd8578d789bdaa7feefdd48cac1ed3d98', '2016-10-18 02:01:42', 'active', NULL),
(6787, 'stix62', 'w.s.0562@mail.ru', NULL, 'b625c5ceb77a175eda6ccbdbed9acc1f', '2016-10-18 02:01:42', 'active', NULL),
(6788, 'lissa2015', 'yarina8585@yandex.ru', NULL, 'ef727188b6f48f8f354fa5af38d39c75', '2016-10-18 02:01:42', 'active', NULL),
(6789, 'tahha', 'natali76146@gmail.com', NULL, '99e798555d628f9e4bc566862ecc29f8', '2016-10-18 02:01:42', 'active', NULL),
(6790, 'alex2204', 'alex2204@list.ru', NULL, '34b92a3ae543d2dda58b8d36315edbde', '2016-10-18 02:01:42', 'active', NULL),
(6791, 'vovkarus4', 'vovka132rus@mail.ru', NULL, 'c2414525cce73e4688fdaeadb12173f7', '2016-10-18 02:01:42', 'active', NULL),
(6792, 'azarin', 'azarin2015@gmail.com', NULL, 'ed9b758b32f6923692c3a2fada9f8fb3', '2016-10-18 02:01:42', 'active', NULL),
(6793, 'Iviro', 'firescorpions.2011@mail.ru', NULL, '34c4a3e446cea9ccceac54c57b179fc9', '2016-10-18 02:01:42', 'active', NULL),
(6794, 'muslim1977', 'nourgouchev@gmail.com', NULL, '85be327757eb566b467b7b7afd1b5f7d', '2016-10-18 02:01:42', 'active', NULL),
(6795, 'alekc107', 'alekc109@mail.ru', NULL, 'c3f14fe7fab39fcb21df3b57e212d157', '2016-10-18 02:01:42', 'active', NULL),
(6796, 'marina19', 'm.89144401139@yandex.ru', NULL, 'fc71acd337698daee6c8414fc55a8262', '2016-10-18 02:01:42', 'active', NULL),
(6797, 'galya11195', 'galya111954@mail.ru', NULL, '4b22819f763e4ea1757b2d5fe5b4ec68', '2016-10-18 02:01:42', 'active', NULL),
(6798, 'yan292', 'yan0292@mail.ru', NULL, '1d745371aa1ee8ae4c4c5a487fcb5337', '2016-10-18 02:01:42', 'active', NULL),
(6799, 'zhasik', 'zhasulan_umarov@mail.ru', NULL, '4b6689b6c2e7bb8d8351ecf4286ee9f4', '2016-10-18 02:01:42', 'active', NULL),
(6800, 'kostromin', 'kostromin_2016@mail.ru', NULL, 'af48e64322cc4d9ccaceb23985ea1ec6', '2016-10-18 02:01:42', 'active', NULL),
(6801, 'vikus', 'ru.neptun@yandex.ru', NULL, 'b8f9a5b729963e5d57286cbee16cebb7', '2016-10-18 02:01:42', 'active', NULL),
(6802, 'lev57', 'lev57.l7@gmail.com', NULL, 'afecb5a5f98432eb8ce4adffe4f8f58e', '2016-10-18 02:01:42', 'active', NULL),
(6803, 'akrom94', '7480878@mail.ru', NULL, 'dedefcea226de5c9b31841ab9c9b9c5b', '2016-10-18 02:01:42', 'active', NULL),
(6804, 'naytul5', 'ptktysqrfgecnf@yandex.ua', NULL, 'bf9f9517e13a26593d299ac65316dc37', '2016-10-18 02:01:42', 'active', NULL),
(6805, 'jek1987', 'vip.murzalev@mail.ru', NULL, '58da112cb54229ba5b813127d77514fd', '2016-10-18 02:01:42', 'active', NULL),
(6806, 'bratva', 'den.selivanov@yandex.ru', NULL, 'e33a1c7584198ec6a6e3fe6115861a22', '2016-10-18 02:01:42', 'active', NULL),
(6807, 'sergik71', 'fart_71@list.ru', NULL, '96e3ae318cdcbc4c523ff8fec3895c36', '2016-10-18 02:01:42', 'active', NULL),
(6808, 'HaKyPuCb', 'men96@mail.ru', NULL, 'b9c53854b8fe67c1fa2bcf176c161df2', '2016-10-18 02:01:42', 'active', NULL),
(6809, 'dgon134', 'dgon34silver@gmail.com', NULL, '9be6a7bb22ba1fd32a7b56646ee348fa', '2016-10-18 02:01:42', 'active', NULL),
(6810, 'trek63', 'aleks63960@gmail.com', NULL, '78d69e436b66d6e6611ff59924afb817', '2016-10-18 02:01:42', 'active', NULL),
(6811, 'mishanja30', 'mishanja.ru30@gmail.com', NULL, '7f38877bd7325f16492a73fc54beabec', '2016-10-18 02:01:42', 'active', NULL),
(6812, 'Aleks1704', 'lexalysenko86@mail.ru', NULL, '1cd5dddb967c3762d7be97119c68c864', '2016-10-18 02:01:42', 'active', NULL),
(6813, 'diman4ik', 'ev.popov.80@mail.ru', NULL, '4b36ea5c495461d2c22357ed816f594d', '2016-10-18 02:01:42', 'active', NULL),
(6814, 'coolcool', 'cool@ya.ru', NULL, '2de88379182292623d33bf1847d99939', '2016-10-18 02:01:42', 'active', NULL),
(6815, 'greycem', 'cergeiydin@gmail.com', NULL, 'b3e855b939c19835727f1cb458ae8b42', '2016-10-18 02:01:42', 'active', NULL),
(6816, 'Arturikus', 'tur-45@mail.ru', NULL, '382988822595a2c56d3c1e2be19c9a21', '2016-10-18 02:01:42', 'active', NULL),
(6817, 'larisa1810', 'larisa.melnichuk2@gmail.com', NULL, '87ca6d4d636a62c6ecdffb3a11f6f516', '2016-10-18 02:01:42', 'active', NULL),
(6818, 'saneiika', 'saneiika@mail.ru', NULL, 'f8183f4f9aefaa47691b3779ff366381', '2016-10-18 02:01:42', 'active', NULL),
(6819, 'At0m1983', 'felix919@mail.ru', NULL, 'af3ffb1441da47f62b6e9396eb86b9b1', '2016-10-18 02:01:42', 'active', NULL),
(6820, 'tony', 'kirshov.2063@mail.ru', NULL, 'cffc16d5813d8fd1a66f33b5ca51bb2d', '2016-10-18 02:01:42', 'active', NULL),
(6821, 'salam1999', 'salam28891188@yandex.ru', NULL, '2a3b1147e4bf6be7b4d783f2356f4163', '2016-10-18 02:01:42', 'active', NULL),
(6822, 'Kalanys', 'nik.burdin.86@mail.ru', NULL, 'fc5c8fae5e7b14f8c437295d274c7a5b', '2016-10-18 02:01:42', 'active', NULL),
(6823, 'vavilon', 'alex2005vavilon@mail.ru', NULL, '22c61f8f4d682c7cb88261b54fedb748', '2016-10-18 02:01:42', 'active', NULL),
(6824, 'Premium', 'premium@inbox.ru', NULL, '5a6799f6b181bcca2be3c79d433a774c', '2016-10-18 02:01:42', 'active', NULL),
(6825, 'Regerat', 'regerat@inbox.ru', NULL, '82f8137c35b86b298d542e7636662842', '2016-10-18 02:01:42', 'active', NULL),
(6826, 'artembox', 'n_romashov@mail.ru', NULL, '59f4a83dda2671ed4458e7935265e7ea', '2016-10-18 02:01:42', 'active', NULL),
(6827, 'money25', 'dima6082006@mail.ru', NULL, 'e8ebaa646cc844d7db19453c1e99692f', '2016-10-18 02:01:42', 'active', NULL),
(6828, 'rambler707', 'rambler000707@meta.ua', NULL, '32bbdd8a355ca96c455178673c45f447', '2016-10-18 02:01:42', 'active', NULL),
(6829, 'Yaruna', 'cuksha@mail.ru', NULL, 'cf43f8761c1ff6b527b299cebd268c7f', '2016-10-18 02:01:42', 'active', NULL),
(6830, 'artemy1357', 'lolci2015@yandex.ru', NULL, '9c1f4ecc489f671513421cdfcad32be7', '2016-10-18 02:01:42', 'active', NULL),
(6831, 'jenyka98', 'fursowjeny@gmail.com', NULL, 'dbdfc5df236cb331ee518467da77d21d', '2016-10-18 02:01:42', 'active', NULL),
(6832, 'XthyjdfYY', 'prtoreza3876@gmail.com', NULL, '7c6dccc558d9e619a261536f25d1de64', '2016-10-18 02:01:42', 'active', NULL),
(6833, 'majahed', 'majahed86@gmail.com', NULL, '447c13c73b536191d38a46a1e8dd7ea3', '2016-10-18 02:01:42', 'active', NULL),
(6834, 'gorendo', 'mc_dia@mail.ru', NULL, 'f11c3423e811b11385dfb7a56237f5a4', '2016-10-18 02:01:42', 'active', NULL),
(6835, 'Ariana', 'kochetova_elena@list.ru', NULL, '717cb6566da37e375c121e17f96644c4', '2016-10-18 02:01:42', 'active', NULL),
(6836, 'valera2002', 'marisha.101@mail.ru', NULL, '745cc435ed4a146ba4ffefb8732a42d6', '2016-10-18 02:01:42', 'active', NULL),
(6837, 'anahana', 'kolosha84@mail.ru', NULL, '873cd2148de2aaaf1bdedf68dccd4ff8', '2016-10-18 02:01:42', 'active', NULL),
(6838, 'andrey7799', 'velikzhanin555@mail.ru', NULL, 'b1ac4effba989893c1c7e561cf16f113', '2016-10-18 02:01:42', 'active', NULL),
(6839, 'Druzhinin', 'drujinin1999@mail.ru', NULL, '426b987eba28cd595c586af693a8294f', '2016-10-18 02:01:42', 'active', NULL),
(6840, 'litniy', 'litniy@mail.ua', NULL, 'a17ebea94e56292ccf585bae2e5e33fc', '2016-10-18 02:01:42', 'active', NULL),
(6841, 'gew73', 'gew7325@yandex.ru', NULL, '8ea962f75a59ebbd1e19347a5795e7c7', '2016-10-18 02:01:42', 'active', NULL),
(6842, 'sasha', 'denschikov.1997@gmail.com', NULL, '6ce82fd94ee43953f9edffc257b452e2', '2016-10-18 02:01:42', 'active', NULL),
(6843, 'kolli', 'anulik258@mail.ru', NULL, '5e199f32a8aed175184d962e4aa18bea', '2016-10-18 02:01:42', 'active', NULL),
(6844, 'ortega58', '58ai@mail.ru', NULL, 'd4aa9a462e6161a6a84ac5a82ef384d6', '2016-10-18 02:01:42', 'active', NULL),
(6845, 'meoweezy', 'voynov.nike@yandex.ru', NULL, '8bfa33b1cafeee1b82c55e856a3a51fb', '2016-10-18 02:01:42', 'active', NULL),
(6846, 'Entertainm', 'introduction08@mail.ru', NULL, '42b9a387128ae3f11e9f16a4e3c4f73c', '2016-10-18 02:01:42', 'active', NULL),
(6847, 'norkina', 'jannet.2013@mail.ru', NULL, '3549e92a1735f2a4c24ed92321152a43', '2016-10-18 02:01:42', 'active', NULL),
(6848, 'volc', 'lisetsky.volodya@yandex.ru', NULL, '6ea9561644dae1978727de1bf35ccb5d', '2016-10-18 02:01:42', 'active', NULL),
(6849, 'anvik68', 'nazaret.sav@yandex.ru', NULL, 'd71ff8312a7d7bd2a1de187c57fd9a9a', '2016-10-18 02:01:42', 'active', NULL),
(6850, 'Yghu', 'alla-naum@bk.ru', NULL, '173cd93cf5be3a5edf2fc5bd723b8625', '2016-10-18 02:01:42', 'active', NULL),
(6851, 'ycnex365', 'axvanasi@rambler.ru', NULL, '681869bff7dbe7ed57efec62f53f46c8', '2016-10-18 02:01:42', 'active', NULL),
(6852, 'Drevniy', 'svarik04@gmail.com', NULL, '8b575dca3262f4b3532c1a34ba463df8', '2016-10-18 02:01:42', 'active', NULL),
(6853, 'bydka', 'bydka@inbox.ru', NULL, '7ed7947d271b2366f7bccdb2e996521d', '2016-10-18 02:01:42', 'active', NULL),
(6854, 'zastalingr', 'micha0000@bk.ru', NULL, 'd966762b268b861db9736a318e17b15e', '2016-10-18 02:01:42', 'active', NULL),
(6855, 'kapitalist', 'gurleva2@gmail.com', NULL, '7f66476a373b8cd1fdceb7ec8ecba367', '2016-10-18 02:01:42', 'active', NULL),
(6856, 'vova94', 'vova_polyakov_94@mail.ru', NULL, '83465549c7c3221555aca79cf98fa189', '2016-10-18 02:01:42', 'active', NULL),
(6857, 'denis272', 'denisoz30@yandex.ru', NULL, 'f3a6d77c3b75d1493cdeeeff91bedf99', '2016-10-18 02:01:42', 'active', NULL),
(6858, 'afvlgr', 'afvlgr@gmail.com', NULL, 'ecd39331dfb9cf7549d67ad6f7e64d1e', '2016-10-18 02:01:42', 'active', NULL),
(6859, 'bjhbiubu', 'dft@ru.ru', NULL, '1437f69de61f6ee573fdbfa167cde5ac', '2016-10-18 02:01:42', 'active', NULL),
(6860, 'vik1654', 'danilov.1954@bk.ru', NULL, '2cc614d1cfccd9f385524e223a31e2e8', '2016-10-18 02:01:42', 'active', NULL),
(6861, 'graf', 'andromeda76.76@mail.ru', NULL, '41e348b9bd479f26267a41ce4748f881', '2016-10-18 02:01:42', 'active', NULL),
(6862, 'pavel53', 'npg1982@mail.ru', NULL, '5f5f7b4e639b517ffd2c94bceba111d2', '2016-10-18 02:01:42', 'active', NULL),
(6863, 'tilimon', 'tolcheeev31@gmail.com', NULL, 'd345541e6dfbf8cea6a7515a69f5f96d', '2016-10-18 02:01:42', 'active', NULL),
(6864, 'nestea1981', 'nestea1981@yandex.ru', NULL, '342fd4826e28b56d2d7768fefbf9b921', '2016-10-18 02:01:42', 'active', NULL),
(6865, 'anastasia', 'asa-enga2007@bk.ru', NULL, 'af7d53a68375152817cc5ed11941ec8b', '2016-10-18 02:01:42', 'active', NULL),
(6866, 'malyshka99', 'malyshka990@yandex.ru', NULL, '1a89acd7b9da8b8cba3d93f9cb5f912a', '2016-10-18 02:01:42', 'active', NULL),
(6867, 'Tata50', 'tata8740@gmail.com', NULL, 'c473c764c3cd8c1f3f3584adc6749b1a', '2016-10-18 02:01:42', 'active', NULL),
(6868, 'inylka', 'inylka8686@mail.ru', NULL, 'abe1d5a231367d28f59da521b6d53665', '2016-10-18 02:01:42', 'active', NULL),
(6869, 'pegun', 'pegun@mail.ru', NULL, 'c961947a811554b33c6ddf769a16f28f', '2016-10-18 02:01:42', 'active', NULL),
(6870, 'Cleopatra', 'liidiado@gmail.com', NULL, 'd3ed366abe47ca8ffe94877e4caf4a11', '2016-10-18 02:01:42', 'active', NULL),
(6871, 'jaylandog', 'mclaren9486@gmail.com', NULL, '9b1b7d6b92b246f72ebe7bbfffacda5f', '2016-10-18 02:01:42', 'active', NULL),
(6872, 'angell1972', 'mva20012001@mail.ru', NULL, '426b26e64d5fc36c184915ac4cc4a775', '2016-10-18 02:01:42', 'active', NULL),
(6873, 'olsorocka', 'olsorocka2@yandex.ua', NULL, '2ad93334bbc8b575dca3262f4b3532c1', '2016-10-18 02:01:42', 'active', NULL),
(6874, 'svarg', 'hjratlleh@bk.ru', NULL, '51b299514593557a663cabb99f5968ca', '2016-10-18 02:01:42', 'active', NULL),
(6875, 'vaprik', 'vaprik1234@gmail.com', NULL, 'fef862b352339ff5914c278498f1c42c', '2016-10-18 02:01:42', 'active', NULL),
(6876, 'qwerty1234', 'bachurin.aleksey.1998@mail.ru', NULL, 'f266e8252ac158f5eac6bede3d42f78c', '2016-10-18 02:01:42', 'active', NULL),
(6877, 'helalex', 'hel-alex1@rambler.ru', NULL, '4d11ffc71acd337698daee6c8414fc55', '2016-10-18 02:01:42', 'active', NULL),
(6878, 'ivbok', 'ivbokov@yandex.ru', NULL, 'f53f46c8ec48aefdc9f5d2ad4712ad93', '2016-10-18 02:01:42', 'active', NULL),
(6879, 'andrei2201', 'andrei-savin@mail.ru', NULL, 'bcdeb59e34c4a3e446cea9ccceac54c5', '2016-10-18 02:01:42', 'active', NULL),
(6880, 'Nadia', 'vip.khokhlunova@mail.ru', NULL, '9fdaf973b6f8c112aafc3c7cf8b1f86e', '2016-10-18 02:01:42', 'active', NULL),
(6881, 'Vanusha', 'vip.ivanovivan2000@bk.ru', NULL, '57997849fd85c5f837d6e38b814bae91', '2016-10-18 02:01:42', 'active', NULL),
(6882, 'Motds', 'qiwi-bonus13@bk.ru', NULL, '8b48349ec4f8686ec7444d9f62c581dc', '2016-10-18 02:01:42', 'active', NULL),
(6883, 'Sarsen', 'sarsen_2002kz@mail.ru', NULL, 'a2b2c48fa2e671d3bb9d86f78a76cdca', '2016-10-18 02:01:42', 'active', NULL),
(6884, 'Guyver5', 'gaiver_123@mail.ru', NULL, 'd2dda58b8d36315edbde5358a6a4b954', '2016-10-18 02:01:42', 'active', NULL),
(6885, 'Locki', 'qwertyzzz1191@gmail.com', NULL, 'a9da4b5c33944524a1e31b65c19378ec', '2016-10-18 02:01:42', 'active', NULL),
(6886, 'voronez', 'natalja.sbitneva@yandex.ru', NULL, '9db3cdfe97acfd8e9a1a83e163a84ce1', '2016-10-18 02:01:42', 'active', NULL),
(6887, 'BUMBASTER', '375333255267@yandex.by', NULL, 'ea1757b2d5fe5b4ec68b2a4667787184', '2016-10-18 02:01:42', 'active', NULL),
(6888, 'aleksssand', 'aleksssandr84@qip.ru', NULL, 'f73c6bb47277354b243e2a16c81ff8ef', '2016-10-18 02:01:42', 'active', NULL),
(6889, 'leonn771', 'leonn771@rambler.ru', NULL, 'a898a3787ad7f1617c38ddda7a791491', '2016-10-18 02:01:42', 'active', NULL),
(6890, 'focsic', 'teteleotam-2015@yandex.ru', NULL, '7f3562fd85478fa49efd79c55af4e93c', '2016-10-18 02:01:42', 'active', NULL),
(6891, 'avz6784', 'avz6784@mail.ru', NULL, '63432124b2e6b2134447d4eca4d2428f', '2016-10-18 02:01:42', 'active', NULL),
(6892, 'Grusca', 'cat.gruc@mail.ru', NULL, '7c3e8a5e8b27ae61a9bdb92793ee742d', '2016-10-18 02:01:42', 'active', NULL),
(6893, 'plyuha', 'akrutkevich@bk.ru', NULL, '619aa48db83a4321a24a79f9f867f3d4', '2016-10-18 02:01:42', 'active', NULL),
(6894, 'niuman', 'amanbekov2000@inbox.ru', NULL, 'b351f89be2cf76cb5de79e12d3822d39', '2016-10-18 02:01:42', 'active', NULL),
(6895, 'niksims', 'niks.67@mail.ru', NULL, '8e621cae82edfc3a52f59e27a833ac31', '2016-10-18 02:01:42', 'active', NULL),
(6896, 'Arhangel87', 'arhangel987@mail.ru', NULL, '9e97738c32afdddd127ed354ebb35e9b', '2016-10-18 02:01:42', 'active', NULL),
(6897, 'viktor3001', 'viktor30011976@mail.ru', NULL, 'ddb6c1cca86aa19a82cd77fc37baeecf', '2016-10-18 02:01:42', 'active', NULL),
(6898, 'dtnth', 'krotenko.ira@mail.ru', NULL, 'd271b2366f7bccdb2e996521d8956793', '2016-10-18 02:01:42', 'active', NULL),
(6899, 'dken', 'd.v.1975@bk.ru', NULL, '22fc6a7dd6aaf3e8f2295f934f263d39', '2016-10-18 02:01:42', 'active', NULL),
(6900, 'fima111', 'kolyunia1985@gmail.com', NULL, 'd6f233343d4f324dd78f6a2e918d98a5', '2016-10-18 02:01:42', 'active', NULL),
(6901, 'staratel', 'almazov.yur@yandex.ru', NULL, '99cc4134c19d75f4d4d85a257e5a9d72', '2016-10-18 02:01:42', 'active', NULL),
(6902, 'inusik', '1979inusik@gmail.com', NULL, '622633ec766eec19ed1e79fba5e2837e', '2016-10-18 02:01:42', 'active', NULL),
(6903, 'Karr', 'nnmd@mail.ru', NULL, '8c129b374f8fca7854954e3694eeb51c', '2016-10-18 02:01:42', 'active', NULL),
(6904, 'Galateya21', 'irena.astra@mail.ru', NULL, 'd7af7dc53eff3c1f155bdba4396f246e', '2016-10-18 02:01:42', 'active', NULL),
(6905, 'ser77788', 'spentya@bk.ru', NULL, '433e5e733c7f9fb7b7226832cfd184af', '2016-10-18 02:01:42', 'active', NULL),
(6906, 'Anton35', 'sagittarius35.rus@yandex.ru', NULL, '9d6d59d59ff27ccdc599c88e2aee19d4', '2016-10-18 02:01:42', 'active', NULL),
(6907, 'w2mwwm', 'w2mwwm-vadim@yandex.ru', NULL, 'd2e965f9286aa9721af1e76e6379f98a', '2016-10-18 02:01:42', 'active', NULL),
(6908, 'anasta', 'nastya_motkova@mail.ru', NULL, 'd2327c1af637e1c8369157be5ef98c8b', '2016-10-18 02:01:42', 'active', NULL),
(6909, 'nik1989', 'nikolya.perov@mail.ru', NULL, '76c5e2512674855a27aa6da143244941', '2016-10-18 02:01:42', 'active', NULL),
(6910, 'khnuev94', 'khnuev94@mail.ru', NULL, '252bbab434f4dfc552aad98b4bcb9583', '2016-10-18 02:01:42', 'active', NULL),
(6911, 'stav52287', 'gil5555555@mail.ru', NULL, '87661182c11e13f66db93e531a334e53', '2016-10-18 02:01:42', 'active', NULL),
(6912, 'denayted', 'gs.aramis@gmail.com', NULL, 'a6232b5211614bd1e8bbbe72f9ed41b1', '2016-10-18 02:01:42', 'active', NULL),
(6913, 'Valerik78', '99949574418@mail.ru', NULL, 'c12e858dda82384f5e42949bd8fa736f', '2016-10-18 02:01:42', 'active', NULL),
(6914, 'alexbabak', 'alex_bmk@i.ua', NULL, '6b6e7fd5a959ad4aa9a462e6161a6a84', '2016-10-18 02:01:42', 'active', NULL),
(6915, 'vans03', 'pikinivan15@mail.ru', NULL, '452748e9da289bf16739adfe881649ac', '2016-10-18 02:01:42', 'active', NULL),
(6916, 'kirillyaka', 'kir.bond-8@mail.ru', NULL, '456f5ff9b7e6d35783b91d4e6495ccae', '2016-10-18 02:01:42', 'active', NULL),
(6917, 'Kolach', 'egrggg@ukr.net', NULL, 'ab2c81124e44ea732e14efd8f8486b21', '2016-10-18 02:01:42', 'active', NULL),
(6918, 'nata1507', 'n.litvishko2010@yandex.ru', NULL, 'cae99ad38e86235d9af68ff8d8136d9e', '2016-10-18 02:01:42', 'active', NULL),
(6919, 'Lada60', 'colncenadeya308@gmail.com', NULL, 'ffe72d74c1f93d46eeb2f83df5ff29e7', '2016-10-18 02:01:42', 'active', NULL),
(6920, 'denis2203', 'denis22031986@mail.ru', NULL, 'c334b3d13c426d41ea61318ac73eea67', '2016-10-18 02:01:42', 'active', NULL),
(6921, 'IN97', 'dimadamow@mail.ru', NULL, '64a3bad663bd8f29bd71ff8312a7d7bd', '2016-10-18 02:01:42', 'active', NULL),
(6922, 'candela', 'zueva_nig@mail.ru', NULL, 'df9163befb2b69521476ca33d48b3f1b', '2016-10-18 02:01:42', 'active', NULL),
(6923, 'ribka', 'ya.ty.1987@mail.ru', NULL, '159ee5515d8d845b68334268f178fb65', '2016-10-18 02:01:42', 'active', NULL),
(6924, 'Alogaki', 'ermolaeva92@rambler.ru', NULL, '2621a737edb3b74e6ceedc5e5e82c434', '2016-10-18 02:01:42', 'active', NULL),
(6925, 'asdsasad', 'asdsaasas@yandex.ru', NULL, 'da49213e72745c46bc6a131e58e8ff44', '2016-10-18 02:01:42', 'active', NULL),
(6926, 'desantura', 'e1e2e4e5e6@yandex.ru', NULL, '4b8477ed2d7e8176c88967e5275fa915', '2016-10-18 02:01:42', 'active', NULL),
(6927, 'turist', '89539497754@yandex.ru', NULL, 'a2918e4131bb1e23191467a1f7752395', '2016-10-18 02:01:42', 'active', NULL),
(6928, 'vavan79', 'stil.retro.x@gmail.com', NULL, 'abdc4af5c4ff1e5e261bd2776eab8129', '2016-10-18 02:01:42', 'active', NULL),
(6929, 'rezeda79', 'rezeda.ayupova@mail.ru', NULL, '65a4a441a2c7993f32eca7f7c1c1ab63', '2016-10-18 02:01:42', 'active', NULL),
(6930, 'Shatenka25', 'shatenka2835@yandex.ua', NULL, '3fb5b96342f52fae25faa71d96813a6a', '2016-10-18 02:01:42', 'active', NULL),
(6931, 'boypower', 'holesterine@bk.ru', NULL, '41c5e4cd192f675d2a62e9ad11394777', '2016-10-18 02:01:42', 'active', NULL),
(6932, 'Mistral', 'jeki.su@yandex.ru', NULL, 'd41b1e1c49e8a88fb749a9d5facacdc8', '2016-10-18 02:01:42', 'active', NULL),
(6933, 'mixa2000', 'mixa-zaliv@yandex.ru', NULL, '6b653c6acaf7482b321dbaad6e545fce', '2016-10-18 02:01:42', 'active', NULL),
(6934, 'Sokol8748', 'sokol8748@bk.ru', NULL, '483274bfe687a87c2d9c4daf8bf1ef46', '2016-10-18 02:01:42', 'active', NULL),
(6935, 'NATALIYA29', 'super.nataliea2015@yandex.ru', NULL, '83eee6a5811ea73d2bbe45a5f1aca9c7', '2016-10-18 02:01:42', 'active', NULL),
(6936, '123qwe', 'ortiqn9@umail.uz', NULL, 'e75ecbb618e95d1865c8c1758ac513d6', '2016-10-18 02:01:42', 'active', NULL),
(6937, 'zuzu71152', 'abz@bigmir.net', NULL, 'ee2e3b72bbbbdae43e9de682d6623b18', '2016-10-18 02:01:42', 'active', NULL),
(6938, 'winner5432', 'iwan.solow2001@yandex.ru', NULL, 'df52171dcff297569efa5446f81929ba', '2016-10-18 02:01:42', 'active', NULL),
(6939, 'ValleRa007', 'www.valera.nn@mail.ru', NULL, '8174b31a16fa67ddfed8dc8538e8efad', '2016-10-18 02:01:42', 'active', NULL),
(6940, 'amail', 'amail.2014@list.ru', NULL, '3d8fd1a66f33b5ca51bb2dbabcf5f742', '2016-10-18 02:01:42', 'active', NULL),
(6941, 'WERBA', 'valyusha.markov@bk.ru', NULL, '949bd8fa736f447782563d868c2b71c1', '2016-10-18 02:01:42', 'active', NULL),
(6942, 'poazon', 'poazon@hot.ee', NULL, 'a3192b8e28c4f5c169f8917331839832', '2016-10-18 02:01:42', 'active', NULL),
(6943, 'flora', 'flora-04@mail.ru', NULL, '18c64c97af121decf55363fcc64628a4', '2016-10-18 02:01:42', 'active', NULL),
(6944, 'Escaperwin', 'escaperwin@mail.ru', NULL, 'f2f3175b4457fc28134bddd34c7c8639', '2016-10-18 02:01:42', 'active', NULL),
(6945, 'krottt', 'kuligin@email.su', NULL, '781f1eaf56938bc554d5ed9e1c92ffb9', '2016-10-18 02:01:42', 'active', NULL),
(6946, 'Shiyanova', 'alena.pirogova.2016@mail.ru', NULL, '15bc661f16dd6321e27a11a3564c2d41', '2016-10-18 02:01:42', 'active', NULL),
(6947, 'ksyunya03', 'www.ksyunya.ru@mail.ru', NULL, '9279bc6fc5283a8c911e25a6aee74ab8', '2016-10-18 02:01:42', 'active', NULL),
(6948, 'GhostMSK', 'mr.123asd321@mail.ru', NULL, '4e75d91b2f51886ad3e277ec2414525c', '2016-10-18 02:01:42', 'active', NULL),
(6949, 'Svetik31', 'svetlanazelenko6@gmail.com', NULL, 'e163a84ce1ab32d44a417316aadf38bf', '2016-10-18 02:01:42', 'active', NULL),
(6950, 'comradx94', 'comradx1994@yandex.ru', NULL, '1c98bc4d8d331bcf99e483d61b77bf2c', '2016-10-18 02:01:42', 'active', NULL),
(6951, 'olan', 'andrej60@yandex.ru', NULL, 'f194ff211f6839eeed211696458b54b6', '2016-10-18 02:01:42', 'active', NULL),
(6952, 'Advocat198', 'antonoff.antonov-sergei@yandex.ru', NULL, '2bdf319874779cede7e729e36feb6f72', '2016-10-18 02:01:42', 'active', NULL),
(6953, 'serjxxp', 'serjxxp@yandex.ru', NULL, '357bc397a3a913aba92dc1eb1295a8f4', '2016-10-18 02:01:42', 'active', NULL),
(6954, 'Dimatrix', 'cddimon08080794@yandex.ru', NULL, '9b98caebb6e69268e9a8c1a6d2ba3293', '2016-10-18 02:01:42', 'active', NULL),
(6955, 'serega094', 'super.serega094@yandex.by', NULL, 'db1473333c15c866bc48bb29394bf83a', '2016-10-18 02:01:42', 'active', NULL),
(6956, 'nanupocuk', 'fisenko.tim@yandex.com', NULL, '78c1c983eb5fafb25bdddf3d83e625a2', '2016-10-18 02:01:42', 'active', NULL),
(6957, 'panteza', 'frolov.sergej79@mail.ru', NULL, '2ce8438a7f1145c9ab5816ed7c6c51c3', '2016-10-18 02:01:42', 'active', NULL),
(6958, 'Alexander', 'alehander1974@gmail.com', NULL, 'b89599ea3f5b2c255aed3af1b5167d5a', '2016-10-18 02:01:42', 'active', NULL),
(6959, 'Pavel123', 'pgorbachuk@inbox.ru', NULL, 'c3212bda6d9d93e21b24d2f968afb6dc', '2016-10-18 02:01:42', 'active', NULL),
(6960, 'UmkaBob', 'nikolaev.simf@mail.ru', NULL, '6edd724a2dd86a4eaab8f61db16ad364', '2016-10-18 02:01:42', 'active', NULL),
(6961, 'jupiteroff', '1alexandr68@mail.ru', NULL, 'c128c8f8c9d39d6ec6d74bd48fb18c25', '2016-10-18 02:01:42', 'active', NULL),
(6962, 'chingiz050', 'fgb2016@gmail.com', NULL, 'b24bb4a4ce295ac13645a898a3787ad7', '2016-10-18 02:01:42', 'active', NULL),
(6963, 'poyasopt', 'poyasopt@mail.ru', NULL, '7966fbbc218ffbcf49b4fb3cbd9185b1', '2016-10-18 02:01:42', 'active', NULL),
(6964, 'natalu113', 'natalu113@yandex.ru', NULL, 'add2f6d1a9f739748e2b2a1cf71b8656', '2016-10-18 02:01:42', 'active', NULL),
(6965, 'sena3', 'verautkina1957@mail.ru', NULL, '63442a9ef11fcb29b7b48b62641c1635', '2016-10-18 02:01:42', 'active', NULL),
(6966, 'vovant', 'vladimir_afanasev_2016@mail.ru', NULL, '276c848685c26121184fb2226c734246', '2016-10-18 02:01:42', 'active', NULL),
(6967, 'aleksandrn', 'aleksandrn2000@yandex.ru', NULL, '9a416c578e221781a1ba6dbfdad73ad1', '2016-10-18 02:01:42', 'active', NULL),
(6968, 'vlad43434', 'kingdomesiket@mail.ru', NULL, '99cc4134c19d75f4d4d85a257e5a9d72', '2016-10-18 02:01:42', 'active', NULL),
(6969, 'rybalov', 'sasharybalov@gmail.com', NULL, '3faa6232b5211614bd1e8bbbe72f9ed4', '2016-10-18 02:01:42', 'active', NULL),
(6970, 'redissskaa', 'redissskaaa@yahoo.com', NULL, '262bfbb3cc142c7dd48584971659dde9', '2016-10-18 02:01:42', 'active', NULL),
(6971, 'greedife', 'shamsetdinov.2002@yandex.ru', NULL, '651b572469c676c71d6539455ba55d5a', '2016-10-18 02:01:42', 'active', NULL),
(6972, 'rifat26', 'minnegulova1982@mail.ru', NULL, '662c828d32efcc7613bc7bd5c65d6a67', '2016-10-18 02:01:43', 'active', NULL),
(6973, 'Amel', 'ortus022@gmail.com', NULL, '2b7ea64c88f86e2b5c64dc3a435dea35', '2016-10-18 02:01:43', 'active', NULL),
(6974, 'salimnew', 'salimbenoun01@gmail.com', NULL, '467a1f7752395b7ab2dab265215a2cd4', '2016-10-18 02:01:43', 'active', NULL),
(6975, 'ybrbnf17', 'zasuxin.nickita2013@yandex.ru', NULL, '1445da99c34e978a4c5d6dee2d4df893', '2016-10-18 02:01:43', 'active', NULL),
(6976, 'ismailova', 'ismailova.1975@bk.ru', NULL, 'a142f8352d77e6778e31be34925bfe37', '2016-10-18 02:01:43', 'active', NULL),
(6977, '1948NIK', 'kutishevsky@gmail.com', NULL, '276dff8941a47424cfcbbdef727188b6', '2016-10-18 02:01:43', 'active', NULL),
(6978, 'vvs14', 'vvsklyarov@yandex.ru', NULL, 'e3e19c2898dce8d7b33d166b2ca3c371', '2016-10-18 02:01:43', 'active', NULL),
(6979, 'Nika84', 'ninaxristova84@gmail.com', NULL, '29c9f34522b778dc5bc88bf571b7e97a', '2016-10-18 02:01:43', 'active', NULL),
(6980, 'fainik12', 'super.cool-voevodin2014@yandex.ua', NULL, '18546bcec9a8b21f3ec892f2e471a852', '2016-10-18 02:01:43', 'active', NULL),
(6981, 'jktu', 'r27sx@yandex.ru', NULL, 'b56f897924d11ffc71acd337698daee6', '2016-10-18 02:01:43', 'active', NULL),
(6982, 'LevV', 'kenya_64@mail.ru', NULL, 'f736dc885c6742982d59f84f44a9da4b', '2016-10-18 02:01:43', 'active', NULL),
(6983, 'sumrak904', 'sumrak904@yandex.ru', NULL, 'b591d16e438d1717147c76a7f439caec', '2016-10-18 02:01:43', 'active', NULL),
(6984, 'vfrcbv2953', 'smagin2017@mail.ru', NULL, '6f65cf7775da8da7cd5175cf3686417c', '2016-10-18 02:01:43', 'active', NULL),
(6985, 'ferichita', 'marinov.mihail@mail.ru', NULL, '598d6eb64197e3ef2f26ecfad5d41aa3', '2016-10-18 02:01:43', 'active', NULL),
(6986, 'dan13', 'www.a.69@mail.ru', NULL, '953776683194dd71de3a2c883ab6116b', '2016-10-18 02:01:43', 'active', NULL),
(6987, 'Dimetr36', 'dimetr.zakharov@mail.ru', NULL, '898381975db7722fc6a7dd6aaf3e8f22', '2016-10-18 02:01:43', 'active', NULL),
(6988, 'skyimp8', 'tyui@bk.ru', NULL, 'c59c6e85e8a3d34329fb4a2a41647ff7', '2016-10-18 02:01:43', 'active', NULL),
(6989, 'penza201', 'penza201@list.ru', NULL, 'ffe79ffb5db1473333c15c866bc48bb2', '2016-10-18 02:01:43', 'active', NULL),
(6990, 'velsk', 'ylia123vel@yandex.ru', NULL, 'ad6394d333d81ca229e4cbed2c548c54', '2016-10-18 02:01:43', 'active', NULL),
(6991, 'babich71', 'babich71@mail.ru', NULL, '453e39ad7cf19881931d351c644fca1c', '2016-10-18 02:01:43', 'active', NULL),
(6992, 'lubov49', 'babalubaks@list.ru', NULL, 'a6799f6b181bcca2be3c79d433a774cd', '2016-10-18 02:01:43', 'active', NULL),
(6993, 'desw', 'tatyana.kalinina.1980@bk.ru', NULL, '2de56efac736c2ef93f6b6d14e3fd779', '2016-10-18 02:01:43', 'active', NULL),
(6994, 'begemot', 'vav.don@mail.ru', NULL, '69fe4ce8522234f3e56a1381df65c75e', '2016-10-18 02:01:43', 'active', NULL),
(6995, 'Lerik090', 'valera.rechkunov@yandex.ru', NULL, 'e614ef6671ca9426b987eba28cd595c5', '2016-10-18 02:01:43', 'active', NULL),
(6996, 'OlegE', 'erhovov@yandex.ru', NULL, 'cd13e16ac1b4bd3bdfa88b36c8ac1826', '2016-10-18 02:01:43', 'active', NULL),
(6997, 'xenia12345', 'xenia.vinogradova2013@yandex.ru', NULL, 'edbadfb6387e7a23af7728b9ef9e7545', '2016-10-18 02:01:43', 'active', NULL),
(6998, 'PENISY', 'nedogarok.olga@mail.ru', NULL, 'bc85abc8b984c7333ae9c453db726ff3', '2016-10-18 02:01:43', 'active', NULL),
(6999, 'wolf17', 'sir.nojckin@yandex.ru', NULL, 'c671141483a5b482916faa8dca7e8292', '2016-10-18 02:01:43', 'active', NULL),
(7000, 'dinessa30', 'dinessa30@yandex.ru', NULL, 'bde29d849b98caebb6e69268e9a8c1a6', '2016-10-18 02:01:43', 'active', NULL),
(7001, 'Konsta222', 'konsta1974@yandex.ru', NULL, '5bd89eab1d399dd54da7e1f1a6ed43eb', '2016-10-18 02:01:43', 'active', NULL),
(7002, 'akm88', 'ok88ok@bk.ru', NULL, 'b98beeaaf77a63272c67a588e63f629b', '2016-10-18 02:01:43', 'active', NULL),
(7003, 'olya1964', 'vasil1964as@gmail.com', NULL, '8834fa8b5a7358745cc435ed4a146ba4', '2016-10-18 02:01:43', 'active', NULL),
(7004, 'vivan', 'bp311214@yandex.ru', NULL, '79f81eebb4ba8e4518e2658f32587f59', '2016-10-18 02:01:43', 'active', NULL),
(7005, 'magichka', 'omanda87@yandex.ru', NULL, '68e15eb1f69a5e199f32a8aed175184d', '2016-10-18 02:01:43', 'active', NULL),
(7006, 'anakonda', 'sherhan1900@mail.ru', NULL, '424a4f89ab7bc63ea978c78617fcfd4a', '2016-10-18 02:01:43', 'active', NULL),
(7007, 'Nellyk', 'nelly_maracheva@mail.ru', NULL, 'c915e554e58443fe339221955ff85be3', '2016-10-18 02:01:43', 'active', NULL),
(7008, 'Andrei2015', 'rekunov.andrey@inbox.ru', NULL, 'cecfd7bdac956d4ece5c2db8f1d3b4b6', '2016-10-18 02:01:43', 'active', NULL),
(7009, 'lera05', 'nazarov-vano@mail.ru', NULL, '9c9aa2d12daaa95f59cfc952fcb69e75', '2016-10-18 02:01:43', 'active', NULL),
(7010, 'vovan65', 'vovan.65vs@gmail.com', NULL, '6ac5453e39ad7cf19881931d351c644f', '2016-10-18 02:01:43', 'active', NULL),
(7011, 'kyarginski', 'kyarginskiy@mail.ru', NULL, 'fd3d1fbe978324d5917d7e79b7adcb47', '2016-10-18 02:01:43', 'active', NULL),
(7012, 'aleks1987', 'cahekru_2011@mail.ru', NULL, 'e13ccfd6c432564445b8d992118b2499', '2016-10-18 02:01:43', 'active', NULL),
(7013, 'gt23', 'klicoleg1@yandex.ru', NULL, '79d2483b45b4582f13be4f249faedce4', '2016-10-18 02:01:43', 'active', NULL),
(7014, 'sashok1991', 'afalla-55@mail.ru', NULL, '793b5f4b22819f763e4ea1757b2d5fe5', '2016-10-18 02:01:43', 'active', NULL),
(7015, 'anatoliy22', 'fedorenko.anatoliy@inbox.ru', NULL, 'd5941575486a772a25d24a6748c739e7', '2016-10-18 02:01:43', 'active', NULL),
(7016, 'smirn59', 'smirn59@gmail.com', NULL, '6566da37e375c121e17f96644c4316cc', '2016-10-18 02:01:43', 'active', NULL),
(7017, 'Lezu', 'vordatunk@inbox.ru', NULL, '3656259b5e5a8ecaa9ec79f6e3d8a1e9', '2016-10-18 02:01:43', 'active', NULL),
(7018, 'hoho', 'gribson1974@mail.ru', NULL, '263f557f9f394e9e313cac2593f54ade', '2016-10-18 02:01:43', 'active', NULL),
(7019, 'Sergey16', 'snshambin@mail.ru', NULL, '25289545d2181e64a87cdf544221d3c3', '2016-10-18 02:01:43', 'active', NULL),
(7020, 'delain', 'delain1985@gmail.com', NULL, '3a435dea3518a136e888fa892e6e36a3', '2016-10-18 02:01:43', 'active', NULL),
(7021, 'batirim', 'batirjan_87@mail.ru', NULL, '611bb417bee3313a82228f3383736cac', '2016-10-18 02:01:43', 'active', NULL),
(7022, 'makschern', 'maks.tchernivsky@yandex.ru', NULL, 'ac2593f54ade935dd476dce325b85c82', '2016-10-18 02:01:43', 'active', NULL),
(7023, 'vetalkahd', 'vetal19880810@mail.ru', NULL, 'ac1ed3d98cbd53125ab62f12c5d5e576', '2016-10-18 02:01:43', 'active', NULL),
(7024, 'busy1958', 'busy1958@yandex.ru', NULL, 'b6fa4c1456de4f71b14ce53ca3d21725', '2016-10-18 02:01:43', 'active', NULL),
(7025, 'krik345', 'fermalord@mail.ru', NULL, '9534de6362d11312effecdf8db38dcef', '2016-10-18 02:01:43', 'active', NULL);

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
-- Индексы таблицы `pnl_process`
--
ALTER TABLE `pnl_process`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id_attachment` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `pnl_aut`
--
ALTER TABLE `pnl_aut`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `pnl_category`
--
ALTER TABLE `pnl_category`
  MODIFY `id_cat` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `pnl_charset`
--
ALTER TABLE `pnl_charset`
  MODIFY `id_charset` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT для таблицы `pnl_log`
--
ALTER TABLE `pnl_log`
  MODIFY `id_log` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT для таблицы `pnl_process`
--
ALTER TABLE `pnl_process`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `pnl_ready_send`
--
ALTER TABLE `pnl_ready_send`
  MODIFY `id_ready_send` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9682;
--
-- AUTO_INCREMENT для таблицы `pnl_subscription`
--
ALTER TABLE `pnl_subscription`
  MODIFY `id_sub` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21079;
--
-- AUTO_INCREMENT для таблицы `pnl_template`
--
ALTER TABLE `pnl_template`
  MODIFY `id_template` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `pnl_users`
--
ALTER TABLE `pnl_users`
  MODIFY `id_user` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7026;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
