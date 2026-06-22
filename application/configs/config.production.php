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
	],

	'smarty' => [
		'template_dir' => [
			dirname(__FILE__) . "/../modules/",
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
	],

	'routes' => require dirname(__FILE__) . "/routes.php",
];
