<!doctype html>
<html lang="en" data-bs-theme-radius="0.5" data-bs-theme="{$smarty.cookies.theme|default:"light"}" data-bs-theme-font="sans-serif" data-bs-theme-base="neutral" data-bs-theme-primary="azure">
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="{$basePath}/assets/painel/fonts/font-awesome/css/all.min.css" >
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/tabler.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/tabler-themes.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/jquery-ui.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/plugins/summernote-bs5.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/custom.css">

		<title>Hello, world!</title>

		<script type="text/javascript">
			var Base = {
				basePath:'{$basePath}',
				messages:{
					error: {json_encode($global_errors|default:[])},
					success: {json_encode($global_success|default:[])},
					info: {json_encode($global_infos|default:[])},
					alert: {json_encode($global_alerts|default:[])},
				},
				toast:{
					time: 5000
				}
			};
		</script>

	</head>
	<body>
		<div class="page">

			{* header *}
			<header class="navbar navbar-expand-md d-print-none">
				<div class="container-xl">

					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					{* logos *}
					{* <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
						<a href="/painel">
							<img src="{$basePath}/assets/painel/images/marca-interna-dark.png" width="110" height="32" alt="NOME" class="navbar-brand-image hide-theme-light">
							<img src="{$basePath}/assets/painel/images/marca-interna.png" width="110" height="32" alt="NOME" class="navbar-brand-image hide-theme-dark">
						</a>
					</h1> *}

					<div class="navbar-nav flex-row order-md-last">
						
						<div class="d-none d-md-flex">
							<a href="#theme=dark" class="nav-link px-0 " data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Habilitar modo escuro" data-bs-original-title="Habilitar modo escuro"><i class="fas fa-moon"></i></a>
							<a href="#theme=light" class="nav-link px-0 " data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Habilitar modo claro" data-bs-original-title="Habilitar modo claro"><i class="fas fa-sun"></i></a>
						</div>

						<div class="nav-item dropdown nav-item-user">
							<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="false">
								{* <span class="avatar avatar-sm" style="background-image: url(/files/general/bbc859c86887754d906c934ea866b081.jpeg)"></span> imagem do perfil quando tiver *}
								<div class="d-none d-xl-block px-2">
									<div class="nome">Bruno</div>
									<div class="mt-1 small text-muted">--</div> {* perfil quando tiver *}
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
								{* <a href="/painel/usuarios/form/idusuario/1" class="dropdown-item">Meu Perfil</a> *}
								<a href="{$this->url(['controller'=>"users", 'action'=>"logout"], "painel")}" class="dropdown-item">Sair</a>
							</div>

						</div>
					</div>

					<div class="collapse navbar-collapse" id="navbar-menu">
						<div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
							<ul class="navbar-nav">
								
								<li class="nav-item">
									<a class="nav-link active" href="{$this->url([], "painel")}">
										<span class="nav-link-icon d-md-none d-lg-inline-block">
											<i class="fas fa-tachometer-alt"></i>
										</span>
										<span class="nav-link-title">
											Dashboard
										</span>
									</a>
								</li>

								{foreach from=$core_funcionalidades item=core_funcionalidade}
								<li class="nav-item">
									<a class="nav-link active" href="{$this->url(['controller'=>$core_funcionalidade['controlador']], "painel")}">
										{if strlen($core_funcionalidade['icone']|default:"") > 0}
										<span class="nav-link-icon d-md-none d-lg-inline-block">
											<i class="{$core_funcionalidade['icone']|escape}"></i>
										</span>
										{/if}
										<span class="nav-link-title">{$core_funcionalidade['nome']|escape}</span>
									</a>
								</li>
								{/foreach}
								
								{* <li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle show" href="#navbar-form" data-bs-toggle="dropdown" data-bs-auto-close="outside">
										<span class="nav-link-icon d-md-none d-lg-inline-block">
											<i class="fa-solid fa-gears"></i>
										</span>
										<span class="nav-link-title">Core</span>
									</a>
									<div class="dropdown-menu" data-bs-popper="static">
										<a class="dropdown-item" href="{$this->url(['controller'=>"funcionalidades"], "painel")}">Funcionalidades</a>
										<a class="dropdown-item" href="{$this->url(['controller'=>"perfis"], "painel")}">Perfis</a>
										<a class="dropdown-item" href="{$this->url(['controller'=>"users"], "painel")}">Users</a>
									</div>
								</li> *}

								{* <li class="nav-item">
									<a class="nav-link active" href="{$this->url(['controller'=>"users"], "painel")}">
										<span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-users"></i></span>
										<span class="nav-link-title">Users</span>
									</a>
								</li> *}
								
							</ul>
						</div>
					</div>
						
				</div>
			</header>

			{* content wrapper *}
			<div class="page-wrapper">
				{$layout_content}
			</div>
		</div>

		{* container para abrigar os alertas *}
		<div class="toast-containert position-fixed bottom-0 end-0 p-3"></div>

		<script src="{$basePath}/assets/painel/js/tabler.min.js"></script>
		<script src="{$basePath}/assets/painel/js/jquery-4.0.0.min.js"></script>
		<script src="{$basePath}/assets/painel/js/jquery-migrate-3.6.0.min.js"></script>
		<script src="{$basePath}/assets/painel/js/jquery-ui.min.js"></script>
		<script src="{$basePath}/assets/painel/js/plugins/helpers.js"></script>
		<script src="{$basePath}/assets/painel/js/plugins/jquery.mask.min.js"></script>
		<script src="{$basePath}/assets/painel/js/plugins/summernote-bs5.min.js"></script>
		<script src="{$basePath}/assets/painel/js/custom.js"></script>
	</body>
</html>