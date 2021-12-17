<?php
// Replace a target string in a HTML file with a replacement string
function replaceInHtml($html, $target, $replacement) : string
{

	$htmlPieces = explode($target, $html);

	$newHtml = $htmlPieces[0];

	$newHtml .= $replacement;

	$newHtml .= $htmlPieces[1];

	return $newHtml;

}
?>