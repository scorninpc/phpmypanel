<?php

namespace PHPMyPanel\Helpers\View;

/**
 * View helper que inclui assets automaticamente caso eles existam com base no caminho controller/action
 */
class Assets
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
	 * 
	 * Faz a chamada
	 * 
	 * @param mixed $type Tipo do asset, css ou javascript
	 * @param integer|null $cache Código do cache para colocar no final
	 * 
	 * @return string
	 */
	public function call($type, $core_cache=NULL)
	{
		// recupera o request do app
		$app = \PHPMyPanel\Internal\Application::getInstance();
		$request = $app->getRequest();
		$config = $app->getConfig();

		$module = $request->getParam("module", "");
		$controller = $request->getParam("controller", "");
		$action = $request->getParam("action", "");

		// inicia a criação do path
		$path = "/assets/" . $module;

		// verifica o tipo
		if($type == "css") {
			$path .= "/css";
		}
		elseif($type == "javascript") {
			$path .= "/js";
		}

		// continua com o restante
		$path .= "/" . $controller . "/" . $action;

		// verifica o tipo novamente para por a extensão
		if($type == "css") {
			$path .= ".css";
		}
		elseif($type == "javascript") {
			$path .= ".js";
		}

		// monta o caminho fisico do arquivo
		$pathFisico = APPLICATION_PATH . "/../public_html" . $path;

		// verifica se o arquivo existe
		$include = "";
		if(file_exists($pathFisico)) {
			
			// verifica se tem cache control
			$htmlCache = "";
			if(intval($core_cache) > 0) {
				$htmlCache = "?" . $core_cache;
			}

			// verifica o tipo novamente para criar o include
			if($type == "css") {
				$include = "<link href=\"" . $config['application']['basepath'] . $path . $htmlCache . "\" rel=\"stylesheet\" type=\"text/css\">";
			}
			elseif($type == "javascript") {
				$include = "<script src=\"" . $config['application']['basepath'] . $path . $htmlCache . "\"></script>";
			}
		}

		// retorna a url
		return $include;
	}
}
