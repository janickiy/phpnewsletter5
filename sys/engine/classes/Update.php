<?php

/********************************************
 * PHP Newsletter 5.2.1
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Update
{
	private $language;
	private $url = 'http://license.janicky.com/';
	private $currenversion;

	public function __construct($language, $currenversion)
	{
		$this->language = $language;
		$this->currenversion = $currenversion;
	}

	/**
	 * @return bool
	 */
	public function checkNewVersion()
	{
		$newversion = $this->getVersion();

		preg_match("/(\d+)\.(\d+)\.(\d+)/", $this->currenversion, $out1);
		preg_match("/(\d+)\.(\d+)\.(\d+)/", $newversion, $out2);

		$v1 = ($out1[1] * 10000 + $out1[2] * 100 + $out1[3]);
		$v2 = ($out2[1] * 10000 + $out2[2] * 100 + $out2[3]);

		if($v2 > $v1)
			return true;
		else
			return false;
	}

	public function getUrlInfo()
	{
		return $this->url . '?id=1&version=' . $this->currenversion . '&lang=' . $this->language . '&ip=' . $this->getIP();
	}

	/**
	 * @param $url
	 * @return mixed
	 */
	public function getDataNewVersion($url)
	{
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 0);
		curl_setopt($ch, CURLOPT_REFERER, isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		$data = curl_exec($ch);

		curl_close($ch);

		preg_match('/\{([^\}])+\}/U', $data, $out);

		return json_decode($out[0], true);
	}

	/**
	 * @return bool
	 */
	public function checkTree()
	{
		preg_match("/(\d+)\.(\d+)\.(\d+)/", $this->currenversion, $out1);

		if($out1[1] < $out1[2])
			return false;
		else
			return true;
	}

	/**
	 * @return mixed
	 */
	public function getVersion()
	{
		$out = $this->getDataNewVersion($this->getUrlInfo());
		return $out['version'];
	}

	/**
	 * @return mixed
	 */
	public function getDownloadLink()
	{
		$out = $this->getDataNewVersion($this->getUrlInfo());
		return $out['download'];
	}

	/**
	 * @return mixed
	 */
	public function getCreated()
	{
		$out = $this->getDataNewVersion($this->getUrlInfo());
		return $out['created'];
	}

	/**
	 * @return mixed
	 */
	public function getUpdate()
	{
		$out = $this->getDataNewVersion($this->getUrlInfo());
		return $out['update'];
	}

	/**
	 * @return mixed
	 */
	public function getUpgradeVersion()
	{
		$out = $this->getDataNewVersion($this->getUrlInfo());
		return $out['upgrade_version'];
	}

	/**
	 * @return mixed
	 */
	public function getMessage()
	{
		$out = $this->getDataNewVersion($this->getUrlInfo());
		return $out['message'];
	}

	/**
	 * @return string
	 */
	public function getIP()
	{
		if (getenv("HTTP_CLIENT_IP") and strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
		elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		elseif (getenv("REMOTE_ADDR") and strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		elseif (!empty($_SERVER['REMOTE_ADDR']) and strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = "unknown";
		
		return $ip;
	}
}