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

class View
{

    public function generate($template_view, $data = null)
    {
        include core::pathTo('views', $template_view);
    }
}

?>
