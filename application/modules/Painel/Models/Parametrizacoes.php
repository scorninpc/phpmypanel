<?php

namespace Application\Painel\Models;

/**
 * model das parametrizações do painel
 */
class Parametrizacoes extends \Application\Painel\Helpers\Model
{
	// configura o nome da tabela e a chave primaria
	protected $table = "parametrizacoes";
	protected $primaryKey = "idparametrizacao";

	/**
	 * configura o model
	 */
	public function configure()
	{
		// adiciona os campos da tabela
		$this->addField("descricao", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Descrição", "Nome da parametrização");
		$this->addField("chave", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Chave", "Chave de identificação da parametrização");
		$this->addField("valor", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Valor", "Valor da parametrização");
		$this->addField("tipo", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Tipo", "Tipo da parametrização");

		// seta o campo descrição
		$this->setDescriptionField("descricao");

		// seta a visibilidade dos campos
		$this->setVisibility("descricao", TRUE, TRUE, TRUE);
		$this->setVisibility("chave", TRUE, TRUE, TRUE);
		$this->setVisibility("valor", TRUE, TRUE, TRUE);
		$this->setVisibility("tipo", TRUE, TRUE, TRUE);

		// seta as opções
		$this->setOptions("tipo", [
				'BOOLEAN',
				'DECIMAL',
				'INTEGER',
				'TEXT',
				'VARCHAR',
			]);
	}
}
