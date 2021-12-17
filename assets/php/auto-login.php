<?php
// Check if there are cookies on the computer but not logged in
if ( !isLoggedIn() && isset($_COOKIE['user-id']) && isset($_COOKIE['user-authentication']) ) {

	// Connect to database
	include $path . "assets/php/connect-database.php";

	// Check remember database for this information
	$stmt = $conn->prepare('SELECT COUNT(*) FROM remember WHERE account_id = ? AND authentication = ?');
	$stmt->bind_param('is', $_COOKIE['user-id'], $_COOKIE['user-authentication']);
	$stmt->execute();

	$res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
	$stmt->close();

	// There is a account with this information
	if ( $res == 1 ) {
		// Make sure that the date is okey
		$stmt = $conn->prepare('SELECT created_date, expire_date FROM remember WHERE account_id = ? AND authentication = ?');
		$stmt->bind_param('is', $_COOKIE['user-id'], $_COOKIE['user-authentication']);
		$stmt->execute();

		$res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
		$stmt->close();

		$createdDate = $res['created_date'];
		$expireDate = $res['expire_date'];
		$today = date("Y-m-d");

		$old = strtotime($createdDate . ' + 1 month') < strtotime($today);
		$expired = strtotime($expireDate) < strtotime($today);

		if ( !$expired ) {
			// Login the user
			// by fetching the correct information
			$stmt = $conn->prepare('SELECT * FROM account WHERE id = (SELECT account_id FROM remember WHERE account_id = ? AND authentication = ?)');
			$stmt->bind_param('is', $_COOKIE['user-id'], $_COOKIE['user-authentication']);
			$stmt->execute();

			// Save the result
			$res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
			$stmt->close();

			// Login by filling in to the session
			$_SESSION['user-id'] = $res['id'];

			// Are the cookies used old?
			if ( $old ) {

				// Remove them
				removeCookies( $conn );

				// Create new one
				createCookies( $conn );

			}
		}
		else {
			// Remove cookies
			removeCookies( $conn );
		}
	}
	else {
		// remove cookies
		removeCookies( $conn );
	}

	// Close connection
	$conn->close();
}
// If you are logged in an there are no cookies set
else if ( isLoggedIn() && !(isset($_COOKIE['user-id']) && isset($_COOKIE['user-authentication'])) ) {

	// Connect to database
	include $path . "assets/php/connect-database.php";

	// Remove them
	removeCookies( $conn );

	// Create new onces
	createCookies( $conn );

	// Close connection
	$conn->close();
}

// Method for creating new cookies
function createCookies( $conn ) {
	// Create an authentication
	$authentication = '';
	for ( $i = 0; $i < 50; $i++ ) {
		$authentication .= chr( rand(65, 90) );
		$authentication .= chr( rand(97, 122) );
	}
	$authentication .= $_SESSION['user-id'];
	for ( $i = 0; $i < 50; $i++ ) {
		$authentication .= chr( rand(65, 90) );
		$authentication .= chr( rand(97, 122) );
	}

	$rememberDays = 90;

	// Create the cookies
	setcookie('user-id', $_SESSION['user-id'], time() + (86400 * $rememberDays), '/');
	setcookie('user-authentication', $authentication, time() + (86400 * $rememberDays), '/');

	// Send information to database
	$createdDate = date('Y-m-d');
	$expireDate = date('Y-m-d', strtotime('+ '.$rememberDays.' days'));

	$stmt = $conn->prepare('INSERT INTO remember (account_id, authentication, created_date, expire_date) VALUES (?, ?, ?, ?);');
	$stmt->bind_param('isss', $_SESSION['user-id'], $authentication, $createdDate, $expireDate);
	$stmt->execute();

	$stmt->close();
}

// Method for removing cookies
function removeCookies( $conn ) {
	// Remove from database
	if ( isset($_COOKIE['user-id']) && isset($_COOKIE['user-authentication']) ) {
		$stmt = $conn->prepare('DELETE FROM remember WHERE account_id = ? AND authentication = ?');
		$stmt->bind_param('is', $_COOKIE['user-id'], $_COOKIE['user-authentication']);
		$stmt->execute();
		$stmt->close();
	}

	// Remove them from local cookie-jar :)
	setcookie('user-id', '', time() - 3600, '/');
	setcookie('user-authentication', '', time() - 3600, '/');

}

?>