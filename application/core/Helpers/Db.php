<?php

namespace PHPMyPanel\Helpers;

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

		$execution = $db->prepare($query);
		$execution->execute($params);
		$result = $execution->fetchAll(\PDO::FETCH_ASSOC);

		return $result;
	}

	/**
	 * executa uma query e retorna somente o primeiro registro
	 * 
	 * @param string $query Query SQL a ser executada
	 * @param array $params Parametros para efetuar o bind
	 * 
	 * @return ?array
	 */
	static public function getFirstFromQuery(string $query, array $params=[]): ?array
	{
		$rows = self::executeQuery($query, $params);
		if(count($rows??[]) > 0) {
			return $rows[0];
		}
		else {
			return NULL;
		}
	}

	/**
	 * executa uma query e retorna os registros
	 * 
	 * @param string $query Query SQL a ser executada
	 * @param array $params Parametros para efetuar o bind
	 * 
	 * @return ?array
	 */
	static public function getFromQuery(string $query, array $params=[]): ?array
	{
		$rows = self::executeQuery($query, $params);
		if(count($rows??[]) > 0) {
			return $rows;
		}
		else {
			return NULL;
		}
	}
}
