<?php

	$inData = getRequestInfo();
	
	$firstName = $inData["registerFirst"];
	$lastName = $inData["registerLast"];
	$login = $inData["registerName"];
	$password = $inData["registerPassword"];
	
	$conn = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");

	if ($conn->connect_error) 
	{
		returnWithError($conn->connect_error);
	} 
	else
	{
		$sql = "insert into USERS (firstName, lastName, login, password) VALUES ('" . $firstName . "','". $lastName . "','" . $login . "', '" . $password . "')";
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