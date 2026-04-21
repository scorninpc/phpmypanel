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
			'long_description' => $long_description
		];
	}

	/**
	 * recupera as colunas
	 */
	public function getColumns()
	{
		return $this->columns;
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
}