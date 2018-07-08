<?php

/********************************************
 * PHP Newsletter 5.3.1
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_category extends Model
{

    /**
     * @return mixed
     */
    public function getCategoryArr()
    {
        $query = "SELECT c.id_cat,c.name,count(s.id_cat) AS subcount FROM " . core::database()->getTableName('category') . " AS c 
                    LEFT JOIN " . core::database()->getTableName('subscription') . " AS s ON c.id_cat=s.id_cat
                    GROUP BY c.id_cat
                    ORDER BY c.name                    
                    ";
        $result = core::database()->querySQL($query);
        return core::database()->getColumnArray($result);
    }

    /**
     * @param $id_cat
     * @return bool
     */
    public function removeCategory($id_cat)
    {
        if (is_numeric($id_cat)) {
            $result = core::database()->delete(core::database()->getTableName('category'), "id_cat=" . $id_cat, '');

            return ($result) ? core::database()->delete(core::database()->getTableName('subscription'), "id_cat=" . $id_cat, '') : false;
        }
    }
}