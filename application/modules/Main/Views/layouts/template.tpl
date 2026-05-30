<!doctype html>
<html lang="en">
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="{$basePath}/assets/painel/fonts/font-awesome/css/all.min.css" >
		<link rel="stylesheet" href="{$basePath}/assets/main/css/bootstrap.min.css">
		<link rel="stylesheet" href="{$basePath}/assets/main/css/custom.css">

		{$this->meta("title")}
		{$this->meta("description")}
		{$this->meta("og:type")}
		{$this->meta("og:title")}
		{$this->meta("og:description")}
		{$this->meta("og:url")}
		{$this->meta("og:image")}
		{$this->meta("og:site_name")}

		{* inclui o css se ele existir *}
		{$this->assets("css")}

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
		{include $layout_content}
	</body>

	<script src="{$basePath}/assets/main/js/jquery-3.5.1.min.js"></script>
	<script src="{$basePath}/assets/main/js/bootstrap.min.js"></script>
	<script src="{$basePath}/assets/main/js/custom.js"></script>

	{* inclui o javascript caso exista *}
	{$this->assets("javascript")}
</html>
