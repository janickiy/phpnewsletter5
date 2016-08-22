<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_add_account extends Model
{
	public function checkExistLogin($login)
	{
		$login = core::database()->escape($login);
		$query = "SELECT * FROM " . core::database()->getTableName('aut') . " WHERE login LIKE '" . $login . "'";
		$result = core::database()->querySQL($query);
				
		if (core::database()->getRecordCount($result) == 0)
			return false;
		else
			return true;
	}
	
	public function createAccount($fields)
	{
		return core::database()->insert($fields, core::database()->getTableName('aut'));
	}	
}