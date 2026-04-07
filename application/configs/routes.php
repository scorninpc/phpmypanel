<?php


return [

	// default route
	'default' => [
		'pattern' => "/[{module}[/{controller}[/{action}[/{params:.*}]]]]",
		'type' => ['GET', 'POST'],
		'defaults' => [
			'module' => "main",
			'controller' => "index",
			'action' => "index",
		],
	],

];