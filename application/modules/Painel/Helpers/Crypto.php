<?php

namespace Application\Painel\Helpers;

class Crypto
{
	/**
	 * check the password
	 */
	public static function check($string, $hash)
	{
		return (crypt($string, $hash) === $hash);
	}
	
	/**
	 * cria a hash de senha
	 */
	public static function hash($string, $cost=7, $length=22)
	{
		$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$salt = "";

		// PHP 8.2+ existe random\randomizer
		if(class_exists('Random\Randomizer')) {
			// salt
			$randomizer = new \Random\Randomizer();
			$salt = $randomizer->getBytesFromString($alphabet, $length);
		}
		else {
			// PHP 8.2- não existe random\randomizer
			$maxIndex = strlen($alphabet) - 1;
    		for($i=0; $i<$length; $i++) {
				$salt .= $alphabet[random_int(0, $maxIndex)];
			}
		}

		// hash string
		$hashString = sprintf("\$2a\$%02d\$%s\$", $cost, $salt);
		
		// retorna a chave criptografada
		return crypt($string, $hashString);
	}

	/**
	 * Criptografa textos
	 * 
	 * @param string $metodo
	 * @param string $chave
	 * @param string $conteudo
	 * @return string
	 */
	static function criptografar($metodo, $chave, $conteudo): string
	{
		$ivlen = openssl_cipher_iv_length($metodo);
		$iv = openssl_random_pseudo_bytes($ivlen);
		$conteudo_criptografado = openssl_encrypt($conteudo, $metodo, $chave, 0, $iv);
		
		// retorna o conteudo criptografado
		return $iv . '::' . $conteudo_criptografado;
	}

	/**
	 * Descriptografa textos
	 * 
	 * @param string $metodo
	 * @param string $chave
	 * @param string $conteudo_criptografado
	 */
	static function descriptografar(string $metodo, string $chave, string $conteudo_criptografado): string
	{
		list($iv, $conteudo) = explode('::', $conteudo_criptografado, 2);
		$conteudo = openssl_decrypt($conteudo, $metodo, $chave, 0, $iv);

		return $conteudo;
	}

}
