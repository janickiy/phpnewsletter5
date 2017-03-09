<?php

/********************************************
 * PHP Newsletter 5.1.0
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_referral extends Model
{
	/**
	 * @param $fields
	 * @return mixed
	 */
	public function redirect_log($fields)
	{
		return core::database()->insert($fields, core::database()->getTableName('redirect_log'));
	}

	/**
	 * @param $id_user
	 * @return mixed
	 */
	public function getUserInfo($id_user)
	{
		if (is_numeric($id_user)) {
			$query = "SELECT * FROM " . core::database()->getTableName('users') . " WHERE id_user=" . $id_user;
			$result = core::database()->querySQL($query);
			return core::database()->getRow($result);
		}
	}
}