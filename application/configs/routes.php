<?php


return [

	// painel route
	'painel' => [
		'pattern' => "/painel[/{controller}[/{action}[/{params:.*}]]]",
		'type' => ['GET', 'POST'],
		'defaults' => [
			'module' => "painel",
			'controller' => "index",
			'action' => "index",
		],
	],

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