<?php

/********************************************
 * PHP Newsletter 5.0.9
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

// authorization
Auth::authorization();

Auth::logOut();

$redirect = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/';
	
header("Location: " . $redirect . "");

exit();