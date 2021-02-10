<?php
	include 'util.php';

	$inData = getRequestInfo();
	
	checkContact($inData["firstName"], $inData["lastName"], $inData["phone"],
				 $inData["email"], $inData["address"], $inData["city"], 
				 $inData["state"], $inData["zip"]);
				 
	$uid = $inData["uid"];
	$cid = $inData["cid"];
	$firstName = $inData["firstName"];
	$lastName = $inData["lastName"];
	$phone = $inData["phone"];
	$email = $inData["email"];
	$address = $inData["address"];
	$city = $inData["city"];
	$state = $inData["state"];
	$zip = $inData["zip"];

	$conn = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");
	if ($conn->connect_error)  {
		returnWithError($conn->connect_error);
	} 
	else {
		$sql = "UPDATE Contacts
				SET firstName = '" . $firstName .
				"', lastName = '" . $lastName . 
				"', phone = '" . $phone .
				"', email = '" . $email . 
				"', address = '" . $address . 
				"', city = '" . $city . 
				"', state = '" . $state . 
				"', zip = '" . $zip . "'" . 
				"WHERE cid = " . $cid . ";";

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {	
			returnWithInfoContact($uid, $cid,
						   		  $firstName, $lastName,
						   		  $phone, $email,
								  $address, $city,
								  $state, $zip);
		}
		else {
			returnWithError("No Records Found");
		}

		$conn->close;
	}
?>