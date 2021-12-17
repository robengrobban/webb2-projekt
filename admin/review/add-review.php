<?php
$path = "../../";

include $path . "assets/php/main-include.php";

header("Content-type: text/plain");

$existsAccount = keyDataExists($_POST, 'account');
$existsContent = keyDataExists($_POST, 'content');

if ( isAdmin($path) && $existsAccount && $existsContent ) {

	$inputAccount = clearData($_POST['account']);
	$inputContent = clearData($_POST['content']);

	// Check if a contact exists with that id
	include $path . "assets/php/connect-database.php";

	$stmt = $conn->prepare("INSERT INTO review (account_id, content) VALUES (?,?)");
	$stmt->bind_param("is", $inputAccount, $inputContent);
	$stmt->execute();

	$insertedId = $stmt->insert_id;
	$stmt->close();

	$conn->close();

	echo "En ny recension har skapats med id #" . $insertedId;

}
else {
	echo "All information var inte satt för att skapa recension.";
}

?>