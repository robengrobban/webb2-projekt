<?php
$path = "../../";
include $path."assets/php/main-include.php";

$existsFirstname = keyDataExists($_POST, 'firstname');
$existsLastname = keyDataExists($_POST, 'lastname');
$existsMessage = keyDataExists($_POST, 'message');

$existsEmail = keyDataExists($_POST, 'email');
$existsPhone = keyDataExists($_POST, 'phone');
$existsAdress = keyDataExists($_POST, 'adress');
$existsZip = keyDataExists($_POST, 'zip');

if ( $existsEmail && $existsFirstname && $existsLastname && $existsMessage  ) {

	// Clear input
	$inputEmail = clearData($_POST['email']);
	$inputFirstname = clearData($_POST['firstname']);
	$inputLastname = clearData($_POST['lastname']);
	$inputMessage = clearData($_POST['message']);

	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("INSERT INTO contact (firstname, lastname, message, awaiting_respond) VALUES (?,?,?,1)");
	$stmt->bind_param("sss", $inputFirstname, $inputLastname, $inputMessage);
	$stmt->execute();

	$connectId = $stmt->insert_id;

	$stmt->close();

	$stmt = $conn->prepare("INSERT INTO respond_email (contact_id, email) VALUES (?,?)");
	$stmt->bind_param("is", $connectId, $inputEmail);
	$stmt->execute();
	$stmt->close();

	$conn->close();

	http_response_code(200);
	header("Content-type: application/json");
	echo json_encode(array());
	return;

}
else if ( $existsPhone && $existsFirstname && $existsLastname && $existsMessage  ) {

	// Clear input
	$inputPhone = clearData($_POST['phone']);
	$inputFirstname = clearData($_POST['firstname']);
	$inputLastname = clearData($_POST['lastname']);
	$inputMessage = clearData($_POST['message']);

	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("INSERT INTO contact (firstname, lastname, message, awaiting_respond) VALUES (?,?,?,1)");
	$stmt->bind_param("sss", $inputFirstname, $inputLastname, $inputMessage);
	$stmt->execute();

	$connectId = $stmt->insert_id;

	$stmt->close();

	$stmt = $conn->prepare("INSERT INTO respond_phone (contact_id, phone) VALUES (?,?)");
	$stmt->bind_param("is", $connectId, $inputPhone);
	$stmt->execute();
	$stmt->close();

	$conn->close();

	http_response_code(200);
	header("Content-type: application/json");
	echo json_encode(array());
	return;

}
else if ( $existsAdress && $existsZip && $existsFirstname && $existsLastname && $existsMessage  ) {

	// Clear input
	$inputAdress = clearData($_POST['adress']);
	$inputZip = clearData($_POST['zip']);
	$inputFirstname = clearData($_POST['firstname']);
	$inputLastname = clearData($_POST['lastname']);
	$inputMessage = clearData($_POST['message']);

	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("INSERT INTO contact (firstname, lastname, message, awaiting_respond) VALUES (?,?,?,1)");
	$stmt->bind_param("sss", $inputFirstname, $inputLastname, $inputMessage);
	$stmt->execute();

	$connectId = $stmt->insert_id;

	$stmt->close();

	$stmt = $conn->prepare("INSERT INTO respond_letter (contact_id, adress, zip) VALUES (?,?,?)");
	$stmt->bind_param("iss", $connectId, $inputAdress, $inputZip);
	$stmt->execute();
	$stmt->close();

	$conn->close();

	http_response_code(200);
	header("Content-type: application/json");
	echo json_encode(array());
	return;

}
else if ( $existsFirstname && $existsLastname && $existsMessage ) {

	// Clear input
	$inputFirstname = clearData($_POST['firstname']);
	$inputLastname = clearData($_POST['lastname']);
	$inputMessage = clearData($_POST['message']);

	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("INSERT INTO contact (firstname, lastname, message, awaiting_respond) VALUES (?,?,?,1)");
	$stmt->bind_param("sss", $inputFirstname, $inputLastname, $inputMessage);
	$stmt->execute();
	$stmt->close();

	$conn->close();

	http_response_code(200);
	header("Content-type: application/json");
	echo json_encode(array());
	return;

}
else {
	// The request was bad
	http_response_code(400);
	return;
}

?>