<?php

defined('LETTER') || exit('NewsLetter: access denied.');

// authorization
Auth::authorization();

unset($_SESSION['sess_admin']);
    
$redirect = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/';
	
header("Location: ".$redirect."");

exit();