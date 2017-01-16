<?php

/********************************************
 * PHP Newsletter 5.0.6
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_accounts extends Model
{
    /**
     * @param $password
     * @return mixed
     */
    public function changePassword($password)
    {
        $password = md5(trim($password));
        $query = "UPDATE " . core::database()->getTableName('aut') . " SET password='".$password."'";
        $result = core::database()->querySQL($query);
        return $result;
    }

    /**
     * @return mixed
     */
    public function getAccountList()
    {
        $query = "SELECT * FROM " . core::database()->getTableName('aut') . "";
        $result = core::database()->querySQL($query);
        return core::database()->getColumnArray($result);
    }

    /**
     * @param $id
     * @return bool
     */
    public function removeAccount($id)
    {
        if (is_numeric($id)) {
            $result = core::database()->delete(core::database()->getTableName('aut'), "id=" . $id, '');
            if ($result)
                return true;
            else
                return false;
        }
    }
}