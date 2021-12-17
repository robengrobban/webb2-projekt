<?php
$path = "../";

include $path . "assets/php/main-include.php";

// If the user is not an admin, send them away
if ( !isAdmin($path) ) {
	header("Location: " . $path);
}

header("Content-Type: text/html");

$html = file_get_contents("admin.html");

include $path . "assets/php/nav-generator.php";
$html = generateNav($html, $path);

$html = generateTrainListIdAndModel($html, $path, "<!--:ALL-TRAINS:-->");

$html = generateLocationListIdAndName($html, $path, "<!--:ALL-LOCATION:-->");

$html = generateTrainListIdAndModel($html, $path, "<!--:TRAIN-OPTIONS:-->");

$html = generateTrainListIdAndModel($html, $path, "<!--:LIST-SEAT-TRAIN-OPTIONS:-->");

$html = generateLocationListIdAndName($html, $path, "<!--:TRIP-LOCATION-FROM:-->");

$html = generateLocationListIdAndName($html, $path, "<!--:TRIP-LOCATION-TO:-->");

$html = generateTrainListIdAndModel($html, $path, "<!--:TRIP-TRAIN:-->");

$html = generateTrips($html, $path);

echo $html;

// Generate a train option list for a HTML document where the id and modell needs to be present. Uses
// a target string to find the subsection
function generateTrainListIdAndModel($html, $path, $target): string
{
	$htmlPieces = explode($target, $html);

	$newHtml = $htmlPieces[0];

	// Get all the trains
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT * FROM train ORDER BY train.id ASC");
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt->close();

	foreach ( $result as $train ) {
		$htmlPiece = $htmlPieces[1];
		$htmlPiece = str_replace("--:train-id:--", $train['id'], $htmlPiece);
		$htmlPiece = str_replace("--:train-model:--", $train['model'], $htmlPiece);
		$newHtml .= $htmlPiece;
	}

	$newHtml .= $htmlPieces[2];

	$conn->close();

	return $newHtml;
}

// Generate a location option list for a HTML document where the id and modell needs to be present. Uses
// a target string to find the subsection
function generateLocationListIdAndName($html, $path, $target): string
{
	$htmlPieces = explode($target, $html);

	$newHtml = $htmlPieces[0];

	// Get all the locations
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT * FROM location ORDER BY location.id ASC");
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt->close();

	foreach ( $result as $location ) {
		$htmlPiece = $htmlPieces[1];
		$htmlPiece = str_replace("--:location-id:--", $location['id'], $htmlPiece);
		$htmlPiece = str_replace("--:location-name:--", $location['name'], $htmlPiece);
		$newHtml .= $htmlPiece;
	}

	$newHtml .= $htmlPieces[2];

	$conn->close();

	return $newHtml;
}

// Generate trip
function generateTrips($html, $path) : string {

	$htmlPieces = explode("<!--:ALL-TRIPS:-->", $html);

	$newHtml = $htmlPieces[0];

	// Get all the trips
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT * FROM trip ORDER BY trip.id ASC");
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt->close();

	foreach ( $result as $trip ) {
		// Get train information
		$stmt = $conn->prepare("SELECT * FROM train WHERE id = ?");
		$stmt->bind_param("i", $trip['train_id']);
		$stmt->execute();

		$train = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
		$stmt->close();

		// Get location information
		$stmt = $conn->prepare("SELECT * FROM location WHERE id = ?");
		$stmt->bind_param("i", $trip['location_from']);
		$stmt->execute();

		$locationFrom = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];

		$stmt->bind_param("i", $trip['location_to']);
		$stmt->execute();

		$locationTo = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
		$stmt->close();

		$htmlPiece = $htmlPieces[1];
		$htmlPiece = str_replace("--:trip-id:--", $trip['id'], $htmlPiece);
		$htmlPiece = str_replace("--:trip-location-from:--", $locationFrom['name'], $htmlPiece);
		$htmlPiece = str_replace("--:trip-location-to:--", $locationTo['name'], $htmlPiece);
		$htmlPiece = str_replace("--:trip-track:--", $trip['track'], $htmlPiece);
		$htmlPiece = str_replace("--:trip-train:--", $train['model']."#".$train['id'], $htmlPiece);
		$htmlPiece = str_replace("--:trip-departure:--", $trip['departure'], $htmlPiece);
		$htmlPiece = str_replace("--:trip-arrival:--", $trip['arrival'], $htmlPiece);
		$newHtml .= $htmlPiece;
	}

	$newHtml .= $htmlPieces[2];

	$conn->close();

	return $newHtml;
}

?>