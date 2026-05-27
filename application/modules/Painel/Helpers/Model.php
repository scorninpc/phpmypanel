<?php

namespace Application\Painel\Helpers;

/**
 * abstração do model, para os CRUDs conseguirem montar os formulários e listagens
 */
class Model extends \PHPMyPanel\Internal\Model
{	
	// configura o nome da tabela e a chave primaria
	protected $table = "";
	protected $primaryKey = "";

	// armazena as colunas do model
	protected $columns = [];

	// armazena o registro
	protected $row;

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
	// const FIELDTYPE_FILE = "file"; // não existe mais, usar varchar, pois o campo no banco é varchar

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
			'modifiers' => [],
			'bootstrap_column_size' => 6,
			'visibility' => [
				'insert' => TRUE,
				'update' => TRUE,
				'list' => TRUE,
			],
			'file' => NULL,
			'autocomplete' => NULL,
			'options' => NULL
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
	 * recupera o nome da tabela
	 */
	public function getTable()
	{
		return $this->table;
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
		// verifica se a coluna existe
		if(!isset($this->columns[$field])) {
			throw new \Exception("Coluna \"" . $field . "\" não existe");
		}

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
		// verifica se a coluna existe
		if(!isset($this->columns[$field])) {
			throw new \Exception("Coluna \"" . $field . "\" não existe");
		}

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
			$select = $this->queryBuilder();
			$this->row = $select->where($this->getPrimaryKey(), $id)->first();
		}
		catch(\Exception $e) {
			throw $e;
		}

		return $this->row;
	}

	/**
	 * recupera o valor de todas as colunas
	 */
	public function getValues()
	{
		return $this->row;
	}

	/**
	 * recupera o valor de uma coluna
	 */
	public function getValue($field)
	{
		return $this->row[$field]??NULL;
	}

	/**
	 * seta o valor de uma coluna
	 */
	public function setValue($field, $value)
	{
		$this->row[$field] = $value;
	}

	/**
	 * Informa a visibilidade do campo conforme a tela do CRUD.
	 * 
	 * @param string $field Nome do campo
	 * @param bool $insert Se o campo é visivel no formulário quando está inserindo um registro
	 * @param bool $update Se o campo é visivel no formulário quando está atualizando um registro
	 * @param bool $list Se o campo é visivel na tela de listagem
	 * 
	 * @return void
	 */
	public function setVisibility($field, $insert=TRUE, $update=TRUE, $list=TRUE):void
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
		// verifica se a coluna existe
		if(!isset($this->columns[$field])) {
			throw new \Exception("Coluna \"" . $field . "\" não existe");
		}

		return $this->columns[$field]['visibility'][$mode];
	}

	/**
	 * seta o tamanho da coluna bootstrap/tabler
	 */
	public function setBootstrapColumnSize($field, $size=6)
	{
		// verifica se a coluna existe
		if(!isset($this->columns[$field])) {
			throw new \Exception("Coluna \"" . $field . "\" não existe");
		}

		return $this->columns[$field]['bootstrap_column_size'] = $size;
	}

	/**
	 * Seta as opções do campo
	 * 
	 * @param string $name Nome do campo
	 * @param array $options Vetor com as opções do campo
	 */
	public function setOptions(string $name, array $options=[])
	{
		$this->columns[$name]['options'] = $options;
	}

	/**
	 * seta o tipo do campo manualmente
	 */
	public function setType($field, $type, $options=[])
	{
		// verifica se o campo existe
		if(!isset($this->columns[$field])) {
			throw new \Exception("Coluna \"" . $field . "\" não existe");
		}

		// texto rico
		if($type == "richtext") {
			if(!isset($options['escape'])) {
				$options['escape'] = FALSE;
			}
			$this->columns[$field]['modifiers']['escape'] = $options['escape'];
			$this->columns[$field]['classes'][] = "core-richtext";

			// muda o tipo
			$this->columns[$field]['datatype'] = \Application\Painel\Helpers\Model::FIELDTYPE_TEXT;
		}

		// telefone
		elseif($type == "phone") {
			$this->columns[$field]['classes'][] = "core-mask-phone";
		}

		// cep
		elseif($type == "cep") {
			$this->columns[$field]['classes'][] = "core-mask-cep";
		}

		// documento
		elseif($type == "documento") {
			$this->columns[$field]['classes'][] = "core-mask-documento";
		}

		// file
		elseif($type == "file") {
			$this->columns[$field]['classes'][] = "core-custom-file";
			$this->columns[$field]['file']['dir'] = $options['dir'];
			$this->columns[$field]['file']['destination'] = APPLICATION_PATH . "/../" . PUBLIC_DIR . "/files/" . $options['dir'];
			$this->columns[$field]['file']['allowed_mimes'] = $options['mimes'];
			$this->columns[$field]['file']['keep_format'] = $options['keep_format']??FALSE;
		}
	}

	/**
	 * seta o campo como autocomplete
	 * 
	 * $field - nome do campo
	 * $model - model da tabela que é pra ser listada
	 * $options - opções de configuração
	 */
	public function setAutocomplete($field, $model_name, $options=[])
	{
		if(!class_exists($model_name)) {
			throw new \Exception("Model \"" . $model_name . "\" não existe");
		}
		$model = new $model_name();

		// monta a configuração padrão
		$defaults = [
			'columns' => [
				\Application\Main\Helpers\Db::raw($model->getPrimaryKey() . " as id"),
				\Application\Main\Helpers\Db::raw($model->getDescriptionField() . " as label"),
			],
			'where' => [
				"LOWER(" . $model->getDescriptionField() . ") like '%' || :term: || '%'" // essa concatenação e o lower é feito para que funcione no sqlite tambem que noa possui ilike
			],
			// 'select' => $select,
			// 'search_field' => "nome || fazenda"
 		];

		// verifica se tem columns
		if(isset($options['columns'])) {
			$defaults['columns'] = $options['columns'];
		}

		// cerifica se é um vetor, pois se for string as colunas tem o mesmo nome, caso contrario 'column_name'=>'ref_column_name'
		if(is_array($field)) {
			$name = key($field);
			$ref_column = current($field);
		}
		else {
			$name = $field;
			$ref_column = $field;
		}

		// armazena as informações do autocomplete
		$this->columns[$name]['autocomplete'] = [
			'model' => $model_name,
			'refcolumn' => $ref_column,
			'options' => $options,
			'columns' => $defaults['columns'],
			'where' => $defaults['where'],
		];

		// seta a classe que vai mudar o autocomplete
		$this->columns[$name]['classes'][] = "core-autocomplete";

	}

	/**
	 * monta a query do model
	 */
	public function queryBuilder()
	{
		// inicia a montagem da query
		$select = $this->from($this->getTable());

		// Recupera as colunas do model
		$select_columns = [$this->getTable() . "." . $this->getPrimaryKey()];
		$columns = $this->getColumns();
		$count = 1;
		foreach($columns as $column => $config) {

			// adiciona a coluna ao select
			$select_columns[] = $this->getTable() . "." . $column;

			// se a coluna for um autocomplete
			if($config['autocomplete'] !== NULL) {

				// cria o model da referencia
				$ac = new $config['autocomplete']['model']();

				// monta a coluna de descricao
				$ac_column_description = sprintf("T%02d.%s as %s_label", $count, $ac->getDescriptionField(), $column);

				// faz o join
				$select->leftJoin(
					$ac->getTable() . " AS " . sprintf("T%02d", $count), 
					sprintf("T%02d", $count) . "." . $config['autocomplete']['refcolumn'], 
					"=", 
					$this->getTable() . "." . $column
				);

				// adiciona a coluna do label
				$select_columns[] = $ac_column_description;

				// proximo join
				$count++;
			}

		}

		// adiciona as colunas
		$select->select($select_columns);

		// retorna a query
		return $select;
	}
}
