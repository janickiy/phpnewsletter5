<?php

/********************************************
 * PHP Newsletter 5.2.1
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_redirect_log extends Model
{
    /**
     * @param int $pnumber
     * @param $page
     * @return mixed
     */
    public function getLogArr($pnumber = 10, $page)
    {
        core::database()->parameters = "*,DATE_FORMAT(time,'%d.%m.%Y %H:%i') AS referrals_time, COUNT(email) AS number_redirect";
        core::database()->tablename = core::database()->getTableName('redirect_log');
        core::database()->order = 'ORDER BY id DESC';
        core::database()->group = 'GROUP BY url';
        core::database()->pnumber = $pnumber;
        core::database()->page = $page;
        return core::database()->get_page();
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        core::database()->tablename = core::database()->getTableName('redirect_log');

        $number = intval((core::database()->get_total('DISTINCT url') - 1) / core::database()->pnumber) + 1;
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
     * @param $url
     * @param int $number
     * @return mixed
     */
    public function getDetaillog($strtmp, $url, $number = 10)
    {
        $url = trim(core::database()->escape($url));

        if (!empty($url)) {
            $query = "SELECT * FROM " . core::database()->getTableName('redirect_log') . "
                        WHERE url LIKE '" . $url . "'
					    ORDER BY " . $strtmp . "
					    LIMIT " . $number;

            $result = core::database()->querySQL($query);
            return core::database()->getColumnArray($result);
        }
    }

    /**
     * @param $url
     * @return mixed
     */
    public function countReferrals($url)
    {
        $url = trim(core::database()->escape($url));

        if (!empty($url)) {
            $query = "SELECT * FROM " . core::database()->getTableName('redirect_log') . " WHERE url='" . $url . "'";
            $result = core::database()->querySQL($query);
            return core::database()->getRecordCount($result);
        }
    }

    /**
     * @return mixed
     */
    public function clearLog()
    {
        return core::database()->delete(core::database()->getTableName('redirect_log'));
    }
}