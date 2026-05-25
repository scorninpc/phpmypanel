<?php

namespace Application\Main\Helpers;

/**
 * Classe de abstração do \Slim\Interfaces\ErrorRendererInterface
 * 
 * Extende \Slim\Interfaces\ErrorRendererInterface para fornecer um html personalizado para telas de erro
 */
final class HtmlErrorRenderer implements \Slim\Interfaces\ErrorRendererInterface
{
	/**
	 * Invoca a chamada ao erro
	 * 
	 * @param Throwable $exception Exception disparado
	 * @param bool $displayErrorDetails Informa se deve mostrar os detalhes do erro 
	 * 
	 * @return string
	 */
	public function __invoke(\Throwable $exception, bool $displayErrorDetails): string
	{
		// verifica qual o tipo de erro
		if($exception instanceof \Slim\Exception\HttpNotFoundException) {
			$title = "Page not found";
			$code = 404;
		} 
		else {
			$title = "Internal server error";
			$code = 500;
		}

		// mensagem do exception
		$message = $exception->getMessage();
		
		// verifica se tem request para forçar qual controller chamar
		$request = \Slim\Mvc\Factory::get("request");
		if(!$request) {
			die("sem request");
		}
		$request->setParam("module", "main");
		$request->setParam("controller", "error");
		$request->setParam("action", "error");
		$request->setParam("exception", $exception);
		$request->setParam("displayErrorDetails", $displayErrorDetails);
		$request->setParam("title", $title);

		// recupera o body do html
		$application = \Slim\Mvc\Factory::get("application");
		$return = $application->run();

		// retorna o html
		return strval($return->getBody());
	}
}