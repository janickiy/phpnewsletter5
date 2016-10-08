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

if (Pnl::CheckAccess($autInfo['role'], 'admin,moderator,editor')) throw new Exception403(core::getLanguage('str', 'dont_have_permission_to_access'));

//include template
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

$tpl->assign('TITLE_PAGE',core::getLanguage('title_page', 'faq'));
$tpl->assign('TITLE',core::getLanguage('title', 'faq'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'faq'));

include_once core::pathTo('extra', 'top.php');

//menu
include_once core::pathTo('extra', 'menu.php');

$tpl->assign('FAQ',$data->get_faq());

//footer
include_once core::pathTo('extra', 'footer.php');

// display content
$tpl->display();