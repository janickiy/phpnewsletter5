<?php

/********************************************
 * PHP Newsletter 5.0.1 beta
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

if (Pnl::CheckAccess($autInfo['role'], 'admin')) throw new Exception403(core::getLanguage('str', 'dont_have_permission_to_access'));

//include template
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

if (Core_Array::getRequest('action') == 'remove'){

	$accountInfo = Auth::getAutInfo(Core_Array::getGet('id'));

	if ($accountInfo['login'] != $autInfo['login']){
		if ($data->removeAccount((int)Core_Array::getGet('id'))){
			$success = core::getLanguage('msg', 'account_removed');
		}
		else{
			$error = core::getLanguage('error', 'web_apps_error');
		}
	}
}

$tpl->assign('TITLE_PAGE', core::getLanguage('title_page', 'accounts'));
$tpl->assign('TITLE', core::getLanguage('title', 'accounts'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'security'));

include_once core::pathTo('extra', 'top.php');

//menu
include_once core::pathTo('extra', 'menu.php');
	
//alert
if (isset($error)) {
	$tpl->assign('STR_ERROR', core::getLanguage('str', 'error'));
	$tpl->assign('ERROR_ALERT', $error);
}
	
if (isset($success)){
	$tpl->assign('MSG_ALERT', $success);
}

$tpl->assign('TH_TABLE_LOGIN', core::getLanguage('str', 'login'));
$tpl->assign('TH_TABLE_ROLE', core::getLanguage('str', 'role'));
$tpl->assign('TH_TABLE_ACTION', core::getLanguage('str', 'action'));

foreach ($data->getAccountList() as $row){
	$rowBlock = $tpl->fetch('row');
	$rowBlock->assign('ID', $row['id']);
	$rowBlock->assign('LOGIN', $row['login']);

	if($row["role"] == 'admin')
		$role = core::getLanguage('str', 'admin');
	else if($row["role"] == 'moderator')
		$role = core::getLanguage('str', 'moderator');
	else if($row["role"] == 'editor')
		$role = core::getLanguage('str', 'editor');

	$rowBlock->assign('ROLE', $role);

	if ($row['login'] != $autInfo['login']) $rowBlock->assign('ALLOW_EDIT', 'yes');

	$rowBlock->assign('STR_EDIT', core::getLanguage('str', 'edit'));
	$rowBlock->assign('STR_REMOVE', core::getLanguage('str', 'remove'));
	$tpl->assign('row', $rowBlock);
}

//form
$tpl->assign('ACTION', $_SERVER['REQUEST_URI']);
$tpl->assign('BUTTON_ADD', core::getLanguage('button', 'add_account'));

//footer
include_once core::pathTo('extra', 'footer.php');

$tpl->display();