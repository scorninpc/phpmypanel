<?php

namespace Application\Main\Helpers;

/**
 * algumas funções que facilitam o tratamento de strings
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
}