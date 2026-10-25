<?php

return [
	
	'application' => [
		'name' => "Application",
		'location' => dirname(__FILE__) . "/..",
		'modules_location' => dirname(__FILE__) . "/../modules",
		'basepath' => "",
		
		'display_error' => FALSE,
		
		'display_debug' => FALSE,

		'log_errors' => TRUE,
		'log_404' => FALSE,

		'error_file' => dirname(__DIR__) . "/modules/Main/Views/error/error.tpl",
	],

	'smarty' => [
		'template_dir' => [
			dirname(__FILE__) . "/../modules",
		],
		'compile_dir' =>  dirname(__FILE__) . "/../tmp/templates_c",
		'cache_dir' =>  dirname(__FILE__) . "/../tmp/templates_c",
		'caching' => FALSE,
		'cache_lifetime' => 4600,
		'force_compile' => FALSE,
		'debugging' => FALSE,
		'compile_check' => FALSE,
	],

	'email' => [
		'dsn' => "",
		'sender' => [
			'email' => "",
			'name' => "",
		],
	],

	'db' => [
		'enabled' => TRUE,
		'driver' => 'sqlite',
		'database' => dirname(__FILE__) . "/../tmp/database.sqlite3",
		'timezone' => "America/Sao_Paulo",
	],

	'routes' => require dirname(__FILE__) . "/routes.php",
];
