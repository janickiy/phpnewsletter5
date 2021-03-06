<?php

/********************************************
 * PHP Newsletter 5.3.1
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_edit_category extends Model
{

	/**
	 * @param $id_cat
	 * @return mixed
	 */
	public function getCategoryRow($id_cat)
	{
		if (is_numeric($id_cat)) {
			$query = "SELECT * FROM ".core::database()->getTableName('category')." WHERE id_cat=" . $id_cat;
			$result = core::database()->querySQL($query);
			return core::database()->getRow($result);
		}
	}

	/**
	 * @param $fields
	 * @param $id_cat
	 * @return mixed
	 */
	public function editCategoryRow($fields, $id_cat)
	{
		if (is_numeric($id_cat)){
			return core::database()->update($fields, core::database()->getTableName('category'), "id_cat=" . $id_cat);
		}
	}
}