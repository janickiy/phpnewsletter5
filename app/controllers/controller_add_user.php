<?php

/********************************************
 * PHP Newsletter 5.0.5
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_add_user extends Controller
{
	function __construct()
	{
		$this->model = new Model_add_user();
		$this->view = new View();
	}

	function action_index()
	{
		$this->view->generate('add_user_view.php',$this->model);
	}
}