<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(

	'driver'       => 'orm',
	'hash_method'  => 'sha256',
	'hash_key'     => 'kkk44555mmmmmkkk',
	'lifetime'     => 1209600,
	'session_type' => Session::$default,
	'session_key'  => 'auth_user',

);
