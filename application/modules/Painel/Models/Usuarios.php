<?php

namespace Application\Painel\Models;

/**
 * model dos usuarios
 */
class Usuarios extends \Application\Painel\Helpers\Model
{
	protected $table = "usuarios";
	protected $primaryKey = "idusuario";

	/**
	 * configura o model
	 */
	public function configure()
	{
		// adiciona os campos da tabela
		$this->addField("nome", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Nome", "Nome do usuário");
		$this->addField("email", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Email", "Email do usuário");
		$this->addField("password", \Application\Painel\Helpers\Model::FIELDTYPE_PASSWORD, "Senha", "Senha do usuário (ao editar, deixe em branco para não modificar)");

		// seta o campo descrição
		$this->setDescriptionField("nome");
		
		// seta a visibilidade dos campos
		$this->setVisibility("nome", TRUE, TRUE, TRUE);
		$this->setVisibility("email", TRUE, TRUE, TRUE);
		$this->setVisibility("password", TRUE, TRUE, FALSE);
	}
}