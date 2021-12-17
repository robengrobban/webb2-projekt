<?php
$path = "../../";
include $path."assets/php/main-include.php";

// Check if it is a PUT request
$request = $_SERVER['REQUEST_METHOD'];
$params = splitIntoParam(file_get_contents('php://input'));

$existsNotificationRecommended = keyDataExists($params, 'notification-recommended');
$existsNotificationUpcoming = keyDataExists($params, 'notification-upcoming');
$existsPaymentSave = keyDataExists($params, 'payment-save');

if ( isLoggedIn() && strcmp($request, 'PUT') === 0 && $existsNotificationRecommended && $existsNotificationUpcoming && $existsPaymentSave ) {

	// Clear the input
	$inputNotificationRecommended = clearData($params['notification-recommended']) == "true" ? 1 : 0;
	$inputNotificationUpcoming = clearData($params['notification-upcoming']) == "true" ? 1 : 0;
	$inputPaymentSave = clearData($params['payment-save']) == "true" ? 1 : 0;

	// Update
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("UPDATE setting SET notification_upcoming = ?, notification_recommended = ?, payment_save = ? WHERE account_id = ?");
	$stmt->bind_param("iiii", $inputNotificationUpcoming, $inputNotificationRecommended, $inputPaymentSave, $_SESSION['user-id']);
	$stmt->execute();

	$stmt->close();
	$conn->close();

	http_response_code(200);
	return;

}
else {
	// The request was bad
	http_response_code(400);
	return;
}

?>