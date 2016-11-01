<?php

/********************************************
 * PHP Newsletter 5.0.2
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');


class Model_subscribers extends Model
{
    public function getSubersArr($strtmp, $search, $category, $page, $pnumber)
    {
        core::database()->tablename = core::database()->getTableName('users');
        if ($search) {
            $_search = core::database()->escape($search);
            
            $temp = strtok($_search, " ");
            $temp = "%" . $temp . "%";
            $logstr = "or";
            $tmpl = null;
            $is_query = null;

            while ($temp) {
                if ($is_query)
                    $tmpl .= " $logstr (name LIKE '" . $temp . "' OR email LIKE '" . $temp . "') ";
                else
                    $tmpl .= "(name LIKE '" . $temp . "' OR email LIKE '" . $temp . "') ";
                
                $is_query = true;
                $temp = strtok(" ");
            }
            
            core::database()->parameters = "*,DATE_FORMAT(time,'%d.%m.%y') as putdate_format";
            core::database()->where = "WHERE " . $tmpl . "";
            core::database()->group = "GROUP BY id_user";
            core::database()->order = "ORDER BY name";
        } elseif (is_numeric($category)) {
            core::database()->tablename = "" . core::database()->getTableName('users') . " usr LEFT JOIN " . core::database()->getTableName('subscription') . " sub ON usr.id_user=sub.id_user";
            $_where = (isset($category) && $category > 0) ? "sub.id_cat=" . $category . " " : "1";
            core::database()->parameters = "*,DATE_FORMAT(time,'%d.%m.%y') as putdate_format, usr.name AS name";
            core::database()->where = "WHERE " . $_where . " ";
            core::database()->order = "ORDER BY usr.name";
        } else {
            core::database()->parameters = "*,DATE_FORMAT(time,'%d.%m.%y') as putdate_format";
            core::database()->order = "ORDER BY " . $strtmp . "";
        }
        
        core::database()->pnumber = $pnumber;
        core::database()->page = $page;
        return core::database()->get_page();
    }

    public function countSubscribers()
    {
        if (Core_Array::getRequest('search')) {
            $_search = core::database()->escape(Core_Array::getRequest('search'));
            
            $temp = strtok($_search, " ");
            $temp = "%" . $temp . "%";
            $logstr = "or";
            $tmpl = null;
            $is_query = null;

            while ($temp) {
                if ($is_query)
                    $tmpl .= " $logstr (name LIKE '" . $temp . "' OR email LIKE '" . $temp . "') ";
                else
                    $tmpl .= "(name LIKE '" . $temp . "' OR email LIKE '" . $temp . "') ";
                
                $is_query = true;
                $temp = strtok(" ");
            }
            
            $query = "SELECT *,DATE_FORMAT(time,'%d.%m.%y') as putdate_format FROM " . core::database()->getTableName('users') . " WHERE " . $tmpl . " GROUP BY id_user";
        } elseif (Core_Array::getRequest('category')) {
            $cat = core::database()->escape(Core_Array::getRequest('category'));
            $_where = (isset($cat) && $cat > 0) ? "sub.id_cat=" . $cat . " " : "1";
            
            $query = "SELECT *,DATE_FORMAT(time,'%d.%m.%y') as putdate_format FROM " . core::database()->getTableName('users') . " usr LEFT JOIN " . core::database()->getTableName('subscription') . " sub ON usr.id_user=sub.id_user  WHERE " . $_where . " ";
        } else {
            $query = "SELECT *,DATE_FORMAT(time,'%d.%m.%y') as putdate_format FROM " . core::database()->getTableName('users');
        }
        $result = core::database()->querySQL($query);
        return core::database()->getRecordCount($result);
    }

    public function getTotal()
    {
        if (Core_Array::getRequest('category')) {
            $cat = core::database()->escape(Core_Array::getRequest('category'));
            $_where = (isset($cat) && $cat > 0) ? "WHERE sub.id_cat=" . $cat . " " : "1";
            core::database()->tablename = core::database()->getTableName('users') . " usr LEFT JOIN " . core::database()->getTableName('subscription') . " sub ON usr.id_user=sub.id_user";
        } else
            core::database()->tablename = core::database()->getTableName('users');

        $number = intval((core::database()->get_total() - 1) / core::database()->pnumber) + 1;
        
        return $number;
    }

    public function getPageNumber()
    {
        return core::database()->page;
    }

    public function updateUsers($activate, $action = 'active')
    {
        $temp = array();
        $fields = array();
        
        foreach ($activate as $id_user) {
            if (is_numeric($id_user))
                $temp[] = $id_user;
        }
        
        $fields['status'] = ($action == 'active') ? 'active' : 'noactive';
        $where = "id_user IN (" . implode(",", $temp) . ")";
        $table = core::database()->getTableName('users');
        $result = core::database()->update($fields, $table, $where);
        unset($temp);
        
        return $result;
    }

    public function deleteUsers($activate)
    {
        $temp = array();
        
        foreach ($activate as $id_user) {
            if (is_numeric($id_user)) {
                $temp[] = $id_user;
            }
        }
        
        $result = core::database()->delete(core::database()->getTableName('users'), "id_user IN (" . implode(",", $temp) . ")");
        if ($result) {
            $result = core::database()->delete(core::database()->getTableName('subscription'), "id_user IN (" . implode(",", $temp) . ")");
            unset($temp);
            
            return $result;
        } else
            return false;
    }

    public function removeAllUsers()
    {
        $delete1 = core::database()->delete(core::database()->getTableName('users'));
        $delete2 = core::database()->delete(core::database()->getTableName('subscription'));
        
        if ($delete1 && $delete2)
            return true;
        else
            return false;
    }

    public function removeUser($id_user)
    {
        if (is_numeric($id_user)) {
            $delete1 = core::database()->delete(core::database()->getTableName('users'), "id_user=" . $id_user);
            $delete2 = core::database()->delete(core::database()->getTableName('subscription'), "id_user=" . $id_user);

            if ($delete1 && $delete2)
                return true;
            else
                return false;
        }
    }
}