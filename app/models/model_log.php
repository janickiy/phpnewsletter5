<?php

/********************************************
 * PHP Newsletter 5.3.2
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_log extends Model
{
    /**
     * @param int $pnumber
     * @param $page
     * @return mixed
     */
    public function getLogArr($pnumber = 10, $page)
    {
        core::database()->parameters = "*,DATE_FORMAT(l.time,'%d.%m.%Y %H:%i') AS send_time, count(r.id_log) AS lettercount, SUM(r.success='yes') AS countsent, SUM(r.readmail='yes') AS countread, l.id_log AS id_log ";
        core::database()->tablename = core::database()->getTableName('log') . " AS l ";
        core::database()->tablename .= "LEFT JOIN " . core::database()->getTableName('ready_send') . " AS r ON l.id_log=r.id_log ";
        core::database()->order = 'ORDER BY l.id_log desc';
        core::database()->group = 'GROUP BY l.id_log';
        core::database()->pnumber = $pnumber;
        core::database()->page = $page;
        return core::database()->get_page();
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        core::database()->tablename = core::database()->getTableName('log');
        $number = intval((core::database()->get_total() - 1) / core::database()->pnumber) + 1;
        return $number;
    }

    /**
     * @return mixed
     */
    public function getPageNumber()
    {
        return core::database()->page;
    }

    /**
     * @param $strtmp
     * @param $id_log
     * @param int $number
     * @return mixed
     */
    public function getDetaillog($strtmp, $id_log, $number = 10)
    {
        if (is_numeric($id_log)) {
            $query = "SELECT *, a.time AS time, c.name AS catname, s.name AS name FROM " . core::database()->getTableName('ready_send') . " a
					    LEFT JOIN " . core::database()->getTableName('template') . " s ON a.id_template=s.id_template
					    LEFT JOIN " . core::database()->getTableName('category') . " c ON s.id_cat=c.id_cat
					    WHERE id_log=" . $id_log . "
					    ORDER BY " . $strtmp . "
					    LIMIT " . $number;

            $result = core::database()->querySQL($query);
            return core::database()->getColumnArray($result);
        }
    }

    /**
     * @return bool
     */
    public function clearLog()
    {
        core::session()->start();
        core::session()->delete('id_log');
        core::session()->commit();

        $delete1 = core::database()->delete(core::database()->getTableName('log'));
        $delete2 = core::database()->delete(core::database()->getTableName('ready_send'));
        
        if ($delete1 && $delete2)
            return true;
        else
            return false;
    }
}