<?php

/********************************************
 * PHP Newsletter 5.3.2
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_expired extends Model
{
    /**
     * @param $licensekey
     * @return mixed
     */
    public function addLicenseKey($licensekey)
    {
        $licensekey = core::database()->escape($licensekey);
        $data = ['licensekey' => $licensekey];

        return core::database()->insert($data, core::database()->getTableName('licensekey'));
    }

    /**
     * @param $licensekey
     * @return mixed
     */
    public function updateLicenseKey($licensekey)
    {
        $licensekey = core::database()->escape($licensekey);
        $fields = ['licensekey' => $licensekey];

        return core::database()->update($fields, core::database()->getTableName('licensekey'), '');
    }

    /**
     * @return mixed
     */
    public function getLicenseKey()
    {
        $query = "SELECT * FROM ".core::database()->getTableName('licensekey');
        $result = core::database()->querySQL($query);
        $row = core::database()->getRow($result);

        return $row['licensekey'];
    }
}