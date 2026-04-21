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
		$primaryKey = $this->model->getPrimaryKey();

		// recupera se tem parametro com o nome da chave primaria
		$id = intval($this->getParam($primaryKey, 0));

		// se tiver id é porque está editando
		$row = NULL;
		if($id > 0) {
			// popula o model com um registro, e retorna ele
			$row = $this->model->setRecord($id);
		}

		// assina as variaveis
		$this->view->core_model = $this->model;
		$this->view->core_row = $row;
	}
	
}