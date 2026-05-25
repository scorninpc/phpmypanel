<?php

namespace PHPMyPanel\Helpers\View;

/**
 * View helper que cria urls
 */
class Url
{
	/**
	 * Armazena o request
	 * @var \PHPMyPanel\Internal\Request
	 */
	protected $request;

	/**
	 * Construtor da classe
	 * 
	 * @param \PHPMyPanel\Internal\Request $request Request da requisição
	 */
	public function __construct(\PHPMyPanel\Internal\Request $request)
	{
		$this->request = $request;
	}

	public function call($params, $name)
	{
		// recupera o parser
		$routeContext = \Slim\Routing\RouteContext::fromRequest($this->request->getRequest());
		$parser = $routeContext->getRouteParser();

		// recupera o container
		$app = \PHPMyPanel\Internal\Application::getSlimApplication();

		// recupera a configuração
		$config = $app->getContainer()->get("config");

		// retorna as rotas
		$routes = $config['routes'];
		
		// percorre os valores padrões
		$final_params = [];
		foreach($routes[$name]['defaults'] as $default => $value) {
			// se esse parametro não estiver vindo da função
			if(!isset($params[$default])) {
				// usa o default
				$final_params[$default] = $value;
			}
			else {
				// usa o que está vindo se não for NULL
				if($params[$default] != NULL) {
					$final_params[$default] = $params[$default];
				}
			}

			// e remove ele
			unset($params[$default]);
		}

		// agora percorre o que sobrou de $params para criar o query string final
		foreach ($params as $key => $value) {
			if($value != NULL) {
				$final_params['params'] .= "/" . urlencode($key) . "/" . urlencode($value);
			}
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