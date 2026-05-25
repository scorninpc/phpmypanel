<?php

namespace Application\Main;

/***
 * class to bootstrap the module
 */
class Bootstrap extends \PHPMyPanel\Internal\Bootstrap
{

	/**
	 * Armazena o view
	 * 
	 * @var \PHPMyPanel\Internal\Smarty
	 */
	protected $view;

	/**
	 * Armazena as configurações
	 * 
	 * @var array
	 */
	protected $config;

	/**
	 * Armazena o request
	 * 
	 * @var \PHPMyPanel\Internal\Request
	 */
	protected $request;

	/**
	 * hook para configuração do bootstrap
	 */
	public function configure()
	{
		// recupera o request do app
		$app = \PHPMyPanel\Internal\Application::getInstance();

		// armazena o request
		$this->request = $app->getRequest();

		// recupera a configuração
		$this->config = $app->getConfig();

		// recupera o view
		$this->view = $app->getView();
	}

	/**
	 * any method that starts with "init" will be called by the bootstrap
	 */
	public function initDatabase()
	{
		// create databases
	}

	/**
	 * inicia as validações de sessão e login
	 */
	public function initSessions()
	{
		
	}

	/**
	 * inicializa as variaveis do view
	 */
	public function initView()
	{
		// recupera os dados do modulo
		$currentController = $this->request->getParam("controller");
		$currentAction = $this->request->getParam("action");

		// recupera as mensagens
		$messages = Helpers\Messages::getMessages();
		$errors = $messages->error;
		$alerts = $messages->alert;
		$success = $messages->success;
		$infos = $messages->info;

		// assina as variaveis
		$this->view->basePath = $this->config['application']['basepath'];
		$this->view->global_errors = $errors;
		$this->view->global_alerts = $alerts;
		$this->view->global_success = $success;
		$this->view->global_infos = $infos;
		$this->view->currentController = $currentController;
		$this->view->currentAction = $currentAction;

		// limpa as mensagens
		Helpers\Messages::clearMessages();
	}
}
