<?php
$path = "../../";
include $path."assets/php/main-include.php";

$existsLocationFrom = keyDataExists($_GET, 'location-from');
$existsLocationTo = keyDataExists($_GET, 'location-to');
$existsDeparture = keyDataExists($_GET, 'departure');
$existsArrival = keyDataExists($_GET, 'arrival');
$existsId = keyDataExists($_GET, 'id');

if ( $existsId ) {

	// Clear input
	$inputId = clearData($_GET['id']);

	// Get the trip from the database
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("SELECT * FROM trip WHERE id = ?");
	$stmt->bind_param("i", $inputId);
	$stmt->execute();

	// Determine if there was a result for this query
	$result = $stmt->get_result();

	$stmt->close();
	$conn->close();

	if ( $result->num_rows == 0 ) {
		// There was no trip with that ID
		http_response_code(404);
		return;
	}

	$result = $result->fetch_all(MYSQLI_ASSOC)[0];

	header("Content-type: application/json");
	http_response_code(200);

	echo json_encode($result, JSON_UNESCAPED_UNICODE);

}
else if ( $existsLocationFrom && $existsLocationTo && $existsDeparture && $existsArrival ) {

	// Clear input
	$inputLocationFrom = clearData($_GET['location-from']);
	$inputLocationTo = clearData($_GET['location-to']);
	$inputDeparture = clearData($_GET['departure']);
	$inputArrival = clearData($_GET['arrival']);

	// Search for trip in database
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("SELECT * FROM trip WHERE location_from = ? AND location_to = ? AND departure = ? AND arrival = ?");
	$stmt->bind_param("iiss", $inputLocationFrom, $inputLocationTo, $inputDeparture, $inputArrival);
	$stmt->execute();

	// Determine if there was a result for this query
	$result = $stmt->get_result();

	$stmt->close();
	$conn->close();

	if ( $result->num_rows == 0 ) {
		// There was no trip
		http_response_code(404);
		return;
	}

	$result = $result->fetch_all(MYSQLI_ASSOC)[0];

	header("Content-type: application/json");
	http_response_code(200);

	echo json_encode($result, JSON_UNESCAPED_UNICODE);

}
else if ( $existsLocationFrom && $existsLocationTo ) {

	// Clear input
	$inputLocationFrom = clearData($_GET['location-from']);
	$inputLocationTo = clearData($_GET['location-to']);

	// Get all trips that have not yet departed between these locations
	$dateNow = date("Y-m-d H:i:s");

	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("SELECT * FROM trip WHERE location_from = ? AND location_to = ? AND departure >= ?");
	$stmt->bind_param("iis", $inputLocationFrom, $inputLocationTo, $dateNow);
	$stmt->execute();

	// Determine if there was a result for this query
	$result = $stmt->get_result();

	$stmt->close();
	$conn->close();

	if ( $result->num_rows == 0 ) {
		// There was no trip
		http_response_code(404);
		return;
	}

	$result = $result->fetch_all(MYSQLI_ASSOC);

	header("Content-type: application/json");
	http_response_code(200);

	echo json_encode($result, JSON_UNESCAPED_UNICODE);

}
else {
	// The request was bad
	http_response_code(400);
	return;
}

?>