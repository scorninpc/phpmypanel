/**
 * dark / light theme
 */
$('a[href="#theme=dark"]').on('click', function(e) {
	e.preventDefault();

	createCookie("theme", "dark");

	setTheme();
});

$('a[href="#theme=light"]').on('click', function(e) {
	e.preventDefault();

	createCookie("theme", "light");

	setTheme();
});

function setTheme()
{
	var theme = readCookie("theme");

	if(theme == "dark") {
		$('html').attr("data-bs-theme", "dark");
	}
	else if(theme == "light") {
		$('html').attr("data-bs-theme", "light");
	}
}

/**
 * confirmação de remoção
 */
$('body').on('click', '.core-delete-confirm', function(e) {
	if(!confirm('Deseja remover esse registro?')) {
		e.preventDefault();
		return false;
	}
});

/**
 * roda as mensagens do sistema
 */
$.each(Base.messages.error, function(index, message) {
		showToast('danger', message);
});
$.each(Base.messages.success, function(index, message) {
		showToast('success', message);
});
$.each(Base.messages.info, function(index, message) {
		showToast('info', message);
});
$.each(Base.messages.alert, function(index, message) {
		showToast('warning', message);
});