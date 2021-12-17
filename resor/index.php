<?php
$path = "../";

include $path . "assets/php/main-include.php";

// Check if user is logged in
if ( !isLoggedIn() ) {
	header("Location: ../logga-in/?ref=resor");
}

// Check if there is order information
$existsFromId = keyDataExists($_POST, 'from-id');
$existsDestId = keyDataExists($_POST, 'dest-id');
$existsDeparture = keyDataExists($_POST, 'departure');
$existsAdults = keyDataExists($_POST, 'adults');
$existsKids = keyDataExists($_POST, 'kids');
$existsSeats = keyDataExists($_POST, 'seats');
$existsCard = keyDataExists($_POST, 'card');
$existsHolder = keyDataExists($_POST, 'holder');
$existsExpire = keyDataExists($_POST, 'expire');

if ( isLoggedIn() && isset($_POST['make-order']) && $existsFromId && $existsDestId && $existsDeparture && $existsAdults && $existsKids && $existsSeats && $existsCard && $existsHolder && $existsExpire) {

	// Clear input
	$inputFromId = (int)clearData($_POST['from-id']);
	$inputDestId = (int)clearData($_POST['dest-id']);
	$inputDeparture = (int)clearData($_POST['departure']);
	$inputAdults = (int)clearData($_POST['adults']);
	$inputKids = (int)clearData($_POST['kids']);
	$inputSeats = clearData($_POST['seats']);
	$inputCard = clearData($_POST['card']);
	$inputHolder = clearData($_POST['holder']);
	$inputExpire = clearData($_POST['expire']);

	$inputSeats = explode(":", $inputSeats);

	$monthYear = explode("/", "03/22");
	$inputExpire = date("Y-m-d", strtotime($monthYear[0]."/01/20".$monthYear[1].' + 1 month'));

	// Connect to database
	include $path . "assets/php/connect-database.php";
	// Start a transaction
	$conn->begin_transaction();

	// Check if these places exists
	$stmt = $conn->prepare("SELECT COUNT(*) FROM location WHERE id = ? OR id = ?");
	$stmt->bind_param("ii", $inputFromId, $inputDestId);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
	$stmt->close();

	if ( $result == 2 ) {

		// Verify that the departure is valid
		$dateNow = date("Y-m-d H:i:s");
		$stmt = $conn->prepare("SELECT * FROM trip WHERE id = ? AND location_from = ? AND location_to = ? AND departure >= ?");
		$stmt->bind_param("iiis", $inputDeparture, $inputFromId, $inputDestId, $dateNow);
		$stmt->execute();

		$tripInformation = $stmt->get_result();
		$stmt->close();

		if ( $tripInformation->num_rows != 0 ) {

			$tripInformation = $tripInformation->fetch_all(MYSQLI_ASSOC)[0];

			// Check that the seats are available
			$seatIds = "";
			for ( $i = 0; $i < count($inputSeats); $i++ ) {
				if ( $i == 0 ) {
					$seatIds .= $inputSeats[$i];
				}
				else {
					$seatIds .= "," . $inputSeats[$i];
				}
			}
			$stmt = $conn->prepare("SELECT COUNT(*) FROM occupation WHERE trip_id = ? AND train_id = ? AND seat_id IN (".$seatIds.")");
			$stmt->bind_param("ii", $tripInformation['id'], $tripInformation['train_id']);
			$stmt->execute();

			$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
			$stmt->close();

			if ( $result == 0 ) {

				// Check that the number of seats are equal to the number of people
				if ( count($inputSeats) == $inputAdults + $inputKids ) {

					// Create order in database
					$paymentId = -1;

					$stmt = $conn->prepare("SELECT id FROM payment WHERE card_number = ? AND card_holder = ? AND card_expire = ?");
					$stmt->bind_param("sss", $inputCard, $inputHolder, $inputExpire);
					$stmt->execute();

					$result = $stmt->get_result();
					$stmt->close();
					if ( $result->num_rows == 0 ) {

						$stmt = $conn->prepare("INSERT INTO payment (card_number, card_holder, card_expire) VALUES (?,?,?)");
						$stmt->bind_param("sss", $inputCard, $inputHolder, $inputExpire);
						$stmt->execute();

						$paymentId = $stmt->insert_id;

					}
					else {
						$paymentId = $result->fetch_all(MYSQLI_ASSOC)[0]['id'];
					}

					$stmt = $conn->prepare("INSERT INTO ticket (adult, kid, payment_id, account_id, trip_id) VALUES (?,?,?,?,?)");
					$stmt->bind_param("iiiii", $inputAdults, $inputKids, $paymentId, $_SESSION['user-id'], $tripInformation['id']);
					$stmt->execute();

					$ticketId = $stmt->insert_id;

					$stmt = $conn->prepare("INSERT INTO occupation (ticket_id, trip_id, train_id, seat_id) VALUES (?,?,?,?)");
					for ( $i = 0; $i < count($inputSeats); $i++ ) {
						$stmt->bind_param("iiii", $ticketId, $tripInformation['id'], $tripInformation['train_id'], $inputSeats[$i]);
						$stmt->execute();
					}
					$stmt->close();

					// Commit and send to receipt window
					$conn->commit();
					$conn->close();

					header("Location: kvitto/?from-id=".$inputFromId."&dest-id=".$inputDestId."&departure=".$inputDeparture."&adult=".$inputAdults."&kid=".$inputKids."&seats=".clearData($_POST['seats'])."&ticket=".$ticketId);
					return;

				}
			}
		}
	}

	// There was a problem, rollback
	$conn->rollback();
	$conn->close();

	// Display error page
	header("Content-Type: text/html");

	$html = file_get_contents("error.html");

	include $path . "assets/php/nav-generator.php";
	$html = generateNav($html, $path);

	include $path . "assets/php/footer-generator.php";
	$html = generateFooter($html, $path);

	echo $html;

}
else {
	header("Content-Type: text/html");

	$html = file_get_contents("resor.html");

	include $path . "assets/php/nav-generator.php";
	$html = generateNav($html, $path);

	include $path . "assets/php/footer-generator.php";
	$html = generateFooter($html, $path);

	echo $html;
}



?>