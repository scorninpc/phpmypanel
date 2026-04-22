<?php

namespace Application\Painel\Controllers;

use Application\Painel\Helpers;

/**
 * controlador para os usuarios
 */
class usuariosController extends \Application\Painel\Helpers\Controller
{
	/**
	 * configura o controller
	 */
	public function configure()
	{
		$this->model = new \Application\Painel\Models\Usuarios();
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
			$model = new \Application\Painel\Models\Usuarios();
			$user = $model->where("email", $email)->first();
			if(!$user) {
				\Application\Main\Helpers\Messages::error("User/Password not match");
				\Application\Main\Helpers\Redirect::back();
			}

			// verifica se a senha está correta
			$check = \Application\Painel\Helpers\Crypto::check($password, $user['password']);
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