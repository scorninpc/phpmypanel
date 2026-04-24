# PHP My Panel

Um painel administrativo em branco em PHP!

Cansou de toda hora ficar refazendo login, adicionando template, criando helpers, etc etc etc? Pois então, esse projeto é para facilitar isso: um esqueleto de um painel usando PHP como linguagem, Slim framework para facilitar tudo, Smarty para manter um MVC limpo, e Tabler para ter um visual lindo.

A ideia é só prover um painel com login e cadastro, e alguns helpers para criação de CRUDs.

# Como usar

## Apache
1. Baixe esse projeto, em `Releases` ou `Download ZIP`. Caso clone, não esqueça de remover o `.git` após clonar
2. Renomeie a pasta conforme o nome do seu projeto
3. Configure o `public_html/.htaccess` modificando o `RewriteBase` para `/seuprojeto/public_html` ou se for a raiz, pode remover
4. Configure o `application/condifs/config.development.php` mudando `application.basepath` para `/seuprojeto/public_html` ou pode deixar em branco
5. Dê permissão 777 recursiva para `application/tmp`
6. Baixe as dependencias PHP com `composer update`
7. Acesse seu projeto pelo navegador `http://localhost/seuprojeto/public_html`

## Docker
1. Baixe esse projeto, em `Releases` ou `Download ZIP`. Caso clone, não esqueça de remover o `.git` após clonar
2. Renomeie a pasta conforme o nome do seu projeto
3. Configure o `public_html/.htaccess` removendo o `RewriteBase`
4. Configure o `application/condifs/config.development.php` mudando `application.basepath` para vazio
5. Dê permissão 777 recursiva para `application/tmp`
6. Baixe as dependencias PHP com `composer update`
7. Acesse a pasta `docker` e execute `docker compose up`
8. Acesse seu projeto pelo navegador `http://localhost:8080/`

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
- [jQuery Mask Plugin](https://github.com/igorescobar/jQuery-Mask-Plugin)
- [Font-Awesome](https://github.com/fortawesome/font-awesome)