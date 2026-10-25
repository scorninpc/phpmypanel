<?php

namespace PHPMyPanel\Helpers\View;

/**
 * View helper que recupera as parametrizações
 */
class Parametrizacoes
{
	/**
	 * Construtor da classe
	 * 
	 * @param \PHPMyPanel\Internal\Request $request Request da requisição
	 */
	public function __construct(\PHPMyPanel\Internal\Request $request)
	{ }

	/**
	 * Faz a chamada
	 * 
	 * @param string $chave
	 * 
	 * @return mixed
	 */
	public function call(string $chave): mixed
	{
		return \PHPMyPanel\Helpers\Parametrizacoes::getValue($chave);
	}
}