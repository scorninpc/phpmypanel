<?php

namespace Application\Painel\Models;

/**
 * model das funcionalidades do painel
 * 
 * create table funcionalidades (
 *	idfuncionalidade integer not null primary key AUTOINCREMENT, 
 *  nome varchar(250),
 *	controlador varchar(250)
 * );
 */
class Funcionalidades extends \Application\Painel\Helpers\Model
{
	// configura o nome da tabela e a chave primaria
	protected $table = "funcionalidades";
	protected $primaryKey = "idfuncionalidade";

	/**
	 * configura o model
	 */
	public function configure()
	{
		// adiciona os campos da tabela
		$this->addField("nome", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Nome", "Nome da funcionalidade");
		$this->addField("controlador", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Controlador", "Nome do controlador da funcionalidade");
	}
}