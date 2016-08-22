<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');


class Model_log extends Model
{

    public function getLogArr($pnumber = 10, $page)
    {
        $table = core::database()->getTableName('log');
        core::database()->parameters = "*,DATE_FORMAT(time,'%d.%m.%Y %H:%i') as send_time";
        core::database()->tablename = core::database()->getTableName('log');
        core::database()->order = 'ORDER BY id_log desc';
        core::database()->pnumber = $pnumber;
        core::database()->page = $page;
        return core::database()->get_page();
    }

    public function getTotal()
    {
        core::database()->tablename = core::database()->getTableName('log');
        $number = intval((core::database()->get_total() - 1) / core::database()->pnumber) + 1;
        return $number;
    }

    public function getPageNumber()
    {
        return core::database()->page;
    }

    public function getDetaillog($strtmp, $id_log, $number = 10)
    {
        if (is_numeric($id_log)) {
            $query = "SELECT *, a.time as time, c.name as catname, s.name as name FROM " . core::database()->getTableName('ready_send') . " a
					    LEFT JOIN " . core::database()->getTableName('users') . " b ON b.id_user=a.id_user
					    LEFT JOIN " . core::database()->getTableName('template') . " s ON a.id_template=s.id_template
					    LEFT JOIN " . core::database()->getTableName('category') . " c ON s.id_cat=c.id_cat
					    WHERE id_log=" . $id_log . "
					    ORDER BY " . $strtmp . "
					    LIMIT " . $number . "";

            $result = core::database()->querySQL($query);
            return core::database()->getColumnArray($result);
        }
    }

    public function countLetters($id_log)
    {
        if (is_numeric($id_log)) {
            $query = "SELECT * FROM " . core::database()->getTableName('ready_send') . " WHERE id_log=" . $id_log;
            $result = core::database()->querySQL($query);
            return core::database()->getRecordCount($result);
        }
    }

    public function countSent($id_log)
    {
        if(is_numeric($id_log)) {
            $query = "SELECT * FROM " . core::database()->getTableName('ready_send') . " WHERE success='yes' and id_log=" . $id_log . "";
            $result = core::database()->querySQL($query);
            return core::database()->getRecordCount($result);
        }
    }

    public function countRead($id_log)
    {
        $id_log = core::database()->escape($id_log);
        $query = "SELECT * FROM " . core::database()->getTableName('ready_send') . " WHERE readmail='yes' and id_log=" . $id_log;
        $result = core::database()->querySQL($query);
        return core::database()->getRecordCount($result);
    }

    public function clearLog()
    {
        $delete1 = core::database()->delete(core::database()->getTableName('log'));
        $delete2 = core::database()->delete(core::database()->getTableName('ready_send'));
        
        if ($delete1 && $delete2)
            return true;
        else
            return false;
    }
}