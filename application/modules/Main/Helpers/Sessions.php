<?php

namespace Application\Main\Helpers;

/**
 * Manipula as sessões da aplicação
 */
class Sessions
{
	/**
	 * Nome do namespace
	 */
	protected $namespace;
	
	/**
	 * Construtor da classe
	 */
	public function __construct(string $namespace)
	{
		$this->namespace = $namespace;
		if (!isset($_SESSION[$this->namespace])) {
			$_SESSION[$this->namespace] = [];
		}
	}
	
	/**
	 * Seta uma propriedade
	 * 
	 * @param string $name Nome da propriedade
	 * @param string $value Valor da propriedade
	 */
	public function __set($name, $value)
	{
		$_SESSION[$this->namespace][$name] = $value;
	}
	
	/**
	 * Recupera o valor de uma propriedade
	 * 
	 * @param string $name Nome da propriedade
	 * @return mixed
	 */
	public function __get($name)
	{
		if (isset($_SESSION[$this->namespace][$name])) {
			return $_SESSION[$this->namespace][$name];
		} else {
			return NULL;
		}
	}
	
	/**
	 * Destroi a sessão
	 */
	public function destroy()
	{
		$_SESSION[$this->namespace] = NULL;
		unset($_SESSION[$this->namespace]);
	}

	/**
	 * Destroi a sessão
	 */
	public function toArray()
	{
		return $_SESSION[$this->namespace];
	}
}