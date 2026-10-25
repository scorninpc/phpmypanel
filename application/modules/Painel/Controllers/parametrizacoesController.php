<?php

namespace Application\Painel\Controllers;

use Application\Painel\Helpers;

/**
 * controlador das parametrizações do painel
 * 
 */
class parametrizacoesController extends \Application\Painel\Helpers\Controller
{

	/**
	 * configura o controller
	 */
	public function configure()
	{
		$this->model = new \Application\Painel\Models\Parametrizacoes();
	}

}