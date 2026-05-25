<?php

namespace PHPMyPanel\Internal;

/**
 * Classe que abstrai os helpers do view
 */
class ViewHelper
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
		$this->request = $request;
	}

	/**
	 * Faz as chamadas dos views helpers
	 */
	public function __call($name, $args)
	{
		
		// recupera o container
		$app = Application::getSlimApplication();

		// recupera a configuração
		$config = $app->getContainer()->get("config");

		// verifica se está usando modulos
		if(($config['application']['modules_location']?:"") == "") {
			// procura dentro do core
			$helperName = "\\PHPMyPanel\\Helpers\\View\\" . ucfirst($name);
		}
		else {
			// recupera o helper do modulo
			$helperName = "\\" . $config['application']['name'] . "\\" . ucfirst($this->request->getParam("module")) . "\\Helpers\\View\\" . ucfirst($name);
		}

		// se ele nao existir
		if(!class_exists($helperName)) {
			// procura dentro do application direto
			$helperName = "\\PHPMyPanel\\Helpers\\View\\" . ucfirst($name);
		}

		// se ele nao existir
		if(!class_exists($helperName)) {
			// da erro
			throw new \Exception("Helper \"" . ucfirst($helperName) . "\" not found");
		}

		// se tudo ok, cria o objeto
		$helper = new $helperName($this->request);

		// e chama
		return call_user_func_array([$helper, "call"], $args);
	}
}