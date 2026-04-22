<?php

namespace Application\Painel\Helpers\View;

class GetFormatedValue
{
	protected $config;
	protected $request;

	public function __construct($config) 
	{
		$this->config = $config;
		$this->request = \Slim\Mvc\Factory::get("request");
	}

	/**
	 * faz a chamada ao helper do template
	 */
	public function call($model, $field, $value)
	{	
		// recupera a coluna
		$column = $model->getColumn($field);

		// verifica o tipo
		switch($column['datatype']) {

			// senhas
			case \Application\Painel\Helpers\Model::FIELDTYPE_PASSWORD:
				$value = "";
				break;

			
		}

		// encoda
		// $value = htmlentities($value);
		$value = htmlspecialchars($value, ENT_QUOTES, "UTF-8");

		// retorna o valor formatado
		return $value;
	}
}