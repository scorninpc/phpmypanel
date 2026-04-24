<?php

namespace Application\Painel\Controllers;

use Application\Painel\Helpers;

/**
 * controlador de teste do painel
 * 
 */
class testesController extends \Application\Painel\Helpers\Controller
{

	/**
	 * configura o controller
	 */
	public function configure()
	{
		$this->model = new \Application\Painel\Models\Testes();
	}

}