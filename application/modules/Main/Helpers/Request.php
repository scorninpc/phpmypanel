<?php

namespace Application\Main\Helpers;

use Slim\Routing\RouteContext;

/**
 * Trata o request, como por exemplo, o metodo, o nome da rota, os parametros.
 */
class Request
{
	/**
	 * Request original do slim
	 * 
	 * @var \Psr\Http\Message\ServerRequestInterface
	 */
	protected $request;

	/**
	 * Vetor com os parametros
	 * 
	 * @var array
	 */
	protected $params;

	/**
	 * Proprio objeto
	 * @var \Application\Main\Helpers\Request
	 */
	static $instance;

	/**
	 * Cria a instancia. Os parametros são passados somente na primeira chamada.
	 * 
	 * @param \Psr\Http\Message\ServerRequestInterface|null $request Request original Slim
	 * @param array|null $args Vetor com os parametros recebidos
	 * 
	 * @return \Application\Main\Helpers\Request
	 */
	static public function getInstance(\Psr\Http\Message\ServerRequestInterface|NULL $request=NULL, array|NULL $args=NULL): \Application\Main\Helpers\Request
	{
		if(!self::$instance) {
			self::$instance = new self($request, $args);
		}

		return self::$instance;
	}

	/**
	 * Construtor privado, para forçar executar somente uma vez.
	 * 
	 * @param \Psr\Http\Message\ServerRequestInterface|null $request Request original Slim
	 * @param array|null $args Vetor com os parametros recebidos
	 * 
	 * @return \Application\Main\Helpers\Request
	 */
	private function __construct($request, $args)
	{
		$this->request = $request;

		// recupera as configurações e os dados das rotas
		$config = require(APPLICATION_PATH . "/configs/routes.php");

		$routeContext = RouteContext::fromRequest($request);
		$route = $routeContext->getRoute();
		$name = $route->getName();

		// adiciona os valores padrão
		foreach($config[$name]['defaults'] as $var => $value) {
			$args[$var] = (!isset($args[$var]) ? $value : $args[$var]);
		}

		// verifica se é post
		if($this->isPost()) {
			$params = (array)$request->getParsedBody();
			$args = array_merge($params, $args);
		}

		// recupera os parametros opcionais
		if(isset($args['params'])) {

			$params = explode("/", $args['params']);
			
			$arr = [];
			for($i=0; $i<count($params); $i+=2) {
				$arr[$params[$i]] = $params[$i+1];
			}

			// faz o merge dos vetores, dando prioridade aos argumentos principais
			$args = array_merge($args, $arr);
		}

		// recupera os parametros no query string
		$query_string  = explode("&", explode("?", $_SERVER['REQUEST_URI']??"")[1]??"" );
		$arr = [];
		foreach($query_string as $arg) {
			$param = explode("=", $arg);

			$arr[$param[0]] = $param[1];
		}
		$args = array_merge($arr, $args);

		// armazena os parametros
		$this->params = $args;
	}

	/**
	 * Retorna o request slim original.
	 * 
	 * @return \Psr\Http\Message\ServerRequestInterface
	 */
	public function getRequest(): \Psr\Http\Message\ServerRequestInterface
	{
		return $this->request;
	}

	/**
	 * seta o request original
	 */
	public function setRequest($request)
	{
		$this->request = $request;
	}

	/**
	 * recupera todos os parametros
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * recupera o parametro
	 */
	public function getParam($name, $default=NULL)
	{
		if(!isset($this->params[$name])) {
			return $default;
		}

		return $this->params[$name];
	}

	/**
	 * seta o parametro
	 */
	public function setParam($name, $value)
	{
		$this->params[$name] = $value;
	}

	/**
	 * recupera especificamente o valor de um parametro POST
	 */
	public function getPostParam($name, $default=NULL)
	{
		$params = $this->getRequest()->getParsedBody();

		if(!isset($params[$name])) {
			return $default;
		}

		return $params[$name];
	}

	/**
	 * verifica se a requisição é um post
	 */
	public function isPost()
	{
		$method = $this->getRequest()->getMethod();
		return $method == "POST";
	}

	/**
	 * verifica se a requisição é um put
	 */
	public function isPut()
	{
		$method = $this->getRequest()->getMethod();
		return $method == "PUT";
	}

	/**
	 * verifica se a requisição é um get
	 */
	public function isGet()
	{
		$method = $this->getRequest()->getMethod();
		return $method == "GET";
	}

	/**
	 * verifica se a requisição é um option
	 */
	public function isOption()
	{
		$method = $this->getRequest()->getMethod();
		return $method == "OPTION";
	}

	/**
	 * verifica se a requisição é um delete
	 */
	public function isDelete()
	{
		$method = $this->getRequest()->getMethod();
		return $method == "DELETE";
	}

	/**
	 * verifica se é uma requisição ajax
	 */
	public function isAjax()
	{
		return strtolower($this->getRequest()->getHeaderLine("X-Requested-With")) === "xmlhttprequest";
	}


}
