<?php

namespace Application\Painel\Helpers;

/**
 * abstração do model, para os CRUDs conseguirem montar os formulários e listagens
 */
class Model extends \Slim\Mvc\Model
{	
	// configura o nome da tabela e a chave primaria
	protected $table = "funcionalidades";
	protected $primaryKey = "idfuncionalidade";

	// armazena as colunas do model
	protected $columns = [];

	// armazena o nome da coluna que serve como identificador/descrição
	protected $description_field = NULL;

	// tipo de dados
	const FIELDTYPE_INTEGER = "integer";
	const FIELDTYPE_DECIMAL = "decimal";
	const FIELDTYPE_VARCHAR = "varchar";
	const FIELDTYPE_TEXT = "text";
	const FIELDTYPE_DATETIME = "datetime";
	const FIELDTYPE_DATE = "date";
	const FIELDTYPE_BOOLEAN = "boolean";
	const FIELDTYPE_PASSWORD = "password";
	const FIELDTYPE_FILE = "file";

	/**
	 * inicializa o controller
	 */
	public function configure() {}

	/**
	 * construtor
	 */
	public function __construct()
	{
		// executa o hook
		$this->configure();

		// chama o parent
		parent::__construct();
	}

	/**
	 * adiciona campos ao model, informando o nome, tipo e descrição de cada campo
	 */
	public function addField($name, $type, $description, $long_description="")
	{
		$this->columns[$name] = [
			'name' => $name,
			'datatype' => $type,
			'description' => $description,
			'long_description' => $long_description,
			'classes' => [],
			'visibility' => [
				'insert' => TRUE,
				'update' => TRUE,
				'list' => TRUE,
			],
		];

		// a depender do tipo, ja configura alguns padrões
		switch($type) {

			// integer
			case \Application\Painel\Helpers\Model::FIELDTYPE_INTEGER:
				$this->columns[$name]['classes'][] = "core-mask-integer";
				break;
				
			// decimal
			case \Application\Painel\Helpers\Model::FIELDTYPE_DECIMAL:
				$this->columns[$name]['classes'][] = "core-mask-decimal";
				break;
				
			// date
			case \Application\Painel\Helpers\Model::FIELDTYPE_DATE:
				$this->columns[$name]['classes'][] = "core-mask-date";
				break;
				
			// datetime
			case \Application\Painel\Helpers\Model::FIELDTYPE_DATETIME:
				$this->columns[$name]['classes'][] = "core-mask-datetime";
				break;
		}
	}

	/**
	 * recupera as colunas
	 */
	public function getColumns()
	{
		return $this->columns;
	}

	/**
	 * recupera uma coluna
	 */
	public function getColumn($field)
	{
		return $this->columns[$field];
	}

	/**
	 * recupera a chave primaria
	 */
	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	/**
	 * seta o nome da coluna descrição/identificador
	 */
	public function setDescriptionField($field)
	{
		$this->description_field = $field;
	}

	/**
	 * recupera o nome da coluna descrição/identificador
	 */
	public function getDescriptionField()
	{
		return $this->description_field;
	}

	/**
	 * popula o model com os dados de um registro
	 */
	public function setRecord($id)
	{
		try {
			$row = $this->where($this->getPrimaryKey(), $id)->first();
		}
		catch(\Exception $e) {
			throw $e;
		}

		// percorre as colunas adicionando o valor nelas
		foreach($this->columns as $field => $column) {
			$this->columns[$field]['value'] = $row[$field];
		}

		return $row;
	}

	/**
	 * recupera o valor de uma coluna
	 */
	public function getValue($field)
	{
		return $this->columns[$field]['value']??NULL;
	}

	/**
	 * seta a visibilidade do campo
	 */
	public function setVisibility($field, $insert=TRUE, $update=TRUE, $list=TRUE)
	{
		// verifica se a coluna existe
		if(!isset($this->columns[$field])) {
			throw new \Exception("Coluna \"" . $field . "\" não existe");
		}

		$this->columns[$field]['visibility']['insert'] = $insert;
		$this->columns[$field]['visibility']['update'] = $update;
		$this->columns[$field]['visibility']['list'] = $list;
	}

	/**
	 * recupera a visibilidade do campo
	 */
	public function getVisibility($field, $mode)
	{
		return $this->columns[$field]['visibility'][$mode];
	}
}