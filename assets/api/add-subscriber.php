<?php
$path = "../../";
include $path."assets/php/main-include.php";

// Check if it is a PUT request
$request = $_SERVER['REQUEST_METHOD'];
$params = splitIntoParam(file_get_contents('php://input'));

$existsEmail = keyDataExists($params, 'email');

if ( strcmp($request, 'POST') === 0 && $existsEmail ) {

	// Get input
	$inputEmail = clearData($params['email']);

	// Check if email already exists
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT COUNT(*) FROM subscriber WHERE email = ?");
	$stmt->bind_param("s", $inputEmail);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]['COUNT(*)'];
	$stmt->close();

	if ( $result == 0 ) {

		// Add email
		$stmt = $conn->prepare("INSERT INTO subscriber (email) VALUES (?)");
		$stmt->bind_param("s", $inputEmail);
		$stmt->execute();

		$stmt->close();
		$conn->close();

		// Set response
		http_response_code(200);
		header("Content-type: application/json");
		echo json_encode(array());

		// Send email
		$msg = "
	<html>
	<head>
		<style>
* {
	padding: 0;
	margin: 0;
	box-sizing: border-box;
	font-family: 'Open Sans', sans-serif;
}
html {
	font-size: 16px;
}
@media only screen and (min-width: 2500px) {
    html {
        font-size:24px
    }
}

@media only screen and (min-width: 3000px) {
    html {
        font-size:32px
    }
}
.mark {
    display: block;
    margin: 1rem 1rem;
    width: 5rem;
    height: 0.25rem;
    background-color: #2dbd2d;
}
.max-content {
    max-width:90rem;
}
.center-content {
    margin-left:auto;
    margin-right:auto;
}
.center-text {
    text-align: center;
}
.brand-color {
    color: #2dbd2d !important;
}
.brand-background-color {
    background-color: #2dbd2d !important;
}
		</style>
	</head>
	<body>
	<main>
		<article class='header-container max-content center-content'>
			<header>
				<h1>Tack för din prenumeration!</h1>
			</header>
			<div class='mark'></div>
			<p>Du kommer nu få email uppdateringar från TuffeTuffeTåg. Dessa uppdateringar kan vara kampanjer för resor, andra erbjudanden eller när det händer viktiga saker.</p>		
		</article>
	</main>
	</body>
	</html>
    ";

		sendEmail($inputEmail, "Tack för din prenumeration!", $msg);

		return;

	}
	else {
		http_response_code(409);
		return;
	}

}
else {
	// The request was bad
	http_response_code(400);
	return;
}

?>