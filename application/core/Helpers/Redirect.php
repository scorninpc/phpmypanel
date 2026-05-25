<?php

namespace PHPMyPanel\Helpers;

/**
 * Classe que ajuda nos redirecionamentos, tanto por nome de rota, por caminho ou outras formas possiveis.
 */
class Redirect
{
	/**
	 * Redireciona a partir do nome da rota.
	 * 
	 * @param string $route Nome da rota
	 * @param array $params Vetor com os parametros
	 * 
	 * @return void
	 */
	static public function urlFor(string $route, array $params=[]): void
	{
		// recupera o request do app
		$app = \PHPMyPanel\Internal\Application::getInstance();
		$request = $app->getRequest();

		// recupera o contexto das rotas e o parser
		$routeContext = \Slim\Routing\RouteContext::fromRequest($request->getRequest());
		$parser = $routeContext->getRouteParser();

		// cria a rota
		self::go($parser->urlFor($route, $params));
	}

	/**
	 * Efetua o redirect a partir da URL.
	 * 
	 * @param string $url URL para dar o redirect
	 * 
	 * @return void
	 */
	static public function go(string $url): void
	{
		// recupera o app
		$app = \PHPMyPanel\Internal\Application::getSlimApplication();

		// recupera a configuração
		$config = $app->getContainer()->get("config");
		
		// Verifica o http
		if(strpos($url, "http://") !== FALSE) {
			header("Location: " . $url);
			exit();
		}
		
		// Verifica o https
		if(strpos($url, "https://") !== FALSE) {
			header("Location: " . $url);
			exit();
		}
		
		// Verifica o basepath
		if(strpos($url, $config['application']['basepath']) !== FALSE) {
			header("Location: " . $url);
			exit();
		}

		// Verifica se possui barra no inicio da url
		if($url[0] == "/") {
			$url = substr($url, 1);
		}

		// Verifica se possui barra no final do basepath
		$basePath = $config['application']['basepath'];
		if(substr($basePath, -1) == "/") {
			unset($basePath[-1]);
		}

		header("Location: " . $basePath . "/" . $url);
		exit();
	}

	/**
	 * Efetua o redirect para a tela anterior.
	 * 
	 * @return void
	 */
	static public function back(): void
	{
		self::go($_SERVER['HTTP_REFERER']??"");
	}

}