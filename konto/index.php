<?php
$path = "../";

include $path . "assets/php/main-include.php";

// If user is not logged in, send them back
if ( !isLoggedIn() ) {
	header("Location: " . $path);
}

// Get account information
include $path . "assets/php/connect-database.php";
$stmt = $conn->prepare("SELECT * FROM account WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user-id']);
$stmt->execute();

$account = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
$stmt->close();

// Get settings information
$stmt = $conn->prepare("SELECT * FROM setting WHERE account_id = ?");
$stmt->bind_param("i", $_SESSION['user-id']);
$stmt->execute();

$settings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
$stmt->close();

// Get upcoming travel information
$dateNow = date("Y-m-d H:i:s");

$stmt = $conn->prepare("SELECT ticket.id, trip.location_from, trip.location_to, trip.departure, trip.track FROM ticket LEFT JOIN trip ON ticket.trip_id = trip.id WHERE account_id = ? AND trip_id IN (SELECT id FROM trip WHERE id = ticket.trip_id AND departure >= ?) ORDER BY trip.departure DESC");
$stmt->bind_param("is", $_SESSION['user-id'],$dateNow);
$stmt->execute();

$upcomingTravels = $stmt->get_result();
$stmt->close();

if ( $upcomingTravels->num_rows == 0 ) {
	$upcomingTravels = array();
}
else {
	$upcomingTravels = $upcomingTravels->fetch_all(MYSQLI_ASSOC);
}

// Get previous travel information
$dateNow = date("Y-m-d H:i:s");

$stmt = $conn->prepare("SELECT ticket.id, trip.location_from, trip.location_to, trip.departure, trip.track FROM ticket LEFT JOIN trip ON ticket.trip_id = trip.id WHERE account_id = ? AND trip_id IN (SELECT id FROM trip WHERE id = ticket.trip_id AND departure <= ?) ORDER BY trip.departure ASC");
$stmt->bind_param("is", $_SESSION['user-id'],$dateNow);
$stmt->execute();

$previousTravels = $stmt->get_result();
$stmt->close();

if ( $previousTravels->num_rows == 0 ) {
	$previousTravels = array();
}
else {
	$previousTravels = $previousTravels->fetch_all(MYSQLI_ASSOC);
}


// Get location mapping
$stmt = $conn->prepare("SELECT * FROM location");
$stmt->execute();

$locations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$locationMapping = array();
for ( $i = 0; $i < count($locations); $i++ ) {
	$locationMapping[$locations[$i]['id']] = $locations[$i]['name'];
}

header("Content-Type: text/html");

$html = file_get_contents("konto.html");

include $path . "assets/php/nav-generator.php";
$html = generateNav($html, $path);

include $path . "assets/php/replace-in-html.php";
$html = replaceInHtml($html, "<!--:FIRSTNAME:-->", $account['firstname']);
$html = replaceInHtml($html, "<!--:LASTNAME:-->", $account['lastname']);
$html = replaceInHtml($html, "<!--:EMAIL:-->", $account['email']);
$html = replaceInHtml($html, "<!--:INPUT-FIRSTNAME:-->", $account['firstname']);
$html = replaceInHtml($html, "<!--:INPUT-LASTNAME:-->", $account['lastname']);
$html = replaceInHtml($html, "<!--:INPUT-EMAIL:-->", $account['email']);
$html = replaceInHtml($html, "data-notification-recommended", ($settings['notification_recommended'] ? "checked" : ""));
$html = replaceInHtml($html, "data-notification-upcoming", ($settings['notification_upcoming'] ? "checked" : ""));
$html = replaceInHtml($html, "data-payment-save", ($settings['payment_save'] ? "checked" : ""));

$htmlPieces = explode("<!--:UPCOMING-ENTRY:-->", $html);
$newHtml = $htmlPieces[0];
// Fill the upcoming travels section
for ( $i = 0; $i < count($upcomingTravels); $i++ ) {

	$travel = $upcomingTravels[$i];

	$from = ucwords($locationMapping[$travel['location_from']]);
	$to = ucwords($locationMapping[$travel['location_to']]);
	$datetime = explode(" ", $travel['departure']);
	$track = $travel['track'];
	$ticketId = $travel['id'];

	$htmlPiece = $htmlPieces[1];
	$htmlPiece = replaceInHtml($htmlPiece,"--:UPCOMING-FROM:--", $from);
	$htmlPiece = replaceInHtml($htmlPiece, "--:UPCOMING-TO:--", $to);
	$htmlPiece = replaceInHtml($htmlPiece, "--:UPCOMING-DATE:--", $datetime[0]);
	$htmlPiece = replaceInHtml($htmlPiece, "--:UPCOMING-TIME:--", $datetime[1]);
	$htmlPiece = replaceInHtml($htmlPiece, "--:UPCOMING-TRACK:--", $track);
	$htmlPiece = replaceInHtml($htmlPiece,"--:UPCOMING-TICKET:--", "<span class='show-ticket' data-id='".$ticketId."'>Visa</span>");

	$newHtml .= $htmlPiece;

}
$newHtml .= $htmlPieces[2];
$html = $newHtml;


$htmlPieces = explode("<!--:PREVIOUS-ENTRY:-->", $html);
$newHtml = $htmlPieces[0];
// Fill the upcoming travels section
for ( $i = 0; $i < count($previousTravels); $i++ ) {

	$travel = $previousTravels[$i];

	$from = ucwords($locationMapping[$travel['location_from']]);
	$to = ucwords($locationMapping[$travel['location_to']]);
	$datetime = explode(" ", $travel['departure']);
	$track = $travel['track'];
	$ticketId = $travel['id'];

	$htmlPiece = $htmlPieces[1];
	$htmlPiece = replaceInHtml($htmlPiece,"--:PREVIOUS-FROM:--", $from);
	$htmlPiece = replaceInHtml($htmlPiece, "--:PREVIOUS-TO:--", $to);
	$htmlPiece = replaceInHtml($htmlPiece, "--:PREVIOUS-DATE:--", $datetime[0]);
	$htmlPiece = replaceInHtml($htmlPiece, "--:PREVIOUS-TIME:--", $datetime[1]);
	$htmlPiece = replaceInHtml($htmlPiece, "--:PREVIOUS-TRACK:--", $track);

	$newHtml .= $htmlPiece;

}
$newHtml .= $htmlPieces[2];
$html = $newHtml;

if ( isset($_GET['error-picture-message']) ) {

	$html = replaceInHtml($html, "<!--:PROFILE-PICTURE-ERROR-SPOT:-->", clearData($_GET['error-picture-message']));

}

include $path . "assets/php/footer-generator.php";
$html = generateFooter($html, $path);

$stmt = $conn->prepare("SELECT * FROM profile_picture WHERE account_id = ?");
$stmt->bind_param("i", $_SESSION['user-id']);
$stmt->execute();

$result = $stmt->get_result();
if ( $result->num_rows == 0 ) {

	$html = replaceInHtml($html, "--:PROFILE-PICTURE:--", $path."assets/img/portrait-placeholder.jpg");

}
else {

	$result = $result->fetch_all(MYSQLI_ASSOC)[0];
	$imageName = $result['file'];
	$html = replaceInHtml($html, "--:PROFILE-PICTURE:--", $path . "assets/uploads/" . $imageName);

}

echo $html;

$conn->close();

?>