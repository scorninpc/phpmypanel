<?php

namespace Application\Main\Controllers;

use Application\Main\Helpers;
use Symfony\Component\Console\Helper\Helper;

/**
 * controller for users
 * 
 * create table users (iduser integer not null primary key AUTOINCREMENT, email varchar(250), password varchar(250));
 * 
 */
class usersController extends \Slim\Mvc\Controller
{

	/**
	 * faz a listagem dos registros
	 */
	public function indexAction()
	{
		// Create the model
		$model = new \Application\Main\Models\Users();
		
		// Fetch user
		$rows =  $model->get();

		// Assign variables
		$this->view->rows = $rows;
	}

	/**
	 * remove um registro
	 */
	public function deleteAction()
	{
		$iduser = intval($this->getParam("iduser", 0));

		// Create the model
		$model = new \Application\Main\Models\Users();
		
		// Fetch user
		$row =  $model->where("iduser", $iduser)->first();
		if(!$row) {
			throw new \Exception("Record not found");
		}

		// remove
		try {
			$model->where("iduser", $iduser)->delete();
		}
		catch(\Exception $e) {
			throw new \Exception("Cannot remove the record");
		}

		// return
		Helpers\Redirect::go("/main/users/index");
	}

	/**
	 * formulario do crud
	 */
	public function formAction()
	{
		$iduser = intval($this->getParam("iduser", 0));
		
		// Create the model
		$model = new \Application\Main\Models\Users();

		// verify if this is a post request
		if($this->getRequest()->isPost()) {

			// 
			$data = [
				'email' => $this->getParam("email"),
				'password' => $this->getParam("password"),
			];

			// 
			if(strlen($data['password']) > 0) {
				$data['password'] = Helpers\Crypto::hash($data['password']);
			}
			else {
				unset($data['password']);
			}

			// 
			try {
				if($iduser > 0) {
					$model->where("iduser", $iduser)->update($data);
				}
				else {
					$model->insert($data);
				}
			}
			catch(\Exception $e) {
				throw new \Exception("Cannot complete the operation");
			}

			// return
			Helpers\Redirect::go("/main/users/index");
		}
		
		// verify if has a user
		if($iduser > 0) {
			// Fetch user
			$row =  $model->where("iduser", $iduser)->first();
			if(!$row) {
				throw new \Exception("Record not found");
			}

			// Assign variables
			$this->view->row = $row;
		}
	}

	/**
	 * efetua o login
	 */
	public function loginAction()
	{
		// desabilita o template
		$this->view->disableTemplate();
	}
}