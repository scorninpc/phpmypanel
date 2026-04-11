<?php

namespace Application\Main;

/***
 * class to bootstrap the module
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
		
	}

	/**
	 * inicializa as variaveis do view
	 */
	public function initView()
	{
		$view = \Slim\Mvc\Factory::get("view");
		$config = \Slim\Mvc\Factory::get("config");

		// recupera as mensagens
		$messages = Helpers\Messages::getMessages();
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
		Helpers\Messages::clearMessages();
	}
}