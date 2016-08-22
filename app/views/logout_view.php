<?php

defined('LETTER') || exit('NewsLetter: access denied.');

session_start();

// authorization
Auth::authorization();

session_write_close();

Auth::logOut();
    
$redirect = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/';
	
header("Location: " . $redirect . "");

exit();