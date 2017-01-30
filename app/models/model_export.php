<?php

/********************************************
 * PHP Newsletter 5.0.7
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_export extends Model
{
	/**
	 * @param $id_cat
	 * @return mixed
	 */
	public function getUserList($id_cat){
		if ($id_cat) {
			$temp = array();
			foreach ($id_cat as $id) {
				if (is_numeric($id)) {
					$temp[] = $id;
				}
			}

			$query = "SELECT u.name, u.email FROM " . core::database()->getTableName('users') . " u
						LEFT JOIN " . core::database()->getTableName('subscription') . " s ON u.id_user=s.id_user
						WHERE status='active' AND s.id_cat IN (" . implode(",", $temp) . ")
						GROUP BY u.id_user";
		}
		else{
			$query = "SELECT name, email FROM " . core::database()->getTableName('users') . " WHERE status='active'";
		}

		$result = core::database()->querySQL($query);
		return core::database()->getColumnArray($result);
	}

	/**
	 * @return mixed
	 */
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
