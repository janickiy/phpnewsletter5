<?php

/********************************************
 * PHP Newsletter 5.0.1 beta
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

$licensekey = trim(strtolower($_REQUEST['licensekey']));
$version = $_REQUEST['version'];
	
$headers = "GET /scripts/check_licensekey.php?licensekey=" . $licensekey . "&domain=" . $_SERVER['SERVER_NAME'] . "&version=" . $version . " HTTP/1.1\r\n";
$headers .= "Host: janicky.com\r\n";
$headers .= "Accept: */*\r\n";
$headers .= "Accept-Charset: utf-8;q=0.7,*;q=0.7\r\n";
$headers .= "Connection: Close\r\n\r\n";	

$str = '';
		
$fp = @fsockopen('janicky.com', 80, $errno, $errstr, 30);

fwrite($fp, $headers);

while (!feof($fp))
{
	$str .= fgets($fp, 1024);
}		

preg_match("/<result>([^<]+)<\/result>/i", $str, $out);

header('Content-Type: application/xml; charset=utf-8');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<document>\n";
	
if($out[1] == 'yes'){
	echo "<result>yes</result>";
}
else{
	echo "<result>no</result>";
}		
	
echo "</document>";