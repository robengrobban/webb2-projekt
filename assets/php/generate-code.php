<?php
$path = "../../";
include $path . "assets/php/main-include.php";
// Generates a digital code, like QR code, for on board scanning

// Set header type
header("Content-type: image/png");

// Load id
$id = -1;
if ( isset($_GET['id']) ) {
	$id = clearData($_GET['id']);
}

// Create a new image
$image = imagecreate(300, 300);

// Create and set image background color
$backgroundColor = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $backgroundColor);

// Fill corners
for ( $i = 0; $i < 30; $i++ ) {
	drawSquare($image, $i*10, 0);
	drawSquare($image, 0, $i*10);

	drawSquare($image, $i*10, 290);
	drawSquare($image, 290, $i*10);
}

if ( $id != -1 ) {

	for ( $i = 0; $i < 30; $i++ ) {

		$y = round(sin(100*$i*$id)*30+30)*10%300;
		$x = $i*10;

		drawSquare($image, $x, $y);

		$y = round(cos(100*$i*$id)*30+30)*10%300;
		$x = $i*10;

		drawSquare($image, $x, $y);

	}

}

imagepng($image);
imagedestroy($image);

function drawSquare($image, $x, $y) {
	$color = imagecolorallocate($image, 0, 0, 0);
	imagefilledrectangle($image, $x, $y, $x+10, $y+10, $color);
}

?>