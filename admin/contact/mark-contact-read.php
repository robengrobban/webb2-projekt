<?php
$path = "../../";

include $path . "assets/php/main-include.php";

header("Content-type: text/plain");

$existsId = keyDataExists($_POST, 'contact-id');

if ( isAdmin($path) && $existsId ) {

	$inputId = clearData($_POST['contact-id']);

	// Check if a contact exists with that id
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("SELECT COUNT(*) FROM contact WHERE id = ?");
	$stmt->bind_param("i", $inputId);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
	$stmt->close();

	if ( $result != 0 ) {

		// Update information
		$stmt = $conn->prepare("UPDATE contact SET awaiting_respond = 0 WHERE id = ?");
		$stmt->bind_param("i", $inputId);
		$stmt->execute();

		$stmt->close();
		$conn->close();

		echo "Kontakten " . $inputId . " har nu markerats som hanterad.";

	}
	else {
		echo "Kontakten " . $inputId . " finns inte.";
		$conn->close();
	}

}
else {
	echo "All information var inte satt för att uppdatera kontakten.";
}

?>