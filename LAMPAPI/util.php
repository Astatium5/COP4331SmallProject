<?php
	// getting data from JSON sent from front end
	function getRequestInfo() {
		return json_decode(file_get_contents('php://input'), true);
	}

	// sending the information from back end to front end in the JSON format
	function sendResultInfoAsJSON($obj) {
		header('Content-type: application/json');
		echo $obj;
	}
	
	// returning from back end with error
	function returnWithError($err) {
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
    }
	
	// sends the info about a user in a JSON package to front end
    function returnWithInfoUser($login, $firstName, $lastName, $uid) {
		$obj->login = $login;
		$obj->uid = $uid;
		$obj->firstName = $firstName;
		$obj->lastName = $lastName;

		$json = json_encode($obj);
        sendResultInfoAsJSON($json);
	}
	
	// sends the info about a contact in a JSON package to front end
	function returnWithInfoContact($uid, $cid, $firstName, $lastName, $phone, $email,
								   $address, $city, $state, $zip) {
		$obj->uid = $uid;
		$obj->cid = $cid;
		$obj->firstName = $firstName;
		$obj->lastName = $lastName;
		$obj->phone = $phone;
		$obj->email = $email;
		$obj->address = $address;
		$obj->city = $city;
		$obj->state = $state;
		$obj->zip = $zip;

		$json = json_encode($obj);
		sendResultInfoAsJson($json);
	}

	// creates a JSON with info about a contact
	function createJSONContact($uid, $cid, $firstName, $lastName, $phone, $email,
							   $address, $city, $state, $zip) {
		$obj->uid = $uid;
		$obj->cid = $cid;
		$obj->firstName = $firstName;
		$obj->lastName = $lastName;
		$obj->phone = $phone;
		$obj->email = $email;
		$obj->address = $address;
		$obj->city = $city;
		$obj->state = $state;
		$obj->zip = $zip;

		return $obj;
	}
?>
