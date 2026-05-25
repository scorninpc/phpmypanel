<?php

// inicia com erros ligados
ini_set("display_errors", "On");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// define o diretorio publico
defined("PUBLIC_DIR") || define("PUBLIC_DIR", getenv("PUBLIC_DIR")?:"public_html");

// define o uso de cache
defined("APPLICATION_CACHE") || define("APPLICATION_CACHE", getenv("APPLICATION_CACHE"));
defined("APPLICATION_DBCACHE") || define("APPLICATION_DBCACHE", getenv("APPLICATION_DBCACHE"));

// ambiente
defined("APPLICATION_ENV") || define("APPLICATION_ENV", getenv("APPLICATION_ENV"));

// recupera as configurações
$configFile = __DIR__ . "/../application/configs/config." . APPLICATION_ENV . ".php";
if(!file_exists($configFile)) {
	throw new \Exception("Config file not exists to this APPLICATION_ENV");
}
$config = require($configFile);

// define o caminho da aplicação
defined("APPLICATION_PATH") || define("APPLICATION_PATH", realpath($config['application']['location']));

// inicia o autoload
require __DIR__ . "/../vendor/autoload.php";

// verifica se é a criação de thumb de imagens, aqui, não carrega nada, fica levinho
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
}

// cria o container da aplicação
$container = new \DI\Container();
\Slim\Factory\AppFactory::setContainer($container);

// cria o app slim e seta ao core
$app = \Slim\Factory\AppFactory::create();

// cria o PHPMyPanel application, e seta o slim application dentro para que possamos
// recuperar em outros momentos de forma statica
$application = \PHPMyPanel\Internal\Application::getInstance($app);

// define o basepath da applicatação
if(!isset($config['application']['basepath'])) {
	$config['application']['basepath'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname($_SERVER['SCRIPT_NAME']));
	if($config['application']['basepath'] == "/") {
		$config['application']['basepath'] = "";
	}
}
$app->setBasePath($config['application']['basepath']);

// seta a configuração no container
$container->set("config", function($container) use ($config) {
	// retorna o config
	return $config;
});

// seta o view no container
$container->set(\PHPMyPanel\Internal\Smarty::class, function($container) use ($config) {
	// cria o view smarty
	return new \PHPMyPanel\Internal\Smarty($config['smarty']);
});

// mantem a compatibilidade com o \Slim\Mvc\* [https://github.com/scorninpc/slim-smarty-view]
// $container->set("view", \DI\get(\PHPMyPanel\Internal\Smarty::class));

// inicializa o banco de dados casou houver habilitado
// não precisa adiciona-lo ao container, pois o setAsGlobal ja deixa ele 
// disponivel globalmente por conta do uso de models
if($config['db']['enabled']) {
	$database = new \Illuminate\Database\Capsule\Manager();
	$database->addConnection($config['db']);
	$database->setAsGlobal();
	$database->bootEloquent();
}

// configura o king como debug
\Kint::$enabled_mode = $config['application']['displayDebug']?:FALSE;
\Kint\Renderer\RichRenderer::$theme = "aante-light.css";
\Kint\Renderer\RichRenderer::$folder = TRUE;

// adiciona as rotas ao container e ao app
$container->set("routes", function($container) use ($config) {
	// retorna as rotas
	return $config['routes'];
});

// percorre as rotas, adicionando-as à aplicação
foreach($config['routes'] as $name => $route) {
	$app->map($route['type'], $route['pattern'], function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args) use ($config, $application, $container) {

			// cria o request e o response do PHPMyPanel
			$PHPMyPanelRequest = new \PHPMyPanel\Internal\Request($request, $args);
			$PHPMyPanelResponse = new \PHPMyPanel\Internal\Response($response);

			// chama o run do application
			return $application->run($PHPMyPanelRequest, $PHPMyPanelResponse);
			
		})
		->setName($name);
}


// configura a tela de erro
// $displayErrorDetails = false; //$config['displayErrorDetails'];
// $logErrors = true;
// $logErrorDetails = false;

// // display errors
// ini_set("display_errors","Off");
// if($displayErrorDetails === true) {
// 	ini_set("display_errors","On");
// }
// ini_set("display_errors","On");

// $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);
// $errorHandler = $errorMiddleware->getDefaultErrorHandler();
// $errorHandler->registerErrorRenderer("text/html", new \Application\Main\Helpers\HtmlErrorRenderer($container));

// $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);
// $errorHandler = $errorMiddleware->getDefaultErrorHandler();
// $errorHandler->registerErrorRenderer("text/html", new \Application\Main\Helpers\HtmlErrorRenderer());
// $errorHandler->registerErrorRenderer("text/html", \Application\Main\Helpers\HtmlErrorRenderer::class);


// executa a aplicação
$app->run();
