<?php
/**
 * phpnewsletter_5_0_alfa
 * Copyright (c) 2016 janic
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 */
 
$tpl->assign('SCRIPT_VERSION', VERSION);
$tpl->assign('STR_WARNING', core::getLanguage('str', 'warning'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'edit_user'));
$tpl->assign('STR_ERROR', core::getLanguage('str', 'error'));
$tpl->assign('STR_LOGOUT', core::getLanguage('str', 'logout'));
$tpl->assign('STR_LAUNCHEDMAILING', core::getLanguage('str', 'launchedmailing'));
$tpl->assign('STR_STOPMAILING', core::getLanguage('str', 'stopmailing'));
$tpl->assign('LANGUAGE', core::getSetting("language"));