<?php

namespace Application\Main\Helpers\View;

/**
 * View Helper que cria a url da imagem para criação de thumbs.
 */
class ImageUrl
{
	protected $config;

	/**
	 * Construtor do helper

	 * @param mixed $config
	 */
	public function __construct($config) 
	{
		// recupera o request do app
		$app = \PHPMyPanel\Internal\Application::getInstance();

		// recupera a configuração
		$this->config = $app->getConfig();
	}

	/**
	 * Faz a chamada do helper
	 * 
	 * @param string $tipo Nome da pasta onde a imagem está salva
	 * @param integer $crop Tipo do crop a ser utilizado
	 * @param integer $largura largura final da imagem
	 * @param integer $altura altura final da imagem
	 * @param string $imagem Nome da imagem dentro da pasta
	 * @param string $titulo Titulo da imagem
	 * 
	 * @return string
	 */
	public function call($tipo, $crop, $largura, $altura, $imagem, $titulo)
	{
		// separa o nome da extensao
		$tmp = explode(".", $imagem);
		
		// recupera o base path
		$basePath = $this->config['application']['basepath'];
		
		// cria o slug do titulo
		$titulo = \Application\Main\Helpers\Strings::slug($titulo);
		
		// cria a URL
		$url = $basePath . "/images/" . $tipo . "/" . $crop . "/" . $largura . "/" . $altura . "/" . $tmp[0] . "/" . $titulo . "." . $tmp[1];
		
		// retorna a url final da imagem
		return $url;
	}
}
