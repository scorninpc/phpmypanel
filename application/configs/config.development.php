<?php

return [
	'extends' => "production",
	
	'application' => [
		'basepath' => "/phpmypanel/public_html",
		
		'display_error' => TRUE,
		'display_debug' => TRUE,
		'log_errors' => TRUE,
	],

	'smarty' => [
		'caching' => FALSE,
		'force_compile' => TRUE,
		'debugging' => TRUE,
		'compile_check' => TRUE,
	],

	'email' => [
		'dsn' => "",
		'sender' => [
			'email' => "",
			'name' => "",
		],
	],

];
