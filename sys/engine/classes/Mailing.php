<?php

/********************************************
 * PHP Newsletter 5.0.6
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Mailing
{
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