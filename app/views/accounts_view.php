<?php

/********************************************
 * PHP Newsletter 5.3.1
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

// authorization
Auth::authorization();

$autInfo = Auth::getAutInfo(Auth::getAutId());

if (Pnl::CheckAccess($autInfo['role'], 'admin')) throw new Exception403(core::getLanguage('str', 'dont_have_permission_to_access'));

//include template
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

$errors = [];

if (Core_Array::getRequest('action') == 'remove'){

	$accountInfo = Auth::getAutInfo(Core_Array::getGet('id'));

	if ($accountInfo['login'] != $autInfo['login']) {
		if ($data->removeAccount((int)Core_Array::getGet('id'))){
			$success_msg = core::getLanguage('msg', 'account_removed');
		} else {
			$errors[] = core::getLanguage('error', 'web_apps_error');
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
if (!empty($errors)){
	$errorBlock = $tpl->fetch('show_errors');
	$errorBlock->assign('STR_IDENTIFIED_FOLLOWING_ERRORS', core::getLanguage('str', 'identified_following_errors'));

	foreach($errors as $row){
		$rowBlock = $errorBlock->fetch('row');
		$rowBlock->assign('ERROR', $row);
		$errorBlock->assign('row', $rowBlock);
	}

	$tpl->assign('show_errors', $errorBlock);
}
	
if (isset($success_msg)) {
	$tpl->assign('MSG_ALERT', $success_msg);
}

$tpl->assign('TH_TABLE_LOGIN', core::getLanguage('str', 'login'));
$tpl->assign('TH_TABLE_NAME', core::getLanguage('str', 'name'));
$tpl->assign('TH_TABLE_DESCRIPTION', core::getLanguage('str', 'description'));
$tpl->assign('TH_TABLE_ROLE', core::getLanguage('str', 'role'));
$tpl->assign('TH_TABLE_ACTION', core::getLanguage('str', 'action'));

foreach ($data->getAccountList() as $row){
	$rowBlock = $tpl->fetch('row');
	$rowBlock->assign('ID', $row['id']);
	$rowBlock->assign('LOGIN', $row['login']);
    $rowBlock->assign('NAME', $row['name']);
    $rowBlock->assign('DESCRIPTION', $row['description']);

	if ($row["role"] == 'admin')
		$role = core::getLanguage('str', 'admin');
	elseif ($row["role"] == 'moderator')
		$role = core::getLanguage('str', 'moderator');
	elseif ($row["role"] == 'editor')
		$role = core::getLanguage('str', 'editor');

	$rowBlock->assign('ROLE', $role);

	if ($row['login'] != $autInfo['login']) $rowBlock->assign('ALLOW_EDIT', 'yes');

	$rowBlock->assign('STR_EDIT', core::getLanguage('str', 'edit'));
	$rowBlock->assign('STR_REMOVE', core::getLanguage('str', 'remove'));
	$tpl->assign('row', $rowBlock);
}

//form
$tpl->assign('STR_CHANGE_PASSWORD', core::getLanguage('str', 'change_password'));
$tpl->assign('ACTION', $_SERVER['REQUEST_URI']);
$tpl->assign('BUTTON_ADD', core::getLanguage('button', 'add_account'));

//footer
include_once core::pathTo('extra', 'footer.php');

$tpl->display();