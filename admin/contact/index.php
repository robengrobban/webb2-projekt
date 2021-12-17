<?php
$path = "../../";

include $path . "assets/php/main-include.php";

// If the user is not an admin, send them away
if ( !isAdmin($path) ) {
	header("Location: " . $path);
}

header("Content-Type: text/html");

$html = file_get_contents("contact.html");

include $path . "assets/php/nav-generator.php";
$html = generateNav($html, $path);

$html = generateContactsInNeedOfRespons($html, $path);
$html = generateContactsInNoNeedOfRespons($html, $path);

echo $html;


// Generate a list of contacts for a HTML document that needs response or handling
function generateContactsInNeedOfRespons($html, $path): string
{
	$htmlPieces = explode("<!--:NEED-ANSWER-CONTACT:-->", $html);

	$newHtml = $htmlPieces[0];

	// Get all the trains
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT * FROM contact WHERE awaiting_respond = 1 ORDER BY id ASC");
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt->close();

	foreach ( $result as $contact ) {
		$htmlPiece = $htmlPieces[1];
		$htmlPiece = str_replace("--:contact-name:--", $contact['firstname']." ".$contact['lastname'], $htmlPiece);
		$htmlPiece = str_replace("--:contact-message:--", $contact['message'], $htmlPiece);
		$htmlPiece = str_replace("--:contact-id:--", $contact['id'], $htmlPiece);


		$id = $contact['id'];

		$foundRespondType = false;

		$stmt = $conn->prepare("SELECT * FROM respond_email WHERE contact_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$result = $stmt->get_result();
		$stmt->close();
		if ( $result->num_rows != 0 ) {
			$foundRespondType = true;
			$result = $result->fetch_all(MYSQLI_ASSOC)[0];
			$htmlPiece = str_replace("--:contact-respond-type:--", "Email: ".$result['email'], $htmlPiece);
		}

		if ( !$foundRespondType ) {

			$stmt = $conn->prepare("SELECT * FROM respond_phone WHERE contact_id = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();

			$result = $stmt->get_result();
			$stmt->close();
			if ( $result->num_rows != 0 ) {
				$foundRespondType = true;
				$result = $result->fetch_all(MYSQLI_ASSOC)[0];
				$htmlPiece = str_replace("--:contact-respond-type:--", "Phone: ".$result['phone'], $htmlPiece);
			}
		}

		if ( !$foundRespondType ) {

			$stmt = $conn->prepare("SELECT * FROM respond_letter WHERE contact_id = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();

			$result = $stmt->get_result();
			$stmt->close();
			if ( $result->num_rows != 0 ) {
				$foundRespondType = true;
				$result = $result->fetch_all(MYSQLI_ASSOC)[0];
				$htmlPiece = str_replace("--:contact-respond-type:--", "Letter. Adress: ".$result['adress'] . " & Zip: " . $result['zip'], $htmlPiece);
			}
		}


		if ( !$foundRespondType ) {
			$htmlPiece = str_replace("--:contact-respond-type:--", "Inget svar har begärts", $htmlPiece);
		}


		$newHtml .= $htmlPiece;
	}

	$newHtml .= $htmlPieces[2];

	$conn->close();

	return $newHtml;
}

// Generate a list of contacts for a HTML document that needs no response or handling
function generateContactsInNoNeedOfRespons($html, $path): string
{
	$htmlPieces = explode("<!--:ANSWERED-CONTACT:-->", $html);

	$newHtml = $htmlPieces[0];

	// Get all the trains
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT * FROM contact WHERE awaiting_respond = 0 ORDER BY id DESC");
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt->close();

	foreach ( $result as $contact ) {
		$htmlPiece = $htmlPieces[1];
		$htmlPiece = str_replace("--:contact-name:--", $contact['firstname']." ".$contact['lastname'], $htmlPiece);
		$htmlPiece = str_replace("--:contact-message:--", $contact['message'], $htmlPiece);


		$id = $contact['id'];

		$foundRespondType = false;

		$stmt = $conn->prepare("SELECT * FROM respond_email WHERE contact_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$result = $stmt->get_result();
		$stmt->close();
		if ( $result->num_rows != 0 ) {
			$foundRespondType = true;
			$result = $result->fetch_all(MYSQLI_ASSOC)[0];
			$htmlPiece = str_replace("--:contact-respond-type:--", "Email: ".$result['email'], $htmlPiece);
		}

		if ( !$foundRespondType ) {

			$stmt = $conn->prepare("SELECT * FROM respond_phone WHERE contact_id = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();

			$result = $stmt->get_result();
			$stmt->close();
			if ( $result->num_rows != 0 ) {
				$foundRespondType = true;
				$result = $result->fetch_all(MYSQLI_ASSOC)[0];
				$htmlPiece = str_replace("--:contact-respond-type:--", "Phone: ".$result['phone'], $htmlPiece);
			}
		}

		if ( !$foundRespondType ) {

			$stmt = $conn->prepare("SELECT * FROM respond_letter WHERE contact_id = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();

			$result = $stmt->get_result();
			$stmt->close();
			if ( $result->num_rows != 0 ) {
				$foundRespondType = true;
				$result = $result->fetch_all(MYSQLI_ASSOC)[0];
				$htmlPiece = str_replace("--:contact-respond-type:--", "Letter. Adress: ".$result['adress'] . " & Zip: " . $result['zip'], $htmlPiece);
			}
		}


		if ( !$foundRespondType ) {
			$htmlPiece = str_replace("--:contact-respond-type:--", "Inget svar har begärts", $htmlPiece);
		}


		$newHtml .= $htmlPiece;
	}

	$newHtml .= $htmlPieces[2];

	$conn->close();

	return $newHtml;
}

?>