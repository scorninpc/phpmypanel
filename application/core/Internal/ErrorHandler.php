<?php

namespace PHPMyPanel\Internal;

/**
 * Classe de tratamento de erros, faz o renderer e o log
 */
final class ErrorHandler implements \Slim\Interfaces\ErrorHandlerInterface
{
	/**
	 * Invoca a chamada ao erro
	 * 
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails): \Psr\Http\Message\ResponseInterface
	{
		// recupera o view e o config
		$app = \PHPMyPanel\Internal\Application::getInstance();
		$view = $app->getView();
		$config = $app->getConfig();
		$response = $app->getResponse()->getResponse();

		// verifica qual o tipo de erro
		if($exception instanceof \Slim\Exception\HttpNotFoundException) {
			$title = "Page not found";
			$code = 404;
		} 
		else {
			$title = "Internal server error";
			$code = 500;
		}

		// grava o log caso precisar
		if($config['application']['log_errors']) {
			if((($config['application']['log_404']) && ($code == 404)) || ($code != 404)) {

			d($exception);
				// grava o log
				\PHPMyPanel\Helpers\Logger::log($exception);
			}
		}

		// assina as variaveis
		$view->exception = $exception;
		$view->displayErrorDetails = $displayErrorDetails;
		$view->title = $title;
		$view->code = $code;
		$view->basePath = $config['application']['basepath'];
		$view->baseDomain = $config['application']['basedomain'];
		
		// recupera o html e retorna o response
		$response->getBody()->write($view->fetch($config['application']['error_file']));
		return $response;
	}
}