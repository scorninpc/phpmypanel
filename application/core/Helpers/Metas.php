<?php

namespace PHPMyPanel\Helpers;

/**
 * Classe que salva as metas HTML
 * 
 * Ela armazena o titulo, description e outras coisas. O view chama essa classe, que verifica se o $type existe, caso contrario
 * tenta recuperar do arquivo metas.php
 */
class Metas
{
	static $instance;

	/**
	 * Armazena as metas
	 * 
	 * @var array
	 */
	public array $meta;

	/**
	 * Armazena o request
	 * @var \PHPMyPanel\Internal\Request
	 */
	public $request;

	/**
	 * Armazena as metas do arquivo
	 * 
	 * @var array
	 */
	public array $fileMetas;

	/**
	 * construtor
	 */
	public function __construct()
	{ }

	/**
	 * Single instance, para garantir que só tem uma instancia criada
	 * 
	 * @return Metas
	 */
	static public function getInstance()
	{
		if(!self::$instance) {
			self::$instance = new self();

			// recupera o request do app
			$app = \PHPMyPanel\Internal\Application::getInstance();
			self::$instance->request = $app->getRequest();
			
			// le o arquivo de metas na primeira vez que instanciou, caso exista
			if(file_exists(APPLICATION_PATH . "/configs/metas.php")) {
				self::$instance->fileMetas = require APPLICATION_PATH . "/configs/metas.php";
			}
		}

		return self::$instance;
	}

	/**
	 * Seta a meta, a tag, ou o titulo, qualquer coisa
	 * 
	 * @param string $type
	 * @param string $value
	 * 
	 * @return void
	 */
	static public function setMeta(string $type, string $value)
	{
		$instance = self::getInstance();

		$instance->meta[$type] = $value;
	}

	/**
	 * Recupera a meta, tag ou titulo, só o conteudo, sem a tag em si
	 * 
	 * @param string $type
	 */
	static public function getMeta($type): string
	{
		$instance = self::getInstance();

		// se a meta setada não existir
		if(!isset($instance->meta[$type])) {

			// recupera o modulo, controlador e o action atual
			$module = $instance->request->getParam("module");
			$controller = $instance->request->getParam("controller");
			$action = $instance->request->getParam("action");

			// verifica se a meta existe no arquivo
			if(!isset($instance->fileMetas[$module][$controller][$action][$type])) {

				// se ainda assim não existir, verifica se o modulo possui defaults
				if(!isset($instance->fileMetas[$module]['defaults'][$type])) {
					return "";
				}

				// retorna o defaults
				return $instance->fileMetas[$module]['defaults'][$type];
			}

			// retorna a meta do arquivo
			return $instance->fileMetas[$module][$controller][$action][$type];
		}

		// retorna a meta setada
		return $instance->meta[$type];
	}

}