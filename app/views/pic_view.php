<?php

/********************************************
 * PHP Newsletter 5.0.9
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

if ( Core_Array::getRequest('id_template') && Core_Array::getRequest('id_user')){
	$result = $data->countUser(Core_Array::getRequest('id_template'), Core_Array::getRequest('id_user'));
}

$img = ImageCreateTrueColor(1,1);
header ("Content-type: image/gif");
imagegif($img);
imagedestroy($img);