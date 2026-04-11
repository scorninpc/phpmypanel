/**
 * Cookies
 */
function createCookie(e, t) {
	var days = 120;
	
	var o = new Date;
	o.setTime(o.getTime()+(days*24*60*60*1000));
	var r = "; expires=" + o.toGMTString()
	
	document.cookie = e + "=" + t + r + "; path=/; SameSite=Lax"
}

function readCookie(e) {
	for (var t = e + "=", n = document.cookie.split(";"), o = 0; o < n.length; o++) {
		for (var r = n[o];
			" " == r.charAt(0);) r = r.substring(1, r.length);
		if (0 == r.indexOf(t)) return r.substring(t.length, r.length)
	}
	return null
}

function eraseCookie(e) {
	createCookie(e, "", -1)
}

/**
 * show toast
 */
function showToast(type, message)
{
	// monta o template do toast
	var html = `
		<div class="toast mb-1" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="` + Base.toast.time + `">
			<div class="toast-header bg-` + type + ` text-white">
				<div class="me-auto">` + message + `</div>
				<button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	`;
	
	// adiciona o toast ao html
	var toastElement = $(html).appendTo('.toast-containert');

	// cria o objeto toast
	var toast = new bootstrap.Toast(toastElement.get(0));

	// ao esconder, remove do html
	toastElement.get(0).addEventListener('hidden.bs.toast', function () {
		$(this).remove();
	});

	// mostra o toast
	toast.show();
}