<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_settings extends Model
{
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

    public function updateSettings($fields)
    {
        $result = core::database()->update($fields, core::database()->getTableName('settings'), '');
        
        if ($result)
            return true;
        else
            return false;
    }
}

?>