<?php

namespace Application\Main\Controllers;

class indexController extends \Slim\Mvc\Controller
{

	public function indexAction()
	{
		
	}

	public function helloAction()
	{
		$this->view->variable1 = "Hello";
		$this->view->variable2 = "World";
	}
}