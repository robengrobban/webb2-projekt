<?php
$path = "../";

include $path . "assets/php/main-include.php";

// If the user is logged in, send to account page
if ( isLoggedIn() ) {
	header("Location: " . $path . "konto/");
}

// Check if there is an request for creating a account
$errorMessage = "";
if ( isset($_POST["sign-up"]) && keyDataExists($_POST, "firstname") && keyDataExists($_POST, "lastname") && keyDataExists($_POST, "email") && keyDataExists($_POST, "password") ) {

	// Clear input
	$inputFirstname = clearData($_POST['firstname']);
	$inputLastname = clearData($_POST['lastname']);
	$inputEmail = clearData($_POST['email']);
	$inputPassword = clearData($_POST['password']);

	//Hash password
	$inputPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

	// Connect to database
	include $path . "assets/php/connect-database.php";

	// Check that the user does not already exist
	$stmt = $conn->prepare("SELECT COUNT(*) FROM account WHERE email = ?");
	$stmt->bind_param("s", $inputEmail);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
	$stmt->close();

	if ( $result == 0 ) {

		// Create the account in the database
		$stmt = $conn->prepare("INSERT INTO account (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssss", $inputFirstname, $inputLastname, $inputEmail, $inputPassword);
		$stmt->execute();

		$userId = $stmt->insert_id;

		$_SESSION['user-id'] = $userId;

		$stmt->close();

		// Add settings
		$defaultSetting = 0;
		$stmt = $conn->prepare("INSERT INTO setting (account_id, notification_upcoming, notification_recommended, payment_save) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("iiii", $_SESSION['user-id'], $defaultSetting, $defaultSetting, $defaultSetting);
		$stmt->execute();

		$stmt->close();
		$conn->close();

		header("Location: " . $path);

	}
	else {
		$errorMessage = '<p id="button-error-spot" class="error-spot error-border">Ett konto med den mejladressen finns redan.</p>';
	}

	$conn->close();

}

header("Content-Type: text/html");

$html = file_get_contents("skapa-konto.html");

include $path . "assets/php/nav-generator.php";
$html = generateNav($html, $path);

include $path . "assets/php/replace-in-html.php";
$html = replaceInHtml($html, "<!--:PHP-ERROR:-->", $errorMessage);

include $path . "assets/php/footer-generator.php";
$html = generateFooter($html, $path);

echo $html;

?>