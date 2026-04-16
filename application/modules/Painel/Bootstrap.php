<?php

namespace Application\Painel;

/***
 * classe que inicializa o modulo
 */
class Bootstrap {

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
		$view = \Slim\Mvc\Factory::get("view");
		$request = \Application\Main\Helpers\Request::getInstance();
		$session = new \Application\Main\Helpers\Sessions("login");

		// recupera os dados do modulo
		$currentController = $request->getParam("controller");
		$currentAction = $request->getParam("action");
		
		// informa as paginas publicas que podem ser acessadas sem login
		// @todo melhorar podendo usar wildcards tipo `main:users:*` ou `api:*`
		// @todo melhorar informando se com login pode ser acessado, por exemplo, tela de login, ao estar logado nao pode acessar, mas tem tela que pode mesmo logado
		$publicPages = [
			"painel:users:login",
			"painel:users:recover",
			"painel:users:register",
		];

		// monta a actionString
		$actionString = $request->getParam("module") . ":" . $currentController . ":" . $currentAction;

		// verifica se não está logado
		if(($session->iduser?:0) == 0) {

			// verifica se é uma tela publica
			if(!in_array($actionString, $publicPages)) {

				// se não, redireciona para o login
				\Application\Main\Helpers\Redirect::go("/painel/users/login");
			}
		}

		// se tiver login
		else {

			// verifica se é uma tela publica
			if(in_array($actionString, $publicPages)) {
				
				// se for, redireciona para o main
				\Application\Main\Helpers\Redirect::go("/painel/index/index");
			}

		}

		// recupera a funcionalidade
		$model = new \Application\Painel\Models\Funcionalidades();
		$funcionalidade = $model->where("controlador", $currentController)->first();

		// assina as variaveis
		$view->core_funcionalidade = $funcionalidade;
		$view->core_current_controller = $currentController;
		$view->core_current_action = $currentAction;
	}

	/**
	 * inicializa as variaveis do view
	 */
	public function initView()
	{
		$view = \Slim\Mvc\Factory::get("view");
		$config = \Slim\Mvc\Factory::get("config");


		// recupera as mensagens
		$messages = \Application\Main\Helpers\Messages::getMessages();
		$errors = $messages->error;
		$alerts = $messages->alert;
		$success = $messages->success;
		$infos = $messages->info;

		// assina as variaveis
		$view->basePath = $config['application']['basepath'];
		$view->global_errors = $errors;
		$view->global_alerts = $alerts;
		$view->global_success = $success;
		$view->global_infos = $infos;

		// limpa as mensagens
		\Application\Main\Helpers\Messages::clearMessages();
	}
}