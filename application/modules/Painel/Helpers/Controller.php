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

		// verifica se tem dados no post
		if($this->getRequest()->isPost()) {
			
			// recupera as colunas do model
			$data = [];
			$columns = $this->model->getColumns();
			foreach($columns as $column => $config) {

				// recupera a informação do form
				$data[$column] = $this->getParam($column, NULL);

				// se é campo senha
				if($config['datatype'] == \Application\Painel\Helpers\Model::FIELDTYPE_PASSWORD) {
					// se estiver vazio, remove o campo, para nao ser atualizado
					if(strlen($data[$column]??"") == 0) {
						unset($data[$column]);
					}

					// se não, criptografa a senha
					else {
						$data[$column] = \Application\Painel\Helpers\Crypto::hash($data[$column]);
					}
				}

			}

			// verifica se está editando ou inserindo
			if($id > 0) {

				// @hook: chama antes de atualizar
				$data = $this->doBeforeUpdate($data);

				// se tem o que atualizar
				if(count($data) > 0) {
					try {
						$this->model->where($this->model->getPrimaryKey(), $id)->update($data);

						// adiciona o alerta
						\Application\Main\Helpers\Messages::success("Registro atualizado");
					}
					catch(\Exception $e) {

						// adiciona o alerta
						\Application\Main\Helpers\Messages::error("Problema ao atualizar o registro");

						throw $e;
					}
				}

				// @hook: chama depois de atualizar
				$this->doAfterUpdate($id);

				// @hook: chama o redirect
				$this->redirectAfterUpdate($id);
				

			}
			else {

				// @hook: chama antes de inserir
				$data = $this->doBeforeInsert($data);

				// se tem o que inserir
				if(count($data) > 0) {
					try {
						$this->model->insert($data);
						
						// recupera o id inserido
						$id = $this->model->getConnection()->getPdo()->lastInsertId();

						// adiciona o alerta
						\Application\Main\Helpers\Messages::success("Registro inserido");
					}
					catch(\Exception $e) {

						// adiciona o alerta
						\Application\Main\Helpers\Messages::error("Problema ao inserir o registro");

						throw $e;
					}
				}

				// @hook: chama depois de inserir
				$this->doAfterInsert($id);

				// @hook: chama o redirect
				$this->redirectAfterInsert($id);

			}

		}

		// assina as variaveis
		$this->view->core_model = $this->model;
		$this->view->core_row = $row;
	}

	/**
	 * ação que deleta um registro
	 */
	public function deleteAction()
	{
		$primaryKey = $this->model->getPrimaryKey();

		// recupera se tem parametro com o nome da chave primaria
		$id = intval($this->getParam($primaryKey, 0));

		// @hook: chama antes de remover
		$this->dobeforeDelete($id);

		// se tiver
		if($id > 0) {
			// remove o registro
			try {
				$this->model->where($this->model->getPrimaryKey(), $id)->delete();

				// adiciona o alerta
				\Application\Main\Helpers\Messages::success("Registro removido");
			}
			catch(\Exception $e) {

				// adiciona o alerta
				\Application\Main\Helpers\Messages::error("Problema ao remover o registro");

				throw $e;
			}

			// @hook: chama depois de remover
			$this->doAfterDelete($id);

			// @hook: chama o redirect
			$this->redirectAfterDelete($id);
		}

		throw new \Exception("ID não encontrado");
	}

	/**
	 * hook para redicionar após inserir
	 */
	public function redirectAfterInsert($id)
	{
		// Retorna para a pagina anterior
		\Application\Main\Helpers\Redirect::urlFor("painel", ['controller'=>$this->getParam("controller")]);
	}

	/**
	 * hook para redicionar após editar
	 */
	public function redirectAfterUpdate($id)
	{
		// Retorna para a pagina anterior
		\Application\Main\Helpers\Redirect::urlFor("painel", ['controller'=>$this->getParam("controller")]);
	}

	/**
	 * hook para redicionar após remover
	 */
	public function redirectAfterDelete($id)
	{
		// Retorna para a pagina anterior
		\Application\Main\Helpers\Redirect::urlFor("painel", ['controller'=>$this->getParam("controller")]);
	}


	/**
	 * hooks
	 */
	public function doAfterInsert($id) {}
	public function doBeforeInsert($data) { return $data; }
	public function doAfterUpdate($id) {}
	public function doBeforeUpdate($data) { return $data; }
	public function doAfterDelete($id) {}
	public function dobeforeDelete($id) {}

	
}