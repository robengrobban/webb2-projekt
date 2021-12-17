<?php
$path = "../../";

include $path . "assets/php/main-include.php";

// Check if user is logged in
if ( !isLoggedIn() ) {
	header("Location: ".$path."logga-in/?ref=konto");
}

// Check that there exists GET information
$existsFromId = keyDataExists($_GET, 'from-id');
$existsDestId = keyDataExists($_GET, 'dest-id');
$existsDeparture = keyDataExists($_GET, 'departure');
$existsAdult = keyDataExists($_GET, 'adult');
$existsKid = keyDataExists($_GET, 'kid');
$existsSeats = keyDataExists($_GET, 'seats');
$existsTicketId = keyDataExists($_GET, 'ticket');

$from = "";
$to = "";
$datetime = "";
$adults = "";
$kids = "";
$seats = "";
$track = "";
$ticketCode = "";

if ( isLoggedIn() && $existsFromId && $existsDestId && $existsDeparture && $existsAdult && $existsKid && $existsSeats && $existsTicketId ) {

	// Get all the necessary information
	$inputFromId = clearData($_GET['from-id']);
	$inputDestId = clearData($_GET['dest-id']);
	$inputDeparture = clearData($_GET['departure']);
	$inputAdult = clearData($_GET['adult']);
	$inputKid = clearData($_GET['kid']);
	$inputSeats = clearData($_GET['seats']);
	$inputTicket = clearData($_GET['ticket']);

	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("SELECT name FROM location WHERE id = ?");
	$stmt->bind_param("i", $inputFromId);
	$stmt->execute();

	$from = ucfirst($stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['name']);

	$stmt->bind_param("i", $inputDestId);
	$stmt->execute();

	$to = ucfirst($stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['name']);
	$stmt->close();

	$stmt = $conn->prepare("SELECT * FROM trip WHERE id = ?");
	$stmt->bind_param("i", $inputDeparture);
	$stmt->execute();

	$tripInformation = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
	$stmt->close();

	$datetime = $tripInformation['departure'];

	$adults = $inputAdult;
	$kids = $inputKid;

	$seats = explode(":", $inputSeats);
	$seatIds = "";
	for ( $i = 0; $i < count($seats); $i++ ) {
		if ( $i == 0 ) {
			$seatIds .= $seats[$i];
		}
		else {
			$seatIds .= ", " . $seats[$i];
		}
	}
	$seats = $seatIds;

	$track = $tripInformation['track'];

	$ticketCode = $inputTicket;

	$conn->close();

}
else {
	header("Location: ".$path."logga-in/?ref=konto");
}

header("Content-Type: text/html");

$html = file_get_contents("kvitto.html");

include $path . "assets/php/nav-generator.php";
$html = generateNav($html, $path);

include $path . "assets/php/replace-in-html.php";
$html = replaceInHtml($html, "<!--:FROM:-->", $from);
$html = replaceInHtml($html, "<!--:TO:-->", $to);
$html = replaceInHtml($html, "<!--:DEPARTURE-DATETIME:-->", $datetime);
$html = replaceInHtml($html, "<!--:ADULTS:-->", $adults);
$html = replaceInHtml($html, "<!--:KIDS:-->", $kids);
$html = replaceInHtml($html, "<!--:SEATS:-->", $seats);
$html = replaceInHtml($html, "<!--:TRACK-NUMBER:-->", $track);
$html = replaceInHtml($html, "<!--:TICKET-CODE:-->", $ticketCode);

include $path . "assets/php/footer-generator.php";
$html = generateFooter($html, $path);

echo $html;

?>