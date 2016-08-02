<?php
defined('LETTER') || exit('NewsLetter: access denied.');

class Model_export extends Model
{

	public function getUserList(){
		$query = "SELECT name,email FROM ".core::database()->getTableName('users')." WHERE status='active'";
		$result = core::database()->querySQL($query);
		
		return core::database()->getColumnArray($result);
	}

	public function getCategoryList()
	{
		$query =  "SELECT *,cat.id_cat as id FROM ".core::database()->getTableName('category')." cat
					LEFT JOIN ".core::database()->getTableName('subscription')." subs ON cat.id_cat=subs.id_cat
					GROUP by id
					ORDER BY name";

		$result = core::database()->querySQL($query);
		return core::database()->getColumnArray($result);
	}
}
