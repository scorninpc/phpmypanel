<?php

namespace PHPMyPanel\Internal;

/**
 * Classe que abstrai a aplicação
 */
class Application
{
	/**
	 * Armazena a instancia SingleTon
	 */
	protected static $instance;

	/**
	 * Armazena a aplicação Slim
	 * 
	 * @var \Slim\App
	 */
	protected static $app;

	/**
	 * Armazena a configuração
	 * 
	 * @var array
	 */
	protected $config;

	/**
	 * Armazena o request da applicação
	 * 
	 * @var \PHPMyPanel\Internal\Request
	 */
	protected $request;

	/**
	 * Armazena o response da applicação
	 * 
	 * @var \PHPMyPanel\Internal\Response
	 */
	protected $response;

	/**
	 * Armazena o view da applicação
	 * 
	 * @var \PHPMyPanel\Internal\Smarty
	 */
	protected $view;

	/**
	 * Construtor da classe
	 * 
	 * @param \Slim\App $app
	 * 
	 * @return void
	 */
	private function __construct(\Slim\App $app)
	{
		self::$app = $app;
	}

	/**
	 * Construtor da classe singleton
	 * 
	 * @param \Slim\App $app
	 * 
	 * @return \PHPMyPanel\Internal\Application
	 */
	public static function getInstance(?\Slim\App $app=NULL): self
	{
		if(!self::$instance) {
			self::$instance = new self($app);
		}

		return self::$instance;
		
	}

	/**
	 * Seta o app
	 * 
	 * @param \Slim\App $app
	 * 
	 * @return void
	 */
	public static function setSlimApplication(\Slim\App $app)
	{
		self::$app = $app;
	}

	/**
	 * recupera o app
	 * 
	 * @return \Slim\App
	 */
	public static function getSlimApplication(): \Slim\App
	{
		return self::$app;
	}

	/**
	 * Seta o request
	 * 
	 * @param \PHPMyPanel\Internal\Request $request
	 * 
	 * @return void
	 */
	public function setRequest(\PHPMyPanel\Internal\Request $request)
	{
		$this->request = $request;
	}

	/**
	 * recupera o request
	 * 
	 * @return \PHPMyPanel\Internal\Request
	 */
	public function getRequest(): \PHPMyPanel\Internal\Request
	{
		return $this->request;
	}

	/**
	 * Seta o response
	 * 
	 * @param \PHPMyPanel\Internal\Response $response
	 * 
	 * @return void
	 */
	public function setResponse(\PHPMyPanel\Internal\Response $response)
	{
		$this->response = $response;
	}

	/**
	 * recupera o response
	 * 
	 * @return \PHPMyPanel\Internal\Response
	 */
	public function getResponse(): \PHPMyPanel\Internal\Response
	{
		return $this->response;
	}

	/**
	 * Seta a configuração
	 * 
	 * @param array $config
	 * 
	 * @return void
	 */
	public function setConfig(array $config)
	{
		$this->config = $config;
	}

	/**
	 * recupera a configuração
	 * 
	 * @return array
	 */
	public function getConfig(): array
	{
		return $this->config;
	}

	/**
	 * Seta o view
	 * 
	 * @param \PHPMyPanel\Internal\Smarty $view
	 * 
	 * @return void
	 */
	public function setView(\PHPMyPanel\Internal\Smarty $view)
	{
		$this->view = $view;
	}

	/**
	 * recupera o view
	 * 
	 * @return \PHPMyPanel\Internal\Smarty
	 */
	public function getView(): \PHPMyPanel\Internal\Smarty
	{
		return $this->view;
	}

	/**
	 * Executa o application após a rota
	 * 
	 * Não é a execução da application como o slim faz. Essa chamada é a aplicação da rota
	 */
	public function run(\PHPMyPanel\Internal\Request $request, \PHPMyPanel\Internal\Response $response): \Psr\Http\Message\ResponseInterface
	{
		// inicia a sessão
		session_start();
		
		// recupera o container
		$container = self::$app->getContainer();

		// recupera a configuração
		$this->config = $container->get("config");

		// armazena o request
		$this->request = $request;

		// armazena o response
		$this->response = $response;

		// recupera o view
		$view = $container->get(\PHPMyPanel\Internal\Smarty::class);
		$this->view = $view;

		// recupera os dados do MVC
		$module = $request->getParam("module", "main");
		$controller = $request->getParam("controller", "index");
		$action = $request->getParam("action", "index");

		// verifica se está usando modulos
		if(($this->config['application']['modules_location']?:"") == "") {
			// cria o path dos views sem o diretório do modulo
			$viewPath = "Views/";
		}
		else {
			// cria o path do view com modulo
			$viewPath = "" . ucfirst(strtolower($module)) . "/Views/";
		}

		// monta o caminho do MVC, caso tenha ou não modulo
		$mvcPath = ($this->config['application']['modules_location']?:APPLICATION_PATH);

		// verifica se o template da action não existe com 
		$contentFile = $viewPath . strtolower($controller) . "/" . strtolower($action) . ".tpl";
		if(!file_exists($mvcPath . "/" . $contentFile)) {
			// se não existir, procura ele no diretorio templates padrão
			$contentFile = $viewPath . "layouts/" . strtolower($action) . ".tpl";
		}

		// agora monta o layout, que é o template padrão, que o contentFile será incluso dentro (menu, rodapé, etc)
		$templateFile = $viewPath . "layouts/template.tpl";

		// tudo pronto, podemos enviar pro view ver o que ele faz
		$view->setTemplateFile($templateFile);
		$view->setContentFile($contentFile);

		// assina o viewhelper dinamico
		$viewHelper = new \PHPMyPanel\Internal\ViewHelper($request);
		$view->assign("this", $viewHelper);

		// verifica se está usando modulo para criar o path do bootstrap
		if(($this->config['application']['modules_location']?:"") == "") {
			// cria o caminho do bootstrap
			$bootstrapName = "\\" . $this->config['application']['name'] . "\\Bootstrap";
		}
		else {
			$bootstrapName = "\\" . $this->config['application']['name'] . "\\" . ucfirst($module) . "\\Bootstrap";
		}

		// verifica se o bootstrap existe
		if(class_exists($bootstrapName)) {
			$bootstrap = new $bootstrapName($request);
		}
		
		
		// verifica se está usando modulos para iniciar o tratamento do controller
		if(($this->config['application']['modules_location']?:"") == "") {
			// cria o nome do controlador sem modulo
			$controllerName = "\\" . $this->config['application']['name'] . "\\Controllers\\" . strtolower($controller) . "Controller";
		}
		else {
			// cria o nome do controlador com modulo
			$controllerName = "\\" . $this->config['application']['name'] . "\\" . ucfirst($module) . "\\Controllers\\" . strtolower($controller) . "Controller";
		}

		// verifica se o controlador existe
		if(!class_exists($controllerName)) {
			throw new \Slim\Exception\HttpNotFoundException($request->getRequest(), "Page not found");
		}
		
		// cria o objeto do controlador
		$controllerObject = new $controllerName($view, $request, $response);

		// verifica se a action existe
		$actionName = $action . "Action";
		if(!method_exists($controllerObject, $actionName)) {
			throw new \Slim\Exception\HttpNotFoundException($request->getRequest(), "Page not found");
		}
		$actionReturn = $controllerObject->$actionName();

		// se teve retorno do action
		if(!$actionReturn) {

			// se nao teve retorno, faz o processamento do view e retorna
			return $view->process($response)->getResponse();
		}
		else {

			// retorna o que o action retornou diretamente, pois pode ser um json ou algo fora do Smarty
			return $actionReturn;
		}

	}
}