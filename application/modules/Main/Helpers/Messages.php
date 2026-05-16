<?php

namespace Application\Main\Helpers;

/**
 * Classe que trata mensagens de alerta do sistema
 * 
 * Responsável por armazenar mensagens de feedback no sistema, que serão exibidas
 * ao usuário na próxima atualização da página. As mensagens são salvas na sessão
 * e exibidas como toasts, sendo removidas da sessão após a exibição.
 */
class Messages
{
	/**
	 * Sessão que armazena as mensagens.
	 * 
	 * @var \Application\Main\Helpers\Sessions
	 */
	private static $_messages;
	
	/**
	 * Informa se está inicializado
	 *
	 * @var bool
	 */
	private static $initialized = FALSE;

	/**
	 * Inicializa a classe garantindo que a instância seja criada apenas uma vez.
	 * 
	 * Configura a propriedade $_messages para armazenar mensagens na sessão.
	 * 
	 * @return void
	 */
	private static function initialize():void
	{
		if (self::$initialized) {
			return;
		}

		self::$_messages = new Sessions("messages");
		self::$initialized = TRUE;
	}

	/**
	 * Adiciona uma mensagem de sucesso na sessão.
	 * 
	 * Inicializa a sessão automaticamente se necessário e define a mensagem de sucesso para exibição futura.
	 * 
	 * @example
	 *
	 * ```php
	 * \Application\Main\Helpers\Messages::success("Registro inserido com sucesso");
	 * ```
	 * 
	 * @param string $message Mensagem de sucesso a ser armazenada.
	 * 
	 * @return void
	 */
	static public function success(string $message):void
	{
		self::initialize();
		
		// adiciona mensagens de sucesso
		$success = self::$_messages->success;
		if(!is_array($success)) {
			$success = [];
		}
		$success[] = $message;
		self::$_messages->success = $success;
	}

	/**
	 * Adiciona uma mensagem de erro na sessão.
	 * 
	 * Inicializa a sessão automaticamente se necessário e define a mensagem de erro para exibição futura.
	 * 
	 * @example
	 * ```php
	 * \Application\Main\Helpers\Messages::error("Erro ao inserir o registro");
	 * ```
	 *
	 * @param string $message Mensagem de erro a ser armazenada.
	 * 
	 * @return void
	 */
	public static function error(string $message):void
	{
		self::initialize();

		// adiciona mensagens de erro
		$error = self::$_messages->error;
		if(!is_array($error)) {
			$error = [];
		}
		$error[] = $message;
		self::$_messages->error = $error;
	}

	/**
	 * Adiciona uma mensagem de alerta na sessão.
	 * 
	 * Inicializa a sessão automaticamente se necessário e define a mensagem de alerta para exibição futura.
	 * 
	 * @example
	 * ```php
	 * \Application\Main\Helpers\Messages::alert("Houve um erro ao enviar uma foto, verifique");
	 * ```
	 *
	 * @param string $message Mensagem de alerta a ser armazenada.
	 * 
	 * @return void
	 */
	static public function alert(string $message):void
	{
		self::initialize();

		// adiciona mensagens de alerta
		$alert = self::$_messages->alert;
		if(!is_array($alert)) {
			$alert = [];
		}
		$alert[] = $message;
		self::$_messages->alert = $alert;
	}
	
	/**
	 * Adiciona uma mensagem de informação na sessão.
	 * 
	 * Inicializa a sessão automaticamente se necessário e define a mensagem de informação para exibição futura.
	 * 
	 * @example
	 * ```php
	 * \Application\Main\Helpers\Messages::info("Um novo usuário efetuou o login");
	 * ```
	 *
	 * @param string $message Mensagem de informação a ser armazenada.
	 * 
	 * @return void
	 */
	static public function info(string $message):void
	{
		self::initialize();
		
		// adiciona mensagens de informação
		$info = self::$_messages->info;
		if(!is_array($info)) {
			$info = [];
		}
		$info[] = $message;
		self::$_messages->info = $info;
	}

	/**
	 * Recupera as mensagens da sessão.
	 * 
	 * Recupera a sessão onde estão armazenadas as mensagens
	 * 
	 * @example
	 * ```php
	 * $sessao = \Application\Main\Helpers\Messages::getMessages();
	 * d($sessao->success);
	 * d($sessao->error);
	 * d($sessao->alert);
	 * d($sessao->info);
	 * ```
	 *
	 * @return \Application\Main\Helpers\Sessions
	 */
	static public function getMessages():\Application\Main\Helpers\Sessions
	{
		self::initialize();
		
		// retorna as mensagens
		return self::$_messages;
	}

	/**
	 * Limpa as mensagens da sessão.
	 * 
	 * Após exibir na tela, não faz sentido mante-las na sessão
	 *
	 * @return \Application\Main\Helpers\Sessions
	 */
	static public function clearMessages():void
	{
		self::initialize();
		
		// limpa a sessão
		self::$_messages->destroy();
	}

}