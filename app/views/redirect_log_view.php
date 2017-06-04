<?php

/********************************************
 * PHP Newsletter 5.1.2
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

// authorization
Auth::authorization();

$autInfo = Auth::getAutInfo(Auth::getAutId());

if (Pnl::CheckAccess($autInfo['role'], 'admin,moderator,editor')) throw new Exception403(core::getLanguage('str', 'dont_have_permission_to_access'));

//include template
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

$errors = array();

if (isset($_REQUEST['clear_log'])){
	if ($data->clearLog())
		$alert_success = core::getLanguage('msg', 'clear_log');
	else
		$errors[] = core::getLanguage('error', 'clear_log');
}

$order = array();
$order['email'] = "email";
$order['time'] = "time";

$strtmp = "id";

foreach($order as $parametr => $field){
	if (isset($_GET[$parametr])){
		if ($_GET[$parametr] == "up"){
			$_GET[$parametr] = "down";
			$strtmp = $field;
			$thclass[$parametr] = 'headerSortDown';
		} else{
			$_GET[$parametr] = "up";
			$strtmp = "" . $field . " DESC";
			$thclass[$parametr] = 'headerSortUp';
		}
	} else {
		$_GET[$parametr] = "up";
		$thclass[$parametr] = 'headerUnSort';
	}
}

$tpl->assign('TITLE_PAGE', core::getLanguage('title_page', 'redirect_log'));
$tpl->assign('TITLE', core::getLanguage('title', 'redirect_log'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'redirect_log'));

include_once core::pathTo('extra', 'top.php');

//menu
include_once core::pathTo('extra', 'menu.php');

//alert error
if (!empty($errors)) {
	$errorBlock = $tpl->fetch('show_errors');
	$errorBlock->assign('STR_IDENTIFIED_FOLLOWING_ERRORS', core::getLanguage('str', 'identified_following_errors'));

	foreach($errors as $row){
		$rowBlock = $errorBlock->fetch('row');
		$rowBlock->assign('ERROR', $row);
		$errorBlock->assign('row', $rowBlock);
	}

	$tpl->assign('show_errors', $errorBlock);
}

//alert success
if (isset($alert_success)){
	$tpl->assign('MSG_ALERT', $alert_success);
}

//pagination
if (isset($_COOKIE['pnumber_redirect_log']))
	$pnumber = (int)$_COOKIE['pnumber_redirect_log'];
else
	$pnumber = 20;

if (Core_Array::getRequest('url')){
	$blockDetailLog = $tpl->fetch('DetailLog');
	$blockDetailLog->assign('STR_BACK', core::getLanguage('str', 'return_back'));

	$arrs = $data->getDetaillog($strtmp, Core_Array::getRequest('url'), 25);

	if (is_array($arrs)){
		$blockDetailLog->assign('ID', $_GET['id']);
		$blockDetailLog->assign('GET_EMAIL', $_GET['email']);
		$blockDetailLog->assign('GET_TIME', $_GET['time']);

		foreach($arrs as $row){
			$rowBlock = $blockDetailLog->fetch('row');
			$rowBlock->assign('EMAIL', $row['email']);
			$rowBlock->assign('TIME', $row['time']);
			$blockDetailLog->assign('row', $rowBlock);
		}	
	}
	
	$tpl->assign('DetailLog', $blockDetailLog);
} else {
	$blockLogList = $tpl->fetch('LogList');
	$blockLogList->assign('STR_CLEAR_LOG', core::getLanguage('str', 'clear_log'));
	$blockLogList->assign('STR_NUMBER_REDIRECT', core::getLanguage('str', 'number_redirect'));
	$blockLogList->assign('STR_DOWNLOAD_REPORT',  core::getLanguage('str', 'download_report'));

	$arrs = $data->getLogArr($pnumber, Core_Array::getRequest('page'));

	if (is_array($arrs)) {
		foreach ($arrs as $row) {
			$rowBlock = $blockLogList->fetch('redirect_log');
			$rowBlock->assign('ID', $row['id']);
			$rowBlock->assign('URL', $row['url']);
			$rowBlock->assign('NUMBER_REDIRECT', $row['number_redirect']);

			if (Pnl::CheckAccess($autInfo['role'], 'admin,moderator') === false) $rowBlock->assign('ALLOW_DOWNLOAD', 'yes');

			$rowBlock->assign('STR_DOWNLOAD', core::getLanguage('str', 'download'));
			$blockLogList->assign('redirect_log', $rowBlock);
		}
	}

	$number = $data->getTotal();
	$page = $data->getPageNumber();

	if ($page != 1) {
		$pervpage = '<a href="./?t=redirect_log&page=1">&lt;&lt;</a>';
		$perv = '<a href="./?t=redirect_log&' . ($page - 1) . '">&lt;</a>';
	}							

	if ($page != $number) {
		$nextpage = '<a href="./?t=redirect_log&' . ($page + 1) . '">&gt;</a>';
		$next = '<a href="./?t=redirect_log&page=' . $number . '">&gt;&gt;</a>';
	}									

	if ($page - 2 > 0) $page2left = '<a href="./?t=redirect_log&page=' . ($page - 2) . '">...' . ($page - 2) . '</a>';
	if ($page - 1 > 0) $page1left = '<a href="./?t=redirect_log&page=' . ($page - 1) . '">' . ($page - 1) . '</a>';
	if ($page + 2 <= $number) $page2right = '<a href="./?t=redirect_log&page=' . ($page + 2) . '">' . ($page + 2) . '...</a>';
	if ($page + 1 <= $number) $page1right = '<a href="./?t=redirect_log&page=' . ($page + 1) . '">' . ($page + 1) . '</a>';

	if ($number > 1) {
		$paginationBlock = $blockLogList->fetch('pagination');
		$paginationBlock->assign('STR_PNUMBER', core::getLanguage('str', 'pnumber'));
		$paginationBlock->assign('CURRENT_PAGE','<a>' . $page . '</a>');
		$paginationBlock->assign('PAGE1RIGHT', isset($page1right) ? $page1right : '');
		$paginationBlock->assign('PAGE2RIGHT', isset($page2right) ? $page2right : '');
		$paginationBlock->assign('PAGE1LEFT', isset($page1left) ? $page1left : '');
		$paginationBlock->assign('PAGE2LEFT', isset($page2left) ? $page2left : '');
		$paginationBlock->assign('PERVPAGE', isset($pervpage) ? $pervpage : '');
		$paginationBlock->assign('NEXTPAGE', isset($nextpage) ? $nextpage : '');
		$paginationBlock->assign('PERV', isset($perv) ? $perv : '');
		$paginationBlock->assign('NEXT', isset($next) ? $next : '');
		$blockLogList->assign('pagination', $paginationBlock);			
	}
	
	$tpl->assign('LogList', $blockLogList);
}

$tpl->assign('SHOW_MORE', core::getLanguage('str', 'show_more'));
$tpl->assign('STR_CLICK', core::getLanguage('str', 'click'));
$tpl->assign('STR_THERE_ARE_NO_MORE_ENTRIES', core::getLanguage('str', 'there_are_no_more_entries'));

//footer
include_once core::pathTo('extra', 'footer.php');

// display content
$tpl->display();