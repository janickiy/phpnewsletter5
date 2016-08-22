<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Update
{
	public $currenversion = null;
	
	public function checkNewVersion()
	{
		$str = $this->getDataNewVersion();		
		$newversion = $this->getVersion($str);
		
		preg_match("/(\d+)\.(\d+)\.(\d+)/", $this->currenversion, $out1);
		preg_match("/(\d+)\.(\d+)\.(\d+)/", $newversion, $out2);
		
		$v1 = ($out1[1] * 10000 + $out1[2] * 100 + $out1[3]);
		$v2 = ($out2[1] * 10000 + $out2[2] * 100 + $out2[3]);
		
		if($v2 > $v1)
			return true;
		else
			return false;
	}

	public function getDataNewVersion() 
	{ 
		$headers = "GET /scripts/index.php?s=newsletter&version=" . $this->currenversion . " HTTP/1.0\r\n";
		$headers .= "Host: janicky.com\r\n";
		if (isset($_SERVER['HTTP_USER_AGENT'])) $headers .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
		$headers .= "Accept: */*\r\n";
		$headers .= "Accept-Charset: utf-8;q=0.7,*;q=0.7\r\n";
		if (isset($_SERVER['HTTP_REFERER'])) $headers .= "Referer: " . $_SERVER['HTTP_REFERER'] . "\r\n";
		$headers .= "Connection: Close\r\n\r\n";

		$out = '';
		
		$fp = @fsockopen('janicky.com', 80, $errno, $errstr, 30);

		fwrite($fp, $headers);

		while (!feof($fp))
		{
			$out .= fgets($fp, 1024);
		}
		
		return $out; 
	}
	
	public function getVersion()
	{
		$str = $this->getDataNewVersion(); 	
		preg_match("/<version>([^<]+)<\/version>/i", $str, $out);
		
		return $out[1];
	}

	public function getDownloadLink()
	{
		$str = $this->getDataNewVersion(); 
		preg_match("/<download>([^<]+)<\/download>/i", $str, $out);
		
		return $out[1];
	}
	
	public function getCreated()
	{
		$str = $this->getDataNewVersion(); 
		preg_match("/<created>([^<]+)<\/created>/i", $str, $out);
		
		return $out[1];
	}
}