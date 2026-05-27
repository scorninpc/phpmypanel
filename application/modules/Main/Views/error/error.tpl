<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="stylesheet" href="{$basePath}/assets/main/css/bootstrap.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/main/css/custom.css">

		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700&display=swap" rel="stylesheet">
	</head>

	<body>
		{if $displayErrorDetails}
			<div class="container mt-4">
				<div class="row">
					<p class="h1">{$title}</p>

					<p class="h3 mb-0 mt-4">Message</p>
					<pre class="pb-4 pt-2 fs-7 mb-0">{$exception->getMessage()}</pre>

					<p class="h3 mb-0">Trace</p>
					<pre class="pb-4 pt-2 fs-7">{$exception->getTraceAsString()}</pre>
				</div>
			</div>
		{else}

			<div class="d-flex align-items-center justify-content-center vh-100" style="background: #0e3b59">
				<div class="d-block">
					<h1 class="display-1 fw-bold text-white mb-0 pb-0">ERRO<span class="ms-2 display-4 fw-bold text-white">{if $code > 0}{$code}{else}500{/if}</span></h1>
					<span class="display-6 fw-bold text-white mt-0 pt-0">{if $code == 404} página não encontrada {else} algo errado ocorreu {/if}</span>
				</div>
			</div>
		{/if}
	</body>

	<script src="{$basePath}/modules/site/js/jquery-3.5.1.min.js"></script>
	<script src="{$basePath}/modules/site/js/bootstrap.bundle.min.js"></script>

</html>
