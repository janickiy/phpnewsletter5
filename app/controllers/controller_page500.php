<?php

/********************************************
 * PHP Newsletter 5.0.5
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/
defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_page500 extends Controller
{
	function action_index()
	{
		$this->view->generate('page500_view.php');
	}
}