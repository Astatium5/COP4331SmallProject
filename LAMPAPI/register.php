<?php
	include 'util.php';
	include 'classes/user.php';

	$inData = getRequestInfo();
	
	try {
		$user = new User(0, $inData["firstName"], $inData["lastName"], 
						$inData["login"], $inData["password"]);
	} catch (Exception $e) {
		echo 'Caught Exception: ', $e->getMessage(), "\n";
		returnWithError($e->getMessage());
	}
	
	$conn = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");

	if ($conn->connect_error) {
		returnWithError($conn->connect_error);
	} else {
		$sql = "insert into USERS (firstName, lastName, login, password) VALUES ('" . $user.get_firstName() . 
		"', '". $user.get_lastName() . "', '" . $user.get_login() . "', '" . $user.get_password() . "')";

		if($result = $conn->query($sql) != TRUE) {
			returnWithError($conn->error);
		}
		
		$conn->close();
	}
?>