<?php

namespace Application\Main\Helpers\View;

class Url
{
	protected $config;
	protected $request;

	public function __construct($config) 
	{
		$this->config = $config;
		$this->request = \Slim\Mvc\Factory::get("request");
	}

	public function call($params, $name)
	{	
		// recupera o parser
		$routeContext = $this->request->getRouteContext();
		$parser = $routeContext->getRouteParser();

		// retorna as rotas
		$container = \Slim\Mvc\Factory::get("container");
		$routes = $container->get("routes");
		
		// percorre os valores padrões
		$final_params = [];
		foreach($routes['default']['defaults'] as $default => $value) {
			// se esse parametro não estiver vindo da função
			if(!isset($params[$default])) {
				// usa o default
				$final_params[$default] = $value;
			}
			else {
				// usa o que está vindo
				$final_params[$default] = $params[$default];
			}

			// e remove ele
			unset($params[$default]);
		}

		// agora percorre o que sobrou de $params para criar o query string final
		foreach ($params as $key => $value) {
			$final_params['params'] .= "/" . urlencode($key) . "/" . urlencode($value);
		}
		if(isset($final_params['params'])) {
			$final_params['params'] = substr($final_params['params'], 1);
		}

		// monta a url final
		$final_url = $parser->urlFor($name, $final_params);

		//
		$final_url = htmlspecialchars($final_url, ENT_QUOTES, "UTF-8");

		// retorna a url
		return $final_url;
	}
}