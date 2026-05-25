<?php

namespace PHPMyPanel\Internal;

/**
 * Classe de abstração do Smarty para renderizar os templates do Slim
 *
 * @link http://www.smarty.net/
 */
class Smarty
{
	/**
	 * Instancia Smarty
	 *
	 * @var \Smarty\Smarty
	 */
	protected $smarty;

	/**
	 * Variaveis do template
	 *
	 * @var array
	 */
	protected $defaultVariables = [];

	/**
	 * Caminho do arquivo tpl de template
	 * @var string
	 */
	protected $template_file;

	/**
	 * Caminho do arquivo tpl do conteudo
	 * @var string
	 */
	protected $content_file;

	/**
	 * Informa se deve desabilitar o template e exibir somente o content
	 * 
	 * @var bool
	 */
	protected $template_disabled = FALSE;

	/**
	 * Construtor da classe
	 */
	public function __construct(array $options = [])
	{
		// cria o objeto Smarty e configura
		$this->smarty = new \Smarty\Smarty();

		$this->smarty->setForceCompile($options['force_compile']);
		$this->smarty->setDebugging($options['debugging']);

		if($options['compile_check']) {
			$this->smarty->setCompileCheck(\Smarty\Smarty::COMPILECHECK_ON);
		}
		else {
			$this->smarty->setCompileCheck(\Smarty\Smarty::COMPILECHECK_OFF);
		}
		
		$this->smarty->setCacheDir($options['cache_dir']);
		$this->smarty->setCaching($options['caching']);
		$this->smarty->setCacheLifetime($options['cache_lifetime']);

		

		$this->smarty->setTemplateDir($options['template_dir'][0]);
		$this->smarty->setCompileDir($options['compile_dir']);

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
			$this->smarty->registerPlugin("modifier", $native, $native);
		}
	}

	/**
	 * Informa se deve desabilitar o template e mostrar somente o content
	 * 
	 * @return void
	 */
	public function disableTemplate()
	{
		$this->template_disabled = TRUE;
	}

	/**
	 * Recupera caminho do template
	 * 
	 * @return string
	 */
	public function getTemplateFile(): string
	{
		return $this->template_file;
	}

	/**
	 * Seta caminho do template
	 * 
	 * @param string $template Caminho do arquivo tpl de template
	 * 
	 * @return void
	 */
	public function setTemplateFile(string $template)
	{
		$this->template_file = $template;
	}

	/**
	 * Recupera caminho do conteudo
	 * 
	 * @return string
	 */
	public function getContentFile(): string
	{
		return $this->content_file;
	}

	/**
	 * Seta caminho do conteudo
	 * 
	 * @param string $content Caminho do arquivo tpl de conteudo
	 * 
	 * @return void
	 */
	public function setContentFile(string $content)
	{
		$this->content_file = $content;
	}

	/**
	 * Processa todo o view, template, content, coloca um dentro do outro, assina as variaveis, etc
	 * 
	 * @param \PHPMyPanel\Internal\Response $response Response que será populado
	 * 
	 * @return  \PHPMyPanel\Internal\Response
	 */
	public function process(\PHPMyPanel\Internal\Response $response):  \PHPMyPanel\Internal\Response
	{
		// se o templete estiver  desativado
		if($this->template_disabled) {
			// a gente seta o contentfile como principal
			$template = $this->getContentFile();
		}
		else {
			// caso contrario, a gente seta o content na variavel layout_content para ser incluso no template.tpl
			$this->defaultVariables['layout_content'] = $this->getContentFile();
			$template = $this->getTemplateFile();
		}

		// recupera as variaveis padrão
		$assign = $this->getVars();

		// renderiza
		$slimResponse = $this->render($response->getResponse(), $template, $assign);

		// seta o novo response 
		$response->setResponse($slimResponse);

		// retorna o novo response
		return $response;

	}

	/**
	 * Assina uma variavel pro template
	 * 
	 * @param string $name Nome da variavel
	 * @param mixed $value Valor da variavel
	 */
	public function assign(string $name, mixed $value)
	{
		$this->defaultVariables[$name] = $value;
	}

	/**
	 * Assina uma variavel pro template
	 * 
	 * @param string $name Nome da variavel
	 * @param mixed $value Valor da variavel
	 */
	public function __set($name, $value)
	{
		$this->defaultVariables[$name] = $value;
	}

	/**
	 * Recupera uma variavel assinada
	 * 
	 * @param string $name Nome da variavel
	 * 
	 * @return mixed
	 */
	public function __get($name): mixed
	{
		// se a variavel for "helper", retorna a classe de helper
		if($name == "helper") {
			return $this->defaultVariables["this"];
		}
		
		return $this->defaultVariables[$name];
	}

	/**
	 * Recupera as variaveis assinadas
	 * 
	 * @return array
	 */
	public function getVars(): array
	{
		return $this->defaultVariables;
	}





	/**
	 * Proxy method to register a plugin to Smarty
	 *
	 * @param string $type plugin type
	 * @param string $tag name of template tag
	 * @param callable $callback PHP callback to register
	 * @param boolean $cacheable if true (default) this function is cachable
	 *
	 * @return self
	 */
	public function registerPlugin(string $type, string $tag, callable $callback, bool $cacheable = true): Smarty
	{
		$this->smarty->registerPlugin($type, $tag, $callback, $cacheable);

		return $this;
	}

	/**
	 * Fetch rendered template
	 *
	 * @param string $template Template pathname relative to templates directory
	 * @param array $data Associative array of template variables
	 *
	 * @return string
	 * @throws \Smarty\Exception
	 */
	public function fetch(string $template, $data = []): string
	{
		$data = array_merge($this->defaultVariables, $data??[]);

		$this->smarty->assign($data);

		return $this->smarty->fetch($template);
	}

	/**
	 * Output rendered template
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param string $template Template pathname relative to templates directory
	 * @param array $data Associative array of template variables
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \Smarty\Exception
	 */
	public function render(\Psr\Http\Message\ResponseInterface $response, string $template, $data = []): \Psr\Http\Message\ResponseInterface
	{
		$response->getBody()->write($this->fetch($template, $data));

		return $response;
	}

	/**
	 * Return Smarty instance
	 *
	 * @return \Smarty\Smarty
	 */
	public function getSmarty(): \Smarty\Smarty
	{
		return $this->smarty;
	}

	/**
	 * Does this collection have a given key?
	 *
	 * @param  string $key The data key
	 *
	 * @return bool
	 */
	public function offsetExists($key): bool
	{
		return array_key_exists($key, $this->defaultVariables);
	}

	/**
	 * Get collection item for key
	 *
	 * @param string $key The data key
	 *
	 * @return mixed The key's value, or the default value
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet($key)
	{
		if (!$this->offsetExists($key)) {
			return null;
		}
		return $this->defaultVariables[$key];
	}

	/**
	 * Set collection item
	 *
	 * @param string $key The data key
	 * @param mixed $value The data value
	 */
	public function offsetSet($key, $value): void
	{
		$this->defaultVariables[$key] = $value;
	}

	/**
	 * Remove item from collection
	 *
	 * @param string $key The data key
	 */
	public function offsetUnset($key): void
	{
		unset($this->defaultVariables[$key]);
	}

	/**
	 * Get number of items in collection
	 *
	 * @return int
	 */
	public function count(): int
	{
		return count($this->defaultVariables);
	}

	/**
	 * Get collection iterator
	 *
	 * @return \ArrayIterator
	 */
	public function getIterator(): \ArrayIterator
	{
		return new \ArrayIterator($this->defaultVariables);
	}
}