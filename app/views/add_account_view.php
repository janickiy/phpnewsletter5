<?php

defined('LETTER') || exit('NewsLetter: access denied.');

session_start();

// authorization
Auth::authorization();

$autInfo = Auth::getAutInfo($_SESSION['id']);

if($_SESSION['role'] != 'admin') exit();

// require temlate class
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");


if (Core_Array::getRequest('action')){
	$login = trim(htmlspecialchars(Core_Array::getPost('login')));
	$password = trim(Core_Array::getPost('password'));
	$password_again = trim(Core_Array::getPost('password_again'));
	$status = Core_Array::getPost('status');
	
	$errors = array();
	
	if (empty($login)) $errors[] = core::getLanguage('error', 'login_isnt_entered');
	if (empty($password)) $errors[] = core::getLanguage('error', 'password_isnt_entered');
	if (empty($password_again)) $errors[] = core::getLanguage('error', 're_enter_password');

	if (!empty($password) && !empty($password_again)){
		if ($password != $password_again) $errors[] = core::getLanguage('error', 'passwords_dont_match');
	}

	if (count($errors) == 0){
		$fields = array();
		$fields['login'] = $login;
		$fields['password'] = md5($password);
		$fields['role'] = $status;

		$result = $data->createAccount($fields);
		
		if ($result){
			header("Location: ./?t=accounts");
			exit();
		}
		else{ 
			$alert_error =core::getLanguage('error', 'web_apps_error');
		}		
	}
}

$tpl->assign('TITLE_PAGE', core::getLanguage('title_page', 'add_account'));
$tpl->assign('TITLE', core::getLanguage('title', 'add_account'));

//error alert
if(!empty($alert_error)) {
	$tpl->assign('ERROR_ALERT', $alert_error);
}

if(count($errors) > 0){
	$errorBlock = $tpl->fetch('show_errors');
	$errorBlock->assign('STR_IDENTIFIED_FOLLOWING_ERRORS', core::getLanguage('str', 'identified_following_errors'));
			
	foreach($errors as $row){
		$rowBlock = $errorBlock->fetch('row');
		$rowBlock->assign('ERROR', $row);
		$errorBlock->assign('row', $rowBlock);
	}
		
	$tpl->assign('show_errors', $errorBlock);
}

include_once core::pathTo('extra', 'top.php');

//menu
include_once core::pathTo('extra', 'menu.php');

$tpl->assign('STR_REQUIRED_FIELDS',core::getLanguage('str', 'required_fields'));
$tpl->assign('STR_LOGIN',core::getLanguage('str', 'login'));
$tpl->assign('STR_PASSWORD',core::getLanguage('str', 'password'));
$tpl->assign('STR_PASSWORD_AGAIN',core::getLanguage('str', 'again_password'));

$tpl->assign('STR_ROLE',core::getLanguage('str', 'role'));
$tpl->assign('STR_ADMIN',core::getLanguage('str', 'admin'));
$tpl->assign('STR_MODERATOR',core::getLanguage('str', 'moderator'));
$tpl->assign('STR_MANAGER',core::getLanguage('str', 'manager'));

$tpl->assign('RETURN_BACK',core::getLanguage('str', 'return_back'));
$tpl->assign('RETURN_BACK_LINK', './?t=accounts');
$tpl->assign('ACTION', $_SERVER['REQUEST_URI']);
$tpl->assign('USER_LOGIN', $_POST['login']);
$tpl->assign('USER_ROLE', $_POST['role']);

$tpl->assign('BUTTON',core::getLanguage('button', 'add'));

//footer
include_once core::pathTo('extra', 'footer.php');

// display content
$tpl->display();