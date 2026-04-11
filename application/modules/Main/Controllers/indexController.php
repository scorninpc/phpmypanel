<?php

namespace Application\Main\Controllers;

class indexController extends \Slim\Mvc\Controller
{

	public function indexAction()
	{
		// redireciona para o painel
		\Application\Main\Helpers\Redirect::go("/painel");
	}
}