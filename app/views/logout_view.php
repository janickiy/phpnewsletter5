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

Auth::logOut();

session_write_close();

$redirect = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/';
	
header("Location: " . $redirect . "");

exit();