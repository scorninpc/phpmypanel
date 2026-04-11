<?php

namespace Application\Painel\Models;

/**
 * model dos usuarios
 */
class Users extends \Slim\Mvc\Model
{
	protected $table = "users";
	protected $primaryKey = "iduser";
}