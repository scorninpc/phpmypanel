<?php

namespace PHPMyPanel\Helpers\View;

/**
 * View helper que cria as metas e titulos
 */
class Meta
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
	{ }

	/**
	 * Faz a chamada
	 * 
	 * @param string $type
	 * @param bool $content
	 * 
	 * @return string
	 */
	public function call(string $type, bool $content=FALSE): string
	{
		// recupera a meta
		$meta = \PHPMyPanel\Helpers\Metas::getMeta($type);

		// se a meta for vazia
		if($meta == "") {
			return "";
		}

		// troca algumas palavras chave
		$url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$meta = str_replace("__SELF_URL__", $url, $meta);

		// se for title
		if($type == "title") {
			return "<title>" . htmlentities($meta) . "</title>";
		}

		// se tiver ":", pode ser OG ou ARTICLE por exemplo, ai é property
		if(strpos("g:", $type) !== FALSE) {
			return "meta property=\"" . $type . " content=\"" . htmlentities($meta) . "\">";
		}

		// se nao tag normal
		return "<meta name=\"" . htmlentities($type) . "\" content=\"" . htmlentities($meta) . "\" />";
	}
}