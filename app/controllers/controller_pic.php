<?php

/********************************************
 * PHP Newsletter 5.3.1
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_pic extends Controller
{
	function __construct()
	{
		$this->model = new Model_pic();
		$this->view = new View();
	}

	function action_index()
	{
		$this->view->generate('pic_view.php',$this->model);
	}
}