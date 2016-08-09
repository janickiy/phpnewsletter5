<?php



defined('LETTER') || exit('NewsLetter: access denied.');


class Auth
{

    public static function authorization()
    {
        if (!isset($_SESSION['sess_admin'])) $_SESSION['sess_admin'] = '';

        $query = "SELECT * FROM " . core::database()->getTableName('aut') . "";
        $result = core::database()->querySQL($query);
        $row = core::database()->getRow($result);
        
        if (Core_Array::getRequest('admin')) {
            if ($_SESSION['sess_admin'] != "ok")
                $sess_pass = md5(trim(Core_Array::getRequest('password')));
            
            if ($sess_pass === $row['password']) {
                $_SESSION['sess_admin'] = "ok";
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
				$tpl->assign('SCRIPT_NAME', core::getLanguage('script', 'name'));
				$tpl->assign('STR_SIGN_IN', core::getLanguage('str', 'sign_in'));
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
        if (isset($_SESSION['sess_admin'])) unset($_SESSION['sess_admin']);
        if (isset($_SESSION['id'])) unset($_SESSION['id']);
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

?>