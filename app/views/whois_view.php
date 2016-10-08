<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
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

if (Pnl::CheckAccess($autInfo['role'], 'admin,moderator,editor')) exit();

//include template
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

$tpl->assign('TITLE_PAGE', core::getLanguage('title_page', 'whois'));
$tpl->assign('TITLE', core::getLanguage('title', 'whois'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'whois'));

include_once core::pathTo('extra', 'top.php');

//menu
include_once core::pathTo('extra', 'menu.php');

$tpl->assign('RETURN_BACK', core::getLanguage('str', 'return_back'));

if (Core_Array::getGet('ip')){
    $sock = @fsockopen("whois.ripe.net", 43, $errno, $errstr);

    if (!$sock) {
        $error = $errno($errstr);
    } else {
        $whoisBlock = $tpl->fetch('whois');
        $whoisBlock->assign('TH_TABLE_IP_INFO', core::getLanguage('str', 'ip_info'));

        fputs ($sock, $_GET['ip']."\r\n");

        while (!feof($sock)){
            $rowBlock = $whoisBlock->fetch('row');
            $rowBlock->assign('SOCK', str_replace(":",":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ,fgets ($sock,128)));
            $whoisBlock->assign('row', $rowBlock);
        }

        $tpl->assign('whois', $whoisBlock);
    }
}
else {
    $error = core::getLanguage('error', 'service_unavailable');
}

if (isset($error)) {
    $tpl->assign('ERROR_ALERT', $error);
}

//footer
include_once core::pathTo('extra', 'footer.php');

// display content
$tpl->display();