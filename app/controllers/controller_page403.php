<?php

/********************************************
 * PHP Newsletter 5.0.10
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_page403 extends Controller
{
    function action_index()
    {
        $this->view->generate('page403_view.php');
    }
}