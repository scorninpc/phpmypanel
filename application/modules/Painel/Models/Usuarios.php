<?php

namespace Application\Painel\Models;

/**
 * model dos usuarios
 */
class Usuarios extends \Slim\Mvc\Model
{
	protected $table = "usuarios";
	protected $primaryKey = "idusuario";

	/**
	 * configura o model
	 */
	public function configure()
	{
		// adiciona os campos da tabela
		$this->addField("email", \Application\Painel\Helpers\Model::FIELDTYPE_VARCHAR, "Email", "Email do usuário");
		$this->addField("password", \Application\Painel\Helpers\Model::FIELDTYPE_PASSWORD, "Senha", "Senha do usuário");
	}
}