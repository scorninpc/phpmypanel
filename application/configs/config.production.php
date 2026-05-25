<?php

return [
	
	'application' => [
		'name' => "Application",
		'location' => dirname(__FILE__) . "/..",
		'modules_location' => dirname(__FILE__) . "/../modules",
		'basepath' => "/lanceagro.com.br/public_html",
		
		'displayErrorDetails' => FALSE,
		'displayDebug' => FALSE,
	],

	'smarty' => [
		'template_dir' => [
			dirname(__FILE__) . "/../",
			dirname(__FILE__) . "/../modules/",
		],
		'compile_dir' =>  dirname(__FILE__) . "/../tmp/templates_c",
		'cache_dir' =>  dirname(__FILE__) . "/../tmp/templates_c",
		'caching' => FALSE,
		'cache_lifetime' => 4600,
		'force_compile' => TRUE,
		'debugging' => FALSE,
		'compile_check' => TRUE,
	],

	'db' => [
		'enabled' => TRUE,
		'driver' => 'sqlite',
		'database' => dirname(__FILE__) . "/../tmp/database.sqlite3",
	],

	'routes' => require APPLICATION_PATH . "/configs/routes.php",
];