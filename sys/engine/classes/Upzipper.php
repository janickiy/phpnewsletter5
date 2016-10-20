<?php

/********************************************
 * PHP Newsletter 5.0.1 beta
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Unzipper {
    public $localdir = '.';
    public $zipfile;
    public static $status = '';
    public static $result = '';

    public function __construct($zipfile)
    {
        $this->zipfile = $zipfile;

        if($this->zipfile != '') {
            self::extract($this->zipfile, $this->localdir);
        }
    }

    public static function extract($archive, $destination)
    {
        $ext = pathinfo($archive, PATHINFO_EXTENSION);

        if ($ext == 'zip') {
            self::extractZipArchive($archive, $destination);
        } else {
            if ($ext == 'gz') {
                self::extractGzipFile($archive, $destination);
            }
        }
    }

    public static function extractZipArchive($archive, $destination)
    {
        if (!class_exists('ZipArchive')) {
            self::$status = 'UNZIP_FUNCTION_IS_NOT_SUPPORT';
            self::$result = 'no';
            return;
        }

        $zip = new ZipArchive;

        if($zip->open($archive) === TRUE) {
            if (is_writeable($destination . '/')) {
                $zip->extractTo($destination);
                $zip->close();
                self::$status = 'FILES_UNZIPPED_SUCCESSFULLY';
                self::$result = 'yes';
            } else {
                self::$status = 'DIRECTORY_NOT_WRITEABLE';
                self::$result = 'no';
            }
        } else {
            self::$status = 'CANNOT_READ_ZIP_ARCHIVE';
            self::$result = 'no';
        }
    }

    public static function extractGzipFile($archive, $destination)
    {
        if (!function_exists('gzopen')) {
            self::$status = 'ZLIB_IS_NOT_SUPPORT';
            self::$result = 'no';
            return;
        }

        $filename = pathinfo($archive, PATHINFO_FILENAME);
        $gzipped = gzopen($archive, "rb");
        $file = fopen($filename, "w");

        while($string = gzread($gzipped, 4096)) {
            fwrite($file, $string, strlen($string));
        }

        gzclose($gzipped);
        fclose($file);

        if (file_exists($destination . '/' . $filename)) {
            self::$status = 'FILES_UNZIPPED_SUCCESSFULLY';
            self::$result = 'yes';
        } else {
            self::$status = 'ERROR_UNZIPPING_FILE';
            self::$result = 'no';
        }
    }
}