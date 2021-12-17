<?php
$path = "../../";

include $path . "assets/php/main-include.php";

header("Content-type: text/plain");

$existsId = keyDataExists($_POST, 'remove-id');

if ( isAdmin($path) && $existsId ) {

	$inputId = clearData($_POST['remove-id']);

	// Check if a contact exists with that id
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("DELETE FROM review WHERE id = ?");
	$stmt->bind_param("i", $inputId);
	$stmt->execute();

	$stmt->close();

	$conn->close();

	echo "Recensionen med id #" . $inputId . " har nu tagits bort.";

}
else {
	echo "All information var inte satt för att ta bort recension.";
}

?>