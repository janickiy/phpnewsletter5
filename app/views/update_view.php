<?php

defined('LETTER') || exit('NewsLetter: access denied.');

session_start();

// authorization
Auth::authorization();

session_write_close();

$autInfo = Auth::getAutInfo($_SESSION['id']);

$update = new Update(core::getSetting('language'));
$newversion = $update->getVersion();
$currentversion = VERSION;

//require temlate class
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

if (Core_Array::getRequest('action')){
	$license_key = trim(Core_Array::getRequest('license_key'));

	if($data->updateLicenseKey($license_key))
		$success = core::getLanguage('msg', 'changes_added');
	else
		$error = core::getLanguage('error', 'web_apps_error');
}
		
//alert
if (isset($error)) {
	$tpl->assign('ERROR_ALERT', $error);
}
	
if (isset($success)){
	$tpl->assign('MSG_ALERT', $success);
}

if ($update->checkNewVersion(VERSION) && $update->checkTree($currenversion)){
	if (Auth::checkLicenseKey()){
		$button = str_replace('%NEW_VERSION%', $newversion, core::getLanguage('button', 'update'));
		$button = str_replace('%SCRIPT_NAME%', core::getLanguage('script', 'name'), $button);
		$tpl->assign('BUTTON_UPDATE', $button);
	}
	else{
		$tpl->assign('MSG_NO_UPDATES', core::getLanguage('msg', 'update_not_available'));
	}	
}
else{
	$button = str_replace('%SCRIPT_NAME%', core::getLanguage('script', 'name'), core::getLanguage('msg', '"no_updates'));
	core::getLanguage('', '')  ["msg"]["no_updates"] = str_replace('%NEW_VERSION%', VERSION, core::getLanguage('msg', 'no_updates'));
	$tpl->assign('MSG_NO_UPDATES', core::getLanguage('msg', 'no_updates'));
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

//value
$tpl->assign('LICENSE_KEY', $data->getLicenseKey());

//footer
include_once core::pathTo('extra', 'footer.php');

// display content
$tpl->display();