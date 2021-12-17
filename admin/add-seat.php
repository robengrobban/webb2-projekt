<?php
$path = "../";

include $path . "assets/php/main-include.php";

header("Content-type: text/plain");

$existsTrain = keyDataExists($_POST, 'train');
$existsSeat = keyDataExists($_POST, 'seat');

if ( isAdmin($path) && isset($_POST['add-seat']) && $existsTrain && $existsSeat ) {

	$inputTrain = clearData($_POST['train']);
	$inputSeat = clearData($_POST['seat']);

	// Check if a seat with that number already exists or not
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("SELECT COUNT(*) FROM seat WHERE train_id = ? AND seat_id = ?");
	$stmt->bind_param("ii", $inputTrain, $inputSeat);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
	$stmt->close();

	if ( $result == 0 ) {

		// Create seat
		$stmt = $conn->prepare("INSERT INTO seat (train_id, seat_id) VALUES (?,?)");
		$stmt->bind_param("ii", $inputTrain, $inputSeat);
		$stmt->execute();

		$stmt->close();

		// Get train information
		$stmt = $conn->prepare("SELECT * FROM train WHERE id = ?");
		$stmt->bind_param("i", $inputTrain);
		$stmt->execute();

		$train = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];

		$stmt->close();
		$conn->close();

		echo "Sittplatsen " . $inputSeat . " har skapats för tåg " . $train['model'] . "#" . $train['id'] . ".";

	}
	else {
		echo "Sittplatsen " . $inputSeat . " finns redan och har inte skapats.";
		$conn->close();
	}

}
else {
	echo "All information var inte satt för att skapa sittplatsen.";
}

?>