<?php

namespace Application\Painel\Controllers;

use Application\Painel\Helpers;

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
		$model = new \Application\Painel\Models\Users();
		
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
		$model = new \Application\Painel\Models\Users();
		
		// Fetch user
		$row =  $model->where("iduser", $iduser)->first();
		if(!$row) {
			throw new \Exception("Record not found");
		}

		// remove
		try {
			$model->where("iduser", $iduser)->delete();

			\Application\Main\Helpers\Messages::success("User deleted!");
		}
		catch(\Exception $e) {
			throw new \Exception("Cannot remove the record");
		}

		// return
		\Application\Main\Helpers\Redirect::go("/painel/users/index");
	}

	/**
	 * formulario do crud
	 */
	public function formAction()
	{
		$iduser = intval($this->getParam("iduser", 0));
		
		// Create the model
		$model = new \Application\Painel\Models\Users();

		// verify if this is a post request
		if($this->getRequest()->isPost()) {

			// 
			$data = [
				'email' => $this->getParam("email"),
				'password' => $this->getParam("password"),
			];

			// 
			if(strlen($data['password']) > 0) {
				$data['password'] = \Application\Main\Helpers\Crypto::hash($data['password']);
			}
			else {
				unset($data['password']);
			}

			// 
			try {
				if($iduser > 0) {
					$model->where("iduser", $iduser)->update($data);

					\Application\Main\Helpers\Messages::success("User updated!");
				}
				else {
					$model->insert($data);

					\Application\Main\Helpers\Messages::success("User inserted!");
				}
			}
			catch(\Exception $e) {
				throw new \Exception("Cannot complete the operation");
			}

			// return
			\Application\Main\Helpers\Redirect::go("/painel/users/index");
		}
		
		// verify if has a user
		if($iduser > 0) {
			// fetch user
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

		// verifica se tem dados no post
		if($this->getRequest()->isPost()) {

			// recupera os dados do form
			$email = strtolower($this->getParam("email", ""));
			$password = $this->getParam("password", "");

			// recupera o email do banco
			$model = new \Application\Painel\Models\Users();
			$user = $model->where("email", $email)->first();
			if(!$user) {
				\Application\Main\Helpers\Messages::error("User/Password not match");
				\Application\Main\Helpers\Redirect::back();
			}

			// verifica se a senha está correta
			$check = \Application\Main\Helpers\Crypto::check($password, $user['password']);
			if(!$check) {
				\Application\Main\Helpers\Messages::error("User/Password not match");
				\Application\Main\Helpers\Redirect::back();
			}

			// efetuou o login ok
			$session = new \Application\Main\Helpers\Sessions("login");
			$session->iduser = $user['iduser'];
			$session->email = $user['email'];

			// 
			\Application\Main\Helpers\Messages::success("Welcome back!");

			// redireciona de volta
			\Application\Main\Helpers\Redirect::back();
		}
	}

	/**
	 * efetua o logoff
	 */
	public function logoutAction()
	{
		$session = new \Application\Main\Helpers\Sessions("login");
		$session->destroy();

		// redireciona de volta
		\Application\Main\Helpers\Redirect::back();
	}
}