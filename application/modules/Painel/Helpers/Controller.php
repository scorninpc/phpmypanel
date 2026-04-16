<?php

namespace Application\Painel\Helpers;

/**
 * abstração do controller, para os CRUDs ja terem sempre o indexAction, formAction e deleteAction
 */
class Controller extends \Slim\Mvc\Controller
{
	/**
	 * armazena o model desse controller
	 */
	public $model;

	/**
	 * inicializa o controller
	 */
	public function configure() {}

	/**
	 * construtor
	 */
	public function __construct($view, $container, $request, $response, $args)
	{
		// executa o hook
		$this->configure();

		// chama o parent
		parent::__construct($view, $container, $request, $response, $args);
	}

	/**
	 * faz a listagem dos registros
	 */
	public function indexAction()
	{
		// recupera os registros
		$rows =  $this->model->get();

		// assina as variaveis
		$this->view->core_rows = $rows;
		$this->view->core_model = $this->model;
	}

	/**
	 * monta o formulário
	 */
	public function formAction()
	{
		// assina as variaveis
		$this->view->core_model = $this->model;
	}
	
}