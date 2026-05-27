<?php

namespace Application\Painel\Helpers\View;

class GetFormatedValue
{
	protected $config;
	protected $request;

	public function __construct($config) 
	{
		// recupera o request do app
		$app = \PHPMyPanel\Internal\Application::getInstance();
		$this->config = $app->getConfig();
		$this->request = $app->getRequest();
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

			// varchar
			case \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR:
				
				// se for um campo com opções (<select>)
				if($column['options'] !== NULL) {
					// verifica se tem associação, pois se tiver INDEX => VALUE, ele salva o INDEX no banco
					$assoc = count(array_filter(array_keys($column['options']), "is_string")) > 0;
					if($assoc) {
						$value = $column['options'][$value];
					}
				}

				break;

			// integer
			case \Application\Painel\Helpers\Model::FIELDTYPE_INTEGER:
				
				// se for autocomplete
				if($column['autocomplete'] !== NULL) {
					$value = $row[$field . "_label"];
				}

				break;

			// decimal
			case \Application\Painel\Helpers\Model::FIELDTYPE_DECIMAL:
				
				if($value !== NULL) {
					$value = number_format($value, 2, ",", ".");
				}

				break;

			// date
			case \Application\Painel\Helpers\Model::FIELDTYPE_DATE:
				$value = strtotime($value??"");
				if($value !== FALSE) {
					$value = date("d/m/Y", $value);
				}
				else {
					$value = "";
				}
				break;

			// datetime
			case \Application\Painel\Helpers\Model::FIELDTYPE_DATETIME:
				
				$value = strtotime($value??"");
				if($value !== FALSE) {
					$value = date("d/m/Y H:i:s", $value);
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
