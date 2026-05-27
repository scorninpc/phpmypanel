<?php

namespace Application\Main\Controllers;

class errorController extends \PHPMyPanel\Internal\Controller
{
	/**
	 * pagina do erro
	 */
	public function errorAction()
	{
		$this->view->disableTemplate();

		// recupera os parametros
		$exception = $this->getParam("exception");
		$displayErrorDetails = $this->getParam("displayErrorDetails");
		$title = $this->getParam("title");
		$code = $this->getParam("code");

		// recupera o code
		if($exception->getCode() == 404) {
			$code = $exception->getCode();
		}
		else if($exception->getCode() > 0) {
			$code = $exception->getCode();
		}
		else {
			$code = 500;
		}

		// assina as variaveis
		$this->view->exception = $exception;
		$this->view->displayErrorDetails = $displayErrorDetails;
		$this->view->title = $title;
		$this->view->code = $code;
	}
}
