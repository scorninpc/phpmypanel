<?php

namespace Application\Painel\Controllers;

class indexController extends \Application\Painel\Helpers\Controller
{
	public function indexAction()
	{ }

	public function autocompleteAction()
	{
		$this->view->disableTemplate();

		return $this->json([
			['id' => 2, 'label' => "oie 2"],
			['id' => 3, 'label' => "oie 3"],
			['id' => 4, 'label' => "oie 4"],
			['id' => 5, 'label' => "oie 5"],
		]);
	}
}
