<?php

namespace Application\Painel;

/***
 * classe que inicializa o modulo
 */
class Bootstrap extends \PHPMyPanel\Internal\Bootstrap
{
	/**
	 * Código do cache para forçar novo css/js/imagem
	 * 
	 * @var integer
	 */
	protected $cache = 3;

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
	 * hook para configuração do bootstrap
	 */
	public function configure()
	{
		// recupera o container
		$app = \PHPMyPanel\Internal\Application::getSlimApplication();

		// recupera a configuração
		$this->config = $app->getContainer()->get("config");

		// recupera o view
		$this->view = $app->getContainer()->get(\PHPMyPanel\Internal\Smarty::class);
	}

	/**
	 * qualquer metodo iniciado com init será inicializado antes do controller chamar a action
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
		// recupera a sessão de login
		$session = new \PHPMyPanel\Helpers\Sessions("login");

		// recupera os dados do modulo
		$currentModule = $this->request->getParam("module");
		$currentController = $this->request->getParam("controller");
		$currentAction = $this->request->getParam("action");
		
		// informa as paginas publicas que podem ser acessadas sem login
		// @todo melhorar podendo usar wildcards tipo `main:usuarios:*` ou `api:*`
		// @todo melhorar informando se com login pode ser acessado, por exemplo, tela de login, ao estar logado nao pode acessar, mas tem tela que pode mesmo logado
		$publicPages = [
			"painel:usuarios:login",
			"painel:usuarios:recover",
			"painel:usuarios:register",
			"main:error:error",
		];

		// monta a actionString
		$actionString = $this->request->getParam("module") . ":" . $currentController . ":" . $currentAction;

		// verifica se não está logado
		if(($session->idusuario?:0) == 0) {

			// verifica se é uma tela publica
			if(!in_array($actionString, $publicPages)) {

				// se não, redireciona para o login
				\PHPMyPanel\Helpers\Redirect::go("/painel/usuarios/login");
			}
		}

		// se tiver login
		else {

			// verifica se é uma tela publica
			if(in_array($actionString, $publicPages)) {
				
				// se for, redireciona para o main
				\PHPMyPanel\Helpers\Redirect::go("/painel/index/index");
			}

		}

		// recupera a funcionalidade
		$model = new \Application\Painel\Models\Funcionalidades();
		$funcionalidade = $model->where("controlador", $currentController)->first();

		// recupera todas as funcionalidades para criar o menu
		$funcionalidades = $model->orderBy("nome")->get();

		// seta o titulo
		if(strlen($funcionalidade['nome']?:"") > 0) {
			\PHPMyPanel\Helpers\Metas::setMeta("title", "PHP My Dash - " . $funcionalidade['nome']);
		}

		// assina as variaveis
		$this->view->core_funcionalidade = $funcionalidade;
		$this->view->core_funcionalidades = $funcionalidades;
		$this->view->core_current_module = $currentModule;
		$this->view->core_current_controller = $currentController;
		$this->view->core_current_action = $currentAction;
		$this->view->core_login = $session;
		$this->view->core_cache = $this->cache;
	}

	/**
	 * inicializa as variaveis do view
	 */
	public function initView()
	{

		// recupera as mensagens
		$messages = \PHPMyPanel\Helpers\Messages::getMessages();
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

		// limpa as mensagens
		\PHPMyPanel\Helpers\Messages::clearMessages();
	}
}
