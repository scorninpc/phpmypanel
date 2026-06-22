<?php

namespace Application\Painel\Controllers;

/**
 * controlador que controla a execução de consultas de banco
 * 
 * isso aqui é porta aberta pro banco, se voce tem duvidas do que é e nao usa, remova esse arquivo todo
 */
class bancodedadosController extends \PHPMyPanel\Internal\Controller
{
	/**
	 * Armazena a sessão do usuario
	 * 
	 * @var \PHPMyPanel\Helpers\Sessions
	 */
	protected $login;

	/**
	 * Configura o controller
	 */
	public function configure()
	{
		$this->login = new \PHPMyPanel\Helpers\Sessions("login");
	}
	
	/**
	 * pagina de listagem dos tickets
	 */
	public function indexAction()
	{
		
		$query = $this->getParam("query", "");
		$exportar = $this->getParam("exportar", "0");

		// verifica se possui query
		if((strlen($query) > 0) && ($this->getRequest()->isPost())) {
			
			try {
				// recupera a conexão
				$capsule = new \Illuminate\Database\Capsule\Manager();

				$connection = $capsule->connection();
				$db = $connection->getPdo();
				
				// prepara a query e executa
				$execution = $db->prepare($query);
				$execution->execute();
				$result = $execution->fetchAll(\PDO::FETCH_ASSOC);

				// se nao for exportar
				if($exportar == "0") {
					// assina as variaveis
					$this->view->execution = $execution;
					$this->view->result = $result;
				}
				else {
					// abre um arquivo temporario
					$stream = fopen("php://temp", "w");
					foreach($result as $line) {
						// grava a linha
						fputcsv($stream, $line, ";", "\"", "");
					}
					rewind($stream);

					// joga o resultado no response e fecha
					$this->getResponse()->getResponse()->getBody()->write(stream_get_contents($stream));
					fclose($stream);

					// retorna o arquivo
					return $this->getResponse()->getResponse()
						->withHeader('Content-Type', 'text/csv; charset=utf-8')
						->withHeader('Content-Disposition', 'attachment; filename="result_' . date('Y-m-d_H-i-s') . '.csv"')
						->withHeader('Pragma', 'no-cache')
						->withHeader('Expires', '0');

				}
			}
			catch (\Exception $e) {
				$this->view->error = $e;
			}
		}
		
		$this->view->query = $query;
	}
}