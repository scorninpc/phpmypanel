
/**
 * cria o codemirror
 */
const textarea = document.getElementById('query');
var editor = CodeMirror.fromTextArea(textarea, {
		mode: "text/x-sql",
		lineNumbers: true,
		indentWithTabs: true,
		smartIndent: true,
		viewportMargin: Infinity,
		theme: 'material', // se for tema escuro
		tabSize: 2,
		indentWithTabs: true,
		lineWrapping: false,
		showCursorWhenSelecting: true
	});

/**
 * cria o exportar
 */
$('.nw-exportar').on('click', function(e) {
	e.preventDefault();

	// seta o exportar 1 e submete o form
	$('input[name="exportar"]').val('1');
	$(this).closest('form').submit();

	// como alguns navegadores não dão refresh, retorna 0
	$('input[name="exportar"]').val('0');

});