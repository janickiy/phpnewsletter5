<?php

/********************************************
 * PHP Newsletter 5.2.0
 * Copyright (c) 2006-2017 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

// authorization
Auth::authorization();

Auth::logOut();

header("Location: ./");

exit();