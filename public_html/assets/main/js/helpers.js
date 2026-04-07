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