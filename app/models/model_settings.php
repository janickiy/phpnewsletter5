<?php

/********************************************
 * PHP Newsletter 5.2.2
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_settings extends Model
{
    /**
     * @return array
     */
    public function getCharsetList()
    {
        $temp = Array();
        $query = "SELECT * FROM " . core::database()->getTableName('charset');
        $result = core::database()->querySQL($query);
        while ($row = core::database()->getRow($result)) {
            $temp[$row['id_charset']] = Pnl::charsetlist($row['charset']);
        }
        return $temp;
    }

    /**
     * @param $fields
     * @return bool
     */
    public function updateSettings($fields)
    {
        $result = core::database()->update($fields, core::database()->getTableName('settings'), '');
        
        if ($result)
            return true;
        else
            return false;
    }

    /**
     *
     */
    public function addHeaders()
    {
        if (count(Core_Array::getPost('header_name')) > 0) {
            for($i = 0; $i < count(Core_Array::getPost('header_name')); $i++) {
                $name = Core_Array::getPost('header_name');
                $value = Core_Array::getPost('header_value');
                $name[$i] = trim($name[$i]);
                $value[$i] = trim($value[$i]);

                if (preg_match("/^[\-a-zA-Z]+$/", $name[$i])) {
                    $value[$i] = str_replace(';', '', $value[$i]);
                    $value[$i] = str_replace(':', '', $value[$i]);
                    if ($name[$i] && $value[$i]) {
                        $fields = array(
                            'id' => 0,
                            'name' => $name[$i],
                            'value'  => $value[$i]
                        );

                        core::database()->insert($fields, core::database()->getTableName('сustomheaders'));
                    }
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function clearHeaders()
    {
        $delete = core::database()->delete(core::database()->getTableName('сustomheaders'));

        if ($delete)
            return true;
        else
            return false;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        $query = "SELECT * FROM " . core::database()->getTableName('сustomheaders');
        $result = core::database()->querySQL($query);
        return core::database()->getColumnArray($result);
    }
}