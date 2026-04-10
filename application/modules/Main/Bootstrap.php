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
		$request = \Application\Main\Helpers\Request::getInstance();
		$session = new Helpers\Sessions("login");

		// informa as paginas publicas que podem ser acessadas sem login
		// @todo melhorar podendo usar wildcards tipo `main:users:*` ou `api:*`
		// @todo melhorar informando se com login pode ser acessado, por exemplo, tela de login, ao estar logado nao pode acessar, mas tem tela que pode mesmo logado
		$publicPages = [
			"main:users:login",
			"main:users:recover",
			"main:users:register",
		];

		// monta a actionString
		$actionString = $request->getParam("module") . ":" . $request->getParam("controller") . ":" . $request->getParam("action");

		// verifica se não está logado
		if(($session->iduser?:0) == 0) {

			// verifica se é uma tela publica
			if(!in_array($actionString, $publicPages)) {

				// se não, redireciona para o login
				Helpers\Redirect::go("/main/users/login");
			}
		}

		// se tiver login
		else {

			// verifica se é uma tela publica
			if(in_array($actionString, $publicPages)) {
				
				// se for, redireciona para o main
				Helpers\Redirect::go("/main/index/index");
			}

		}
	}

	/**
	 * inicializa as variaveis do view
	 */
	public function initView()
	{
		$view = \Slim\Mvc\Factory::get("view");
		$config = \Slim\Mvc\Factory::get("config");

		$view->basePath = $config['application']['basepath'];
	}
}