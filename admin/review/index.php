<?php
$path = "../../";

include $path . "assets/php/main-include.php";

// If the user is not an admin, send them away
if ( !isAdmin($path) ) {
	header("Location: " . $path);
}

header("Content-Type: text/html");

$html = file_get_contents("review.html");

include $path . "assets/php/nav-generator.php";
$html = generateNav($html, $path);

$html = generateAccountListAsOptions($html, $path, "<!--:ACCOUNTS:-->");
$html = generateReviewListAsList($html, $path, "<!--:ALL-REVIEWS:-->");

echo $html;

// Generate a account list for a HTML document where the id and name needs to be present. Uses
// a target string to find the subsection
function generateAccountListAsOptions($html, $path, $target): string
{
	$htmlPieces = explode($target, $html);

	$newHtml = $htmlPieces[0];

	// Get all the accounts
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT * FROM account");
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt->close();

	foreach ( $result as $account ) {
		$htmlPiece = $htmlPieces[1];
		$htmlPiece = str_replace("--:account-id:--", $account['id'], $htmlPiece);
		$htmlPiece = str_replace("--:account-name:--", ucwords($account['firstname']." ".$account['lastname']), $htmlPiece);
		$newHtml .= $htmlPiece;
	}

	$newHtml .= $htmlPieces[2];

	$conn->close();

	return $newHtml;
}

// Generate a account list for a HTML document where the id and name needs to be present. Uses
// a target string to find the subsection
function generateReviewListAsList($html, $path, $target): string
{
	$htmlPieces = explode($target, $html);

	$newHtml = $htmlPieces[0];

	// Get all the accounts
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT * FROM review");
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt->close();

	$stmt = $conn->prepare("SELECT * FROM account WHERE id = ?");

	foreach ( $result as $review ) {
		$stmt->bind_param("i", $review['account_id']);
		$stmt->execute();

		$account = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];

		$htmlPiece = $htmlPieces[1];
		$htmlPiece = str_replace("--:account-id:--", $account['id'], $htmlPiece);
		$htmlPiece = str_replace("--:account-name:--", ucwords($account['firstname']." ".$account['lastname']), $htmlPiece);
		$htmlPiece = str_replace("--:review-id:--", $review['id'], $htmlPiece);
		$htmlPiece = str_replace("--:review-content:--", $review['content'], $htmlPiece);
		$newHtml .= $htmlPiece;
	}

	$newHtml .= $htmlPieces[2];

	$conn->close();

	return $newHtml;
}

?>