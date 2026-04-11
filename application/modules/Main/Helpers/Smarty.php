<?php

namespace Application\Main\Helpers;

/**
 * 
 */
class Smarty extends \Slim\Views\Smarty 
{
	/**
	 * 
	 */
	public function __construct($options = [])
	{
		parent::__construct($options);

		// smarty removeu o uso das funções nativas, tambem não acho interessante habilitar tudo, porem algumas sao de grande ajuda
		// então aqui a gente habilita ele
		$natives = [
			"strtoupper", "strtolower", "str_replace", "ucfirst", "ucwords", "sprintf", "lcfirst", "ltrim", "rtrim", "trim",
			"nl2br",
			"stripos", "strpos", "strlen", 
			"explode", "implode", "count",
			"number_format", "intval", "floatval", "is_numeric", 
			"strtotime", "date",
			"urlencode", "urldecode",
			"var_dump",
			"base64_encode", "base64_decode", "rand",
			"json_encode", "json_decode",
		];
		foreach($natives as $native) {
			parent::registerPlugin("modifier", $native, $native);
		}
	}
}