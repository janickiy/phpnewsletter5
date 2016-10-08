<?php

/********************************************
 * PHP Newsletter 5.0.1 beta
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Mailing
{
    public static function getCurrentMailingStatus()
    {
        $query = "SELECT * FROM " . core::database()->getTableName('process') . "";
        $result = core::database()->querySQL($query);
        $row = core::database()->getRow($result);

        return $row['process'];
    }
}