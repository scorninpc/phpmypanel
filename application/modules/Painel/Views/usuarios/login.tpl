<!doctype html>
<html lang="en" data-bs-theme-radius="0.5" data-bs-theme="{$smarty.cookies.theme|default:"light"}" data-bs-theme-font="sans-serif" data-bs-theme-base="neutral" data-bs-theme-primary="azure">
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="{$basePath}/assets/painel/fonts/font-awesome/css/all.min.css?{$core_cache}" >
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/tabler.min.css?{$core_cache}">
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/tabler-themes.min.css?{$core_cache}">
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/custom.css?{$core_cache}">

		<title>Acesso ao painel</title>

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
		<div class="page page-center">
			
			<div class="container container-tight py-4">
				
				{* your logo *}
				{* <div class="text-center mb-4">
					<a href="." class="navbar-brand navbar-brand-autodark">
						<img>
						or
						<svg>
					</a>
				</div> *}

				<div class="card card-md">
					<div class="card-body">
						<h2 class="h2 text-center mb-4">ACESSO AO PAINEL</h2>
						<form action="{$this->url(['controller'=>"usuarios", 'action'=>"login"], "painel")}" method="POST">
							<div class="mb-3">
								<label class="form-label" for="l_email">Email</label>
								<input type="email" name="email" id="l_email" class="form-control" placeholder="">
							</div>
							<div class="mb-2">
								<label class="form-label" for="l_password">
									Senha
									{* <span class="form-label-description">
										<a href="{$this->url(['controller'=>"usuarios", 'action'=>"recorver"], "painel")}">I forgot password</a>
									</span> *}
								</label>
								<input type="password" name="password" id="l_password" class="form-control" placeholder="" autocomplete="off">
							</div>
							<div class="mb-2">
							<label class="form-check">
								<input type="checkbox" class="form-check-input">
								<span class="form-check-label" name="remember">Confiar nesse dispositivo</span>
							</label>
							</div>
							<div class="form-footer">
								<button type="submit" class="btn btn-primary w-100">ENTRAR</button>
							</div>
						</form>
					</div>
				</div>

				{* enable if anyone can register *}
				{* <div class="text-center text-secondary mt-3">Don't have account yet? <a href="{$this->url(['controller'=>"usuarios", 'action'=>"register"], "painel")}" tabindex="-1">Sign up</a></div> *}

			</div>

		</div>

		{* container para abrigar os alertas *}
		<div class="toast-containert position-fixed bottom-0 end-0 p-3"></div>


		<script src="{$basePath}/assets/painel/js/tabler.min.js?{$core_cache}"></script>
		<script>var bootstrap = tabler;</script>
		<script src="{$basePath}/assets/painel/js/jquery-4.0.0.min.js?{$core_cache}"></script>
		<script src="{$basePath}/assets/painel/js/plugins/helpers.js?{$core_cache}"></script>
		<script src="{$basePath}/assets/painel/js/plugins/jquery.mask.min.js?{$core_cache}"></script>
		<script src="{$basePath}/assets/painel/js/plugins/fancybox.umd.js?{$core_cache}"></script>
		<script src="{$basePath}/assets/painel/js/custom.js?{$core_cache}"></script>
	</body>
</html>