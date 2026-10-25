<?php

namespace PHPMyPanel\Helpers;

/**
 * Faz os logs de erros no arquivo
 */
class Logger
{
	/**
	 * construtor
	 */
	private function __construct()
	{ }

	/**
	 * Grava o exception no arquivo
	 * 
	 * @param \Exception $exception
	 */
	static public function log(\Exception $exception)
	{
		// recupera os dados da aplicação
		$app = \PHPMyPanel\Internal\Application::getInstance();
		$request = $app->getRequest();

		// inicia a saida do buffer para log
		ob_start();

		// horario
		echo date("d/m/Y H:i:s") . "\n\n";

		// mensagem
		echo $exception->getCode() . ": " . $exception->getMessage() . "\n\n";

		// urls
		echo "Url: " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on" ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\n";
		echo "Referer: " . ((isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "--")) . "\n\n";

		// o trace do exception
		echo "TRACE:\n";
		echo $exception->getTraceAsString();
		echo "\n\n";

		// dados do post
		echo "POST:\n";
		var_dump($_POST);
		echo "\n\n";

		// dados do get
		echo "GET:\n";
		var_dump($_GET);
		echo "\n\n";

		// dados do raw
		echo "RAW:\n";
		var_dump((string)$request->getRequest()->getBody());
		echo "\n\n";

		// dados do arquivo
		echo "FILE:\n";
		var_dump($_FILES);
		echo "\n\n";

		// dados da sessao
		echo "SESSION:\n";
		var_dump($_SESSION);
		echo "\n\n";

		// dados de cookies
		echo "COOKIE:\n";
		var_dump($_COOKIE);
		echo "\n\n";

		// dados do server
		echo "SERVER:\n";
		var_dump($_SERVER);
		echo "\n\n";

		

		// recupera os dados do buffer
		$c = ob_get_contents();
		ob_end_clean();

		// salva o arquivo
		file_put_contents(APPLICATION_PATH . "/tmp/logs/errors/" . time() . "-" . rand(100000, 999999) . ".txt", $c);

	}
}