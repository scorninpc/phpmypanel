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

	public function initSessions()
	{
		$request = \Application\Main\Helpers\Request::getInstance();
		$session = new Helpers\Sessions("login");

		// verifica se não está logado
		if(($session->iduser?:0) == 0) {

			// se nao ta logado, verifica se é a tela de login
			if(($request->getParam("controller") == "users") && ($request->getParam("action") == "login")) { }
			// elseif(($request->getParam("controller") == "users") && ($request->getParam("action") == "register")) { } // uncoment if anyone can register
			elseif(($request->getParam("controller") == "users") && ($request->getParam("action") == "recorver")) { }
			else {
				// se não, redireciona para o login
				Helpers\Redirect::go("/main/users/login");
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