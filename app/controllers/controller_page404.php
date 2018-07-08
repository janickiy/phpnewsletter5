<?php

/********************************************
 * PHP Newsletter 5.3.2
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_page404 extends Controller
{
	function action_index()
	{
		$this->view->generate('page404_view.php');
	}
}