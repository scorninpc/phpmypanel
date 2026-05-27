<?php

namespace PHPMyPanel\Helpers\View;

/**
 * View Helper para criar slugs non view
 */
class Slug
{
	protected $config;
	protected $request;

	public function __construct($config) 
	{
		$this->config = $config;
	}

	/**
	 * Faz a chamada ao helper
	 * 
	 * @param mixed $string Texto a ser slugfyed
	 * @return string
	 */
	public function call(string $string): string
	{	
		$string = htmlentities($string);
		
		$string = \PHPMyPanel\Helpers\Strings::slug($string);

		return $string;
	}
}