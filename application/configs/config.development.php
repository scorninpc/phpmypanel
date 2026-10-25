<?php

return [
	'extends' => "production",
	
	'application' => [
		'basepath' => "/phpmypanel/public_html",
		
		'display_error' => FALSE,
		'display_debug' => FALSE,
		'log_errors' => FALSE,
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
