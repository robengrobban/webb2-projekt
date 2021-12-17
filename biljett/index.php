<?php
$path = "../";

include $path . "assets/php/main-include.php";

header("Content-Type: text/html");

if ( !isset($_GET['id']) ) {
	http_response_code(404);
}
else {
	$html = file_get_contents("biljett.html");
	include $path . "assets/php/replace-in-html.php";
	$html = replaceInHtml($html, "--:ID:--", clearData($_GET['id']));
	echo $html;
}

?>