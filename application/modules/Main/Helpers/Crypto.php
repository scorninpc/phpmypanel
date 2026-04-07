<?php

namespace Application\Main\Helpers;

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
	 * create a password hash
	 */
	public static function hash($string, $cost=7, $length=22)
	{
		// Salt
		$randomizer = new \Random\Randomizer();
		$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$salt = $randomizer->getBytesFromString($alphabet, $length);

		// Hash string
		$hashString = sprintf("\$2a\$%02d\$%s\$", $cost, $salt);
		
		// Retorna a chave criptografada
		return crypt($string, $hashString);
	}

}