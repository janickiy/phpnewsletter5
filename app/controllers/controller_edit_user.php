<?php
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
class Controller_edit_user extends Controller
{
	function __construct()
	{
		$this->model = new Model_edit_user();
		$this->view = new View();
	}

	function action_index()
	{
		$this->view->generate('edit_user_view.php', $this->model);
	}
}

?>
