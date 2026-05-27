<?php

namespace PHPMyPanel\Helpers;

/**
 * Algumas funções que facilitam o tratamento de strings
 */
class Strings
{	
	/**
	 * sprintf por marcado
	 * 
	 * %(name)s - string no marcador name
	 * %(age)02d - integer 02 no marcador age
	 */
	static public function vsprintf_named($format, $args) 
	{
		return preg_replace_callback('/%\((.*?)\)s/', function ($matches) use ($args) {
			return isset($args[$matches[1]]) ? $args[$matches[1]] : "";
		}, $format);
	}

	/**
	 * Converte strings para slugs utilizados em links
	 * 
	 * @param string $string String a ser slugfyed
	 * @param boolean $tolower Informa se deve deixar tudo minusculo
	 * 
	 * @return string
	 */
	static public function slug($string, $tolower=TRUE):string
	{
		// remove os espaços das bordas
		$string = rtrim(ltrim($string));
	
		// decodifica o html entities
		$string = html_entity_decode($string, ENT_QUOTES, "UTF-8");
	
		// troca os caracteres especiais
		$trans = array('ç' => "c",'á' => "a",'â' => "a",'à' => "a",'ã' => "a",'é' => "e",'ê' => "e",'è' => "e",'ẽ' => "e",'í' => "i",'î' => "i",'ì' => "i",'ĩ' => "i",'ó' => "o",'ô' => "o",'ò' => "o",'õ' => "o",'ú' => "u",'û' => "u",'ù' => "u",'ũ' => "u",);
		if($tolower) {
			// diminui o tamanho da letra
			$string = mb_strtolower($string, "UTF-8");
		}
		else {
			// caso contrario converte para letras simples
			$trans = array_merge($trans, ['Ç' => "C",'Á' => "A",'Â' => "A",'À' => "A",'Ã' => "A",'É' => "E",'Ê' => "E",'È' => "E",'Ẽ' => "E",'Í' => "I",'Î' => "I",'Ì' => "I",'Ĩ' => "I",'Ó' => "O",'Ô' => "O",'Ò' => "O",'Õ' => "O",'Ú' => "U",'Û' => "U",'Ù' => "U",'Ũ' => "U"]);
		}

		// faz a troca
		$string = strtr($string, $trans);
	
		// trocar o que não é especial
		$string = preg_replace("@[^a-zA-Z0-9\_\.]@", "-", $string);
	
		// troca varios espacos por 1 só
		$string = preg_replace("/__+/", "-", $string);
	
		// troca varios espacos por 1 só
		$string = str_replace("--", "-", str_replace("--", "-", str_replace("--", "-", $string)));
	
		// remove os "-" da direita
		$string = rtrim($string, "-");
	
		// retorna o texto
		return $string;
	}
}