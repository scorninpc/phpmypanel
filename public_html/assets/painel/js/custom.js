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
// $('.core-mask-date').mask('00/00/0000'); // removido, vamos usar o input type="date"
// $('.core-mask-datetime').mask('00/00/0000 00:00'); // removido, vamos usar o input type="datetime-local"
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



/**
 * plugin do autocomplete
 */
jQuery.fn.CoreAutocomplete = function(e) {

	// configuração padrão
	var config = {
		onCreateUrl : null,
		onSelect : null,
		onClear : null
	};

	// destroy o elemento e volta a ser um input normal
	if(e == 'destroy') {
		return this.each(function() {
			
			$("*[rel='" + $(this).attr("id") + "']").remove();

			$(this).attr({readonly : false}).removeClass('autocomplete-value');
			
			var input_group = $(this).closest('.input-group');
			
			input_group.before($(this)).remove();
			
		});
	}

	// limpa os campos
	if(e == 'clear') {
		return this.each(function() {
			$("*[rel='" + $(this).attr('id') + "']").val('');
			$("*[rel='" + $(this).attr('id') + "']").keyup();
		});
	}

	// mescla as configurações padroes com o passado pelo parametro
	if(e) {
		$.extend(config, e);
	}

	return this.each(function() {

			// guarda as configurações originais
			var e = $(this), 
				original_model_name = encodeURI(e.attr('data-core-autocomplete-model')),
				original_name = e.attr('name'),
				original_id = e.attr('id'),
				original_value = e.val(),
				original_autocomplete_label = e.attr('data-core-autocomplete-label'),
				original_placeholder = e.attr('placeholder'),
				is_array = false;

			// se o nome for um vetor
			if(original_name.indexOf("[") > 0) {
				// recupera somente o nome
				is_array = true;
				original_name = original_name.substring(0, original_name.indexOf('['));
			}

			// se nao tem id, usa o nome como id
			if(original_id == undefined) {
				original_id = original_name;
			}

			// cria os novos elementos
			var input_group = $('<div class="input-group">'),
				input_value = e,
				input_label = $('<input type="text">'),
				input_button = $('<button class="btn btn-white" type="button"><i class="fas fa-caret-down"></i></button>');

			// configura o input value
			input_value
				.attr({
					readonly: true,
					placeholder: ""
				});

			// quando o value receber foco, muda o foco pro label
			input_value.on('focus', function() {
				$(this).next().focus();
			});

			// configura o input label
			input_label
				.addClass('form-control core-autocomplete-label')
				.val(original_autocomplete_label)
				.attr({
						name: e.attr('name').replace(original_name, original_name+'_label'), // faz esse replace para manter o [] caso houver
						autocomplete: 'off',
						placeholder: original_placeholder
					});

			// configura o botão
			input_button
				.attr({
						name: e.attr('name').replace(original_name, original_name+'_button'), // faz esse replace para manter o [] caso houver
					})
				.off('click').on('click', function(e) {
						e.preventDefault();
						input_label.autocomplete('search', ' ');
						input_label.focus();
					});
			
			// adiciona o group antes do elemento, e adiciona os elementos dentro do group
			input_value.before(input_group);
			input_group.append(input_value);
			input_group.append(input_label);
			input_group.append(input_button);

			// monta o autocomplete jqueryUI
			input_label.autocomplete({

				// monta o conteudo
				source: function(request, response) {

					// ajusta o termo
					request.term = request.term.replaceAll(" ", "%");
					request.term = request.term.replaceAll("%", "'");
					var url = Base.basePath + '/painel/index/autocomplete/term/' + request.term + '/model/' + original_model_name + '/field/' + original_name;

					// hook para criação da url
					if(typeof config.onCreateUrl == 'function') {
						url = config.onCreateUrl.call(this, url);
					}

					// adiciona o loading
					input_label.addClass('ui-autocomplete-loading');

					// recupera os dados
					$.ajax({
							url: url,
							dataType: 'json',
							success: function(result) {
								
								$.each(result, function(index, item) {
									item.label = $('<span></span>').html(item.label).text()
								});

								response(result);
							}
						});
				},

				// ao selecionar
				select: function(event, ui) {
				
					// callback para quando o item é selecionado
					if (typeof config.onSelect == 'function') {
						var ret = config.onSelect.call(this, ui.item);
						if (ret == false) {
							return false;
						}
					}

					// seta o id no input value
					e.val(ui.item.id);
				},

				// ao fechar o dropdown
				close: function() {
				
				}


			})
			// evento para adicionar algumas funções
			.on('keyup', function() {
					
					// se o label ta limpo, dispara o clear
					if($(this).val() == "") {
					
						// hook para quando a lista é limpa
						if (typeof config.onClear == 'function') {
							var ret = config.onClear.call(this);
							if(ret == false) {
								return false;
							}
						}
						e.val('');
					}
				});


		});
};

/**
 * autocomplete
 */
$('input[data-core-autocomplete-model]').each(function() {

	$(this).CoreAutocomplete();

});

/**
 * custom files
 */
Fancybox.bind("[data-fancybox]", {});
