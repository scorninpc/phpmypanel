<?php

namespace Application\Main\Helpers;

class Messages
{
	// armazena as mensagens
	private static $_messages;
	
	// informa se está inicializado
	private static $initialized = FALSE;

	/**
	 * inicializa a classe estatica
	 */
	private static function initialize()
	{
		if (self::$initialized) {
			return;
		}

		self::$_messages = new Sessions("messages");
		self::$initialized = TRUE;
	}

	/**
	 * adiciona mensagens de sucesso na sessão
	 */
	static public function success($message)
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
	 * adiciona mensagens de erro na sessão
	 */
	public static function error($message)
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
	 * adiciona mensagens de alerta na sessão
	 */
	static public function alert($message)
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
	 * adiciona mensagens de informação na sessão
	 */
	static public function info($message)
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
	 * recupera as mensagens
	 */
	static public function getMessages()
	{
		self::initialize();
		
		// retorna as mensagens
		return self::$_messages;
	}

	/**
	 * limpa as mensagens
	 */
	static public function clearMessages()
	{
		self::initialize();
		
		// limpa a sessão
		self::$_messages->destroy();
	}

}