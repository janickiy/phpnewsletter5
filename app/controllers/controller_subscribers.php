<?php

/********************************************
 * PHP Newsletter 5.0.1 beta
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Controller_subscribers extends Controller
{
	function __construct()
	{
		$this->model = new Model_subscribers();
		$this->view = new View();
	}
	
	public function action_index()
	{
		$this->view->generate('subscribers_view.php', $this->model);
	}
}