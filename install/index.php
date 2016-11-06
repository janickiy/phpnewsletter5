<?php

/********************************************
 * PHP Newsletter 5.0.2
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

error_reporting(0);
session_start();

$INSTALL = array();
$INSTALL["version"] = '5.0.2';

$INSTALL["system"]["dir_config"] = 'config/';
$SCRIPT_URL = substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'],"install/"));

$_SESSION['domain'] = (substr($_SERVER['SERVER_NAME'], 0, 4)) == "www." ? str_replace('www.','', $_SERVER['SERVER_NAME']) : $_SERVER['SERVER_NAME'];

// Step
$INSTALL['step_count'] = 7;
$INSTALL['step'] = 1;

if (!empty($_POST['step']) && is_numeric($_POST['step'])){
	$INSTALL['step'] = $_POST['step'];
} elseif (!empty($_GET['step']) && is_numeric($_GET['step'])){
	$INSTALL['step'] = $_GET['step'];
}

if ($INSTALL['step'] < 1 or $INSTALL['step'] > $INSTALL['step_count']){
	$INSTALL['step'] = 1;
}

// language
$INSTALL['available_langs'] = array(
	'en' => 'English',
	'ru' => 'Russian'
);

if ($INSTALL['step'] == 1 && isset($_POST['forward'])){
	$_SESSION['language'] = $_POST['language'];
}

if ($INSTALL['step'] == 2) {
	if ($_POST['license_key'])
		$_SESSION['license_key'] = trim($_POST['license_key']);
	else
		$_SESSION['license_key'] = 'DEMO';
}

$INSTALL['language'] = !empty($_SESSION['language']) ? $_SESSION['language'] : null;

if (empty($INSTALL['language']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
	preg_match_all('/([a-z-]+)(?:;q=([0-9.]+))?/', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $accept_langs);

	foreach ($accept_langs[1] as $lang) {
		$code = substr($lang, 0, 2);

		if ($code == 'en') {
			$INSTALL['language'] = 'en';
			break;
		}

		if ($code == 'ru') {
			$INSTALL['language'] = 'ru';
			break;
		}
	}
}

if (empty($INSTALL['language']) or !isset($INSTALL['available_langs'][$INSTALL['language']])) {
	$INSTALL['language'] = 'en';
}

if ($INSTALL['language'])
	$lang_file = $INSTALL['language'].'.php';
else 
	$lang_file = "en.php";

if (file_exists($lang_file))
	include $lang_file;
else
	exit('ERROR: Language file can not load!');

$INSTALL['step_title'] = array(
	1 => $INSTALL["lang"]["str"]["install_lang_select"],
	2 => $INSTALL["lang"]["str"]["license_key"],
	3 => $INSTALL["lang"]["str"]["license"],	
	4 => $INSTALL["lang"]["str"]["system_req"],
	5 => $INSTALL["lang"]["str"]["db_and_product_settings"],
	6 => $INSTALL["lang"]["str"]["db_and_product_settings"],
	7 => $INSTALL["lang"]["str"]["install_completion"],
);

$INSTALL['tables'] = array(
	'attach',
	'aut',
	'category',
	'charset',
	'licensekey',
	'log',
	'process',
	'ready_send',
	'settings',
	'subscription',
	'template',
	'users',
);

// Handlers
if ($INSTALL['step'] == 1 && isset($_POST['forward'])){
	$_POST = array();
	$INSTALL['step'] = 2;
}

if ($INSTALL['step'] == 2 && isset($_POST['forward'])){
	$_POST = array();
	$INSTALL['step'] = 3;
}

if ($INSTALL['step'] == 3 && isset($_POST['forward'])){
	$_POST = array();
	$INSTALL['step'] = 4;
}

if ($INSTALL['step'] == 4 && isset($_POST['forward'])){
	$_POST = array();
	$INSTALL['step'] = 5;
}

if ($INSTALL['step'] == 5){
	$INSTALL['type'] = null;
	$INSTALL['version_detect'] = null;
	
	if (isset($_POST["forward"])){
		// DB params
		
		$_POST["name"] = trim($_POST["name"]);
		$_POST['host'] = trim($_POST['host']);
		$_POST['user'] = trim($_POST['user']);
		$_POST['password'] = trim($_POST['password']);	
		$_POST['prefix'] = trim($_POST['prefix']);	

		if (empty($_POST['host'])){
			$INSTALL['errors'][] = $INSTALL["lang"]["error"]["must_be_enter_dbserver"];
		}

		if (empty($_POST['user'])){
			$INSTALL['errors'][] = $INSTALL["lang"]["error"]["must_be_enter_dblogin"];
		}

		if (empty($_POST['name'])){
			$INSTALL['errors'][] = $INSTALL["lang"]["error"]["must_be_enter_dbname"];
		}

		$_POST['lang'] = 'en';

        if ($INSTALL['language'] == 'ru'){
			$_POST['lang'] = 'ru';
		}

		if (!$INSTALL['errors']){
			$dbh = new mysqli($_POST['host'], $_POST['user'], $_POST['password']);

			if (mysqli_connect_errno()){
				$INSTALL['errors'][] = $INSTALL["lang"]["error"]["dbconnect_error"];
			} else {
				$dbh->query("SET NAMES 'utf8'");
				
				if (!$dbh->select_db($_POST["name"])){
					if ($dbh->query("CREATE DATABASE ".$dbh->real_escape_string($_POST['name']))){
						$dbh->select_db($_POST["name"]);
                    } else {
						$INSTALL['errors'][] = $INSTALL["lang"]["error"]["dbcreate_error"];
                    }
				}
			}
		}
        
		if (!$INSTALL['errors']){
			$tables = array();

			if ($res1 = $dbh->query("SHOW TABLES FROM `".$dbh->real_escape_string($_POST['name'])."` LIKE '".$dbh->real_escape_string($_POST['prefix'])."%'")) {
				while ($row1 = $res1->fetch_row()){
					$res2 = $dbh->query("DESCRIBE `".$row1[0]."`");
					$tables[substr($row1[0], strlen($_POST['prefix']))] = array();

					while($row2 = $res2->fetch_row()) {
						$tables[substr($row1[0], strlen($_POST['prefix']))][] = $row2[0];
					}
				}
			}
			
			$exists_tables = array();

			foreach($INSTALL['tables'] as $table){
				if (isset($tables[$table])) {
					$exists_tables[] = $table;
				}
			}
			
			$INSTALL['version_detect'] = null;
			
			if ($exists_tables) {
				$INSTALL['version_detect'] = '5.0.0';
                $INSTALL['version_code'] = 50000;
			}
			
			$INSTALL['type'] = 'install';
			
			if ($INSTALL['version_detect']){
				preg_match("/(\d+)\.(\d+)\./", $INSTALL["version"], $out);
		
				$current_version_code = ($out[1] * 10000 + $out[2] * 100);
			
				if ($INSTALL['version_code'] != $current_version_code){
					$INSTALL['type'] = 'update';
				} else {
					$INSTALL['type'] = 'clear';
				}
            }
			
			$_POST['action'] = isset($_POST['action']) ? $_POST['action'] : '';
			
			if ($INSTALL['type'] == 'update'){
				if ($_POST['action'] == 'update') {
					if (count($INSTALL['errors']) == 0){
						$_SESSION['name'] = $_POST["name"];
						$_SESSION['host'] = $_POST['host'];
						$_SESSION['user'] = $_POST['user'];
						$_SESSION['password'] = $_POST['password'];						
						$_SESSION['prefix'] = $_POST['prefix'];
					
						$_POST = array();
						$INSTALL['step'] = 6;
					}	
				} elseif ($_POST['action'] == 'clear') {
					$tables_drop = array();
        
					foreach($INSTALL['tables'] as $table) {
						$tables_drop[] = '`'.$_POST['prefix'].$table.'`';
					}

					if (count($tables_drop) > 0) {
						$dbh->query('DROP TABLE IF EXISTS '.implode(',', $tables_drop));
					}

					import_scheme('sql/phpnewsletter.sql', $_POST['prefix']);
					import_data('sql/phpnewsletter_data_'.$INSTALL['language'].'.sql', $_POST['prefix']);
            
					if (count($INSTALL['errors']) == 0){
						$_SESSION['name'] = $_POST["name"];
						$_SESSION['host'] = $_POST['host'];
						$_SESSION['user'] = $_POST['user'];
						$_SESSION['password'] = $_POST['password'];						
						$_SESSION['prefix'] = $_POST['prefix'];
        
						$_POST = array();
						$INSTALL['step'] = 6;
					}
				}
			} elseif ($_POST['action'] == 'clear'){
				if ($INSTALL['version_detect'] && $_POST['action'] == 'clear'){
					$tables_drop = array();
					 
					foreach ($INSTALL['tables'] as $table){
						$tables_drop[] = '`'.$_POST['prefix'].$table.'`';
					}
					
					if (count($tables_drop) > 0){
                        $dbh->query('DROP TABLE IF EXISTS '.implode(',', $tables_drop));
                    }
					
					import_scheme('sql/phpnewsletter.sql', $_POST['prefix']);
					import_data('sql/phpnewsletter_data_'.$INSTALL['language'].'.sql', $_POST['prefix']);
					
					if (count($INSTALL['errors']) == 0){
						$_SESSION['name'] = $_POST["name"];
						$_SESSION['host'] = $_POST['host'];
						$_SESSION['user'] = $_POST['user'];
						$_SESSION['password'] = $_POST['password'];						
						$_SESSION['prefix'] = $_POST['prefix'];
					
                        $_POST = array();
                        $INSTALL['step'] = 6;
                    }
				} elseif ($_POST['action'] == 'clear') {
					$tables_drop = array();
        
					foreach($INSTALL['tables'] as $table) {
						$tables_drop[] = '`'.$_POST['prefix'].$table.'`';
					}

					if (count($tables_drop) > 0) {
						$dbh->query('DROP TABLE IF EXISTS '.implode(',', $tables_drop));
					}

					import_scheme('sql/phpnewsletter.sql', $_POST['prefix']);
            
					if (count($INSTALL['errors']) == 0){
						$_SESSION['name'] = $_POST["name"];
						$_SESSION['host'] = $_POST['host'];
						$_SESSION['user'] = $_POST['user'];
						$_SESSION['password'] = $_POST['password'];						
						$_SESSION['prefix'] = $_POST['prefix'];
        
						$_POST = array();
						$INSTALL['step'] = 6;
					}
                }
			} elseif ($INSTALL['type'] == 'install'){
                if ($_POST['action'] == 'install'){
                    import_scheme('sql/phpnewsletter.sql', $_POST['prefix']);
                    import_data('sql/phpnewsletter_data_' . $INSTALL['language'] . '.sql', $_POST['prefix']);

                    if (count($INSTALL['errors']) == 0){
						$_SESSION['name'] = $_POST["name"];
						$_SESSION['host'] = $_POST['host'];
						$_SESSION['user'] = $_POST['user'];
						$_SESSION['password'] = $_POST['password'];						
						$_SESSION['prefix'] = $_POST['prefix'];
					
						$_POST = array();
						$INSTALL['step'] = 6;
                    }
                }
            }			
        }
    } else {
        $_POST["host"] = "localhost";
        $_POST["prefix"] = "pnl_";
		$_POST["user"] = "root";
		$_POST["name"] = "phpnewsletter";
    }
}

if ($INSTALL['step'] == 6 && isset($_POST['forward'])){
	$_POST['password'] = trim($_POST['password']);
	$_POST['confirm_password'] = trim($_POST['confirm_password']);
	$_POST['login'] = trim($_POST['login']);

	if (empty($_POST['login'])) $INSTALL['errors'][] = $INSTALL["lang"]["error"]["enter_login"];
	if (empty($_POST['password'])){
		$INSTALL['errors'][] = $INSTALL["lang"]["error"]["must_be_enter_apass"];
	} elseif ($_POST['password'] != $_POST['confirm_password']){
		$INSTALL['errors'][] = $INSTALL["lang"]["error"]["invalid_confirm_apass"];
	}
	
	if (count($INSTALL['errors']) == 0){
		$password = md5($_POST['password']);
		$login = $_POST['login'];

		$dbh = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['name']);
		$result1 = $dbh->query("TRUNCATE TABLE `" . $_SESSION['prefix'] . "aut`");
		$result2 = $dbh->query("INSERT INTO `". $_SESSION['prefix'] . "aut` (`id`, `login`, `password`, `role`) VALUES (0, '" . $dbh->real_escape_string($login) . "', '" . $password . "', 'admin')");
		$result3 = $dbh->query("INSERT INTO `" . $_SESSION['prefix'] . "licensekey` (`licensekey`) VALUES ('" . $_SESSION['license_key'] . "')");

		if ($result1 && $result2 && $result3){
			$string = "<?php\n";
			$string .= "\$ConfigDB[\"host\"]  = \"".str_replace("\"", "\\\"", $_SESSION['host'])."\";\n";
			$string .= "\$ConfigDB[\"name\"] = \"".str_replace("\"", "\\\"", $_SESSION['name'])."\";\n";
			$string .= "\$ConfigDB[\"user\"] = \"".str_replace("\"", "\\\"", $_SESSION['user'])."\"; // login\n";
			$string .= "\$ConfigDB[\"passwd\"] = \"".str_replace("\"", "\\\"", $_SESSION['password'])."\"; // password\n";
			$string .= "\$ConfigDB[\"prefix\"] = \"".str_replace("\"", "\\\"", $_SESSION['prefix'])."\"; // prefix\n";
			$string .= "\$ConfigDB[\"charset\"] = \"utf8\"; // database charset\n";
			$string .= "?>";
	
			$f = @fopen("../" . $INSTALL["system"]["dir_config"] . "config_db.php","w");

			if (fwrite($f, $string) === FALSE){
				$_POST = array();
				$INSTALL['step'] = 6;
				$INSTALL['errors'][] = $INSTALL["lang"]["error"]["unwritabl_config"];						
			} else {
				$_POST = array();
				$INSTALL['step'] = 7;
			}
	
			fclose($f);
		} else {
			$_POST = array();
			$INSTALL['step'] = 6;
			$INSTALL['errors'][] = $INSTALL["lang"]["error"]["setting_product"];
		}
	}
}

$step_name = '' . $INSTALL["lang"]["str"]["install"] . ' %SCRIPT_NAME% %VERSION% %STEP% %NUM%/%COUNT% - %STEP_TITLE%';
$step_name = str_replace('%SCRIPT_NAME%', $INSTALL["lang"]["script"]["name"], $step_name);
$step_name = str_replace('%VERSION%', $INSTALL["version"], $step_name);
$step_name = str_replace('%STEP%', $INSTALL["lang"]["str"]["step"], $step_name);
$step_name = str_replace('%NUM%', $INSTALL['step'], $step_name);
$step_name = str_replace('%COUNT%', $INSTALL['step_count'], $step_name);
$step_name = str_replace('%STEP_TITLE%', $INSTALL['step_title'][$INSTALL['step']], $step_name);

header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo "" . $INSTALL["lang"]["script"]["name"] . "  " . $INSTALL["version"] . " | " . $INSTALL["lang"]["str"]["install"] . ""; ?></title>

	<!-- Bootstrap Core CSS -->
	<link href="../templates/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- MetisMenu CSS -->
	<link href="../templates/assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

	<!-- DataTables CSS -->
	<link href="../templates/assets/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="../templates/assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../templates/assets/dist/css/sb-admin-2.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="../templates/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link href="../templates/assets/styles/styles.css" rel="stylesheet">


	<script src="../templates/js/jquery.min.js"></script>
	<script src="../templates/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../templates/js/jquery.hide_alertblock.js"></script>

</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
				<div class="row" style="background-color: white">
					<div class="col-lg-12">
						<h2 class="page-header"><small><?php echo $step_name; ?></small></h2>
					</div>
					<div class="col-lg-12">

						<div class="panel panel-default">
							<div class="panel-heading">
								<a target="_blank" href="http://janicky.com/">PHP Newsletter</a> | <a target="_blank" href="<?php echo $INSTALL["lang"]["str"]["url_info"]; ?>"><?php echo $INSTALL["lang"]["str"]["install_manual"]; ?></a>
							</div>

							<div class="panel-body">
								<div class="table-responsive">

<?php

if ($INSTALL['step'] == 1){

	/*********
	  Step 1
	*********/

?>
      <form role="form" action="?" method="post">
        <input type="hidden" name="step" value="1" />
        <fieldset>
          <legend><?php echo $INSTALL["lang"]["str"]["install_lang_select"]; ?></legend>
			<div class="form-group">
            <label for="lang"><?php echo $INSTALL["lang"]["str"]["language"]; ?>:</label>
                  <select class="form-control" name="language">
<?php

    foreach ($INSTALL['available_langs'] as $code => $lang){
	
?>
                <option value="<?php echo $code; ?>"<?php echo $INSTALL['language'] == $code ? ' selected="selected"' : ''; ?>><?php echo $lang; ?></option>
<?php

    }
	
?>
              </select>

          </div>
        </fieldset>
        <div class="form-actions">
          <input type="submit" name="forward" class="btn btn-primary" value="<?php echo $INSTALL["lang"]["str"]["next"]; ?>" />
          <input type="button" class="btn" value="<?php echo $INSTALL["lang"]["str"]["cancel"]; ?>" onclick="location.href='../'" />
        </div>
      </form>
<?php

}
else if($INSTALL['step'] == 2){

	/*********
	  Step 2
	*********/

?>
<script type="text/javascript">
$(document).on('change','#license_key',function(){
	var licensekey = $("#license_key").val();

	$.ajax({
		type: "POST",
		url: "./check_license.php",
		data: "licensekey=" + licensekey + '&version=<?php echo $INSTALL["version"]; ?>&lang=<?php echo $_SESSION['language']; ?>',
		dataType: "json",
		success: function(data) {
			if (data.result == 'no') {
				$("#error_msg").text(data.error);
				$(".btn-primary").attr("disabled", "disabled");
			} else {
				$("#error_msg").text('');
				$('.btn-primary').removeAttr("disabled");
			}
		}
	});
});
	
</script>
<form role="form" action="?" method="post">
	<input type="hidden" name="step" value="2" />
	<fieldset>
		<legend><?php echo $INSTALL["lang"]["str"]["license_key"]; ?></legend>
		<div class="form-group">
				<label class="radio-inline">
					<input type="radio" onclick="document.getElementById('license_key').disabled='disabled'; this.form.forward.disabled=!this.checked;" name="license_key_type" value="demo" checked="checked"> <?php echo $INSTALL["lang"]["str"]["demo_version"]; ?>
				</label>
				<label class="radio-inline">
					<input type="radio" onclick="document.getElementById('license_key').disabled=''; this.form.forward.disabled=this.checked;" name="license_key_type" value="license_key"> <?php echo $INSTALL["lang"]["str"]["commercial_version"]; ?>
				</label>
			</div>
			<div class="form-group">
				<label for="license_key"><?php echo $INSTALL["lang"]["str"]["license_key"]; ?></label>

					<input id="license_key" class="form-control" type="text" name="license_key" disabled='disabled' value="DEMO"><span id="error_msg"></span>

			</div>			
	</fieldset>
	<div class="form-actions">
		<input type="submit" name="forward" class="btn btn-primary" value="<?php echo $INSTALL["lang"]["str"]["next"]; ?>" />
		<input type="button" class="btn" value="<?php echo $INSTALL["lang"]["str"]["cancel"]; ?>" onclick="location.href='../'" />
	</div>	
</form> 
<?php

} elseif ($INSTALL['step'] == 3){

	/*********
	  Step 3
	*********/
	
	$filename = '../LICENSE_' . strtoupper($INSTALL['language']);
	
	if ($handle = fopen($filename, "r")){
		$contents = fread($handle, filesize($filename));
		fclose($handle);
	}

?>
<form role="form" action="?" method="post">
	<input type="hidden" name="step" value="3" />
	<fieldset>
		<legend><?php echo $INSTALL["lang"]["str"]["license"]; ?></legend>
		<div class="form-group">
				<label><?php echo $INSTALL["lang"]["str"]["read_license"]; ?></label>
				<textarea class="form-control" name="readonly" rows="15"><?php echo $contents; ?></textarea>
			</div>

			<div class="form-group">
				<label class="checkbox-inline" for="accept_license">

					<input type="checkbox" id="accept_license" name="accept_license" onclick="this.form.forward.disabled=!this.checked;" /> <?php echo $INSTALL["lang"]["str"]["accept_license"]; ?>
				</label>

			</div>	
	</fieldset>
	<div class="form-actions">
		<input type="submit" name="forward" class="btn btn-primary"  value="<?php echo $INSTALL["lang"]["str"]["next"]; ?>" disabled="disabled"/>
		<input type="button" class="btn" value="<?php echo $INSTALL["lang"]["str"]["cancel"]; ?>" onclick="location.href='../'" />
	</div>
</form>
<?php

} elseif ($INSTALL['step'] == 4) {

	/*********
	  Step 4
	*********/

	$check = array();
    $info = array();
    
    $check["php_version"] = version_compare(PHP_VERSION, "5.3", ">=");
    $info["php_version"] = PHP_VERSION;
    $check["php_mysql"] = extension_loaded("mysql");
    $check["php_mbstring"] = extension_loaded("mbstring");
	$check["php_iconv"] = extension_loaded("iconv");
	$check["php_zip"] = extension_loaded("zip");
	$check["php_curl"] = extension_loaded("curl");

if (ini_get('register_globals') == 1) {
	
?>
<div class="alert alert-warning"> <a class="close" href="#" data-dismiss="alert">×</a>
	<p><?php echo $INSTALL["lang"]["warning"]["register_globals_on"] ; ?></p>
	<p><strong><?php echo $INSTALL["lang"]["str"]["can_continue_install"]; ?></strong></p>
</div>
<?php

    }
	
    if (in_array(false, $check)) {
	
?>
<div class="alert alert-warning">
	<p><?php echo $INSTALL["lang"]["warning"]["system_req_warning"]; ?></p>
	<p><strong><?php echo $INSTALL["lang"]["str"]["can_continue_install"]; ?></strong></p>
</div>
<?php

    }
	
?>
<form role="form" action="?" method="post">
	<input type="hidden" name="step" value="4" />
	<fieldset>
		<legend><?php echo $INSTALL["lang"]["str"]["check_result"]; ?></legend>
			<table class="table table-striped table-bordered table-hover dataTable" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
              <tr>
                <td width="250">PHP 5.3 + </td>
                <td><strong><?php echo $check["php_version"] ? '<span class="label label-success">'.$INSTALL["lang"]["str"]["yes"].'</span>' : '<span class="label label-important">'.$INSTALL["lang"]["str"]["no"].'</span>'; ?></strong></td>
              </tr>
              <tr>
                <td width="250">MySQL</td>
                <td><strong><?php echo $check["php_mysql"] ? '<span class="label label-success">'.$INSTALL["lang"]["str"]["yes"].'</span>' : '<span class="label label-important">'.$INSTALL["lang"]["str"]["no"].'</span>'; ?></strong></td>
              </tr>
              <tr>
                <td width="250">MB String</td>
                <td><strong><?php echo $check["php_mbstring"] ? '<span class="label label-success">'.$INSTALL["lang"]["str"]["yes"].'</span>' : '<span class="label label-important">'.$INSTALL["lang"]["str"]["no"].'</span>'; ?></strong></td>
              </tr>
              <tr>
                <td width="250">Iconv</td>
                <td><strong><?php echo $check["php_iconv"] ? '<span class="label label-success">'.$INSTALL["lang"]["str"]["yes"].'</span>' : '<span class="label label-important">'.$INSTALL["lang"]["str"]["no"].'</span>'; ?></strong></td>
              </tr>
			   <tr>
				  <td width="250">Zip</td>
				  <td><strong><?php echo $check["php_zip"] ? '<span class="label label-success">'.$INSTALL["lang"]["str"]["yes"].'</span>' : '<span class="label label-important">'.$INSTALL["lang"]["str"]["no"].'</span>'; ?></strong></td>
			  </tr>
			  <tr>
				  <td width="250">cURL</td>
				  <td><strong><?php echo $check["php_curl"] ? '<span class="label label-success">'.$INSTALL["lang"]["str"]["yes"].'</span>' : '<span class="label label-important">'.$INSTALL["lang"]["str"]["no"].'</span>'; ?></strong></td>
			  </tr>
			</tbody>
          </table>
        </fieldset>
        <div class="form-actions">
          <input type="submit" name="forward" class="btn btn-primary" value="<?php echo $INSTALL["lang"]["str"]["next"]; ?>" />
          <input type="button" class="btn" value="<?php echo $INSTALL["lang"]["str"]["cancel"]; ?>" onclick="location.href='../'" />
        </div>
      </form>
<?php

}
else if ($INSTALL['step'] == 5){

	/*********
	  Step 5
	*********/
	
	if (count($INSTALL['errors']) > 0){
	
?>
      <div class="alert alert-danger">
        <h4 class="alert-heading"><?php echo $INSTALL["lang"]["str"]["error_after_process"]; ?>:</h4>
<?php

    echo "<ul>\n";
	
	foreach($INSTALL['errors'] as $error){
		echo "<li>".$error."</li>";
	}
	
    echo "</ul>\n";
	
?>
      </div>
<?php

    }	
	
?>
      <form role="form" action="?" method="post">
        <input type="hidden" name="step" value="5" />
<?php

    if ($INSTALL['type'] == 'update') {
	
?>
        <h4><?php echo $INSTALL["lang"]["str"]["update"]; ?></h4>
        <div class="alert alert-warning">
          <p><?php echo str_replace('%VERSION%', $INSTALL['version_detect'], $INSTALL["lang"]["warning"]["detect_old_version"]); ?></p>
          <label class="inline radio">
          <?php echo str_replace('%VERSION%', $INSTALL["version"], $INSTALL["lang"]["str"]["update_to_version"]); ?>
          <input type="radio" name="action" value="update" id="update" checked="checked" /><br>
		  </label>
          <div class="control-group error"><span class="help-inline"><?php echo $INSTALL["lang"]["warning"]["update_warning"]; ?></span></div>
		  <label class="inline radio"><?php echo str_replace('%VERSION%', $INSTALL["version"], $INSTALL["lang"]["str"]["clear_and_install"]); ?>
          <input type="radio" name="action" value="clear" id="reinstall" />
          <?php echo $INSTALL["lang"]["str"]["clear_and_reinstall"]; ?><br>
          </label>
		  <div class="control-group error"><span class="help-inline"><?php echo $INSTALL["lang"]["warning"]["reinstall_warning"]; ?></span></div>
        </div>
        <?php

    } elseif ($INSTALL['type'] == 'clear'){
	
?>
        <h4><?php echo $INSTALL["lang"]["str"]["install"]; ?></h4>
        <div class="alert alert-danger">
          <p><?php echo str_replace('%VERSION%', $INSTALL['version_detect'], $INSTALL["lang"]["warning"]["detect_last_version"]); ?></p>
          <label>
          <input type="checkbox" name="action" value="clear" id="install">
          <?php echo $INSTALL["lang"]["str"]["clear_and_reinstall"]; ?><br>
          <div style="color: red;"><?php echo $INSTALL["lang"]["warning"]["reinstall_warning"]; ?></div>
          </label>
        </div>
        <?php

    } else {
	
?>
        <input type="hidden" name="action" value="install" />
<?php

    }  
	
?>
        <fieldset>
          <legend><?php echo $INSTALL["lang"]["str"]["mysql_settings"]; ?></legend>
          <div class="form-group">
            <label for="host"><?php echo $INSTALL["lang"]["str"]["mysql_server"]; ?>:</label>
              <input class="form-control" type="text" name="host" value="<?php echo $_POST["host"]; ?>" />
          </div>
          <div class="form-group">
            <label for="user"><?php echo $INSTALL["lang"]["str"]["mysql_login"]; ?>:</label>
                <input class="form-control" type="text" name="user" value="<?php echo $_POST["user"]; ?>" />
          </div>
          <div class="form-group">
            <label for="password"><?php echo $INSTALL["lang"]["str"]["mysql_pass"]; ?>:</label>
            <div class="form-group">
              <input class="form-control" type="text" name="password" value="<?php echo $_POST["password"]; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label for="name"><?php echo $INSTALL["lang"]["str"]["db_name"]; ?>:</label>
              <input class="form-control" type="text" name="name" value="<?php echo $_POST["name"]; ?>" />
             </div>
          <div class="form-group">
            <label for="prefix"><?php echo $INSTALL["lang"]["str"]["table_prefix"]; ?>:</label>
                 <input class="form-control" type="text" name="prefix" value="<?php echo $_POST["prefix"]; ?>" />
               </div>
        </fieldset>
        <div class="form-actions">
          <input type="submit" name="forward" class="btn btn-primary" value="<?php echo $INSTALL["lang"]["str"]["next"]; ?>" />
          <input type="button" class="btn" value="<?php echo $INSTALL["lang"]["str"]["cancel"]; ?>" onclick="location.href='../'" />
        </div>
      </form>
      <?php

} else if($INSTALL['step'] == 6) {
 
	/*********
	  Step 6
	*********/
	
?>
      <form role="form" action="?" method="post">
        <input type="hidden" name="step" value="6" />
<?php

    if(count($INSTALL['errors']) > 0){
?>
        <div class="alert alert-danger">
          <h4><?php echo $INSTALL["lang"]["str"]["error_after_process"]; ?>:</h4>
<?php

	echo "<ul>\n";
	
	foreach($INSTALL['errors'] as $error){
		echo "<li>" . $error . "</li>";
	}
	
	echo "</ul>\n";	
?>
        </div>
<?php

    }
	
?>
        <fieldset>
          <legend><?php echo $INSTALL["lang"]["str"]["administration"]; ?></legend>
			<div class="form-group">
				<label for="passw"><?php echo $INSTALL["lang"]["str"]["login"]; ?>:</label>
				<input class="form-control" type="text" name="login" value="<?php echo $_POST["login"]; ?>" />
			</div>
          <div class="form-group">
            <label for="passw"><?php echo $INSTALL["lang"]["str"]["password"]; ?>:</label>
              <input class="form-control" type="password" name="password" value="<?php echo $_POST["password"]; ?>" />
          </div>
          <div class="form-group">
            <label for="confirm_passw"><?php echo $INSTALL["lang"]["str"]["confirm_password"]; ?>:</label>
              <input class="form-control" type="password" name="confirm_password" value="<?php echo $_POST["confirm_password"]; ?>" />
          </div>
        </fieldset>
        <div class="form-actions">
          <input type="submit" name="forward" class="btn btn-primary" value="<?php echo $INSTALL["lang"]["str"]["next"]; ?>" />
          <input type="button" class="btn" value="<?php echo $INSTALL["lang"]["str"]["cancel"]; ?>" onclick="location.href='../'" />
        </div>
      </form>
<?php

} elseif ($INSTALL['step'] == 7) {

?>
      <fieldset>
        <legend><?php echo $INSTALL["lang"]["str"]["further_actions"]; ?></legend>
        <p><?php echo str_replace("%VERSION%", $INSTALL["version"], $INSTALL["lang"]["str"]["install_complete"]); ?></p>
        <a href="<?php echo $SCRIPT_URL; ?>"><?php echo $INSTALL["lang"]["str"]["admin_area"]; ?> &gt;&gt;</a>
      </fieldset>
<?php

}

?>

					</div>

					</div>

				</div>
			<footer> <?php echo "".$INSTALL["lang"]["str"]["logo"].", ".$INSTALL["lang"]["str"]["author"]."" ?> </footer>

			</div>

		</div>

	</div>
</div>
</div>
</body>
</html>
<?php

function import_data($filename, $prefix) {
	global $INSTALL, $dbh;

	$queries = @file($filename);

	foreach ($queries as $query){
		$query = str_replace('%prefix%', $prefix, $query);
		$query = trim($query);

		if (empty($query)){
			continue;
		}

		if (!$dbh->query($query)){
			$INSTALL['errors'][] = $INSTALL["lang"]["error"]["tablesinsert_error"].' : '.$dbh->error;
			break;
		}
	}
}

function import_scheme($filename, $prefix) {
    global $INSTALL, $dbh;

    $sql = @file_get_contents($filename);
    $queries = explode(';', $sql);

    foreach ($queries as $query) {
        $query = str_replace('%prefix%', $prefix, $query);
        $query = trim($query);

        if (empty($query)) {
            continue;
        }

        if (!$dbh->query($query)) {
            $INSTALL['errors'][] = $INSTALL["lang"]["error"]["tablescreate_error"].' : '.$dbh->error;
            break;
        }
    }
}

?>