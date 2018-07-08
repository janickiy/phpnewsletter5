<?php

/********************************************
 * PHP Newsletter 5.3.2
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Mailing
{
    /**
     * @param $id_user
     * @return mixed
     */
    public static function getCurrentMailingStatus($id_user)
    {
        if (is_numeric($id_user)) {
            $query = "SELECT * FROM " . core::database()->getTableName('process') . " WHERE id_user=" . $id_user;
            $result = core::database()->querySQL($query);
            $row = core::database()->getRow($result);

            return $row['process'];
        }
    }
}