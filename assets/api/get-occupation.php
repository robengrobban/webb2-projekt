<?php
$path = "../../";
include $path."assets/php/main-include.php";

$existsTripId = keyDataExists($_GET, 'trip-id');

if ( isLoggedIn() && $existsTripId ) {

	// Clear input
	$inputTripId = clearData($_GET['trip-id']);

	// Get database entries
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("SELECT * FROM occupation WHERE trip_id = ?");
	$stmt->bind_param("i", $inputTripId);
	$stmt->execute();

	$result = $stmt->get_result();

	$stmt->close();
	$conn->close();

	if ( $result->num_rows == 0 ) {
		// No response
		http_response_code(404);
		return;
	}

	$result = $result->fetch_all(MYSQLI_ASSOC);

	// Set response type
	http_response_code(200);
	header("Content-type: application/json");

	echo json_encode($result, JSON_UNESCAPED_UNICODE);

}
else {
	// The request was bad
	http_response_code(400);
	return;
}

?>