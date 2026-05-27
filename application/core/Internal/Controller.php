<?php

namespace PHPMyPanel\Internal;

/**
 * Faz as tratativas de um controller MVC
 */
class Controller
{
	/**
	 * Armazena o $view
	 * @var \PHPMyPanel\Internal\Smarty
	 */
	protected $view;

	/**
	 * Armazenna o request
	 * @var \PHPMyPanel\Internal\Request
	 */
	protected $request;

	/**
	 * Armazena o response
	 * @var \PHPMyPanel\Internal\Response
	 */
	protected $response;

	/**
	 * Construtor da classe
	 * 
	 * @param \PHPMyPanel\Internal\Smarty $view
	 * @param \PHPMyPanel\Internal\Request $request
	 * @param \PHPMyPanel\Internal\Response $response
	 */
	public function __construct(\PHPMyPanel\Internal\Smarty $view, \PHPMyPanel\Internal\Request $request, \PHPMyPanel\Internal\Response $response)
	{
		// armazena os objetos
		$this->view = $view;
		$this->request = $request;
		$this->response = $response;

		// chama o hook para configuração do controller à ser executado sempre no inicio
		$this->configure();
	}

	/**
	 * Recupera o request
	 * 
	 * @return \PHPMyPanel\Internal\Request
	 */
	public function getRequest(): \PHPMyPanel\Internal\Request
	{
		return $this->request;
	}

	/**
	 * Recupera o response
	 * 
	 * @return \PHPMyPanel\Internal\Response
	 */
	public function getResponse(): \PHPMyPanel\Internal\Response
	{
		return $this->response;
	}

	/**
	 * Alias para simplificar e nao precisar pegar o request antes
	 * 
	 * @param string $name Nome do parametro
	 * @param string $default Valor default caso o parametro não exista
	 * 
	 * @return mixed
	 */
	public function getParam($name, $default=NULL): mixed
	{
		return $this->getRequest()->getParam($name, $default);
	}

	/**
	 * Hooks
	 */
	public function configure() {}

	/**
	 * Retorna no formato JSON
	 * 
	 * @param array $payload Vetor com os dados json
	 * @param integer $status Código do status HTTP
	 * 
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function json(array $payload, int $status=200): \Psr\Http\Message\ResponseInterface
	{
		// se for um vetor, encoda json
		if(is_array($payload)) {
			$payload = json_encode($payload);
		}

		// recupera o container
		$app = \PHPMyPanel\Internal\Application::getSlimApplication();

		// retorna o json
		$this->response->getResponse()->getBody()->write($payload);
		return $this->response->getResponse()->withHeader("Content-Type", "application/json")->withStatus($status);
	}

}
