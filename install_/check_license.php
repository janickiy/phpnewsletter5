<?php

/********************************************
 * PHP Newsletter 5.0.1 beta
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

$licensekey = trim(strtolower($_REQUEST['licensekey']));

if ($_REQUEST['lang'])
	$lang_file = $_REQUEST['lang'] . '.php';
else
	$lang_file = "en.php";

if (file_exists($lang_file)) include $lang_file;

$version = $_REQUEST['version'];
	
$domain = (substr($_SERVER['SERVER_NAME'], 0, 4)) == "www." ? str_replace('www.','', $_SERVER['SERVER_NAME']) : $_SERVER['SERVER_NAME'];
$url = 'http://site3.ru/check_licensekey.php?licensekey=' . $licensekey . '&domain=' . $domain . '&s=phpnewsletter&version=' . $version . '';

$ch = curl_init();

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);

$data = curl_exec($ch);
curl_close($ch);

$content = array();

if ($data) {
	$arr = json_decode($data, true);

	if (isset($arr['error'])) $arr['error'] = str_replace('LICENSE_IS_USED', $INSTALL["lang"]["error"]["license_is_used"], $arr['error']);
	if (isset($arr['error']))  $arr['error'] = str_replace('LICENSE_NOT_FOUND', $INSTALL["lang"]["error"]["license_not_found"], $arr['error']);

	if ($arr['result'] == 'yes')
		$content = array('result' => 'yes');
	else
		$content = array('result' => 'no', 'error' => $arr['error']);
} else $content = array('result' => 'no', 'error' => $INSTALL["lang"]["warning"]["detect_last_version"]);


header('Cache-Control: no-store, no-cache, must-revalidate');
header('Content-Type: application/json');
echo json_encode($content);
exit();