<?php
$path = "../../";
include $path."assets/php/main-include.php";

// Check if required parameters exists
$existsTripId = keyDataExists($_POST, 'trip-id');
$existsAdult = keyDataExists($_POST, 'adult');
$existsKid = keyDataExists($_POST, 'kid');
$existsCardNumber = keyDataExists($_POST, 'card-number');
$existsCardHolder = keyDataExists($_POST, 'card-holder');
$existsCardExpire = keyDataExists($_POST, 'card-expire');
$existsCardCVV = keyDataExists($_POST, 'card-cvv');
$existsSeatIds = keyDataExists($_POST, 'seat-ids');

if ( isLoggedIn() && $existsTripId && $existsAdult && $existsKid && $existsCardNumber && $existsCardHolder && $existsCardExpire && $existsCardCVV && $existsSeatIds ) {

	// Clear input
	$inputTripId = clearData($_POST['trip-id']);
	$inputAccountId = $_SESSION['user-id'];
	$inputAdult = clearData($_POST['adult']);
	$inputKid = clearData($_POST['kid']);
	$inputCardNumber = clearData($_POST['card-number']);
	$inputCardHolder = clearData($_POST['card-holder']);
	$inputCardExpire = clearData($_POST['card-expire']);
	$inputCardCVV = clearData($_POST['card-cvv']);
	$inputSeatIds = clearData($_POST['seat-ids']);

	$inputSeatIds = explode(":", $inputSeatIds);



}
else {
	// The request was bad
	http_response_code(400);
	return;
}

?>