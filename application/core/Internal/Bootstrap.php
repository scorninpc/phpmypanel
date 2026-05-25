<?php

namespace PHPMyPanel\Internal;

/**
 * Faz as tratativas do bootstrap, que faz algumas chamadas de configuração antes e depois da aplicação
 */
class Bootstrap
{
	/**
	 * Armazena o request
	 * @var \PHPMyPanel\Internal\Request
	 */
	protected $request;

	/**
	 * Construtor da classe
	 * 
	 * @param \PHPMyPanel\Internal\Request $request Request da requisição
	 */
	public function __construct(\PHPMyPanel\Internal\Request $request) 
	{
		// armazena o request
		$this->request = $request;

		// hook para configurar o bootstrap
		$this->configure();

		// recupera os methods
		$methods = get_class_methods($this);
		foreach($methods as $method) {

			// se iniciar com init
			if(substr($method, 0, 4) == "init") {

				// executa executa
				$this->$method();
			}
		}

	}

	/**
	 * Hooks
	 */
	public function configure() {}
}