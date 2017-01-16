<?php

/********************************************
 * PHP Newsletter 5.0.6
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

define('LETTER', TRUE);
define('SYS_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

require_once SYS_ROOT . "bootstrap.php";
require_once core::pathTo('core', 'route.php');

// check install
if (is_file(SYS_ROOT . $cmspaths['config'] . '/config_db.php') && is_dir(SYS_ROOT . "install")) {
    header("Content-type: text/html; charset=utf-8");

    echo "<!DOCTYPE html>\n";
    echo "<html>\n";
    echo "<head>\n";
    echo "<title>PHP Newsletter " . VERSION . "</title>\n";
    echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
    echo "<style type=\"text/css\">\n";
    echo 'p, li {font-family: Arial; font-size: 11px;color: black;}';
    echo "</style>\n";
    echo "</head>\n";
    echo "<body>\n";
    echo '<p><a target="_blank" href="' . core::getLanguage('str', 'url_info') . '">PHP Newsletter</a> | ';
    echo "<p>" . str_replace('%URL%', "http://" . $_SERVER["SERVER_NAME"] . Pnl::root(). "install", core::getLanguage('str', 'install_msg')) . "</p>\n";
    echo "</body>\n";
    echo '</html>';

    exit();
}

Route::start();