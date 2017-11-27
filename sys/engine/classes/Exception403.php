<?php

/********************************************
 * PHP Newsletter 5.2.3
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Exception403 extends Exception
{
	public function __construct($message)
	{
		parent::__construct($message);
	}
}