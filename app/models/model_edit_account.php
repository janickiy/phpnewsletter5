<?php

/********************************************
 * PHP Newsletter 5.0.8
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_edit_account extends Model
{
	/**
	 * @param $id
	 * @return mixed
	 */
	public function getAccountInfo($id)
	{
		if (is_numeric($id)){
			$query = "SELECT * FROM " . core::database()->getTableName('aut') . " WHERE id=" . $id;
			$result = core::database()->querySQL($query);
			return core::database()->getRow($result);
		}
	}

	/**
	 * @param $fields
	 * @param $id
	 * @return mixed
	 */
	public function editAccount($fields, $id)
	{
		if (is_numeric($id)) {
			return core::database()->update($fields, core::database()->getTableName('aut'), "id=" . $id);
		}
	}
}	