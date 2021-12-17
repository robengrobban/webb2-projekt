<?php
$path = "";

include $path . "assets/php/main-include.php";
include $path . "assets/php/logout.php";

header("Content-Type: text/html");

$html = file_get_contents("home.html");

include $path . "assets/php/nav-generator.php";
$html = generateNav($html, $path);

include $path . "assets/php/footer-generator.php";
$html = generateFooter($html, $path);

echo $html;

?>