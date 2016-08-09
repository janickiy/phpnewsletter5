<?php

defined('LETTER') || exit('NewsLetter: access denied.');

session_start();

// authorization
Auth::authorization();

$autInfo = Auth::getAutInfo($_SESSION['id']);

if($autInfo['role'] != 'admin') exit();

// require temlate class
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

$error = array();

if (Core_Array::getPost('action')){
	$current_password = trim(Core_Array::getPost('current_password'));
	$password = trim(Core_Array::getPost('password'));
	$password_again = trim(Core_Array::getPost('password_again'));

	if (!$current_password){
		$error[] = core::getLanguage('error', 'enter_current_passwd');
	}

	if (!$password){
		$error[] = core::getLanguage('error', 'password_isnt_entered');
	}

	if (!$password_again){
		$error[] = core::getLanguage('error', 're_enter_password');
	}
	
	if($password && $password_again && $password != $password_again){
		$error[] = core::getLanguage('error', 'passwords_dont_match');
	}
	
	if($_POST["current_password"]){
		$current_password = md5($_POST["current_password"]);
		
		if(Auth::getCurrentHash() != $current_password){
			$error[] = core::getLanguage('error', 'current_password_incorrect');
		}
	}

	if (!$error) {
		if ($data->changePassword($password, $autInfo['id'])){
			$success = core::getLanguage('msg', 'password_has_been_changed');
		}	
		else{
			$error_passw_change = core::getLanguage('error', 'change_password');
		}		
	}
}

$tpl->assign('TITLE_PAGE', core::getLanguage('title_page', 'change_password'));
$tpl->assign('TITLE', core::getLanguage('title', 'change_password'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'change_password'));

include_once core::pathTo('extra', 'top.php');

// menu
include_once core::pathTo('extra', 'menu.php');
	
//alert
if (isset($error_passw_change)) {
	$tpl->assign('ERROR_ALERT', $error_passw_change);
}
	
if (count($error) > 0){
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

//form
$tpl->assign('ACTION', $_SERVER['REQUEST_URI']);
$tpl->assign('STR_CURRENT_PASSWORD', core::getLanguage('str', 'current_password'));
$tpl->assign('STR_PASSWORD', core::getLanguage('str', 'password'));
$tpl->assign('STR_AGAIN_PASSWORD', core::getLanguage('str', 'again_password'));
$tpl->assign('BUTTON_SAVE', core::getLanguage('button', 'save'));

//footer
include_once core::pathTo('extra', 'footer.php');

$tpl->display();