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
		$this->addField("is_admin", \Application\Painel\Helpers\Model::FIELDTYPE_BOOLEAN, "Admin", "Informa se é um usuário administrador SINCORE");
		$this->addField("is_gerente", \Application\Painel\Helpers\Model::FIELDTYPE_BOOLEAN, "Gerente", "Informa se é um usuário gerente");

		// seta o campo descrição
		$this->setDescriptionField("nome");

		// seta a obrigatoriedade dos campos
		$this->setRequired("nome", TRUE);
		$this->setRequired("email", TRUE);
		
		// seta a visibilidade dos campos
		$this->setVisibility("nome", TRUE, TRUE, TRUE);
		$this->setVisibility("email", TRUE, TRUE, TRUE);
		$this->setVisibility("password", TRUE, TRUE, FALSE);
		$this->setVisibility("is_admin", TRUE, TRUE, TRUE);
		$this->setVisibility("is_gerente", TRUE, TRUE, TRUE);

		$this->setBootstrapColumnSize("nome", 4);
		$this->setBootstrapColumnSize("email", 4);
		$this->setBootstrapColumnSize("password", 4);
		$this->setBootstrapColumnSize("is_admin", 2);
		$this->setBootstrapColumnSize("is_gerente", 3);
	}
}
