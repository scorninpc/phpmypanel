<?php

ini_set("display_errors", "On");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Get the config file
$config = require(__DIR__ . "/../application/configs/config.development.php");

// Define a path to application directory
defined("APPLICATION_PATH") || define("APPLICATION_PATH", realpath($config['application']['location']));

// define o diretorio publico
defined("PUBLIC_DIR") || define("PUBLIC_DIR", getenv("PUBLIC_DIR")?:"public_html");

// define cache usage
defined("APPLICATION_CACHE") || define("APPLICATION_CACHE", getenv("APPLICATION_CACHE"));
defined("APPLICATION_DBCACHE") || define("APPLICATION_DBCACHE", getenv("APPLICATION_DBCACHE"));

// Include autoload
require __DIR__ . "/../vendor/autoload.php";

// verifica se é a criação de imagens
if ((isset($_GET['param'])) && ($_GET['param'] == "tbimage")) {

	session_cache_limiter('none');

	// busca os parametros
	$name = $_GET["imagem"];
	$type = $_GET["tipo"];
	$width = $_GET["largura"];
	$height = $_GET["altura"];
	$crop = $_GET["crop"];
	$titulo = $_GET["titulo"];
	$extension = substr($titulo, strrpos($titulo, ".")+1);
	$file = $name . "." . $extension;

	// verifica se o cache está habilitado
	if (APPLICATION_CACHE == 1) {
		
		// monta o nome do arquivo cahce
		$cachefile = APPLICATION_PATH . "/../" . PUBLIC_DIR . "/cache/images/" . $type . "/" . $crop . "/" . $width . "/" . $height . "/" . $name . "/" . $titulo;
		
		// cria o diretório caso não exista
		mkdir(dirname($cachefile), 0777, true);
		chmod(dirname($cachefile), 0777);

		// verifica se o arquivo existe
		if (file_exists($cachefile)) {
			$file = $cachefile;
			$cached = TRUE;
		}
		else {
			$file = APPLICATION_PATH . "/../" . PUBLIC_DIR . "/files/" . $type . "/" . $file;
			$cached = FALSE;
		}
	}
	else {
		
		// monta o caminho do arquivo
		$file = APPLICATION_PATH . "/../" . PUBLIC_DIR . "/files/" . $type . "/" . $file;
		$cached = FALSE;
	}

	// verifica se está em cache
	if (! $cached) {
		
		// cria o objeto canvas
		$canvas = new \Canvas($file);
		
		// verifica se foi passada somente a largura
		if (($width != "") && ($height == "")) {
			$canvas->redimensiona($width);
		}

		// verifica se foi passada somente a altura
		elseif ($width == "" && $height != "") {
			$canvas->redimensiona('', $height);
		}
		
		// verifica se foram passadas as duas dimensoes
		elseif ($width != "" && $height != "") {

			if ($crop == 0) {
				$canvas->redimensiona($width, $height);
			}
			elseif ($crop == 1) {
				$canvas->redimensiona($width, $height, "crop");
			}
			elseif ($crop == 2) {
				$canvas->hexa("FFFFFF");
				$canvas->redimensiona($width, $height, "preenchimento");
			}
			elseif ($crop == 3) {
				$canvas->redimensiona($width, $height, "crop");
				$canvas->filtra("blur", 40);

				$canvas_image = new \Canvas($file);
				$canvas_image->redimensiona($width, $height, 'proporcional');

				$canvas->marca($canvas_image, "meio", "centro");
			}
		}
		else {
			$canvas->redimensiona($thumbs->largura, $thumbs->altura, "preenchimento");
		}
		
		// verifica se o cache está habilitado
		if (APPLICATION_CACHE == 1) {
			// grava o cache
			$canvas->grava($cachefile, 95);
		}
		else {
			// exibe a imagem
			$canvas->grava("", 95);
		}
	}

	// verifica se o cache está habilitado
	if (APPLICATION_CACHE == 1) {

		// verifica a extensão
		$extension = substr($cachefile, strrpos($cachefile, ".") + 1);
		switch (strtolower($extension)) {
			case "jpg":
			case "jpeg":
				header("Content-type: image/jpeg");
				break;
			case "png":
				header("Content-type: image/png");
				break;
			case "gif":
				header("Content-type: image/gif");
				break;
			case "webp":
				header("Content-type: image/webp");
				break;
		}

		header('Cache-control: max-age='.(60*60*24*365));
		header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*365));
		header('Last-Modified: '.gmdate(DATE_RFC1123,filemtime($cachefile)));
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			header('HTTP/1.1 304 Not Modified');
			die();
		}
		
		// joga o conteudo do arquivo pro buffer
		readfile($cachefile);
	}
	
	die();

	die("OK");
}

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
	$view = new \Application\Main\Helpers\Smarty($config['smarty']);

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

// Config the errors
\Kint::$enabled_mode = TRUE;
\Kint\Renderer\RichRenderer::$theme = 'aante-light.css';
\Kint\Renderer\RichRenderer::$folder = true;

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
