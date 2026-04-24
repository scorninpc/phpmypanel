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

		// template da coluna
		$column_template = "
			<div class=\"col-12 col-md-6 mb-3\">
				<label class=\"form-label\" for=\"%(id)s\"> %(description)s </label>
				%(input)s
			</div>";

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
				$template = "<input type=\"password\" name=\"%(name)s\" id=\"%(id)s\" value=\"\" placeholder=\"%(long_description)s\" class=\"form-control %(classes)s\">";
				break;

			// boolean
			case \Application\Painel\Helpers\Model::FIELDTYPE_BOOLEAN:

				$checked = "";
				if($value == TRUE) {
					$checked = "checked=\"checked\"";
				}

				$template = "<label class=\"form-check pt-2\">
					<input type=\"checkbox\" name=\"%(name)s\" id=\"%(id)s\" value=\"1\" class=\"form-check-input %(classes)s\" data-value=\"%(value)s\" %(checked)s>
				</label>";
				break;

			// text
			case \Application\Painel\Helpers\Model::FIELDTYPE_TEXT:
				$template = "<textarea name=\"%(name)s\" id=\"%(id)s\" class=\"form-control %(classes)s\">%(value)s</textarea>";
				break;

			// todos os outros tipos são um input="text"
			case \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR:
			case \Application\Painel\Helpers\Model::FIELDTYPE_INTEGER:
			case \Application\Painel\Helpers\Model::FIELDTYPE_DECIMAL:
			default:
				$template = "<input type=\"text\" name=\"%(name)s\" id=\"%(id)s\" value=\"%(value)s\" placeholder=\"%(long_description)s\" class=\"form-control %(classes)s\">";
				break;
		}

		// recupera as classes do campo
		$classes = implode(" ", $column['classes']);

		// faz a troca do campo
		$field_html = \Application\Main\Helpers\Strings::vsprintf_named($template, [
			'name' => $column['name'],
			'classes' => $classes,
			'id' => $column['id']??$column['name'],
			'long_description' => $column['long_description'],
			'value' => $value??"",
			'checked' => $checked??"",
		]);

		// faz a troca do template todo (coluna bootstrap)
		$html = \Application\Main\Helpers\Strings::vsprintf_named($column_template, [
			'name' => $column['name'],
			'id' => $column['id']??$column['name'],
			'description' => $column['description'],
			'long_description' => $column['long_description'],
			'input' => $field_html??"",
		]);


		return $html;
	}
}