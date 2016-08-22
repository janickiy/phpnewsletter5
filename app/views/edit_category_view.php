<?php
defined('LETTER') || exit('NewsLetter: access denied.');

session_start();

// authorization
Auth::authorization();

session_write_close();

$autInfo = Auth::getAutInfo($_SESSION['id']);

//include template
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

if (Core_Array::getRequest('action')){
	$name = htmlspecialchars(trim(Core_Array::getRequest('name')));

	if (empty($name)) $alert_error = core::getLanguage('error', 'empty_category_name');
		
	if (!isset($alert_error)){
		$fields = array();
		$fields['name'] = $_POST['name'];
	
		if ($data->editCategoryRow($fields)){
			header("Location: ./?t=category");
			exit;
		}
		else  $alert_error = core::getLanguage('error', 'edit_cat_name');
	}
}

//title
$tpl->assign('TITLE_PAGE', core::getLanguage('title_page', 'edit_category'));
$tpl->assign('TITLE', core::getLanguage('title', 'edit_category'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'edit_category'));

include_once core::pathTo('extra', 'top.php');

//menu
include_once core::pathTo('extra', 'menu.php');

//error alert
if (isset($alert_error)) {
	$tpl->assign('ERROR_ALERT', $alert_error);
}

//form
$tpl->assign('ACTION', $_SERVER['REQUEST_URI']);
$tpl->assign('STR_NAME', core::getLanguage('str', 'name'));
$tpl->assign('BUTTON', core::getLanguage('button', 'edit'));
$tpl->assign('STR_RETURN_BACK', core::getLanguage('str', 'return_back'));

$row = $data->getCategoryRow();

//value
$tpl->assign('NAME', Core_Array::getPost('name') ?  $_POST['name'] : $row['name']);
$tpl->assign('ID_CAT', $row['id_cat']);

//footer
include_once core::pathTo('extra', 'footer.php');

// display content
$tpl->display();