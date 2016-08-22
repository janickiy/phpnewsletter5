<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_edit_category extends Model
{

	public function getCategoryRow()
	{
		$id_cat = core::database()->escape(Core_Array::getRequest('id_cat'));
		$query = "SELECT * FROM ".core::database()->getTableName('category')." WHERE id_cat=".$id_cat;
		$result = core::database()->querySQL($query);
		return core::database()->getRow($result);
	}
	
	public function editCategoryRow($fields)
	{
		$id_cat = core::database()->escape(Core_Array::getRequest('id_cat'));
		$table = core::database()->getTableName('category');
		$where = "id_cat=".$id_cat;
		return core::database()->update($fields, $table, $where); 
	}
}