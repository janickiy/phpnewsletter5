<?php
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