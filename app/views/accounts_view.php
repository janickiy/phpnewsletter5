<?php
defined('LETTER') || exit('NewsLetter: access denied.');

// authorization
Auth::authorization();

//include template
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

$error = array();

if (Core_Array::getRequest('action')){
	$current_password = trim(Core_Array::getRequest('current_password'));
	$password = trim(Core_Array::getRequest('password'));
	$password_again = trim(Core_Array::getRequest('password_again'));

	if (empty($current_password)){
		$error[] = core::getLanguage('error', 'enter_current_passwd');
	}

	if (empty($password)){
		$error[] = core::getLanguage('error', 'password_isnt_entered');
	}

	if (empty($password_again)){
		$error[] = core::getLanguage('error', 're_enter_password');
	}
	
	if ($password && $password_again && $password != $password_again){
		$error[] = core::getLanguage('error', 'passwords_dont_match');
	}
	
	if ($current_password){
		$current_password = md5($current_password);

		if (Auth::getCurrentHash() != $current_password){
			$error[] = core::getLanguage('error', 'current_password_incorrect');
		}
	}

	if(!$error) {
		$result = $data->changePassword($password);
		
		if($result){
			$success = core::getLanguage('msg', 'password_has_been_changed');
		}	
		else{
			$error_passw_change = core::getLanguage('error', 'change_password');
		}		
	}
}

$tpl->assign('TITLE_PAGE', core::getLanguage('title_page', 'security'));
$tpl->assign('TITLE', core::getLanguage('title', 'security'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'security'));

include_once core::pathTo('extra', 'top.php');

//menu
include_once core::pathTo('extra', 'menu.php');
	
//alert
if (isset($error_passw_change)) {
	$tpl->assign('STR_ERROR', core::getLanguage('str', 'error'));
	$tpl->assign('ERROR_ALERT', $error_passw_change);
}
	
if (isset($error) && count($error) > 0){
	$errorBlock = $tpl->fetch('show_errors');
	$errorBlock->assign('STR_IDENTIFIED_FOLLOWING_ERRORS', core::getLanguage('str', 'identified_following_errors'));
			
	foreach($error as $row){
		$rowBlock = $errorBlock->fetch('row');
		$rowBlock->assign('ERROR', $row);
		$errorBlock->assign('row', $rowBlock);
	}
		
	$tpl->assign('show_errors', $errorBlock);
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

	if ($row['login'] != $_SESSION['login']) $rowBlock->assign('ALLOW_EDIT', 'yes');

	$rowBlock->assign('STR_EDIT', core::getLanguage('str', 'edit'));
	$rowBlock->assign('STR_REMOVE', core::getLanguage('str', 'remove'));
	$tpl->assign('row', $rowBlock);
}

//form
$tpl->assign('ACTION', $_SERVER['REQUEST_URI']);
$tpl->assign('BUTTON_ADD', core::getLanguage('button', 'add'));

//footer
include_once core::pathTo('extra', 'footer.php');

$tpl->display();