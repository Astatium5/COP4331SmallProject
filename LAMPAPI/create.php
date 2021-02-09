<?php
	include 'util.php';
	include 'classes/contact.php';

	$inData = getRequestInfo();
	
	try {
		$contact = new Contact($inData["uid"], 0, $inData["firstName"], $inData["lastName"],
							$inData["phone"], $inData["email"], $inData["address"], 
							$inData["city"], $inData["state"], $inData["zip"]);
	} catch (Exception $e) {
		echo 'Caught message: ', $e->getMessage(), '\n';
		returnWithError($e->getMessage());
	}

	$conn = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");

	if ($conn->connect_error) {
		returnWithError( $conn->connect_error );
	}
	else {
		$sql = "insert into CONTACTS (uid, firstName, lastName, phone, email, address, city, state, zip) VALUES 
		(`" . $contact.get_firstName() . "`, `". $contact.get_lastName() . "`, `" . $contact.get_phone() . "`, `" . $contact.get_email() . "`, `" 
		. $contact.get_address() . "`, `" . $contact.get_city() . "`, `" . $contact.get_state() . "`, `" . $contact.get_zip() . "`);";

		if($result = $conn->query($sql) != TRUE)
		{
			returnWithError($conn->error);
		}
		
		$conn->close();
	}
?>