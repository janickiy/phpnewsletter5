<?php

/********************************************
 * PHP Newsletter 5.2.0
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_edit_account extends Controller
{
	function __construct()
	{
		$this->model = new Model_edit_account();
		$this->view = new View();
	}

	function action_index()
	{
		$this->view->generate('edit_account_view.php', $this->model);
	}
}