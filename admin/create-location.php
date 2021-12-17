<?php
$path = "../";

include $path . "assets/php/main-include.php";

header("Content-type: text/plain");

$existsLocation = keyDataExists($_POST, 'location');

if ( isAdmin($path) && isset($_POST['create-location']) && $existsLocation ) {

	$inputLocation = strtolower(clearData($_POST['location']));

	// Check if location exists
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("SELECT COUNT(*) FROM location WHERE LOWER(name) = ? ");
	$stmt->bind_param("s", $inputLocation);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
	$stmt->close();

	if ( $result == 0 ) {

		// Create location
		$stmt = $conn->prepare("INSERT INTO location (name) VALUES (?)");
		$stmt->bind_param("s", $inputLocation);
		$stmt->execute();

		$id = $stmt->insert_id;

		$stmt->close();
		$conn->close();

		echo "Platsen " . $inputLocation . " med id nummer " . $id . " har skapats.";

	}
	else {
		echo "Platsen " . $inputLocation . " finns redan och har inte skapats.";
		$conn->close();
	}

}
else {
	echo "All information var inte satt för att skapa platsen.";
}

?>