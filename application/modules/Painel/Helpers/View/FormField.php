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
	public function call($model, $field, $row=NULL)
	{	

		// recupera a coluna
		$column = $model->getColumn($field);

		// template da coluna
		$column_template = "
			<div class=\"col-12 col-md-%(bootstrap_column_size)s mb-3\">
				<label class=\"form-label\" for=\"%(id)s\"> %(description)s </label>
				%(input)s
			</div>";

		// inicia o template
		$template = "";

		// recupera o basepath
		$config = \Slim\Mvc\Factory::get("config");
		$basePath = $config['application']['basepath'];

		// recupera o valor já formatado para usar no value
		// $original_value = $model->getValue($column['name'])??"";
		// $helper = new \Application\Painel\Helpers\View\GetFormatedValue($this->config);
		// $value = $helper->call($model, $field, $row);

		$value = $model->getValue($column['name'])??"";

		// verifica o tipo
		switch($column['datatype']) {

			// senhas
			case \Application\Painel\Helpers\Model::FIELDTYPE_PASSWORD:
				$template = "<input type=\"password\" name=\"%(name)s\" id=\"%(id)s\" value=\"\" placeholder=\"%(long_description)s\" class=\"form-control %(classes)s\">";
				break;

			// boolean
			case \Application\Painel\Helpers\Model::FIELDTYPE_BOOLEAN:

				$checked = "";
				if($value) {
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

			// date
			case \Application\Painel\Helpers\Model::FIELDTYPE_DATE:
				$template = "<input type=\"date\" name=\"%(name)s\" id=\"%(id)s\" value=\"%(value)s\" class=\"form-control %(classes)s\">";
				break;

			// datetime
			case \Application\Painel\Helpers\Model::FIELDTYPE_DATETIME:
				$template = "<input type=\"datetime-local\" name=\"%(name)s\" id=\"%(id)s\" value=\"%(value)s\" class=\"form-control %(classes)s\">";
				break;

			// todos os outros tipos são um input="text"
			case \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR:
				// template padrão do varchar
				$template = "<input type=\"text\" name=\"%(name)s\" id=\"%(id)s\" value=\"%(value)s\" placeholder=\"%(long_description)s\" class=\"form-control %(classes)s\">";

				// se for um arquivo
				if($column['file'] !== NULL) {

					// se tiver valor, mostra o preview
					if($value?:"" !== "") {

						$preview_attrib = "target=\"_blank\"";

						// verifica se é uma imagem
						$finfo = new \finfo(FILEINFO_MIME_TYPE);
						if(in_array($finfo->file($column['file']['destination'] . "/" . $value), ['image/jpeg', 'image/png', 'image/webp', 'image/bmp', 'image/gif'])) {
							$preview_attrib = "data-fancybox";
						}
						
						// monta o caminho do arquivo 
						$preview_path = $basePath . "/files/" . $column['file']['dir'] . "/" . $value;

						$template = "
							<div class=\"input-group\">
								<a href=\"" . $preview_path . "\" class=\"btn\" " . $preview_attrib . ">
									<i class=\"fa-solid fa-picture-in-picture\"></i>
								</a>
								<input type=\"file\" name=\"%(name)s\" id=\"%(id)s\" value=\"%(value)s\" class=\"form-control %(classes)s\">
							</div>

							<div class=\"modal\" id=\"exampleModal\" tabindex=\"-1\">
								<div class=\"modal-dialog\" role=\"document\">
									<div class=\"modal-content\">
									<div class=\"modal-header\">Preview</div>
									<div class=\"modal-body\">...</div>
									</div>
								</div>
							</div>
						";
					}
					else {
						$template = "
							<input type=\"file\" name=\"%(name)s\" id=\"%(id)s\" value=\"%(value)s\" class=\"form-control %(classes)s\">
						";
					}
					
				}

				break;

			case \Application\Painel\Helpers\Model::FIELDTYPE_INTEGER:
				$template = "<input type=\"text\" name=\"%(name)s\" id=\"%(id)s\" value=\"%(value)s\" placeholder=\"%(long_description)s\" class=\"form-control %(classes)s\">";

				// se for um autocomplete
				if($column['autocomplete'] !== NULL) {
					$autocomplete_label = $row[$field . "_label"];
					$template = "<input type=\"text\" name=\"%(name)s\" id=\"%(id)s\" value=\"%(value)s\" placeholder=\"%(long_description)s\" class=\"form-control %(classes)s\" data-core-autocomplete-model=\"%(model_name)s\" data-core-autocomplete-label=\"%(autocomplete_label)s\">";
				}

				break;
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
			'autocomplete_label' => $autocomplete_label??"",
			'checked' => $checked??"",
			'model_name' => "\\" . get_class($model),
		]);

		// faz a troca do template todo (coluna bootstrap)
		$html = \Application\Main\Helpers\Strings::vsprintf_named($column_template, [
			'name' => $column['name'],
			'id' => $column['id']??$column['name'],
			'description' => $column['description'],
			'long_description' => $column['long_description'],
			'bootstrap_column_size' => $column['bootstrap_column_size'],
			'input' => $field_html??"",
		]);


		return $html;
	}
}
