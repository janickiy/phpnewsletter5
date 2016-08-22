<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

/**
 * ******************************************
 * PHP Newsletter 4.0.15
 * Copyright (c) 2006-2015 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 * ******************************************
 */

class Controller_category extends Controller
{
	function __construct()
	{
		$this->model = new Model_category();
		$this->view = new View();
	}

	function action_index()
	{
		$this->view->generate('category_view.php',$this->model);
	}
}

?>