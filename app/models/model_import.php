<?php

/********************************************
 * PHP Newsletter 5.2.2
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_import extends Model
{
	/**
	 * @return mixed
	 */
	public function getCategoryList()
	{
		$query =  "SELECT *,cat.id_cat as id FROM ".core::database()->getTableName('category')." cat
					LEFT JOIN ".core::database()->getTableName('subscription')." subs ON cat.id_cat=subs.id_cat
					GROUP by cat.id_cat
					ORDER BY name";
					
		$result = core::database()->querySQL($query);
		return core::database()->getColumnArray($result);
	}

	/**
	 * @param $id_cat
	 * @return int
	 */
	public function importFromExcel($id_cat)
	{
		core::requireEx('libs', "PHPExcel/PHPExcel/IOFactory.php");
		
		$count = 0;
		
		if ($_FILES['file']['tmp_name']){
			$objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

			foreach($sheetData as $d){
				$email = trim($d['A']);
				$name = trim($d['B']);

				if (!Pnl::check_email($email)){					

					$query = "SELECT * FROM " . core::database()->getTableName('users') . " WHERE email='" . $email . "'";
					$result = core::database()->querySQL($query);
					
					if (core::database()->getRecordCount($result) > 0) {
						$row = core::database()->getRow($result);

						core::database()->delete(core::database()->getTableName('subscription'),"id_user=" . $row['id_user'],'');

						foreach($id_cat as $id) {
							if (is_numeric($id)) {
								$fields = array(
                                    'id_sub'  => 0,
                                    'id_user' => $row['id_user'],
                                    'id_cat'  => $id,
                                );

								core::database()->insert($fields, core::database()->getTableName('subscription'));
							}
						}
					} else {
						$fields = array(
                            'id_user' => 0,
                            'name'    => $name,
                            'email'   => $email,
                            'token'   => Pnl::getRandomCode(),
                            'time'    => date("Y-m-d H:i:s"),
                            'status'  => 'active',
                            'time_send' => '0000-00-00 00:00:00',
                        );
						
						$insert_id = core::database()->insert($fields, core::database()->getTableName('users'));
						
						if ($insert_id) $count++;
						
						foreach($id_cat as $id){
							if (is_numeric($id)){
								$subfields = array(
                                    'id_sub'  => 0,
                                    'id_user' => $insert_id,
                                    'id_cat'  => $id,
                                );
									
								core::database()->insert($subfields, core::database()->getTableName('subscription'));
							}
						}
					}
				}
			}
		}	

		return $count;	
	}

	/**
	 * @param $id_cat
	 * @return bool|int
	 */
	public function importFromText($id_cat)
	{
		core::requireEx('libs', "ConvertCharset/ConvertCharset.class.php");

		if (!($fp = @fopen($_FILES['file']['tmp_name'], "rb"))) {
			return false;
		} else {
			$buffer = fread($fp, filesize($_FILES['file']['tmp_name']));
			fclose($fp);
			$tok = strtok($buffer, "\n");

			while ($tok) {
				$tok = strtok("\n");
				$strtmp[] = $tok;
			}

			$count = 0;

			foreach ($strtmp as $val) {
				$str = $val;

				if (!mb_check_encoding($str, 'utf-8') && core::getSetting('id_charset')) {
					$sh = new ConvertCharset(core::getSetting('id_charset'), "utf-8");
					$str = $sh->Convert($str);
				}

				preg_match('/([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)/uis', $str, $out);

				$email = isset($out[0]) ? $out[0] : '';
				$name = str_replace($email, '', $str);
				$email = strtolower($email);
				$name = trim($name);

				if (strlen($name) > 250) {
					$name = '';
				}

				if ($email) {
					$query = "SELECT * FROM " . core::database()->getTableName('users') . " WHERE email='" . $email . "'";
					$result = core::database()->querySQL($query);

					if (core::database()->getRecordCount($result) > 0) {
						$row = core::database()->getRow($result);

						core::database()->delete(core::database()->getTableName('subscription'), "id_user=" . $row['id_user'], '');

						if ($id_cat) {
							foreach ($id_cat as $id) {
								if (is_numeric($id)) {
									$fields = array(
                                        'id_sub'  => 0,
                                        'id_user' => $row['id_user'],
                                        'id_cat'  => $id
                                    );

									core::database()->insert($fields, core::database()->getTableName('subscription'));
								}
							}
						}
					} else {
						$fields = array(
                            'id_user' => 0,
                            'name'    => $name,
                            'email'   => $email,
                            'token'   => Pnl::getRandomCode(),
                            'time'    => date("Y-m-d H:i:s"),
                            'status'  =>  'active',
                            'time_send' => '0000-00-00 00:00:00'
                        );

						$insert_id = core::database()->insert($fields, core::database()->getTableName('users'));

						if ($insert_id) $count++;

						if ($id_cat) {
							foreach ($id_cat as $id) {
								if (is_numeric($id)) {
									$fields = array(
                                        'id_sub'  => 0,
                                        'id_user' => $insert_id,
                                        'id_cat'  => $id,
                                    );

									core::database()->insert($fields, core::database()->getTableName('subscription'));
								}
							}
						}
					}
				}
			}
		}

		return $count;
	}
}