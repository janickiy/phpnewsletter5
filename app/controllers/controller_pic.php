<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
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