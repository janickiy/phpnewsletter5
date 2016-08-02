<?php

/**
 * phpnewsletter_5_0_alfa
 * Copyright (c) 2016 janic
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 */

defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_logout extends Controller
{
    function action_index()
    {
        $this->view->generate('logout_view.php');
    }
}