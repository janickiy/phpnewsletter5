<?php

/********************************************
 * PHP Newsletter 5.0.2
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_ajax extends Controller
{
	function __construct()
	{
		$this->model = new Model_ajax();
		$this->view = new View();
	}

	function action_index()
	{
		$this->view->generate('ajax_view.php',$this->model);
	}
}