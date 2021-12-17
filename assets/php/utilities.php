<?php
function isLoggedIn(): bool
{
	return (isset($_SESSION['user-id']));
}

function clearData($data): string
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function sendEmail($to, $title, $message, $headers = array('Content-type: text/html;charset=UTF-8\r\nContent-Transfer-Encoding: 8bit')): bool
{
	$from = "stinkyboomerbrain@gmail.com";
	$head = "From: TuffeTuffeTåg <" . $from . ">\r\n";
	foreach ($headers as $header) {
		$head .= $header . "\r\n";
	}
	return mail($to, $title, $message, $head);
}

function keyDataExists($array, $key): bool
{
	return isset($array[$key]) && trim($array[$key]) != "";
}

function isAdmin($path): bool
{
	include $path . "assets/php/connect-database.php";
	$stmt = $conn->prepare("SELECT COUNT(*) FROM admin WHERE account_id = ?");
	$stmt->bind_param("i", $_SESSION['user-id']);
	$stmt->execute();

	$isAdmin = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["COUNT(*)"] == 1;

	$stmt->close();
	$conn->close();

	return $isAdmin;
}

function splitIntoParam($data): array
{
	$body = explode("&", $data);
	$params = array();
	foreach ($body as $param) {
		$pair = explode("=", $param);
		$params[$pair[0]] = $pair[1];
	}
	return $params;
}

?>