<?php
$path = "../";

include $path . "assets/php/main-include.php";

header("Content-type: text/plain");

$existsModel = keyDataExists($_POST, 'train-model');

if ( isAdmin($path) && isset($_POST['create-train']) && $existsModel ) {

	$inputModel = clearData($_POST['train-model']);

	// Update the database
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("INSERT INTO train (model) VALUES (?)");
	$stmt->bind_param("s", $inputModel);
	$stmt->execute();

	$id = $stmt->insert_id;

	$stmt->close();
	$conn->close();

	echo "Tåget " . $inputModel . " med id nummer " . $id . " har skapats.";

}
else {
	echo "All information var inte satt för att skapa tåget.";
}

?>