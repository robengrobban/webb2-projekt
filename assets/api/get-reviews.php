<?php
$path = "../../";
include $path."assets/php/main-include.php";

include $path . "assets/php/connect-database.php";

$stmt = $conn->prepare("SELECT review.id, review.content, account.firstname, profile_picture.file FROM review LEFT JOIN account ON review.account_id = account.id LEFT JOIN profile_picture ON review.account_id = profile_picture.account_id;");
$stmt->execute();

$result = $stmt->get_result();
$stmt->close();
if ( $result->num_rows == 0 ) {
	http_response_code(404);
	$conn->close();
	return;
}

$result = $result->fetch_all(MYSQLI_ASSOC);

header("Content-type: application/json");
http_response_code(200);
echo json_encode($result, JSON_UNESCAPED_UNICODE);

$conn->close();

?>