<?php

namespace Application\Painel\Models;

/**
 * model de testes do painel
 */
class Testes extends \Application\Painel\Helpers\Model
{
	// configura o nome da tabela e a chave primaria
	protected $table = "testes";
	protected $primaryKey = "idteste";

	/**
	 * configura o model
	 */
	public function configure()
	{
		// adiciona os campos da tabela
		$this->addField("campo_varchar", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Campo Varchar", "Campo do tipo varchar");
		$this->addField("campo_integer", \Application\Painel\Helpers\Model::FIELDTYPE_INTEGER, "Campo Integer", "Campo do tipo integer");
		$this->addField("campo_decimal", \Application\Painel\Helpers\Model::FIELDTYPE_DECIMAL, "Campo Decimal", "Campo do tipo decimal");
		$this->addField("campo_boolean", \Application\Painel\Helpers\Model::FIELDTYPE_BOOLEAN, "Campo Boolean", "Campo do tipo boolean");
		$this->addField("campo_senha", \Application\Painel\Helpers\Model::FIELDTYPE_PASSWORD, "Campo Senha", "Campo do tipo senha");
		$this->addField("campo_texto", \Application\Painel\Helpers\Model::FIELDTYPE_TEXT, "Campo Texto", "Campo do tipo texto");
		$this->addField("campo_data", \Application\Painel\Helpers\Model::FIELDTYPE_DATE, "Campo Data", "Campo do tipo data");
		$this->addField("campo_datahora", \Application\Painel\Helpers\Model::FIELDTYPE_DATETIME, "Campo Data Hora", "Campo do tipo data e hora");
		$this->addField("campo_arquivo", \Application\Painel\Helpers\Model::FIELDTYPE_FILE, "Campo Arquivo", "Campo do tipo arquivo");

		// seta o campo descrição
		$this->setDescriptionField("campo_varchar");

		// seta os modificadores
		$this->setType("campo_texto", "richtext");

		// seta a visibilidade dos campos
		$this->setVisibility("campo_varchar", TRUE, TRUE, TRUE);
		$this->setVisibility("campo_integer", TRUE, TRUE, TRUE);
		$this->setVisibility("campo_decimal", TRUE, TRUE, TRUE);
		$this->setVisibility("campo_boolean", TRUE, TRUE, TRUE);
		$this->setVisibility("campo_senha", TRUE, TRUE, FALSE);
		$this->setVisibility("campo_texto", TRUE, TRUE, FALSE);
		$this->setVisibility("campo_data", TRUE, TRUE, TRUE);
		$this->setVisibility("campo_datahora", TRUE, TRUE, TRUE);
		$this->setVisibility("campo_arquivo", TRUE, TRUE, FALSE);

		// seta o tamanho da coluna bootstrap
		$this->setBootstrapColumnSize("campo_varchar", 4);
		$this->setBootstrapColumnSize("campo_integer", 4);
		$this->setBootstrapColumnSize("campo_decimal", 4);
		$this->setBootstrapColumnSize("campo_boolean", 2);
		$this->setBootstrapColumnSize("campo_texto", 12);
		$this->setBootstrapColumnSize("campo_data", 3);
		$this->setBootstrapColumnSize("campo_datahora", 3);
		$this->setBootstrapColumnSize("campo_arquivo", 6);
	}
}