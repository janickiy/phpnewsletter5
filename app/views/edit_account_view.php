<?php

// authorization
Auth::authorization();

if($_SESSION['role'] != 'admin') exit();

// require temlate class
require_once $PNSL["system"]["dir_root"].$PNSL["system"]["dir_libs"]."html_template/SeparateTemplate.php";
$tpl = SeparateTemplate::instance()->loadSourceFromFile($PNSL["system"]["template"]."edit_account.tpl");

$tpl->assign('SCRIPT_VERSION', $PNSL["system"]["version"]);
$tpl->assign('STR_WARNING',core::getLanguage('', '')["str"]["warning"]);
$tpl->assign('INFO_ALERT',core::getLanguage('', '')["info"]["edit_user"]);
$tpl->assign('STR_ERROR',core::getLanguage('', '')["str"]["error"]);
$tpl->assign('STR_LOGOUT',core::getLanguage('', '')["str"]["logout"]);

if($_POST['action']){
	$password = trim($_POST['password']);
	$password_again = trim($_POST['password_again']);
	$status = $_POST['status'];
	$id = $_POST['id'];
	
	$errors = array();
	
	if(empty($password)) $errors[] =core::getLanguage('', '')["error"]["password_isnt_entered"];
	if(empty($password_again)) $errors[] =core::getLanguage('', '')["error"]["password_isnt_entered"];

	if(!empty($password) && !empty($password_again)){
		if($password != $password_again) $errors[] =core::getLanguage('', '')["error"]["passwords_dont_match"];
	}
	
	if(count($errors) == 0){
		$fields = array();
		$fields['password'] = md5($password);
		$fields['role'] = $status;

		$result = $data->editAccount($fields);
		
		if($result){
			header("Location: ./?task=security");
			exit();
		}
		else{ 
			$alert_error =core::getLanguage('', '')["error"]["web_apps_error"];
		}		
	}
}

$tpl->assign('TITLE_PAGE',core::getLanguage('', '')["title_page"]["edit_account"]);
$tpl->assign('TITLE',core::getLanguage('', '')["title"]["edit_account"]);

//error alert
if(!empty($alert_error)) {
	$tpl->assign('ERROR_ALERT', $alert_error);
}

if(count($errors) > 0){
	$errorBlock = $tpl->fetch('show_errors');
	$errorBlock->assign('STR_IDENTIFIED_FOLLOWING_ERRORS',$PNSL["lang"]["str"]["identified_following_errors"]);
			
	foreach($errors as $row){
		$rowBlock = $errorBlock->fetch('row');
		$rowBlock->assign('ERROR', $row);
		$errorBlock->assign('row', $rowBlock);
	}
		
	$tpl->assign('show_errors', $errorBlock);
}

//menu
include_once "menu.php";

//form
$tpl->assign('STR_REQUIRED_FIELDS',core::getLanguage('', '')["str"]["required_fields"]);
$tpl->assign('STR_LOGIN',core::getLanguage('', '')["str"]["login"]);
$tpl->assign('STR_PASSWORD',core::getLanguage('', '')["str"]["password"]);
$tpl->assign('STR_PASSWORD_AGAIN',core::getLanguage('', '')["str"]["again_password"]);
$tpl->assign('STR_ROLE',core::getLanguage('', '')["str"]["role"]);
$tpl->assign('STR_ADMIN',core::getLanguage('', '')["str"]["admin"]);
$tpl->assign('STR_MODERATOR',core::getLanguage('', '')["str"]["moderator"]);
$tpl->assign('STR_MANAGER',core::getLanguage('', '')["str"]["manager"]);

$tpl->assign('MAILING_STATUS', getCurrentMailingStatus());
$tpl->assign('STR_LAUNCHEDMAILING',core::getLanguage('', '')["str"]["launchedmailing"]);
$tpl->assign('STR_STOPMAILING',core::getLanguage('', '')["str"]["stopmailing"]);
$tpl->assign('RETURN_BACK',core::getLanguage('', '')["str"]["return_back"]);
$tpl->assign('RETURN_BACK_LINK', './?task=security');
$tpl->assign('ACTION', $_SERVER['REQUEST_URI']);

$row = $data->getAccountInfo();

$tpl->assign('USER_ROLE', $row['role']);
$tpl->assign('ID', $row['id']);
$tpl->assign('BUTTON',core::getLanguage('', '')["button"]["edit"]);

//footer
include_once "footer.php";

// display content
$tpl->display();