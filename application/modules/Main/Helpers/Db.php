<?php

namespace Application\Main\Helpers;

/**
 * Classe de abstração do \Illuminate\Database\Capsule\Manager
 * 
 * Extende \Illuminate\Database\Capsule\Manager para fornecer um nome de classe mais curto
 * facilitando o uso do gerenciador de banco de dados do Illuminate.
 */
class Db extends \Illuminate\Database\Capsule\Manager
{
	/**
	 * Executa queries no formato texto, sem usar o query builder
	 * 
	 * @param string $query Query SQL a ser executada
	 * @param array $params Parametros para efetuar o bind
	 * 
	 * @return array
	 */
	static public function executeQuery(string $query, array $params=[]): array
	{
		$capsule = new \Illuminate\Database\Capsule\Manager();

		$connection = $capsule->connection();
		$db = $connection->getPdo();
		// $db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);

		$execution = $db->prepare($query);
		$execution->execute($params);
		$result = $execution->fetchAll(\PDO::FETCH_ASSOC);

		return $result;
	}
}