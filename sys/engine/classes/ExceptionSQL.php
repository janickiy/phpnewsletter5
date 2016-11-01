<?php

/********************************************
 * PHP Newsletter 5.0.2
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class ExceptionSQL extends Exception
{
	protected $sql_error;
	protected $sql_query;

	public function __construct($sql_error, $sql_query, $message)
	{
		$this->sql_error = $sql_error;
		$this->sql_query = $sql_query;

		parent::__construct($message);
	}

	public function getSQLError()
	{
		return $this->sql_error;
	}

	public function getSQLQuery()
	{
		return $this->sql_query;
	}
}