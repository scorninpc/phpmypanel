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
	public function call($model, $field, $row)
	{	
		// recupera o valor do campo
		$value = $row[$field];

		// recupera a coluna
		$column = $model->getColumn($field);

		// verifica o tipo
		switch($column['datatype']) {

			// senhas
			case \Application\Painel\Helpers\Model::FIELDTYPE_PASSWORD:
				$value = "";
				break;

			// integer
			case \Application\Painel\Helpers\Model::FIELDTYPE_INTEGER:
				
				// se for autocomplete
				if($column['autocomplete'] !== NULL) {
					$value = $row[$field . "_label"];
				}

				break;

			// date
			case \Application\Painel\Helpers\Model::FIELDTYPE_DATE:
				$value = strtotime($value);
				if($value !== FALSE) {
					$value = date("d/m/Y", $value);
				}
				else {
					$value = "";
				}
				break;

			// boolean
			case \Application\Painel\Helpers\Model::FIELDTYPE_BOOLEAN:
				
				if($value == TRUE) {
					$value = "Sim";
				}
				else {
					$value = "Não";
				}
				
				break;

			
		}

		// encoda
		if(!$column['modifiers']['escape']) { }
		else {
			// $value = htmlentities($value);
			$value = htmlspecialchars($value??"", ENT_QUOTES, "UTF-8");
		}

		// retorna o valor formatado
		return $value;
	}
}
