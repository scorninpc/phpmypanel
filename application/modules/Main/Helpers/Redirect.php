<?php

namespace Application\Main\Helpers;

class Redirect
{
	/**
	 * do the redirect
	 */
	static public function go($url)
	{
		$config = \Slim\Mvc\Factory::get("config");

		// Verifica o http
		if(strpos($url, "http://") !== FALSE) {
			header("Location: " . $url);
			exit();
		}
		
		// Verifica o https
		if(strpos($url, "https://") !== FALSE) {
			header("Location: " . $url);
			exit();
		}
		
		// Verifica o basepath
		if(strpos($url, $config['application']['basepath']) !== FALSE) {
			header("Location: " . $url);
			exit();
		}

		// Verifica se possui barra no inicio da url
		if($url[0] == "/") {
			$url = substr($url, 1);
		}

		// Verifica se possui barra no final do basepath
		$basePath = $config['application']['basepath'];
		if(substr($basePath, -1) == "/") {
			unset($basePath[-1]);
		}

		header("Location: " . $basePath . "/" . $url);
		exit();
	}

	/**
	 * go to back
	 */
	static public function back()
	{
		Redirect::go($_SERVER['HTTP_REFERER']??"");
	}

}