<?php

/********************************************
 * PHP Newsletter 5.2.1
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');


class Controller_faq extends Controller
{
	function __construct()
	{
		$this->model = new Model_faq();
		$this->view = new View();
	}

	function action_index()
	{
		$this->view->generate('faq_view.php',$this->model);
	}
}