<?php
$path = "../";

include $path . "assets/php/main-include.php";

header("Content-type: text/plain");

$existsLocationFrom = keyDataExists($_POST, 'from');
$existsLocationTo = keyDataExists($_POST, 'to');
$existsDeparture = keyDataExists($_POST, 'departure');
$existsArrival = keyDataExists($_POST, 'arrival');
$existsTrackNumber = keyDataExists($_POST, 'track-number');
$existsTrain = keyDataExists($_POST, 'train');

if ( isAdmin($path) && isset($_POST['create-trip']) && $existsLocationFrom && $existsLocationTo && $existsDeparture && $existsArrival && $existsTrackNumber && $existsTrain ) {

	// Clear input
	$inputLocationFrom = clearData($_POST['from']);
	$inputLocationTo = clearData($_POST['to']);
	$inputDeparture = clearData($_POST['departure']);
	$inputArrival = clearData($_POST['arrival']);
	$inputTrackNumber = clearData($_POST['track-number']);
	$inputTrain = clearData($_POST['train']);

	include $path . "assets/php/connect-database.php";

	// Validate if location from and to exists
	$stmt = $conn->prepare("SELECT COUNT(*) FROM location WHERE id = ? OR id = ?");
	$stmt->bind_param("ii", $inputLocationFrom, $inputLocationTo);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
	$stmt->close();

	if ( $result == 2 && $inputLocationTo != $inputLocationFrom ) {

		// Validate that the train exists
		$stmt = $conn->prepare("SELECT COUNT(*) FROM train WHERE id = ?");
		$stmt->bind_param("i", $inputTrain);
		$stmt->execute();

		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
		$stmt->close();

		if ( $result == 1 ) {

			// Validate that the train is available
			$stmt = $conn->prepare("SELECT COUNT(*) FROM trip WHERE train_id = ? AND (departure BETWEEN ? AND ? OR arrival BETWEEN ? AND ?)");
			$stmt->bind_param("issss", $inputTrain, $inputDeparture, $inputArrival, $inputDeparture, $inputArrival);
			$stmt->execute();

			$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];

			if ( $result == 0 ) {

				// Validate that the track number is available
				$stmt = $conn->prepare("SELECT COUNT(*) FROM trip WHERE location_from = ? AND track = ? AND departure = ?");
				$stmt->bind_param("iis", $inputLocationFrom, $inputTrackNumber, $inputDeparture);
				$stmt->execute();

				$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
				$stmt->close();

				if ( $result == 0 ) {

					// Validate that the arrival date is after the departure date
					$result = strcmp($inputDeparture, $inputArrival);

					if ( $result < 0 ) {
						// Create trip
						$stmt = $conn->prepare("INSERT INTO trip (location_from, location_to, departure, arrival, track, train_id) VALUES (?, ?, ?, ?, ?, ?)");
						$stmt->bind_param("iissii", $inputLocationFrom, $inputLocationTo, $inputDeparture, $inputArrival, $inputTrackNumber, $inputTrain);
						$stmt->execute();

						$id = $stmt->insert_id;

						$stmt->close();

						// Get location from and to
						$stmt = $conn->prepare("SELECT * FROM location WHERE id = ?");
						$stmt->bind_Param("i", $inputLocationFrom);
						$stmt->execute();

						$locationFrom = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];

						$stmt->bind_param("i", $inputLocationTo);
						$stmt->execute();

						$locationTo = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
						$stmt->close();

						// Get train information
						$stmt = $conn->prepare("SELECT * FROM train WHERE id = ?");
						$stmt->bind_param("i", $inputTrain);
						$stmt->execute();

						$train = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
						$stmt->close();

						echo "En resa mellan " . $locationFrom['name'] . " och " . $locationTo['name'] . " med tåg " . $train['model'] . "#" . $train['id'] . " som åker " . $inputDeparture . " från spår " . $inputTrackNumber . " och kommer fram " . $inputArrival . " har skapats.";

					}
					else {
						echo "Avgång datum måste vara innan framkomst datum.";
					}
				}
				else {
					echo "Tågspåret är upptaget";
				}
			}
			else {
				echo "Tåget du valde är upptaget under den tiden.";
			}
		}
		else {
			echo "Tåget finns inte.";
		}
	}
	else {
		echo "Platserna är inte korrekta.";
	}

	$conn->close();

}
else {
	echo "All information var inte satt för att skapa resan.";
}

?>