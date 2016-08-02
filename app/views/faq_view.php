<?php
defined('LETTER') || exit('NewsLetter: access denied.');

/**
 * ******************************************
 * PHP Newsletter 4.0.15
 * Copyright (c) 2006-2015 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 * ******************************************
 */

// authorization
Auth::authorization();

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