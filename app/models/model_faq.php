<?php

/********************************************
 * PHP Newsletter 5.1.1
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

class Model_faq extends Model
{
	/**
	 * @return string
	 */
	public function get_faq()
	{
		$filename = core::pathTo('templates', "language/faq_".core::getSetting("language") );
		return file_get_contents($filename);
	}
}