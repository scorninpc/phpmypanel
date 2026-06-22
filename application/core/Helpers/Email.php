<?php

namespace PHPMyPanel\Helpers;

/**
 * Classe de email de emails
 * 
 * Extende \Symfony\Component\Mime\Email para fornecer um nome de classe mais curto,
 * facilitar o uso em uma unica classe que ja le o arquivo de configuração de como enviar,
 * e adicionar funcionalidades e validações em um só lugar
 */
class Email extends \Symfony\Component\Mime\Email
{
	/**
	 * Armazena as configurações
	 * 
	 * @var array
	 */
	protected $config;

	/**
	 * Armazena o html
	 * 
	 * @var string
	 */
	protected $html;

	/**
	 * construtor da classe
	 */
	public function __construct(\Symfony\Component\Mime\Header\Headers|null $headers = null, \Symfony\Component\Mime\Part\AbstractPart|null $body = null)
	{
		// recupera o request do app
		$app = \PHPMyPanel\Internal\Application::getInstance();

		// recupera a configuração
		$this->config = $app->getConfig();

		// chama o construtor do parente
		parent::__construct($headers, $body);

		// seta o from do config
		parent::from(new \Symfony\Component\Mime\Address($this->config['email']['sender']['email'], $this->config['email']['sender']['name']));
	}

	/**
	 * Seta o template smarty como body
	 * 
	 * @param string $filename
	 * @param array $vars
	 * 
	 * @return \PHPMyPanel\Helpers\Email
	 */
	public function setTemplate(string $filename, array $vars): \PHPMyPanel\Helpers\Email
	{
		// adiciona o basePath e baseDomain
		$vars['basePath'] = $this->config['application']['basepath'];
		$vars['baseDomain'] = $this->config['application']['basedomain'];

		// faz o parse do tpl
		$smarty = new \PHPMyPanel\Internal\Smarty($this->config['smarty']);
		$html = $smarty->fetch($filename, $vars);

		// seta o html no email
		$this->setHtml($html);

		// retorna o proprio
		return $this;
	}

	/**
	 * Abstrai a função do parent para facilitar o envio de nome
	 * @param \Symfony\Component\Mime\Address|string $addresses
	 * 
	 * @return Email
	 */
	public function to(\Symfony\Component\Mime\Address|string ...$addresses): static
	{
		// se passou 2 parametros e os 2 são string, é o que eu quero
		if((count($addresses) === 2) && (is_string($addresses[0])) && (is_string($addresses[1]))) {
            
			$email = $addresses[0];
            $nome = $addresses[1];
            
            // monta o endereço
            return parent::to(new \Symfony\Component\Mime\Address($email, $nome));
        }

		// se nao só chama o parent e boa
		parent::to(...$addresses);
		return $this;
	}

	/**
	 * seta o html ao body e armazena
	 * 
	 * @param string $html
	 * @return Email
	 */
	public function setHtml(string $html): \PHPMyPanel\Helpers\Email
	{
		$this->html = $html;

		// seta o html no email
		parent::html($html);
		
		// retorna o proprio
		return $this;
	}

	/**
	 * envia o email
	 */
	public function send()
	{
		// configura o transporte e o mailer a partir do arquivo de configuração
		$transport = \Symfony\Component\Mailer\Transport::fromDsn($this->config['email']['dsn']);
    	$mailer = new \Symfony\Component\Mailer\Mailer($transport);

		// envia o email
		$mailer->send($this);
	}

	/**
	 * exibe o email
	 */
	public function show()
	{
		die($this->html);
	}
}