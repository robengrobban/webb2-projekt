<?php
$path = "../../";
include $path."assets/php/main-include.php";

// Check if there exists a name search
$existsName = keyDataExists($_GET, 'name');

if ( $existsName ) {

	$inputName = "%" . strtolower(clearData($_GET['name'])) . "%";

	// Get database entries
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT * FROM location WHERE LOWER(location.name) LIKE ?");
	$stmt->bind_param("s", $inputName);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt->close();
	$conn->close();

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