<?php

/********************************************
 * PHP Newsletter 5.3.2
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_add_account extends Model
{
	/**
	 * @param $login
	 * @return bool
	 */
	public function checkExistLogin($login)
	{
		$login = core::database()->escape($login);
		$query = "SELECT * FROM " . core::database()->getTableName('aut') . " WHERE login='" . $login . "'";
		$result = core::database()->querySQL($query);
				
		if (core::database()->getRecordCount($result) == 0)
			return false;
		else
			return true;
	}

	/**
	 * @param $fields
	 * @return mixed
	 */
	public function createAccount($fields)
	{
		return core::database()->insert($fields, core::database()->getTableName('aut'));
	}	
}