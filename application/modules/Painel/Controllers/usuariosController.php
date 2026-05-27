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
	 * hook antes da atualização
	 */
	public function doBeforeUpdate($data)
	{
		// se a senha for vazia, remove o campo
		if(strlen($data['password']?:"") == 0) {
			unset($data['password']);
		}

		return $data;
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
				\PHPMyPanel\Helpers\Messages::error("Usuário/senha não conferem");
				\PHPMyPanel\Helpers\Redirect::back();
			}

			// verifica se a senha está correta
			$check = \Application\Painel\Helpers\Crypto::check($password, $user['password']);
			if(!$check) {
				\PHPMyPanel\Helpers\Messages::error("Usuário/senha não conferem");
				\PHPMyPanel\Helpers\Redirect::back();
			}

			// efetuou o login ok
			$session = new \PHPMyPanel\Helpers\Sessions("login");
			$session->nome = $user['nome'];
			$session->idusuario = $user['idusuario'];
			$session->email = $user['email'];

			// seta a mensagem
			\PHPMyPanel\Helpers\Messages::success("Welcome back!");

			// redireciona de volta
			\PHPMyPanel\Helpers\Redirect::back();
		}
	}

	/**
	 * efetua o logoff
	 */
	public function logoutAction()
	{
		$session = new \PHPMyPanel\Helpers\Sessions("login");
		$session->destroy();

		// redireciona de volta
		\PHPMyPanel\Helpers\Redirect::back();
	}
}
