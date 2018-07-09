<?php

/********************************************
 * PHP Newsletter 5.3.2
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_subscribe extends Model
{
    /**
     * @param $id_user
     * @return mixed
     */
    public function getToken($id_user)
    {
        if (is_numeric($id_user)) {
            $query = "SELECT token FROM " . core::database()->getTableName('users') . " WHERE id_user=" . $id_user;
            $result = core::database()->querySQL($query);
            $row = core::database()->getRow($result);
            return $row['token'];
        }
    }

    /**
     * @param $id_user
     * @return mixed
     */
    public function makeActivateSub($id_user)
    {
        if (is_numeric($id_user)) {
            $query = "UPDATE " . core::database()->getTableName('users') . " SET status='active' WHERE id_user=" . $id_user;
            return core::database()->querySQL($query);
        }
    }
}