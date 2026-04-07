<?php

namespace Application\Main\Models;

/**
 * model dos usuarios
 */
class Users extends \Slim\Mvc\Model
{
	protected $table = "users";
	protected $primaryKey = "iduser";
}