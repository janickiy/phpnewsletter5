<?php

defined('LETTER') || exit('NewsLetter: access denied.');

session_start();

// authorization
Auth::authorization();

Auth::logOut();
    
$redirect = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/';
	
header("Location: " . $redirect . "");

exit();