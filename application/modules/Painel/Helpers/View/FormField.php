<?php

namespace Application\Painel\Helpers\View;

class FormField
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
	public function call($model, $field)
	{	

		// recupera a coluna
		$column = $model->getColumn($field);

		// inicia o template
		$template = "";
		$value = "";

		// recupera o valor, caso tenha
		$value = $model->getValue($column['name'])??"";
		$value = htmlentities($value);

		// verifica o tipo
		if($column['datatype'] == \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR) {
			$template = "<input type=\"text\" name=\"%(name)s\" value=\"%(value)s\" placeholder=\"%(long_description)s\" class=\"form-control\">";
		}

		// faz a troca
		$html = \Application\Main\Helpers\Strings::vsprintf_named($template, [
			'name' => $column['name'],
			'id' => $column['id']??$column['name'],
			'long_description' => $column['long_description'],
			'value' => $value??"",
		]);


		return $html;
	}
}