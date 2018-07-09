<?php

/********************************************
 * PHP Newsletter 5.3.2
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_ajax extends Model
{
    /**
     * @param $status
     * @param $id_user
     * @return bool
     */
    public function updateProcess($status, $id_user)
    {
        if ($status && is_numeric($id_user)) {
            $status = core::database()->escape($status);
            $query = "SELECT * FROM " . core::database()->getTableName('process') . "  WHERE id_user=" . $id_user;
            $result = core::database()->querySQL($query);

            if (core::database()->getRecordCount($result) == 0) {
                $fields = [
                    'id' => 0,
                    'process' => $status,
                    'id_user' => $id_user,
                ];

                $insert = core::database()->insert($fields, core::database()->getTableName("process"));

                if ($insert)
                    return true;
                else
                    return false;
            } else {
                $query = "UPDATE " . core::database()->getTableName('process') . " SET process='" . $status . "' WHERE id_user=" . $id_user;
                return core::database()->querySQL($query);
            }

        } else
            return false;
    }

    /**
     * @return null
     */
    public function getTotalMails($activate)
    {
        $temp =  array();
        $common_cat = false;

        foreach ($activate as $id_template) {
            if (is_numeric($id_template)) {
                $temp[] = $id_template;
                if ($this->getCatIdByTemplateId($id_template) == 0) $common_cat =  true;
            }
        }

        $query = "SELECT COUNT(*) FROM " . core::database()->getTableName('subscription') . " s
                    LEFT JOIN " . core::database()->getTableName('category') . " c ON c.id_cat=s.id_cat
                    LEFT JOIN " . core::database()->getTableName('template') . " t ON c.id_cat=t.id_cat
                    LEFT JOIN " . core::database()->getTableName('users') . " u ON u.id_user=s.id_user
                    WHERE t.id_template IN  (" . implode(",", $temp) . ") AND u.status='active'";

        $total = 0;
        $result = core::database()->querySQL($query);
        $count = core::database()->getRow($result, 'row');
        $total = $count[0];

        if ($common_cat) {
            $query = "SELECT COUNT(*) FROM " . core::database()->getTableName('users') . " WHERE status = 'active'";
            $result = core::database()->querySQL($query);
            $count = core::database()->getRow($result, 'row');
            $total = $total + $count[0];
        }

        return core::getSetting('make_limit_send') == "yes" && core::getSetting('limit_number') > $total ? core::getSetting('limit_number') : $total;
    }

    /**
     * @param $id_template
     * @return mixed
     */
    public function getCatIdByTemplateId($id_template)
    {
        if (is_numeric($id_template)) {
            $query = "SELECT id_cat FROM " . core::database()->getTableName('template') . " WHERE id_template=" . $id_template;
            $result = core::database()->querySQL($query);
            $row = core::database()->getRow($result);

            return $row['id_cat'];
        }
    }

    /**
     * @param $id_log
     * @return int
     */
    public function getSuccessMails($id_log)
    {
        if (is_numeric($id_log)){
            $query = "SELECT COUNT(*) FROM " . core::database()->getTableName('ready_send') . " WHERE id_log=" . $id_log . " AND success='yes'";
            $result = core::database()->querySQL($query);
            $count = core::database()->getRow($result, 'row');

            return $count[0];
        } else
            return 0;
    }

    /**
     * @param $id_log
     * @return int
     */
    public function getUnsuccessfulMails($id_log)
    {
        if (is_numeric($id_log)){
            $query = "SELECT COUNT(*) FROM " . core::database()->getTableName('ready_send') . " WHERE id_log=" . $id_log . " AND success='no'";
            $result = core::database()->querySQL($query);
            $count = core::database()->getRow($result, 'row');

            return $count[0];
        }  else
            return 0;
    }

    /**
     * @param $id_user
     * @return mixed
     */
    public function getMailingStatus($id_user)
    {
        if ($id_user) {
            $query = "SELECT * FROM " . core::database()->getTableName('process') . " WHERE id_user=" . $id_user;
            $result = core::database()->querySQL($query);
            $status = core::database()->getRow($result);

            return $status['process'];
        }
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getCurrentUserLog($limit = 10)
    {
        $query = "SELECT * FROM " . core::database()->getTableName('ready_send') . " a LEFT JOIN " . core::database()->getTableName('users') . " b ON b.id_user=a.id_user ORDER by id_ready_send DESC LIMIT " . $limit;
        $result = core::database()->querySQL($query);

        return core::database()->getColumnArray($result);
    }

    /**
     * @param $path
     * @param null $getfile
     * @return bool
     */
    public function DownloadUpdate($path, $getfile = null)
    {
        $result = true;

        if ($getfile){
            $newUpdate = file_get_contents($getfile);
            if (!is_dir(SYS_ROOT . core::getPath('tmp'))) mkdir(SYS_ROOT . core::getPath('tmp'));

            $dlHandler = fopen($path, 'w');

            if (!fwrite($dlHandler, $newUpdate)) {
                $result = false;
            }

            fclose($dlHandler);
        }

        return $result;
    }

    /**
     * @param $path
     * @return bool
     */
    public function updateDB($path)
    {
        global $ConfigDB;

        $result = true;

        $sql = file_get_contents($path);
        $queries = explode(';', $sql);

        foreach ($queries as $query){
            $query = str_replace('%prefix%', $ConfigDB["prefix"], $query);
            $query = trim($query);

            if (empty($query)){
                continue;
            }

            if (!core::database()->querySQL($query)){
                $result = false;
                break;
            }
        }

        return $result;
    }

    /**
     * @return int|null
     */
    public function version_code_detect()
    {
        global $ConfigDB;

        $tables_list = [
            'attach',
            'aut',
            'category',
            'charset',
            'сustomheaders',
            'licensekey',
            'log',
            'process',
            'ready_send',
            'redirect_log',
            'settings',
            'subscription',
            'template',
            'users',
        ];

        $tables = [];

        if ($res1 = core::database()->querySQL("SHOW TABLES FROM `" . $ConfigDB["name"] . "` LIKE '" . $ConfigDB["prefix"] . "%'")) {
            while ($row1 = core::database()->getRow($res1)){
                $res2 = core::database()->querySQL("DESCRIBE `".$row1[0]."`");
                $tables[substr($row1[0], strlen($ConfigDB["prefix"]))] = array();

                while($row2 = core::database()->getRow($res2)) {
                    $tables[substr($row1[0], strlen($ConfigDB["prefix"]))][] = $row2[0];
                }
            }
        }

        $exists_tables = array();

        foreach($tables_list as $table){
            if (isset($tables[$table])) {
                $exists_tables[] = $table;
            }
        }

        $version_code_detect = null;

        if ($exists_tables) {
            $version_code_detect = 50000;

            if (in_array('remove_subscriber', $tables['settings'])) {
                $version_code_detect = 50100;
            } elseif (isset($tables['сustomheaders'])) {
                $version_code_detect = 50200;
            } elseif (in_array('name', $tables['aut'])) {
                $version_code_detect = 50300;
            }
        }

        return $version_code_detect;
    }

    /**
     * @param $email
     * @param $subject
     * @param $body
     * @param $prior
     * @return bool
     * @throws Exception
     * @throws phpmailerException
     */
    public function sendTestEmail($email, $subject, $body, $prior)
    {
        $user = 'USERNAME';
        $subject = str_replace('%NAME%', $user, $subject);

        core::requireEx('libs', "PHPMailer/class.phpmailer.php");

        $m = new PHPMailer();

        if (core::getSetting('how_to_send') == 2){
            $m->IsSMTP();

            $m->SMTPAuth = true;
            $m->SMTPKeepAlive = true;
            $m->Host = core::getSetting('smtp_host');
            $m->Port = core::getSetting('smtp_port');
            $m->Username = core::getSetting('smtp_username');
            $m->Password = core::getSetting('smtp_password');

            if (core::getSetting('smtp_secure') == 'ssl')
                $m->SMTPSecure  = 'ssl';
            elseif (core::getSetting('smtp_secure') == 'tls')
                $m->SMTPSecure  = 'tls';

            if (core::getSetting('smtp_aut') == 'plain')
                $m->AuthType = 'PLAIN';
            elseif (core::getSetting('smtp_aut') == 'cram-md5')
                $m->AuthType = 'CRAM-MD5';

            $m->Timeout =  core::getSetting('smtp_timeout');
        } elseif (core::getSetting('how_to_send') == 3 && core::getSetting('sendmail') != ''){
            $m->IsSendmail();
            $m->Sendmail = core::getSetting('sendmail');
        } else {
            $m->IsMail();
        }

        $query = "SELECT * FROM " . core::database()->getTableName('charset') . " WHERE id_charset=" . core::getSetting('id_charset');
        $result = core::database()->querySQL($query);
        $char = core::database()->getRow($result);
        $charset = $char['charset'];

        $m->CharSet = $charset;

        if (core::getSetting('email_name') == '')
            $from = $_SERVER["SERVER_NAME"];
        else
            $from = core::getSetting('email_name');

        $organization = core::getSetting('organization');

        if ($charset != 'utf-8') {
            $from = iconv('utf-8', $charset, $from);
            $subject = iconv('utf-8', $charset, $subject);
            if (!empty($organization)) $organization = iconv('utf-8', $charset, $organization);
        }

        $m->Subject = $subject;
        if (core::getSetting('organization') != '') $m->addCustomHeader("Organization: " . core::getSetting('organization'));

        if ($prior == 1)
            $m->Priority = 1;
        elseif ($prior == 2)
            $m->Priority = 2;
        else
            $m->Priority = 3;

        if (core::getSetting('show_email') == "no")
            $m->From = "noreply@" . $_SERVER['SERVER_NAME'];
        else
            $m->From = core::getSetting('email');

        $m->FromName = $from;

        if (core::getSetting('content_type') == 2)
            $m->isHTML(true);
        else
            $m->isHTML(false);

        $m->AddAddress($email);

        if (core::getSetting('request_reply') == "yes" && core::getSetting('email_reply') != ''){
            $m->addCustomHeader("Disposition-Notification-To: " . core::getSetting('email_reply'));
            $m->ConfirmReadingTo = core::getSetting('email_reply');
        }

        foreach($this->getCustomHeaders() as $row) {
            if (!empty($row['name']) && !empty($row['value'])) $m->addCustomHeader($row['name'] . ":" . $row['value']);
        }

        if (core::getSetting('precedence') == 'bulk')
            $m->addCustomHeader("Precedence: bulk");
        elseif (core::getSetting('precedence') == 'junk')
            $m->addCustomHeader("Precedence: junk");
        elseif (core::getSetting('precedence') == 'list')
            $m->addCustomHeader("Precedence: list");
        if (core::getSetting('list_owner') != '') $m->addCustomHeader("List-Owner: <" . core::getSetting('list_owner') . ">");
        if (core::getSetting('return_path') != '') $m->addCustomHeader("Return-Path: <" . core::getSetting('return_path') . ">");

        $UNSUB = "http://" . $_SERVER["SERVER_NAME"] . Pnl::root() . "?t=unsubscribe&id=test&token=test";
        $unsublink = str_replace('%UNSUB%', $UNSUB, core::getSetting('unsublink'));

        if (core::getSetting('show_unsubscribe_link') == "yes" && core::getSetting('unsublink') != '') {
            $msg = "" . $body . "<br><br>" . $unsublink;
            $m->addCustomHeader("List-Unsubscribe: " . $UNSUB);
        } else
            $msg = $body;

        $msg = preg_replace_callback("/%REFERRAL\:(.+)%/isU", function($matches) { return "http://%URL_PATH%?t=referral&ref=" . base64_encode($matches[1]) . "&id=%USERID%"; }, $msg);
        $msg = str_replace('%NAME%', $user, $msg);
        $msg = str_replace('%EMAIL%', $email, $msg);
        $msg = str_replace('%UNSUB%', $UNSUB, $msg);
        $msg = str_replace('%SERVER_NAME%', $_SERVER['SERVER_NAME'], $msg);
        $msg = str_replace('%USERID%', 0, $msg);
        $msg = str_replace('%URL_PATH%', $_SERVER["SERVER_NAME"] . Pnl::root(), $msg);
        $msg = core::getSetting('replacement_chars_body') == 'yes' ? Pnl::encodeString($msg) : $msg;

        if ($charset != 'utf-8') $msg = iconv('utf-8', $charset, $msg);
        if (core::getSetting('content_type') == 1) {
            $msg = preg_replace('/<br(\s\/)?>/i', "\n", $msg);
            $msg = Pnl::remove_html_tags($msg);
        }

        $m->Body = $msg;

        if (!$m->Send()){
            if (core::getSetting('how_to_send') == 2) $m->SmtpClose();
            return false;
        } else {
            if (core::getSetting('how_to_send') == 2) $m->SmtpClose();
            return true;
        }
    }

    /**
     * @param null $activate
     * @return int
     * @throws Exception
     * @throws phpmailerException
     */
    public function SendEmails($activate = NULL)
    {
        $mailcountno = 0;
        $mailcount = 0;

        if (isset($activate) && is_array($activate)) {
            $fh = fopen(__FILE__, 'r');

            if (! flock($fh, LOCK_EX | LOCK_NB)) {
                exit('Script is already running');
            }

            core::requireEx('libs', "PHPMailer/class.phpmailer.php");

            foreach($activate as $id_template){
                if (is_numeric($id_template)){
                    $temp[] = $id_template;
                }
            }

            $fields = array('id_log' => 0, 'time' => date("Y-m-d H:i:s"));
            core::session()->start();

            if (core::session()->issetName('id_log') == true) {
                $insert_id = core::session()->get('id_log');
                core::session()->commit();
            } else {
                $insert_id = core::database()->insert($fields, core::database()->getTableName('log'));
                core::session()->set('id_log', $insert_id);
            }

            core::session()->commit();

            $query = "SELECT * FROM " . core::database()->getTableName('charset') . " WHERE id_charset=" . core::getSetting('id_charset');
            $result = core::database()->querySQL($query);
            $char = core::database()->getRow($result);
            $charset = $char['charset'];
            $from = core::getSetting('email_name') == '' ? $_SERVER["SERVER_NAME"] : core::getSetting('email_name');

            if ($charset != 'utf-8') {
                $from = iconv('utf-8', $charset, $from);
                if (core::getSetting('organization') != '') core::setSetting('organization', iconv('utf-8', $charset, core::getSetting('organization')));
            }

            $query = "SELECT * FROM " . core::database()->getTableName('template') . " WHERE active='yes' AND id_template IN (" . implode(",", $temp) . ")";
            $result = core::database()->querySQL($query);

            if (core::database()->getRecordCount($result) > 0) {
                while ($send = core::database()->getRow($result)) {
                    $subject = core::getSetting('replacement_chars_subject') == 'yes' ? Pnl::encodeString($send['name']) : $send['name'];

                    if (core::getSetting('interval_type') == 'm')
                        $interval = "AND (time_send < NOW() - INTERVAL '" . core::getSetting('interval_number') . "' MINUTE)";
                    elseif (core::getSetting('interval_type') == 'h')
                        $interval = "AND (time_send < NOW() - INTERVAL '" . core::getSetting('interval_number') . "' HOUR)";
                    elseif (core::getSetting('interval_type') == 'd')
                        $interval = "AND (time_send < NOW() - INTERVAL '" . core::getSetting('interval_number') . "' DAY)";
                    else
                        $interval = '';

                    $limit = core::getSetting('make_limit_send') == "yes" ? "LIMIT " . core::getSetting('limit_number') : "";
                    $order = core::getSetting('random') == "yes" ? 'ORDER BY RAND()' : '';

                    if (Core_Array::getRequest('typesend') == 2) {
                        if ($send['id_cat'] == 0)
                            $query_users = "SELECT *,u.id_user AS id, u.email AS email FROM " . core::database()->getTableName('users') . " u
											LEFT JOIN " . core::database()->getTableName('ready_send') . " r ON (u.id_user=r.id_user) AND (r.success='yes') AND (r.id_template=" . $send['id_template'] . ")
											WHERE (r.id_user IS NULL) AND (status='active') " . $order . " " . $limit . "";
                        else
                            $query_users = "SELECT *,u.id_user AS id, u.email AS email FROM " . core::database()->getTableName('users') . " u
											LEFT JOIN " . core::database()->getTableName('subscription') . " s ON u.id_user=s.id_user
											LEFT JOIN " . core::database()->getTableName('ready_send') . " r ON (u.id_user=r.id_user) AND (r.success='yes') AND (r.id_template=" . $send['id_template'] . ")
											WHERE (r.id_user IS NULL) AND (id_cat=" . $send['id_cat'] . ") AND (status='active') " . $order . " " . $limit;
                    } else {
                        if (core::getSetting('re_send') == "no") {
                            if ($send['id_cat'] == 0)
                                $query_users = "SELECT *,u.id_user AS id, u.email AS email FROM " . core::database()->getTableName('users') . " u
												LEFT JOIN " . core::database()->getTableName('ready_send') . " r ON u.id_user=r.id_user AND r.id_template=" . $send['id_template'] . "
												WHERE (r.id_user IS NULL) AND (status='active') " . $interval . " " . $limit;
                            else
                                $query_users = "SELECT *,u.id_user AS id, u.email AS email FROM " . core::database()->getTableName('users') . " u
												LEFT JOIN " . core::database()->getTableName('subscription') . " s ON u.id_user=s.id_user
												LEFT JOIN " . core::database()->getTableName('ready_send') . " r ON u.id_user=r.id_user AND r.id_template=" . $send['id_template'] . "
												WHERE (r.id_user IS NULL) AND (id_cat=" . $send['id_cat'] . ") AND (status='active') " . $interval . "	" . $order . " " . $limit;
                        } else {
                            if ($send['id_cat'] == 0)
                                $query_users = "SELECT *,id_user AS id FROM " . core::database()->getTableName('users') . " WHERE status='active' " . $interval . " " . $order . " " . $limit . "";
                            else
                                $query_users = "SELECT *,u.id_user AS id, u.email AS email FROM " . core::database()->getTableName('users') . " u
												LEFT JOIN " . core::database()->getTableName('subscription') . " s ON u.id_user=s.id_user
												WHERE (id_cat=" . $send['id_cat'] . ") AND (status='active') " . $interval . " " . $order . " " . $limit;
                        }
                    }

                    $result_users = core::database()->querySQL($query_users);

                    while ($user = core::database()->getRow($result_users)) {
                        $m = new PHPMailer();

                        if (core::getSetting('add_dkim') == 'yes' && file_exists(SYS_ROOT . core::getSetting('dkim_private'))) {
                            $m->DKIM_domain = core::getSetting('dkim_domain');
                            $m->DKIM_private = core::getSetting('dkim_private');
                            $m->DKIM_selector = core::getSetting('dkim_selector');
                            $m->DKIM_passphrase = core::getSetting('dkim_passphrase');
                            $m->DKIM_identity = core::getSetting('dkim_identity');
                        }

                        if (core::getSetting('how_to_send') == 2) {
                            $m->IsSMTP();
                            $m->SMTPAuth = true;
                            $m->SMTPKeepAlive = true;
                            $m->Host = core::getSetting('smtp_host');
                            $m->Port = core::getSetting('smtp_port');
                            $m->Username = core::getSetting('smtp_username');
                            $m->Password = core::getSetting('smtp_password');

                            if (core::getSetting('smtp_secure') == 'ssl')
                                $m->SMTPSecure = 'ssl';
                            elseif (core::getSetting('smtp_secure') == 'tls')
                                $m->SMTPSecure = 'tls';

                            if (core::getSetting('smtp_aut') == 'plain')
                                $m->AuthType = 'PLAIN';
                            elseif (core::getSetting('smtp_aut') == 'cram-md5')
                                $m->AuthType = 'CRAM-MD5';

                            $m->Timeout = core::getSetting('smtp_timeout');
                        } else {
                            if (core::getSetting('how_to_send') == 3 && (core::getSetting('sendmail') != '')) {
                                $m->IsSendmail();
                                $m->Sendmail = core::getSetting('sendmail');
                            } else {
                                $m->IsMail();
                            }
                        }

                        $m->CharSet = $charset;

                        if ($charset != 'utf-8') {
                            $subject = iconv('utf-8', $charset, $subject);
                        }

                        $m->Subject = $subject;

                        if ($send['prior'] == 1)
                            $m->Priority = 1;
                        else
                            if ($send['prior'] == 2)
                                $m->Priority = 5;
                            else
                                $m->Priority = 3;

                        if (core::getSetting('show_email') == "no")
                            $m->From = "noreply@" . $_SERVER['SERVER_NAME'];
                        else
                            $m->From = core::getSetting('email');

                        $m->FromName = $from;

                        if (core::getSetting('content_type') == 2)
                            $m->isHTML(true);
                        else
                            $m->isHTML(false);


                        if ( $this->getStatusProcess(Auth::getAutId()) == 'stop' || $this->getStatusProcess(Auth::getAutId()) == 'pause') {
                            break;
                        }

                        if (core::getSetting('sleep') && core::getSetting('sleep') > 0)
                            sleep(core::getSetting('sleep'));

                        if (core::getSetting('organization') != '')
                            $m->addCustomHeader("Organization: " . core::getSetting('organization') . "");

                        $IMG = '<img border="0" src="http://' . $_SERVER["SERVER_NAME"] . Pnl::root() . '?t=pic&id_user=' . $user['id'] . '&id_template=' . $send['id_template'] . '" width="1" height="1">';

                        $m->AddAddress($user['email']);

                        if (core::getSetting('request_reply') == 'yes' && (core::getSetting('email') != '')) {
                            $m->addCustomHeader("Disposition-Notification-To: " . core::getSetting('email') . "");
                            $m->ConfirmReadingTo = core::getSetting('email');
                        }

                        foreach($this->getCustomHeaders() as $row) {
                            if (!empty($row['name']) && !empty($row['value'])) $m->addCustomHeader($row['name'] . ":" . $row['value']);
                        }

                        if (core::getSetting('precedence') == 'bulk')
                            $m->addCustomHeader("Precedence: bulk");
                        elseif (core::getSetting('precedence') == 'junk')
                            $m->addCustomHeader("Precedence: junk");
                        elseif (core::getSetting('precedence') == 'list')
                            $m->addCustomHeader("Precedence: list");

                        if (core::getSetting('list_owner') != '') $m->addCustomHeader("List-Owner: <" . core::getSetting('list_owner') . ">");
                        if (core::getSetting('return_path') != '') $m->addCustomHeader("Return-Path: <" . core::getSetting('return_path') . ">");

                        $UNSUB = "http://" . $_SERVER["SERVER_NAME"] . Pnl::root() . "?t=unsubscribe&id=" . $user['id'] . "&token=" . $user['token'];
                        $unsublink = str_replace('%UNSUB%', $UNSUB, core::getSetting('unsublink'));
                        $send['body'] = core::getSetting('replacement_chars_body') == 'yes' ? Pnl::encodeString($send['body']) : $send['body'];

                        if (core::getSetting('show_unsubscribe_link') == "yes" && (core::getSetting('unsublink') != '')) {
                            $msg = $send['body'] . "<br><br>" . $unsublink;
                            $m->addCustomHeader("List-Unsubscribe: " . $UNSUB . "");
                        } else
                            $msg = $send['body'];

                        $msg = preg_replace_callback("/%REFERRAL\:(.+)%/isU", function($matches) { return "http://%URL_PATH%?t=referral&ref=" . base64_encode($matches[1]) . "&id=%USERID%"; }, $msg);
                        $msg = str_replace('%NAME%', $user['name'], $msg);
                        $msg = str_replace('%EMAIL%', $user['email'], $msg);
                        $msg = str_replace('%UNSUB%', $UNSUB, $msg);
                        $msg = str_replace('%SERVER_NAME%', $_SERVER['SERVER_NAME'], $msg);
                        $msg = str_replace('%USERID%', $user['id'], $msg);
                        $msg = str_replace('%URL_PATH%', $_SERVER["SERVER_NAME"] . Pnl::root(), $msg);

                        $query = "SELECT * FROM " . core::database()->getTableName('attach') . " WHERE id_template=" . $send['id_template'];
                        $result_attach = core::database()->querySQL($query);

                        while ($row = core::database()->getRow($result_attach)) {
                            if ($fp = @fopen($row['path'], "rb")) {
                                fread($fp, filesize($row['path']));

                                fclose($fp);

                                if ($charset != 'utf-8') $row['name'] = iconv('utf-8', $charset, $row['name']);

                                $ext = strrchr($row['path'], ".");
                                $mime_type = Pnl::get_mime_type($ext);

                                $m->AddAttachment($row['path'], $row['name'], 'base64', $mime_type);
                            }
                        }

                        if ($charset != 'utf-8')
                            $msg = iconv('utf-8', $charset, $msg);

                        if (core::getSetting('content_type') == 2) {
                            $msg .= $IMG;
                        } else {
                            $msg = preg_replace('/<br(\s\/)?>/i', "\n", $msg);
                            $msg = Pnl::remove_html_tags($msg);
                        }

                        $m->Body = $msg;

                        if (!$m->Send()) {
                            $fields = [
                                'id_ready_send' => 0,
                                'id_user'       => $user['id'],
                                'email'       => $user['email'],
                                'id_template' => $send['id_template'],
                                'success'     => 'no',
                                'errormsg'    => $m->ErrorInfo,
                                'readmail' => 'no',
                                'time'     => date("Y-m-d H:i:s"),
                                'id_log'   => $insert_id,
                                 ];

                            core::database()->insert($fields, core::database()->getTableName("ready_send"));
                            $mailcountno = $mailcountno + 1;
                        } else {
                            $fields = [
                                'id_ready_send' => 0,
                                'id_user'       => $user['id'],
                                'email'       => $user['email'],
                                'id_template' => $send['id_template'],
                                'success'     => 'yes',
                                'readmail'    => 'no',
                                'time'   => date("Y-m-d H:i:s"),
                                'id_log' => $insert_id,
                            ];

                            core::database()->insert($fields, core::database()->getTableName("ready_send"));

                            $query = "UPDATE " . core::database()->getTableName("users") . " SET time_send = NOW() WHERE id_user=" . $user['id'];
                            core::database()->querySQL($query);

                            $mailcount = $mailcount + 1;
                        }

                        $m->ClearCustomHeaders();
                        $m->ClearAllRecipients();
                        $m->ClearAttachments();

                        if (core::getSetting('make_limit_send') == "yes" && core::getSetting('limit_number') == $mailcount) {
                            if (core::getSetting('how_to_send') == 2) $m->SmtpClose();
                            if ($this->getStatusProcess(Auth::getAutId()) == 'start') {
                                if ($this->updateProcess('stop', Auth::getAutId())) {
                                    core::session()->start();
                                    core::session()->delete('id_log');
                                    core::session()->commit();
                                }
                            }

                            return $mailcount;
                            break;
                        }
                    }
                }

                if (core::getSetting('make_limit_send') == "yes" && core::getSetting('limit_number') == $mailcount) {
                    if (core::getSetting('how_to_send') == 2) $m->SmtpClose();
                    if ($this->getStatusProcess(Auth::getAutId()) == 'start') {
                        if ($this->updateProcess('stop', Auth::getAutId())) {
                            core::session()->start();
                            core::session()->delete('id_log');
                            core::session()->commit();
                        }
                    }
                    return $mailcount;
                }
            }

            if ($this->getStatusProcess(Auth::getAutId()) == 'start') {
                if ($this->updateProcess('stop', Auth::getAutId())) {
                    core::session()->start();
                    core::session()->delete('id_log');
                    core::session()->commit();
                }
            }
        }

        return $mailcount;
    }

    /**
     * @param $id_user
     * @return mixed
     */
    public function getStatusProcess($id_user)
    {
        if (is_numeric($id_user)){
            $query = "SELECT * FROM " . core::database()->getTableName('process') . "  WHERE id_user=" . $id_user;
            $result = core::database()->querySQL($query);
            $row = core::database()->getRow($result);

            return $row['process'];
        }
    }

    /**
     * @param $offset
     * @param $number
     * @param $id_log
     * @param $strtmp
     * @return mixed
     */
    public function getDetaillog($offset, $number, $id_log, $strtmp)
    {
        if (is_numeric($offset) && is_numeric($number) && is_numeric($id_log)) {
            $strtmp = core::database()->escape($strtmp);

            $query = "SELECT *, a.time AS time, c.name AS catname, s.name AS name FROM " . core::database()->getTableName('ready_send') . " a
					LEFT JOIN " . core::database()->getTableName('template') . " s ON a.id_template=s.id_template
					LEFT JOIN " . core::database()->getTableName('category') . " c ON s.id_cat=c.id_cat
					WHERE id_log=" . $id_log . "
					ORDER BY " . $strtmp . "
					LIMIT " . $number . "
					OFFSET " . $offset . "
					";

            $result = core::database()->querySQL($query);

            return core::database()->getColumnArray($result);
        }
    }

    /**
     * @param $offset
     * @param $number
     * @param $url
     * @param $strtmp
     * @return mixed
     */
    public function getDetailRedirectLog($offset, $number, $url, $strtmp)
    {
        if (is_numeric($offset) && is_numeric($number)) {
            $strtmp = core::database()->escape($strtmp);
            $url = trim(core::database()->escape($url));

            $query = "SELECT * FROM " . core::database()->getTableName('redirect_log') . "
                        WHERE url LIKE '" . $url . "'
					    ORDER BY " . $strtmp . "
					    LIMIT " . $number . "
					    OFFSET " . $offset . "
					    ";

            $result = core::database()->querySQL($query);

            return core::database()->getColumnArray($result);
        }
    }

    /**
     * @param $id_attachment
     * @return mixed
     */
    public function removeAttach($id_attachment)
    {
        if (is_numeric($id_attachment)) {
            $query = "SELECT * FROM " . core::database()->getTableName('attach') . " WHERE id_attachment=" . $id_attachment;
            $result = core::database()->querySQL($query);

            while ($row = core::database()->getRow($result, 'array')) {
                if (file_exists($row['path'])) @unlink($row['path']);
            }

            return core::database()->delete(core::database()->getTableName('attach'), "id_attachment=" . $id_attachment, '');
        }
    }

    /**
     * @return mixed
     */
    public function getCustomHeaders()
    {
        $query = "SELECT * FROM " . core::database()->getTableName('сustomheaders');
        $result = core::database()->querySQL($query);
        return core::database()->getColumnArray($result);
    }
}