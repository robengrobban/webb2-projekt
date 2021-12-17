<?php
$path = "../../";
include $path."assets/php/main-include.php";

// Check if it is a PUT request
$request = $_SERVER['REQUEST_METHOD'];
$params = splitIntoParam(file_get_contents('php://input'));

$existsFirstname = keyDataExists($params, 'firstname');
$existsLastname = keyDataExists($params, 'lastname');
$existsEmail = keyDataExists($params, 'email');

if ( isLoggedIn() && strcmp($request, 'PUT') === 0 && $existsFirstname && $existsLastname && $existsEmail ) {

	// Clear the input
	$inputFirstname = clearData($params['firstname']);
	$inputLastname = clearData($params['lastname']);
	$inputEmail = clearData($params['email']);

	// Check if it is an email
	if ( filter_var($inputEmail, FILTER_VALIDATE_EMAIL) ) {
		// Check if this email already exists
		include $path . "assets/php/connect-database.php";
		$stmt = $conn->prepare("SELECT COUNT(*) FROM account WHERE email = ? AND id != ?");
		$stmt->bind_param("si", $inputEmail, $_SESSION['user-id']);
		$stmt->execute();

		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
		$stmt->close();

		if ( $result == 0 ) {

			// Update information
			$stmt = $conn->prepare("UPDATE account SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
			$stmt->bind_param("sssi", $inputFirstname, $inputLastname, $inputEmail, $_SESSION['user-id']);
			$stmt->execute();

			$stmt->close();
			$conn->close();

			// Everything is good
			http_response_code(200);
			return;

		}
		else {
			// There is a conflict, cannot update
			http_response_code(409);
			return;
		}
	}
	else {
		// Bad request
		http_response_code(400);
		return;
	}
}
else {
	// The request was bad
	http_response_code(400);
	return;
}

?>