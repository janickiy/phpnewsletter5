<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Auth
{
    public static function authorization()
    {
        if (!isset($_SESSION['sess_admin']) || !isset($_SESSION['id'])) {
            $_SESSION['id'] = '';
            $_SESSION['sess_admin'] = '';
        }
        
        if (Core_Array::getRequest('admin')) {
            $login = trim(core::database()->escape(Core_Array::getPost('login')));
            $query = "SELECT * FROM " . core::database()->getTableName('aut') . " WHERE login='" . $login . "'";
            $result = core::database()->querySQL($query);
            $row = core::database()->getRow($result);

            if ($_SESSION['sess_admin'] != "ok")
                $sess_pass = md5(trim(Core_Array::getRequest('password')));
            
            if ($sess_pass === $row['password']) {
                $_SESSION['sess_admin'] = "ok";
                $_SESSION['id'] = $row['id'];
            } else {
                self::logOut();

                echo '<!DOCTYPE html>
				<html>
				<head>
				<title>' . core::getLanguage('title', 'error_authorization') . '</title>
				<meta http-equiv="content-type" content="text/html; charset=utf-8">
				</head>
				<body>
				<script type="text/javascript">
				window.alert(\'' . core::getLanguage('alert', 'not_authorized') . '\');
				window.location.href=\'' . $_SERVER['PHP_SELF'] . '\';
				</script>
				</body>
				</html>';
                
                exit();
            }
        } else {
            if ($_SESSION['sess_admin'] != "ok") {

				// require temlate class
				core::requireEx('libs', "html_template/SeparateTemplate.php");

				$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . "authorization.tpl");
				$tpl->assign('TITLE', core::getLanguage('title', 'authorization'));
				$tpl->assign('STR_ADMIN_AREA', core::getLanguage('str', 'admin_area'));
				$tpl->assign('SCRIPT_NAME', core::getLanguage('str', 'script_name'));
				$tpl->assign('STR_SIGN_IN', core::getLanguage('str', 'sign_in'));
                $tpl->assign('STR_LOGIN', core::getLanguage('str', 'login'));
				$tpl->assign('STR_PASSWORD', core::getLanguage('str', 'password'));
				
				// display content
				$tpl->display();				
        
                exit();
            }
        }
    }

    public static function getCurrentHash($id)
    {
        if (is_numeric($id)) {
            $query = "SELECT * FROM " . core::database()->getTableName('aut') . " WHERE id=" . $id;
            $result = core::database()->querySQL($query);
            $row = core::database()->getRow($result);

            return $row['password'];
        }
    }

    public static function logOut()
    {
        unset($_SESSION['sess_admin']);
        unset($_SESSION['id']);
    }

    public static function getAutInfo($id)
    {
        if (is_numeric($id)){
            $query = "SELECT * FROM " . core::database()->getTableName('aut') . " WHERE id=" . $id;
            $result = core::database()->querySQL($query);
            return core::database()->getRow($result);
        }
    }
}