<?php
	include 'util.php';

	echo 'test';
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

	$conn = db_connection();
	if ($conn->connect_error) {
		returnWithErrorContact($conn->connect_error);
	} else {
		$sql = "SELECT * FROM CONTACTS WHERE cid=" . $cid . ";";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$currentFirstName = $row["firstName"];
			$currentLastName = $row["larstName"];
			$currentPhone = $row["phone"];
			$currentEmail = $row["email"];
			$currentAddress = $row["address"];
			$currentCity = $row["city"];
			$currentState = $row["state"];
			$currentZip = $row["zip"];

			if ($currentFirstName != $firstName && $firstName == "") {
				$firstName = $currentFirstName;
			}

			if ($currentLastName != $lastName && $lastName == "") {
				$lastName = $currentLastName;
			}

			if ($currentPhone != $phone && $phone == "") {
				$phone = $currentPhone;
			}

			if ($currentEmail != $email && $email == "") {
				$email = $currentEmail;
			}

			if ($currentAddress != $address && $address == "") {
				$address = $currentAddress;
			}

			if ($currentCity != $city && $city == "") {
				$city = $currentCity;
			}

			if ($currentState != $state && $state == "") {
				$state = $currentState;
			}

			if ($currentZip != $zip && $zip == "") {
				$zip = $currentZip;
			}
		}
	}

	
	$sql = "UPDATE CONTACTS
					SET firstName = '" . $firstName .
					"', lastName = '" . $lastName . 
					"', phone = '" . $phone .
					"', email = '" . $email . 
					"', address = '" . $address . 
					"', city = '" . $city . 
					"', state = '" . $state . 
					"', zip = '" . $zip . "'" . 
					"WHERE cid = " . $cid . ";";

	if ($result = $conn->query($sql) != TRUE) {
		returnWithErrorContact("No Records Found");
	} else {
		returnWithInfoContact($uid, $cid, $firstName, $lastName, $phone, 
													$email, $address, $city, $state, $zip, "");
	}
		
	conn->close();
?>