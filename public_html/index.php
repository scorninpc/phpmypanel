<?php

ini_set("display_errors", "On");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Get the config file
$config = require(__DIR__ . "/../application/configs/config.development.php");

// Define a path to application directory
defined("APPLICATION_PATH") || define("APPLICATION_PATH", realpath($config['application']['location']));

// Include autoload
require __DIR__ . "/../vendor/autoload.php";

// Create Container
$container = new \DI\Container();
\Slim\Factory\AppFactory::setContainer($container);

// Create the app
$app = \Slim\Factory\AppFactory::create();

// Define basepath if it's not defined on config
if(!isset($config['application']['basepath'])) {
	$config['application']['basepath'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname($_SERVER['SCRIPT_NAME']));
	if($config['application']['basepath'] == "/") {
		$config['application']['basepath'] = "";
	}
}
$app->setBasePath($config['application']['basepath']);

// Set view in Container
$container->set("view", function($container) use ($config) {

	// Create smarty view
	$view = new \Slim\Views\Smarty($config['smarty']);

	// Return view object
	return $view;
});

// Initialize database
if($config['db']['enabled']) {
	$database = new \Illuminate\Database\Capsule\Manager();
	$database->addConnection($config['db']);
	$database->setAsGlobal();
	$database->bootEloquent();
}

// Set the config
$container->set("config", function($container) use ($config) {
	return $config;
});

// Routes
$routes = require(APPLICATION_PATH . "/configs/routes.php");
$container->set("routes", $routes);
foreach($routes as $name => $route) {
	$app->map($route['type'], $route['pattern'], function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, $args) use ($config) {

			// store request and response
			\Application\Main\Helpers\Request::getInstance($request, $args);

			// Call MVC bootstrap
			$bootstrap = new \Slim\Mvc\Bootstrap($this, $request, $response, $args, $config);

			// Get response from controller
			return $bootstrap->getResponse();
			
		})
		->setName($name);
}

// Run
$app->run();
