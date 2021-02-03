<?php

	$inData = getRequestInfo();
	
	$firstName = $inData["contactFirstName"];
	$lastName = $inData["contactLastName"];
	$phone = $inData["phone"];
	$email = $inData["email"];
	$address = $inData["address"];
	$city = $inData["city"];
	$state = $inData["state"];
	$zip = $inData["zip"];

	$conn = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$sql = "insert into CONTACTS (firstName, lastName, phone, email, address, city, state, zip) VALUES ('" . $firstName . "','". $lastName . "','" . $phone . "', '" . $email . "', '" . $address . "', '" . $city . "', '" . $state . "', " . $zip . ")";
		if($result = $conn->query($sql) != TRUE)
		{
			returnWithError($conn->error);
		}
		$conn->close();
	}
	
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>