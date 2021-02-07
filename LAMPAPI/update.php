<?php
	include 'classes/contact.php';
	include 'util.php';

	$inData = getRequestInfo();
	
	try {
		$contact = new Contact($inData["uid"], $inData["cid"], $inData["firstName"],
							   $inData["lastName"], $inData["phone"], $inData["email"],
							   $inData["address"], $inData["city"], $inData["state"],
							   $inData["zip"]);
	} catch (Exception $e) {
	    echo 'Caught Exception: ', $e->getMessage(), '\n';
	    returnWithError($e->getMessage());
	}

	$conn = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError($conn->connect_error);
	} 
	else
	{
		$sql = "UPDATE Contacts
				SET firstName = `" . $contact.get_firstName() .
				"`, lastName = `" . $contact.get_lastName() . 
				"`, phone = `" . $contact.get_phone() .
				"`, email = `" . $contact.get_email() . 
				"`, address = `" . $contact.get_address() . 
				"`, city = `" . $contact.get_city() . 
				"`, state = `" . $contact.get_state() . 
				"`, zip = `" . $contact.get_zip() . "`" . 
				"WHERE cid = " . $contact.get_cid() . ";";

		$result = $conn->query($sql);

		if ($result->num_rows > 0)
		{	
			returnWithInfoContact($contact.get_uid(), $contact.get_cid(),
						   		  $contact.get_firstName(), $contact.get_lastName(),
						   		  $contact.get_phone(), $contact.get_email(),
								  $contact.get_address(), $contact.get_city(),
								  $contact.get_state(), $contact.get_zip());
		}
		else
		{
			returnWithError("No Records Found");
		}

		$conn->close();
	}
?>