<?php

namespace Application\Painel\Controllers;

use Application\Painel\Helpers;

/**
 * controlador das funcionalidades do painel
 * 
 */
class funcionalidadesController extends \Application\Painel\Helpers\Controller
{

	/**
	 * configura o controller
	 */
	public function configure()
	{
		$this->model = new \Application\Painel\Models\Funcionalidades();
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
	public function fsormAction()
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

}