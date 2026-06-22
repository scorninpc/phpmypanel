<?php

return [
	
	'application' => [
		'name' => "Application",
		'location' => dirname(__FILE__) . "/..",
		'modules_location' => dirname(__FILE__) . "/../modules",
		'basepath' => "/phpmypanel/public_html",
		
		'display_error' => TRUE,
		'display_debug' => TRUE,
		'log_errors' => TRUE,
	],

	'smarty' => [
		'template_dir' => [
			dirname(__FILE__) . "/../modules",
		],
		'compile_dir' =>  dirname(__FILE__) . "/../tmp/templates_c",
		'cache_dir' =>  dirname(__FILE__) . "/../tmp/templates_c",
		'caching' => FALSE,
		'cache_lifetime' => 4600,
		'force_compile' => TRUE,
		'debugging' => FALSE,
		'compile_check' => TRUE,
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
