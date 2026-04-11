<!doctype html>
<html lang="en" data-bs-theme-radius="0.5" data-bs-theme="{$smarty.cookies.theme|default:"light"}" data-bs-theme-font="sans-serif" data-bs-theme-base="neutral" data-bs-theme-primary="azure">
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="{$basePath}/assets/painel/fonts/font-awesome/css/all.min.css" >
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/tabler.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/tabler-themes.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/painel/css/custom.css">

		<title>Access to the dashboard</title>

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
						<h2 class="h2 text-center mb-4">ACCESS TO THE DASHBOARD</h2>
						<form action="{$this->url(['controller'=>"users", 'action'=>"login"], "painel")}" method="POST">
							<div class="mb-3">
								<label class="form-label" for="l_email">Email address</label>
								<input type="email" name="email" id="l_email" class="form-control" placeholder="your@email.com">
							</div>
							<div class="mb-2">
								<label class="form-label" for="l_password">
									Password
									{* <span class="form-label-description">
										<a href="{$this->url(['controller'=>"users", 'action'=>"recorver"], "painel")}">I forgot password</a>
									</span> *}
								</label>
								<input type="password" name="password" id="l_password" class="form-control" placeholder="Your password" autocomplete="off">
							</div>
							<div class="mb-2">
							<label class="form-check">
								<input type="checkbox" class="form-check-input">
								<span class="form-check-label" name="remember">Remember me on this device</span>
							</label>
							</div>
							<div class="form-footer">
								<button type="submit" class="btn btn-primary w-100">Sign in</button>
							</div>
						</form>
					</div>
				</div>

				{* enable if anyone can register *}
				{* <div class="text-center text-secondary mt-3">Don't have account yet? <a href="{$this->url(['controller'=>"users", 'action'=>"register"], "painel")}" tabindex="-1">Sign up</a></div> *}

			</div>

		</div>

		{* container para abrigar os alertas *}
		<div class="toast-containert position-fixed bottom-0 end-0 p-3"></div>


		<script src="{$basePath}/assets/painel/js/tabler.min.js"></script>
		<script>var bootstrap = tabler;</script>
		<script src="{$basePath}/assets/painel/js/jquery-4.0.0.min.js"></script>
		<script src="{$basePath}/assets/painel/js/helpers.js"></script>
		<script src="{$basePath}/assets/painel/js/custom.js"></script>
	</body>
</html>