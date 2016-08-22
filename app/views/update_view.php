<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

session_start();

// authorization
Auth::authorization();

$autInfo = Auth::getAutInfo($_SESSION['id']);

if (Pnl::CheckAccess($autInfo['role'], 'admin')) exit();

$update = new Update(core::getSetting('language'));
$newversion = $update->getVersion();
$currentversion = VERSION;

//require temlate class
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

//alert
if (isset($error)) {
	$tpl->assign('ERROR_ALERT', $error);
}
	
if (isset($success)){
	$tpl->assign('MSG_ALERT', $success);
}

$tpl->assign('TITLE_PAGE', core::getLanguage('title_page', 'update'));
$tpl->assign('TITLE', core::getLanguage('title', 'update'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'update'));

include_once core::pathTo('extra', 'top.php');

//menu
include_once core::pathTo('extra', 'menu.php');

//form
$tpl->assign('ACTION', $_SERVER['REQUEST_URI']);
$tpl->assign('STR_LICENSE_KEY', core::getLanguage('str', 'license_key'));
$tpl->assign('BUTTON_SAVE', core::getLanguage('button', 'save'));
$tpl->assign('STR_START_UPDATE', core::getLanguage('str', 'start_update'));

$tpl->assign('MSG_UPDATE_COMPLETED', core::getLanguage('msg', 'update_completed'));

//footer
include_once core::pathTo('extra', 'footer.php');

// display content
$tpl->display();