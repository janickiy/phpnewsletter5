<?php

/********************************************
 * PHP Newsletter 5.3.2
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_create_template extends Model
{
	/**
	 * @return mixed
	 */
	public function getCategoryOptionList()
	{
 		$query = "SELECT * FROM " . core::database()->getTableName('category') . " ORDER BY name";
        $result = core::database()->querySQL($query);

		return core::database()->getColumnArray($result);
	}

	/**
	 * @param $fields
	 * @return bool
	 */
	public function addNewTemplate($fields)
	{
		$parameters = 'MAX(pos)';
		$from = core::database()->getTableName('template');
		$result = core::database()->select($parameters,$from,'','','','');
		$total = core::database()->getRow($result, 'assoc');
		
		$fields['pos'] = ($total)? $total['MAX(pos)'] + 1 : 1; 
		$id_insert = core::database()->insert($fields, core::database()->getTableName('template'));
		
		if ($id_insert){
			for ($i = 0; $i < count($_FILES["attachfile"]["name"]); $i++) {
				if (!empty($_FILES["attachfile"]["name"][$i])){
					$ext = strrchr($_FILES['attachfile']['name'][$i], ".");
					$attachfile = core::pathTo(core::getPath('attach'), date("YmdHis", time()) . $i . $ext);
			
					if (@copy($_FILES['attachfile']['tmp_name'][$i], $attachfile)) {
						@unlink($_FILES['attachfile']['tmp_name'][$i]); 
					}

					$attachfields = [
                        'id_attachment' => 0,
                        'name' => $_FILES['attachfile']['name'][$i],
                        'path' => $attachfile,
                        'id_template' => $id_insert
                    ];
				
					core::database()->insert($attachfields, core::database()->getTableName('attach'));
				}		
			}
			
			return $id_insert;
		} else
			return false;
	}
}