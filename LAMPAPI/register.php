<?php
	include 'util.php';

	$inData = getRequestInfo();

	checkUser($inData["login"], $inData["password"], $inData["firstName"], $inData["lastName"]);

	$firstName = $inData["firstName"];
	$lastName = $inData["lastName"];
	$login = $inData["login"];
	$password = $inData["password"];
	
	$conn = db_connection();

	if ($conn->connect_error) {
		returnWithError($conn->connect_error);
	} else {
		$sql = "insert into USERS (firstName, lastName, login, password) VALUES ('" . $firstName . 
		"', '". $lastName . "', '" . $login . "', '" . $password . "')";

		if ($result = $conn->query($sql) != TRUE) {
			returnWithError($conn->error);
		}
		
		$conn->close();
	}
?>