<?php

namespace PHPMyPanel\Internal;

/**
 * Faz as tratativas do response custom do PHPMyPanel
 */
class Response
{
	/**
	 * Armazena o $view
	 * @var \PHPMyPanel\Internal\Smarty
	 */
	protected $view;

	/**
	 * Armazenna o request
	 * 
	 * @var \Psr\Http\Message\ResponseInterface
	 */
	protected $response;

	/**
	 * Construtor da classe
	 * 
	 * @param \Psr\Http\Message\ResponseInterface $response
	 */
	public function __construct(\Psr\Http\Message\ResponseInterface $response)
	{
		$this->response = $response;
	}

	/**
	 * Forma de setar o response fora do construtor
	 * 
	 * @param \Psr\Http\Message\ResponseInterface $response Response à setar
	 * 
	 * @return void
	 */
	public function setResponse(\Psr\Http\Message\ResponseInterface $response)
	{
		$this->response = $response;
	}

	/**
	 * Recupera o response original
	 * 
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getResponse(): \Psr\Http\Message\ResponseInterface
	{
		return $this->response;
	}
}