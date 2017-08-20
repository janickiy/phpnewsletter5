<?php

/********************************************
 * PHP Newsletter 5.2.0
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_redirectlogstatxls extends Model
{
    /**
     * @param $url
     * @return mixed
     */
    public function getLogList ($url)
    {
        $url = trim(core::database()->escape($url));

        if (!empty($url)) {
            $query = "SELECT * FROM " . core::database()->getTableName('redirect_log') . " WHERE url='" . $url . "'";
            $result = core::database()->querySQL($query);
            return core::database()->getColumnArray($result);
        }
    }
}