<?php

define('LETTER', TRUE);
define('SYS_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

require_once SYS_ROOT."bootstrap.php";
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
    echo '<p><a target="_blank" href="' .core::getLanguage('', '')["str"]["url_info"] . '">PHP Newsletter</a> | ';
    echo "<p>" . str_replace('%URL%', SYS_ROOT . 'install/',core::getLanguage('', '')["str"]["install_msg"]) . "</p>\n";
    echo "</body>\n";
    echo '</html>';

    exit();
}

Route::start();