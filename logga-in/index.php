<?php
$path = "../";

include $path . "assets/php/main-include.php";

// If the user is logged in, send to account page
if ( isLoggedIn() ) {
	header("Location: " . $path . "konto/");
}

// Check if there is an request for logging in to a account
$errorMessage = "";
if ( isset($_POST["log-in"]) && keyDataExists($_POST, "email") && keyDataExists($_POST, "password") ) {

	// Clear input
	$inputEmail = clearData($_POST['email']);
	$inputPassword = clearData($_POST['password']);

	// Get information about the email
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT * FROM account WHERE email = ?");
	$stmt->bind_param("s", $inputEmail);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt->close();

	if ( count($result) == 1 ) {

		$result = $result[0];

		// Verify password
		if ( password_verify($inputPassword, $result['password']) ) {

			$_SESSION['user-id'] = $result['id'];

			$conn->close();

			// Check for reference else, send back to start page
			if ( isset($_GET['ref']) ) {
				$inputReference = clearData($_GET['ref']);
				header("Location: " . $path . $inputReference);
			}
			else {
				header("Location: " . $path);
			}


		}
		else {
			$errorMessage = '<p id="button-error-spot" class="error-spot error-border">Felaktig mejladress eller lösenord.</p>';
		}
	}
	else {
		$errorMessage = '<p id="button-error-spot" class="error-spot error-border">Felaktig mejladress eller lösenord.</p>';
	}

	$conn->close();

}

header("Content-Type: text/html");

$html = file_get_contents("logga-in.html");

include $path . "assets/php/nav-generator.php";
$html = generateNav($html, $path);

include $path . "assets/php/replace-in-html.php";
$html = replaceInHtml($html, "<!--:PHP-ERROR:-->", $errorMessage);

include $path . "assets/php/footer-generator.php";
$html = generateFooter($html, $path);

echo $html;

?>