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

class Controller
{

    public $model;

    public $view;

    function __construct()
    {
        $this->view = new View();
    }

    function action_index()
    {}
}

?>
