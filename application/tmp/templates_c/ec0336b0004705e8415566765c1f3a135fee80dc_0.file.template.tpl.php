<?php
/* Smarty version 4.5.6, created on 2026-04-06 02:52:14
  from '/var/www/html/phpmypanel/application/modules/Main/Views/layouts/template.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.6',
  'unifunc' => 'content_69d31fded2d216_74318342',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ec0336b0004705e8415566765c1f3a135fee80dc' => 
    array (
      0 => '/var/www/html/phpmypanel/application/modules/Main/Views/layouts/template.tpl',
      1 => 1775443933,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69d31fded2d216_74318342 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html lang="en" data-bs-theme-radius="0.5" data-bs-theme="light" data-bs-theme-font="sans-serif" data-bs-theme-base="neutral" data-bs-theme-primary="azure">
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/assets/main/css/tabler.min.css">
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/assets/main/css/tabler-themes.min.css">

		<title>Hello, world!</title>
	</head>
	<body>
		This is a application/modules/Main/Views/layouts/template.tpl
		<hr>
		<?php echo $_smarty_tpl->tpl_vars['layout_content']->value;?>


		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/assets/main/js/tabler.min.js"><?php echo '</script'; ?>
>
	</body>
</html><?php }
}
