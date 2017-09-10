<?php

/********************************************
 * PHP Newsletter 5.2.2
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

$url = base64_decode(Core_Array::getRequest('ref'));
$id_user = Core_Array::getRequest('id');

if (!empty($url) && is_numeric($id_user)) {
	$row = $data->getUserInfo($id_user);

	$fields = array(
        'id'  => 0,
        'url' => $url,
        'time'  => date("Y-m-d H:i:s"),
        'email' => $row['email'],
    );

	$data->redirect_log($fields);

	header("Location: " . $url);
	exit;
}