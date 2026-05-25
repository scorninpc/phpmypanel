<?php

namespace Application\Main\Controllers;

class indexController extends \PHPMyPanel\Internal\Controller
{
	/**
	 * pagina inicial
	 */
	public function indexAction()
	{
		// redireciona para o painel
		\PHPMyPanel\Helpers\Redirect::go("/painel");
	}
}
