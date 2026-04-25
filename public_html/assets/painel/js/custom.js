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

/**
 * mascaras automaticas
 */
$('.core-mask-date').mask('00/00/0000');
$('.core-mask-datetime').mask('00/00/0000 00:00');
$('.core-mask-time').mask('00:00');
$('.core-mask-cep').mask('99999-999');
$('.core-mask-phone').mask(mask_telefone, options_telefone);
$('.core-mask-documento').mask(mask_documento, options_documento);
$('.core-mask-cpf').mask('000.000.000-00');
$('.core-mask-cnpj').mask('00.000.000/0000-00');
$('.core-mask-integer').mask('#');
$('.core-mask-decimal').on('input', function(e) {
		
	var valor = $(this).val(),
		valor_final = '',
		permitidos = '.,0123456789';

	if((valor.match(/,/g) || []).length == 2) {
		valor_final = valor.substring(0, valor.lastIndexOf(',')) + valor.substring(valor.lastIndexOf(',')+1);
		$(this).val(valor_final);
		return false;
	}

	for(i=0; i<valor.length; i++){
		for(j=0; j<permitidos.length; j++){
			if(valor[i] == permitidos[j]){
				valor_final += valor[i];
			}
		}   
	}   

	$(this).val(valor_final);
	return false;

});


/**
 * texto rico
 */
$('.core-richtext').each(function() {

	$(this).summernote({
		minHeight: 200,
		maxHeight: 500,
		lang: 'pt-BR'
	});

});