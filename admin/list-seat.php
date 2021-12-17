<?php
$path = "../";

include $path . "assets/php/main-include.php";

header("Content-type: text/plain");

$existsTrain = keyDataExists($_GET, 'train');

if ( isAdmin($path) && isset($_GET['list-seat']) && $existsTrain ) {

	$inputTrain = clearData($_GET['train']);

	// Get all the seats from that train
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("SELECT * FROM seat WHERE train_id = ?");
	$stmt->bind_param("i", $inputTrain);
	$stmt->execute();

	$result = $stmt->get_result();
	$stmt->close();

	if ( $result->num_rows == 0 ) {
		echo "Det finns inga platser för det tåget du angav.";
	}
	else {
		$result = $result->fetch_all(MYSQLI_ASSOC);

		// Hämta information om tåget
		$stmt = $conn->prepare("SELECT * FROM train WHERE id = ?");
		$stmt->bind_param("i", $inputTrain);
		$stmt->execute();

		$train = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
		$stmt->close();

		echo "Sittplats information för tåg " . $train['model'] . "#" . $train['id'] . "\n";

		foreach ( $result as $seat ) {
			echo "Sittplats #" . $seat['seat_id'] . "\n";
		}
	}

	$conn->close();
}
else {
	echo "All information var inte satt kolla upp sittplatser.";
}

?>