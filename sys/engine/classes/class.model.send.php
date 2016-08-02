<?php
defined('LETTER') || exit('NewsLetter: access denied.');

/**
 * ******************************************
 * PHP Newsletter 4.0.15
 * Copyright (c) 2006-2015 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 * ******************************************
 */
class Model_eMailSend extends Model
{

    public function getStatusProcess()
    {
        $query = "SELECT * FROM " . core::database()->getTableName('process') . "";
        $result = core::database()->querySQL($query);
        $row = core::database()->getRow($result, 'array');
        return $row['process'];
    }

    public  function updateProcess($status)
    {
        $query = "UPDATE " . core::database()->getTableName('process') . " SET process='" . $status . "'";
        return core::database()->querySQL($query);
    }

    public function modelMailSend($templates = NULL)
    {
        $mailcountno = 0;
        $mailcount = 0;
        
        if (isset($templates) && is_array($templates)) {
             
            $fh = fopen(__FILE__, 'r');
            
            if (! flock($fh, LOCK_EX | LOCK_NB)) {
                exit('Script is already running');
            }
             
            core::requireEx('libs', "PHPMailer/class.phpmailer.php");
            
            $fields = array();
            $fields['id_log'] = 0;
            $fields['time'] = date("Y-m-d H:i:s");
            
            $insert_id = core::database()->insert($fields, core::database()->getTableName('log'));
            
            $query = "SELECT * FROM " . core::database()->getTableName('charset') . " WHERE id_charset=" . core::getSetting('id_charset');
            $result = core::database()->querySQL($query);
            $char = core::database()->getRow($result);
            $charset = $char['charset'];
            
            if ($charset != 'utf-8') {
                $from = iconv('utf-8', $charset, $from);
                if (core::getSetting('organization') != '')
                    core::setSetting('organization', iconv('utf-8', $charset, core::getSetting('organization')));
            }
            
            $from = core::getSetting('email_name') == '' ? $_SERVER["SERVER_NAME"] : core::getSetting('email_name');
                        
            $query = "SELECT * FROM " . core::database()->getTableName('template') . " WHERE active='yes' AND id_template IN (" . implode(",", $templates) . ")";
            $result = core::database()->querySQL($query);
            
            if (core::database()->getRecordCount($result) > 0) {
                
                $m = new PHPMailer();
                
                if (core::getSetting('add_dkim') == 'yes' and file_exists(SYS_ROOT . core::getSetting('dkim_private'))) {
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
                } else 
                    if (core::getSetting('how_to_send') == 3 and (core::getSetting('sendmail') != '')) {
                        $m->IsSendmail();
                        $m->Sendmail = core::getSetting('sendmail');
                    } else {
                        $m->IsMail();
                    }
                
                while ($send = core::database()->getRow($result)) {
                    $subject = $send['name'];
                    $m->CharSet = $charset;
                    
                    if ($charset != 'utf-8') {
                        $subject = iconv('utf-8', $charset, $subject);
                    }
                    
                    $m->Subject = $subject;
                    
                    if ($send['prior'] == "1")
                        $m->Priority = 1;
                    else 
                        if ($send['prior'] == "2")
                            $m->Priority = 5;
                        else
                            $m->Priority = 3;
                    
                    if (core::getSetting('show_email') == "no")
                        $m->From = "noreply@" . $_SERVER['SERVER_NAME'] . "";
                    else
                        $m->From = core::getSetting('email');
                    
                    $m->FromName = $from;
                    
                    if (core::getSetting('content_type') == 2)
                        $m->isHTML(true);
                    else
                        $m->isHTML(false);
                    
                    if (core::getSetting('interval_type') == 'm')
                        $interval = "AND (time_send < NOW() - INTERVAL '" . core::getSetting('interval_number') . "' MINUTE)";
                    elseif (core::getSetting('interval_type') == 'h')
                        $interval = "AND (time_send < NOW() - INTERVAL '" . core::getSetting('interval_number') . "' HOUR)";
                    elseif (core::getSetting('interval_type') == 'd')
                        $interval = "AND (time_send < NOW() - INTERVAL '" . core::getSetting('interval_number') . "' DAY)";
                    else
                        $interval = '';
                    
                    $limit = core::getSetting('make_limit_send') == "yes" ? "LIMIT " . core::getSetting('limit_number') . "" : "";
                    
                    if ($_GET['typesend'] == 2) {
                        if ($send['id_cat'] == 0)
                            $query_users = "SELECT *,u.id_user as id FROM " . core::database()->getTableName('users') . " u 
						LEFT JOIN " . core::database()->getTableName('ready_send') . " r ON (u.id_user=r.id_user) AND (r.success='yes') AND (r.id_template=" . $send['id_template'] . ")
						WHERE (r.id_user IS NULL) AND (status='active') " . $limit . "";
                        else
                            $query_users = "SELECT *,u.id_user as id FROM " . core::database()->getTableName('users') . " u
						LEFT JOIN " . core::database()->getTableName('subscription') . " s ON u.id_user=s.id_user
						LEFT JOIN " . core::database()->getTableName('ready_send') . " r ON (u.id_user=r.id_user) AND (r.success='yes') AND (r.id_template=" . $send['id_template'] . ")
						WHERE (r.id_user IS NULL) AND (id_cat=" . $send['id_cat'] . ") AND (status='active') " . $limit . "";
                    } else {
                        if (core::getSetting('re_send') == "no") {
                            if ($send['id_cat'] == 0)
                                $query_users = "SELECT *,u.id_user as id FROM " . core::database()->getTableName('users') . " u 
							LEFT JOIN " . core::database()->getTableName('ready_send') . " r ON u.id_user=r.id_user AND r.id_template=" . $send['id_template'] . " 
							WHERE (r.id_user IS NULL) AND (status='active') " . $interval . " " . $limit . "";
                            else
                                $query_users = "SELECT *,u.id_user as id FROM " . core::database()->getTableName('users') . " u 
							LEFT JOIN " . core::database()->getTableName('subscription') . " s ON u.id_user=s.id_user
							LEFT JOIN " . core::database()->getTableName('ready_send') . " r ON u.id_user=r.id_user AND r.id_template=" . $send['id_template'] . " 
							WHERE (r.id_user IS NULL) AND (id_cat=" . $send['id_cat'] . ") AND (status='active') " . $interval . " 
							" . $limit . "";
                        } else {
                            if ($send['id_cat'] == 0)
                                $query_users = "SELECT *,id_user as id FROM " . core::database()->getTableName('users') . " WHERE status='active' " . $interval . " " . $limit . "";
                            else
                                $query_users = "SELECT *,u.id_user as id FROM " . core::database()->getTableName('users') . " u 
							LEFT JOIN " . core::database()->getTableName('subscription') . " s ON u.id_user=s.id_user 
							WHERE (id_cat=" . $send['id_cat'] . ") AND (status='active') " . $interval . "
							" . $limit . "";
                        }
                    }
                    
                    $result_users = core::database()->querySQL($query_users);
                    
                    while ($user = core::database()->getRow($result_users)) {
                        if ( $this->getStatusProcess() == 'stop' or $this->getStatusProcess() == 'pause')
                            break;
                        if (core::getSetting('sleep') and core::getSetting('sleep') > 0)
                            sleep(core::getSetting('sleep'));
                        
                        if (core::getSetting('organization') != '')
                            $m->addCustomHeader("Organization: " . core::getSetting('organization') . "");
                        
                        $IMG = '<img border="0" src="http://' . $_SERVER["SERVER_NAME"] . root() . '?t=pic&id_user=' . $user['id'] . '&id_template=' . $send['id_template'] . '" width="1" height="1">';
                        
                        $m->AddAddress($user['email']);
                        
                        if (core::getSetting('request_reply') == 'yes' and (core::getSetting('email') != '')) {
                            $m->addCustomHeader("Disposition-Notification-To: " . core::getSetting('email') . "");
                            $m->ConfirmReadingTo = core::getSetting('email');
                        }
                        
                        if (core::getSetting('precedence') == 'bulk')
                            $m->addCustomHeader("Precedence: bulk");
                        elseif (core::getSetting('precedence') == 'junk')
                            $m->addCustomHeader("Precedence: junk");
                        elseif (core::getSetting('precedence') == 'list')
                            $m->addCustomHeader("Precedence: list");
                        
                        $UNSUB = "http://" . $_SERVER["SERVER_NAME"] . root() . "?t=unsubscribe&id=" . $user['id'] . "&token=" . $user['token'] . "";
                        $unsublink = str_replace('%UNSUB%', $UNSUB, core::getSetting('unsublink'));
                        
                        if (core::getSetting('show_unsubscribe_link') == "yes" and (core::getSetting('unsublink') != '')) {
                            $msg = "" . $send['body'] . "<br><br>" . $unsublink . "";
                            $m->addCustomHeader("List-Unsubscribe: " . $UNSUB . "");
                        } else
                            $msg = $send['body'];
                        
                        $msg = str_replace('%NAME%', $user['name'], $msg);
                        $msg = str_replace('%UNSUB%', $UNSUB, $msg);
                        $msg = str_replace('%SERVER_NAME%', $_SERVER['SERVER_NAME'], $msg);
                        $msg = str_replace('%USERID%', $user['id'], $msg);
                        
                        $query = "SELECT * FROM " . core::database()->getTableName('attach') . " WHERE id_template=" . $send['id_template'];
                        $result_attach = core::database()->querySQL($query);
                        
                        while ($row = core::database()->getRow($result_attach)) {
                            if ($fp = @fopen($row['path'], "rb")) {
                                $file = fread($fp, filesize($row['path']));
                                
                                fclose($fp);
                                
                                if ($charset != 'utf-8')
                                    $row['name'] = iconv('utf-8', $charset, $row['name']);
                                
                                $ext = strrchr($row['path'], ".");
                                $mime_type = get_mime_type($ext);
                                
                                $m->AddAttachment($row['path'], $row['name'], 'base64', $mime_type);
                            }
                        }
                        
                        if ($charset != 'utf-8')
                            $msg = iconv('utf-8', $charset, $msg);
                        
                        if (core::getSetting('content_type') == 2) {
                            $msg .= $IMG;
                        } else {
                            $msg = preg_replace('/<br(\s\/)?>/i', "\n", $msg);
                            $msg = remove_html_tags($msg);
                        }
                        
                        $m->Body = $msg;
                        
                        if (! $m->Send()) {
                            $fields = array();
                            $fields['id_ready_send'] = 0;
                            $fields['id_user'] = $user['id'];
                            $fields['id_template'] = $send['id_template'];
                            $fields['success'] = 'no';
                            $fields['errormsg'] = $m->ErrorInfo;
                            $fields['readmail'] = 'no';
                            $fields['time'] = date("Y-m-d H:i:s");
                            $fields['id_log'] = $insert_id;
                            
                            $insert = core::database()->insert($fields, core::database()->getTableName("ready_send"));
                            $mailcountno = $mailcountno + 1;
                        } else {
                            $fields = array();
                            $fields['id_ready_send'] = 0;
                            $fields['id_user'] = $user['id'];
                            $fields['id_template'] = $send['id_template'];
                            $fields['success'] = 'yes';
                            $fields['errormsg'] = '';
                            $fields['readmail'] = 'no';
                            $fields['time'] = date("Y-m-d H:i:s");
                            $fields['id_log'] = $insert_id;
                            
                            $insert = core::database()->insert($fields, core::database()->getTableName("ready_send"));
                            
                            $query = "UPDATE " . core::database()->getTableName("users") . " SET time_send = NOW() WHERE id_user=" . $user['id'];
                            $update = core::database()->querySQL($query);
                            
                            $mailcount = $mailcount + 1;
                        }
                        
                        $m->ClearCustomHeaders();
                        $m->ClearAllRecipients();
                        $m->ClearAttachments();
                        
                        if (core::getSetting('make_limit_send') == "yes" and core::getSetting('limit_number') == $mailcount) {
                            if (core::getSetting('how_to_send') == 2)
                                $m->SmtpClose();
                            $result = $this->updateProcess('stop');
                            return $mailcount;
                            break;
                        }
                    }
                }
                
                if (core::getSetting('make_limit_send') == "yes" and core::getSetting('limit_number') == $mailcount) {
                    if (core::getSetting('how_to_send') == 2)
                        $m->SmtpClose();
                    $result =$this->updateProcess('stop');
                    return $mailcount;
                    break;
                }
            }
            
            $result = $this->updateProcess('stop');
        }
        return $mailcount;
    }
}

?>