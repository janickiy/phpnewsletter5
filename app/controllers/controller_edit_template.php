<?php

/********************************************
 * PHP Newsletter 5.0.3
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_edit_template extends Controller
{
    function __construct()
    {
        $this->model = new Model_edit_template();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('edit_template_view.php', $this->model);
    }
}