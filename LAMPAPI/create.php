<?php
	include 'util.php';

	$inData = getRequestInfo();

	checkContact($inData["firstName"], $inData["lastName"], $inData["phone"],
				 			 $inData["email"], $inData["address"], $inData["city"], 
				 			 $inData["state"], $inData["zip"]);
				 
	$uid = $inData["uid"];
	$cid = 0;
	$firstName = $inData["firstName"];
	$lastName = $inData["lastName"];
	$phone = $inData["phone"];
	$email = $inData["email"];
	$address = $inData["address"];
	$city = $inData["city"];
	$state = $inData["state"];
	$zip = $inData["zip"];

	$conn = db_connection();

	if ($conn->connect_error) {
		returnWithErrorContact($conn->connect_error);
	} else {
		$sql = "insert into CONTACTS (uid, firstName, lastName, phone, email, address, city, state, zip) VALUES 
		('" . $uid . ", " . $firstName . "', '". $lastName . "', '" . $phone . "', '" . $email . "', '" 
		. $address . "', '" . $city . "', '" . $state . "', '" . $zip . "');";

		if ($result = $conn->query($sql) != TRUE) {
			returnWithErrorContact($conn->error);
		} else {
			$sql = "SELECT LAST_INSERT_ID();";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$cid = $row["cid"];
			returnWithInfoContact($uid, $cid, "", "", "", "", "", "", "", "", "");
		}
		
		$conn->close;
	}
?>