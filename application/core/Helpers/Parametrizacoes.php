<?php

namespace PHPMyPanel\Helpers;

/**
 * Classe que recupera dados das parametrizações
 */
class Parametrizacoes
{
	/**
	 * construtor
	 */
	private function __construct()
	{ }

	/**
	 * Recupera uma parametrização
	 * 
	 * @param string $chave
	 * 
	 * @return mixed
	 */
	static public function getValue(string $chave):mixed
	{
		// busca o valor da parametrização
		$parametrizacao = \PHPMyPanel\Helpers\Db::getFirstFromQuery("SELECT * FROM parametrizacoes WHERE chave = :chave", ['chave'=>$chave]);
		if(!$parametrizacao) {
			throw new \Exception("Não existe parametrização com a chave \"" . $chave . "\"");
		}

		// faz o cast do tipo
		switch($parametrizacao['tipo']) {
			case "BOOLEAN":
				return ($parametrizacao['valor'] == "True") ? TRUE : FALSE;
			case "DECIMAL":
				return floatval(Strings::toDecimal($parametrizacao['valor']));
			case "INTEGER":
				return Strings::toInteger($parametrizacao['valor']);
			default:
				return $parametrizacao['valor'];
		}
	}
}