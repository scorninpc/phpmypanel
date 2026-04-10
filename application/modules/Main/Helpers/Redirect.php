<?php

namespace Application\Main\Helpers;

class Redirect
{
	/**
	 * redireciona a partir da rota
	 */
	static public function urlFor($route, $params=[])
	{
		$request = \Slim\Mvc\Factory::get("request");
		
		$routeContext = $request->getRouteContext();
		$parser = $routeContext->getRouteParser();

		self::go($parser->urlFor($route, $params));
	}

	/**
	 * efetua o redirect
	 * 
	 * @param string $url URL para dar o redirect
	 */
	static public function go($url)
	{
		$config = \Slim\Mvc\Factory::get("config");
		
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
	 * efetua o redirect para a tela anterior
	 */
	static public function back()
	{
		\Application\Main\Helpers\Redirect::go($_SERVER['HTTP_REFERER']??"");
	}

}