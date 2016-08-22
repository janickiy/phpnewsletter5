<?php

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

