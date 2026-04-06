<?php

namespace Application\Main\Controllers;

class crudController extends \Slim\Mvc\Controller
{

	public function listAction()
	{
		// Create the model
		$model = new \Application\Main\Models\Test();
		
		// Fetch tests
		$tests =  $model->get();

		// Assign variables
		$this->view->tests = $tests;
	}

	public function recordAction()
	{
		// Create the model
		$model = new \Application\Main\Models\Test();
		
		// Insert an record
		// $idtest = $model->insert([
		// 	'text_field' => "Text Field",
		// 	'varchar_field' => "Varchar Field",
		// ]);

		// Fetch tests
		$tests =  $model->get();

		// Assign variables
		$this->view->tests = $tests;
	}
}