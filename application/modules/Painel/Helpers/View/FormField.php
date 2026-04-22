<?php

namespace Application\Painel\Helpers\View;

class FormField
{
	protected $config;
	protected $request;
	protected $view;

	public function __construct($config) 
	{
		$this->config = $config;
		$this->request = \Slim\Mvc\Factory::get("request");
		$this->view = \Slim\Mvc\Factory::get("view");
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

		// recupera o valor já formatado para usar no value
		$original_value = $model->getValue($column['name'])??"";
		$helper = new \Application\Painel\Helpers\View\GetFormatedValue($this->config);
		$value = $helper->call($model, $field, $original_value);

		// verifica o tipo
		switch($column['datatype']) {

			// senhas
			case \Application\Painel\Helpers\Model::FIELDTYPE_PASSWORD:
				$template = "<input type=\"password\" name=\"%(name)s\" value=\"\" placeholder=\"%(long_description)s\" class=\"form-control\">";
				break;

			// textos
			case \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR:
				$template = "<input type=\"text\" name=\"%(name)s\" value=\"%(value)s\" placeholder=\"%(long_description)s (deixe\" class=\"form-control\">";
				break;

			
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