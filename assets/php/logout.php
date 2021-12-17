<?php
if ( isset($_GET['logout']) ) {

	include $path . 'assets/php/connect-database.php';
	removeCookies( $conn );
	$conn->close();

	session_unset();
	session_destroy();
	header("Location: ?");
}
?>