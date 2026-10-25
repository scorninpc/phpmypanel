<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="stylesheet" href="{$basePath}/assets/main/css/tabler.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/main/css/tabler-themes.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/main/css/custom.css">

		<style>
			@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
			:root {
				--tblr-font-sans-serif: Roboto, Helvetica Neue, sans-serif;
			}
			body {
				font-feature-settings: "cv03", "cv04", "cv11";
			}
		</style>
	</head>

	<body style="{if !$displayErrorDetails}background: #0e3b59{/if}">

		{if $displayErrorDetails}
			<div class="container-fluid">
				<div class="row">
					<h1 class="my-4">{$code} - {$title}</h1>

					<p class="h3">Arquivo</p>
					<pre class="p-2 text-wrap">{$exception->getFile()}({$exception->getLine()})</pre>

					<p class="h3 mb-0">Message</p>
					<pre class="p-2 text-wrap">{$exception->getMessage()}</pre>

					<p class="h3">Trace</p>
					<pre class="p-2">{$exception->getTraceAsString()}</pre>
				</div>
			</div>
		{else}

			<div class="d-flex align-items-center justify-content-center vh-100" >
				<div class="d-block">
					<h1 class="display-1 fw-bold text-white mb-0 pb-0">ERRO<span class="ms-2 display-4 fw-bold text-white">{if $code > 0}{$code}{else}500{/if}</span></h1>
					<span class="display-6 fw-bold text-white mt-0 pt-0">{if $code == 404} página não encontrada {else} algo errado ocorreu {/if}</span>
				</div>
			</div>
		{/if}
	</body>

</html>
