<?php
// Connection variables
$serverip = "localhost";
$username = "root";
$password = "";
$database = "gesällprov_roen8744";

// Create connection variable
$conn = new mysqli( $serverip , $username , $password , $database );
// Handle connection error
if ( $conn->connect_error ) {
	die();
}
?>