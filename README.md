# PHP My Panel

Um painel administrativo em branco em PHP!

Cansou de toda hora ficar refazendo login, adicionando template, criando helpers, etc etc etc? Pois então, esse projeto é para facilitar isso: um esqueleto de um painel usando PHP como linguagem, Slim framework para facilitar tudo, Smarty para manter um MVC limpo, e Tabler para ter um visual lindo.

A ideia é só prover um painel com login e cadastro, e alguns helpers para criação de CRUDs.

# Como usar

## Apache
1. Baixe esse projeto, em `Releases` ou `Download ZIP`. Caso clone, não esqueça de remover o `.git` após clonar
2. Renomeie a pasta conforme o nome do seu projeto
3. Configure o `public_html/.htaccess` modificando o `RewriteBase` para `/seuprojeto/public_html`
4. Configure o `application/condifs/config.development.php` mudando `application.basepath` para `/seuprojeto/public_html`
5. Dê permissão 777 recursivo para `application/tmp`
6. Baixe as dependencias PHP com `composer update`
7. Acesse seu projeto pelo navegador `http://localhost/seuprojeto/public_html`

## Docker
1. Baixe o docker
2. Configure qual banco quer usar em `docker/docker-compose.yaml` descomentando o bloco necessário
3. Baixe as dependencias PHP com `composer update`
4. Inicialize o `docker/docker-compose.yaml`
5. Acesse seu projeto pelo navegador `http://localhost:8875/`


---
#### Esse projeto só é possivel graças a:

- [PHP](https://github.com/php/php-src)
- [slim-mvc-skel](https://github.com/scorninpc/slim-mvc-skel)
- [Slim Framework](https://github.com/slimphp/Slim)
- [Smarty](https://github.com/smarty-php/smarty)
- [Slim Smarty View](https://github.com/scorninpc/slim-smarty-view)
- [Slim MVC](https://github.com/scorninpc/slim-mvc)
- [Composer](https://github.com/composer/composer)
- [Bootstrap](https://github.com/twbs/bootstrap)
- [Tabler](https://github.com/tabler/tabler)
- [JQuery](https://github.com/jquery/jquery)
- [Font-Awesome](https://github.com/fortawesome/font-awesome)