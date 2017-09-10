<?php

/********************************************
 * PHP Newsletter 5.2.2
 * Copyright (c) 2006-2017 Alexander Yanitsky
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
$url = 'http://license.janicky.com/?t=check_licensekey&licensekey=' . $licensekey . '&domain=' . $domain . '&s=phpnewsletter&version=' . $version . '';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 0);
curl_setopt($ch, CURLOPT_REFERER, isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$data = curl_exec($ch);

curl_close($ch);

preg_match('/\{([^\}])+\}/U',$data, $out);

$content = array();

if ($out[0]) {
	$arr = json_decode($out[0], true);

	if (isset($arr['error'])) $arr['error'] = str_replace('LICENSE_IS_USED', $INSTALL["lang"]["error"]["license_is_used"], $arr['error']);
	if (isset($arr['error']))  $arr['error'] = str_replace('LICENSE_NOT_FOUND', $INSTALL["lang"]["error"]["license_not_found"], $arr['error']);

	if ($arr['result'] == 'yes')
		$content = array('result' => 'yes');
	else
		$content = array('result' => 'no', 'error' => $arr['error']);
} else $content = array('result' => 'no', 'error' => $INSTALL["lang"]["error"]["error_checking_license"]);


header('Cache-Control: no-store, no-cache, must-revalidate');
header('Content-Type: application/json');
echo json_encode($content);
exit();