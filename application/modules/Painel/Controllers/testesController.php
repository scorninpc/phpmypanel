<?php

namespace Application\Painel\Controllers;

use Application\Painel\Helpers;

/**
 * controlador de teste do painel
 * 
 */
class testesController extends \Application\Painel\Helpers\Controller
{

	/**
	 * configura o controller
	 */
	public function configure()
	{
		$this->model = new \Application\Painel\Models\Testes();
	}

	/**
	 * hook antes a listagem
	 */
	public function doBeforeList($select) { return $select; }
	
	/**
	 * hook depois de inserir
	 */
	public function doAfterInsert($id) {}

	/**
	 * hook antes de inserir
	 */
	public function doBeforeInsert($data) { return $data; }

	/**
	 * hook depois de atualizar
	 */
	public function doAfterUpdate($id) {}

	/**
	 * hook antes de atualizar
	 */
	public function doBeforeUpdate($data) { return $data; }
	
	/**
	 * hook depois de deletar
	 */
	public function doAfterDelete($id) {}
	
	/**
	 * hook antes de deletar
	 */
	public function dobeforeDelete($id) {}
	
	/**
	 * hook depois de montar o formulário
	 */
	public function doAfterForm() { }

	/**
	 * hook antes de montar o formulário
	 */
	public function doBeforeForm() { }

}
