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
	 * armazena o request
	 */
	public $request;

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
		// inicia a query
		$select = $this->model->queryBuilder();

		// cria o hook para manipulação da qeury
		$select = $this->doBeforeList($select);

		// recupera os registros
		$rows =  $select->get();

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

				// se é um campo boolean
				else if($config['datatype'] == \Application\Painel\Helpers\Model::FIELDTYPE_BOOLEAN) {

					// trata o valor
					if($data[$column] == 1) {
						$data[$column] = TRUE;
					}
					else {
						$data[$column] = FALSE;
					}
				}

				// se é um campo varchar
				else if($config['datatype'] == \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR) {


					// se é campo de arquivo
					if($config['file'] !== NULL) {

						$arquivo = $_FILES[$column];
						if($arquivo['size'] > 0) {

							// verifica se o arquivo é valido
							$filetype = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $arquivo['tmp_name']);
							if(!in_array($filetype, $config['file']['allowed_mimes'])) {
								\Application\Main\Helpers\Messages::error("Tipo do arquivo não permitido");
								\Application\Main\Helpers\Redirect::back();
							}

							// verifica se o diretório existe e é escrevivel (hahah)
							if(!is_writable($config['file']['destination'])) {
								\Application\Main\Helpers\Messages::error("Diretório \"" . ($config['file']['destination']) . "\" não possui permissão de escrita ou não existe");
								\Application\Main\Helpers\Redirect::back();
							}
							
							// caminho final do arquivo
							$destiny = $config['file']['destination'];

							// se tiver imagick, força salvar em webp se for uma imagem
							if(class_exists("\\Imagick") && (strpos($filetype, "image") !== FALSE) && (!$config['file']['keep_format'])) {
								$name = md5(time() . rand(1000, 9999));
								$extension = "webp";
								$filename = $name . "." . $extension;
								$dest = $destiny . "/" . $filename;

								$format = explode("/", $arquivo['type'])[1] ?? "";

								$img = new \Imagick();
								$img->readImage($format . ":" . $arquivo['tmp_name']);
								$img->setImageFormat("webp");
								$img->setImageCompressionQuality(85);

								$largura = $img->getImageWidth();
								if ($largura > 1090) {
									$img->resizeImage(1090, 0, \Imagick::FILTER_LANCZOS, 1);
								}

								$img->stripImage();
								$img->writeImage($dest); 

								if(method_exists($img, "clear")) {
									$img->clear();
								}
								$img->destroy();
							}
							else {
								$filename = md5(time() . rand(1000, 9999)) . "." . pathinfo($arquivo['name'], PATHINFO_EXTENSION);

								// move o arquivo para o diretório
								move_uploaded_file($arquivo['tmp_name'], $destiny . "/" . $filename);
							}

							// seta o nome final do arquivo
							$data[$column] = $filename;
						}
						else {
							unset($data[$column]);
						}
					}
				}

				// verifica se a coluna é vazia, se for da unset para não atualizar vazia
				if($data[$column] === NULL) {
					unset($data[$column]);
					continue;
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

		// executa antes de montar o form
		$this->doBeforeForm();

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
	 * retorna no formato json
	 */
	public function json($payload, $status=200)
	{
		// se for um vetor, encoda json
		if(is_array($payload)) {
			$payload = json_encode($payload);
		}

		// retorna o json
		$this->response->getBody()->write($payload);
		return $this->response->withHeader("Content-Type", "application/json")->withStatus($status);
	}

	

	/**
	 * hooks
	 */
	public function doBeforeList($select) { return $select; }
	public function doAfterInsert($id) {}
	public function doBeforeInsert($data) { return $data; }
	public function doAfterUpdate($id) {}
	public function doBeforeUpdate($data) { return $data; }
	public function doAfterDelete($id) {}
	public function dobeforeDelete($id) {}
	public function doBeforeForm() { }
	
}
