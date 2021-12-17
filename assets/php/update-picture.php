<?php

$path = "../../";
include $path."assets/php/main-include.php";

// Check if there exists a name search
$existsPicture = isset($_FILES['picture']);

if ( isLoggedIn() && $existsPicture ) {

	$imageFileType = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));

	$targetDirectory = "assets/uploads/";
	$targetFile = "user-".$_SESSION['user-id'].".".$imageFileType;

	$canUpload = true;
	$errorMessage = "";

	// Control Image
	$imageCheck = getimagesize($_FILES['picture']['tmp_name']);
	if ( $imageCheck == false ) {
		$canUpload = false;
		$errorMessage = "Filtypen stöds inte. ";
	}

	// Control Image Size 1MB
	$imageSize = 1 * 1000000;
	if ( $_FILES['picture']['size'] > $imageSize ) {
		$canUpload = false;
		$errorMessage = "File är för stor. Inte mer än 1MB. ";
	}

	if ( $canUpload ) {

		include $path . "assets/php/connect-database.php";

		// Get any already existing pictures
		$stmt = $conn->prepare("SELECT * FROM profile_picture WHERE account_id = ?");
		$stmt->bind_param("i", $_SESSION['user-id']);
		$stmt->execute();

		$existingOldPicture = $stmt->get_result()->num_rows != 0;
		$stmt->close();

		// Upload image
		if ( move_uploaded_file($_FILES['picture']['tmp_name'], $path . $targetDirectory . $targetFile) ) {
			// Remove old image
			if ( $existingOldPicture ) {

				$stmt = $conn->prepare("DELETE FROM profile_picture WHERE account_id = ?");
				$stmt->bind_param("i", $_SESSION['user-id']);
				$stmt->execute();

			}
			$stmt = $conn->prepare("INSERT INTO profile_picture (account_id, file, extension) VALUES (?,?,?)");
			$stmt->bind_param("iss", $_SESSION['user-id'], $targetFile, $imageFileType);
			$stmt->execute();

			header("Location: " . $path . "konto/");
		}
		else {
			header("Location: " . $path . "konto/?error-picture-message=Kunde inte uppdatera bilden, var vänligen och försök igen senare.#upload-profile-picture");
		}
	}
	else {
		header("Location: " . $path . "konto/?error-picture-message=".$errorMessage."#upload-profile-picture");
	}
}
else {
	header("Location: " . $path . "konto/");
}

?>