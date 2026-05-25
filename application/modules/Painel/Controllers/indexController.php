<?php

namespace Application\Painel\Controllers;

class indexController extends \PHPMyPanel\Internal\Controller
{
	public function indexAction()
	{ }

	/**
	 * monta o autocomplete
	 */
	public function autocompleteAction()
	{
		$this->view->disableTemplate();

		// recupera os parametros
		$term = $this->getParam("term", "");
		$model_name = $this->getParam("model", "");
		$field = $this->getParam("field", "");

		// ajusta o term
		$term = (html_entity_decode($term));
		if($term == " ") {
			$term = "";
		}
		if($term == "'") {
			$term = "";
		}
		$this->getRequest()->setParam("term", $term);

		// cria o model
		if(!class_exists($model_name)) {
			throw new \Exception("Model \"" . $model_name . "\" não existe");
		}
		$model = new $model_name();

		// recupera as configurações o campo
		$config = $model->getColumn($field);
		if($config['autocomplete'] === NULL) {
			throw new \Exception("Campo \"" . $field . "\" não possui autocomplete");
		}

		// cria o model referencia
		if(!class_exists($config['autocomplete']['model'])) {
			throw new \Exception("Model referencia \"" . $config['autocomplete']['model'] . "\" não existe");
		}
		$ref_model = new $config['autocomplete']['model']();
	
		// recupera as colunas
		$columns = $config['autocomplete']['columns'];

		// faz o select
		$select = $ref_model
			->select($columns);

		// percorre os wheres
		foreach($config['autocomplete']['where'] as $where) {

			// recupera o parametro
			preg_match("/\:(.*)\:/", $where, $match);

			// verifica se possui parametro
			if(isset($match[1])) {
				// troca o nome do parametro pelo parametro do sql
				$param_name = $match[1];
				$new_where = str_replace($match[0], "?", $where);

				// recupera o parametro e seta ele na query
				$param = $this->getParam($param_name, NULL);
				$select->whereRaw($new_where, [mb_strtolower($param)]);

			}
			else {
				$select->where($new_where);
			}
		}

		// recupera os dadods
		$rows = $select->get();

		return $this->json($rows->toArray());
	}
}
