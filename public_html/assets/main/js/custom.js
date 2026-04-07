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