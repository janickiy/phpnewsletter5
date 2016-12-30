<?php

/********************************************
 * PHP Newsletter 5.0.4
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

$tpl->assign('STR_LOGO',core::getLanguage('str', 'logo'));
$tpl->assign('STR_AUTHOR',core::getLanguage('str', 'author'));