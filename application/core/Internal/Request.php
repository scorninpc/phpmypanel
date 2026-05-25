<?php

namespace PHPMyPanel\Internal;

/**
 * Faz as tratativas do request custom do PHPMyPanel
 */
class Request
{
	/**
	 * Armazena o $view
	 * @var \PHPMyPanel\Internal\Smarty
	 */
	protected $view;

	/**
	 * Armazena o request
	 * 
	 * @var \Psr\Http\Message\ServerRequestInterface
	 */
	protected $request;

	/**
	 * Armazena os parametros ja tratados
	 * 
	 * @var array
	 */
	protected $params;

	/**
	 * Construtor da classe
	 * 
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param array $args
	 */
	public function __construct(\Psr\Http\Message\ServerRequestInterface $request, array $args)
	{
		// armazena o request original
		$this->request = $request;

		// recupera o container
		$app = Application::getSlimApplication();

		// recupera a configuração
		$config = $app->getContainer()->get("config");

		// recupera os dados da rota
		$routeContext = \Slim\Routing\RouteContext::fromRequest($request);
		$route = $routeContext->getRoute();
		$name = $route->getName();

		// adiciona os valores padrão da rota aos args
		foreach($config['routes'][$name]['defaults'] as $var => $value) {
			$args[$var] = (!isset($args[$var]) ? $value : $args[$var]);
		}

		// verifica se é post, pois se for, substitui os parametros, dando maior relevancia aos dados vindos pelo POST
		if($this->isPost()) {
			$params = (array)$request->getParsedBody();
			$args = array_merge($params, $args);
		}

		// recupera os parametros opcionais do parametro da url (usar sempre esse nome para parametros opcionais na url da rota [/{params:.*}] por exemplo)
		if(isset($args['params'])) {
			// faz o parse em todos os parametros
			$params = explode("/", $args['params']);
			
			// percorre todos eles name/valor (chave/chave+1)
			$arr = [];
			for($i=0; $i<count($params); $i+=2) {
				$arr[$params[$i]] = $params[$i+1];
			}

			// faz o merge dos vetores, dando prioridade aos argumentos principais
			$args = array_merge($args, $arr);
		}

		// recupera os parametros no query string, vindos por GET ?var=valor
		$query_string  = explode("&", explode("?", $_SERVER['REQUEST_URI']??"")[1]??"");
		if(count($query_string) > 0) {
			
			// percorre os parametros separados por &
			$arr = [];
			foreach($query_string as $arg) {
				// faz o parse em todos os parametros var=valor
				$param = explode("=", $arg);

				// faz o merge dos vetores, dando prioridade aos argumentos principais
				$arr[$param[0]] = $param[1];
			}

			// faz o merge dos vetores, dando prioridade aos argumentos principais
			$args = array_merge($arr, $args);
		}

		// armazena os parametros
		$this->params = $args;
	}

	/**
	 * Recupera o request original
	 * 
	 * @return \Psr\Http\Message\ServerRequestInterface
	 */
	public function getRequest(): \Psr\Http\Message\ServerRequestInterface
	{
		return $this->request;
	}

	/**
	 * Forma de setar o request fora do construtor
	 * 
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @return void
	 */
	public function setRequest(\Psr\Http\Message\ServerRequestInterface $request)
	{
		$this->request = $request;
	}

	/**
	 * Verifica se é uma requisição POST
	 * 
	 * @return bool
	 */
	public function isPost(): bool
	{
		$method = $this->getRequest()->getMethod();
		return $method == "POST";
	}

	/**
	 * Verifica se é uma requisição PUT
	 * 
	 * @return bool
	 */
	public function isPut(): bool
	{
		$method = $this->getRequest()->getMethod();
		return $method == "PUT";
	}

	/**
	 * Verifica se é uma requisição GET
	 * 
	 * @return bool
	 */
	public function isGet(): bool
	{
		$method = $this->getRequest()->getMethod();
		return $method == "GET";
	}

	/**
	 * Verifica se é uma requisição OPTIONS
	 * 
	 * @return bool
	 */
	public function isOption(): bool
	{
		$method = $this->getRequest()->getMethod();
		return $method == "OPTION";
	}

	/**
	 * Verifica se é uma requisição DELETE
	 * 
	 * @return bool
	 */
	public function isDelete(): bool
	{
		$method = $this->getRequest()->getMethod();
		return $method == "DELETE";
	}

	/**
	 * Verifica se é uma requisição ajax
	 * 
	 * @return bool
	 */
	public function isAjax(): bool
	{
		return strtolower($this->getRequest()->getHeaderLine('X-Requested-With')) === 'xmlhttprequest';
	}

	/**
	 * Recupera todos os parametros
	 * 
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}

	/**
	 * Recupera um parametro
	 * 
	 * @param string $name Nome do parametro
	 * @param string $default Valor default caso o parametro não exista
	 * 
	 * @return string
	 */
	public function getParam(string $name, mixed $default=NULL): ?string
	{
		// se o parametro não existir
		if(!isset($this->params[$name])) {
			// retorna o default
			return $default;
		}

		return $this->params[$name];
	}

	/**
	 * eta o parametro
	 * 
	 * @param string $name Nome do parametro
	 * @param mixed $value Valor a ser setado no parametro
	 */
	public function setParam(string $name, mixed $value)
	{
		// armazena o valor na variavel
		$this->params[$name] = $value;
	}

	/**
	 * Recupera um parametro vindo do POST, pois algumas vezes pode vir o mesmo nome por GET e POST
	 * 
	 * @param mixed $name Nome do parametro
	 * @param mixed $default Valor default caso o parametro não exista
	 * 
	 * @return string
	 */
	public function getPostParam($name, $default=NULL): string
	{
		// recupera os parametros do POST
		$params = $this->getRequest()->getParsedBody();

		// se o parametro não existir
		if(!isset($params[$name])) {
			// retorna o padrão
			return $default;
		}

		return $params[$name];
	}
}