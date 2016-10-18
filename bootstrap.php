<?php

/********************************************
 * PHP Newsletter 5.0.1 beta
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

//Error_Reporting(0); // set error reporting level
define("DEBUG", 0);
define('VERSION', '5.0.1');

$cmspaths = array(
    'core' => 'sys/core',
    'engine' => 'sys/engine', // Engines AUTOLOAD folder
    'attach' => 'attach', // attachment
    'config' => 'config', // Config
    'templates' => 'templates', // templates
    'libs' => 'vendor', // libraries
    'controllers' => 'app/controllers', // controllers
    'models' => 'app/models',
    'views' => 'app/views',
	'extra' => 'app/snippets',
	'tmp' => 'tmp'
);

require_once SYS_ROOT . $cmspaths['config'] . '/config_db.php';
require_once SYS_ROOT . $cmspaths['core'] . '/core.php';
core::init($cmspaths);
core::$db = new DB($ConfigDB);
core::$session = new Session();

// get settings
if (!is_array(core::getSetting())) {
    $query = "SELECT * FROM " . core::database()->getTableName('settings');
    $result = core::database()->querySQL($query);
    core::addSetting(core::database()->getRow($result));
}

// get language
$lang_file = core::pathTo('templates', 'language/');
$lang_file .= ((core::getSetting("language")) ? core::getSetting("language") . ".php" : "en.php");

if (file_exists($lang_file)) {
    include $lang_file;
    core::addLanguage($language);
} else {
    exit('ERROR: Language file can not load!');
}

core::setTemplate("assets/");