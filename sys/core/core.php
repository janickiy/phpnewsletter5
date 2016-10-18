<?php

/********************************************
 * PHP Newsletter 5.0.1 beta
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class core
{
    protected static $_init = NULL;
    protected static $paths = array();
    protected static $mainConfig = NULL;
    protected static $language = NULL;
    protected static $key = 'Rii73dg=4&8#!@9';
    protected static $licensekey_url = 'http://site3.ru/licensekey.php';
    protected static $license_path = 'sys/license_key';
    public static $db = NULL;
    public static $tpl = NULL;
    public static $path = NULL;
    public static $session = NULL;

    /**
     * Check if self::init() has been called
     *
     * @return boolean
     */

    static public function isInit()
    {
        if (self::checkLicense() === false){
            header('Location: ./?t=expired');
            exit();
        }

        return self::$_init;
    }

    /**
     * Initialization
     *
     * @return boolean
     */

    static public function init($paths)
    {
        if (self::isInit())
            return TRUE;
        self::$paths = $paths;
        self::$path = str_replace("//", "/", "/" . trim(str_replace(chr(92), "/", substr(SYS_ROOT, strlen($_SERVER["DOCUMENT_ROOT"]))), "/") . "/");
        self::_loadEngines();
        self::$_init = TRUE;
    }

    /**
     * Create class $className
     *
     * @param string $className
     *            class name
     * @return mixed
     */

    static public function factory($className)
    {
        return new $className();
    }

    static public function database()
    {
        return self::$db;
    }

    static public function session()
    {
        return self::$session;
    }

    /**
     * AUTOLOAD modules
     */

    static protected function _loadEngines()
    {
        require_once 'folders.php';
        $folders = array(
            self::$paths['engine']
        );
        $autoload = array_reverse(folders::scan($folders, 'php', TRUE));
        foreach ($autoload as $lib) {
            if (is_file($lib))
                require_once $lib;
        }
    }

    static public function getTemplate()
    {
        return self::$tpl;
    }

    static public function setTemplate($tpl)
    {
        self::$tpl = SYS_ROOT . self::$paths['templates'] . DIRECTORY_SEPARATOR . $tpl;
    }

    // --------- SETTINGS -------------------------------
    static public function addSetting($set = array())
    {
        self::$mainConfig = (is_array(self::$mainConfig)) ? array_merge(self::$mainConfig, $set) : $set;
    }

    static public function setSetting($index, $value)
    {
        self::$mainConfig[$index] = $value;
    }

    static public function getSetting($name = '')
    {
        // Main config
        return ($name == '') ? self::$mainConfig : self::$mainConfig[$name];
    }
    // --------- SETTINGS -------------------------------

    // --------- language -------------------------------
    static public function addLanguage($lng = array())
    {
        self::$language = $lng;
    }

    static public function getLanguage($section, $item)
    {
        return (isset(self::$language[$section][$item])) ? self::$language[$section][$item] : '';
    }

    static public function setLanguage($section, $item, $value)
    {
        self::$language[$section][$item] = $value;
    }

    static public function pathTo($engine, $data)
    {
        return SYS_ROOT . self::$paths[$engine] . DIRECTORY_SEPARATOR . $data;
    }

    static public function requireEx($engine, $name)
    {
        $file = SYS_ROOT . self::$paths[$engine] . DIRECTORY_SEPARATOR . $name;
        if (file_exists($file)) {
            require_once $file;
            return true;
        } else
            return false;
    }

    static public function includeEx($engine, $name)
    {
        $file = SYS_ROOT . self::$paths[$engine] . DIRECTORY_SEPARATOR . $name;
        if (file_exists($file)) {
            include_once $file;
            return true;
        } else
            return false;
    }

    static public function getPath($path)
    {
        return self::$paths[$path];
    }

    static public function encodeStr($text = null)
    {
        $td = mcrypt_module_open("tripledes", '', 'cfb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        if (mcrypt_generic_init($td, self::$key, $iv) != -1) {
            $enc_text = base64_encode(mcrypt_generic($td, $iv . $text));
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return $enc_text;
        }
    }

    static public function strToHex($string)
    {
        $hexv = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }

        return $hex;
    }

    static public function decodeStr($text)
    {
        $td = mcrypt_module_open("tripledes", '', 'cfb', '');
        $iv_size = mcrypt_enc_get_iv_size($td);
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        if (mcrypt_generic_init($td, self::$key, $iv) != -1) {
            $decode_text = substr(mdecrypt_generic($td, base64_decode($text)), $iv_size);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return $decode_text;
        }
    }

    static public function hexToStr($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $string;
    }

    static public function checkLicense()
    {
        $result = true;
        if (file_exists(SYS_ROOT . self::$license_path)) {
            $lisense_info = self::getLicenseInfo(SYS_ROOT . self::$license_path);

            if ($lisense_info['license_type'] == 'demo' && $_SERVER["SERVER_NAME"] == $lisense_info['domain'] && $_REQUEST['t'] != 'expired') {
                if (round((strtotime($lisense_info['date_to']) - strtotime(date("Y-m-d H:i:s"))) / 3600 / 24) < 0) {
                    return false;
                }
            }
        } else {
            $lisense_info = json_decode(self::file_get_contents_curl(self::$licensekey_url), true);

            $arr = array();
            $arr['domain'] = $_SERVER["SERVER_NAME"];
            $arr['license_type'] = $lisense_info['license_type'];
            $arr['created'] = $lisense_info['created'];
            $arr['date_from'] = $lisense_info['date_from'];
            $arr['date_to'] = $lisense_info['date_to'];

            $encodeStr = self::encodeStr(json_encode($arr));

            $f = fopen(SYS_ROOT . self::$license_path, "w");

            if (fwrite($f, $encodeStr) === FALSE) {
                throw new Exception('Error: can not create ' . self::$license_path  . '! PLease check the permissions (chmod)');
            }

            fclose($f);
        }

        return $result;
    }

    static public function getLicenseInfo($filename)
    {
        if ($handle = fopen($filename, "r")) {
            $contents = fread($handle, filesize($filename));
            fclose($handle);

            return json_decode(self::decodeStr($contents), true);
        }
    }

    static public function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    static public function expired_day_count()
    {
        $lisense_info = self::getLicenseInfo(SYS_ROOT . self::$license_path);

        if ($lisense_info['license_type'] == 'demo') {
            return round((strtotime($lisense_info['date_to']) - strtotime(date("Y-m-d H:i:s"))) / 3600 / 24);
        }
    }
}