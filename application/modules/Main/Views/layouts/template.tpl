<!doctype html>
<html lang="en">
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Hello, world!</title>

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

	{* inclui o javascript caso exista *}
	{$this->assets("javascript")}
</html>
