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

	function checkUser($login, $password, $firstName, $lastName) {
		if (strlen($login) >= 20)
			returnWithError("The login is invalid. length" . $login);
		else if ($login === NULL)
			returnWithError($login);
			// returnWithError("The login is invalid. null" . $login);
		else if (strlen($password) >= 70 || $password == NULL)
			returnWithError("The password is invalid.");
		else if (strlen($firstName) >= 30 || $firstName == NULL)
			returnWithError("The user first name is invalid.");
		else if (strlen($lastName) >= 30 || $lastName == NULL)
			returnWithError("The user last name is invalid.");
	}

	function checkContact($firstName, $lastName, $phone, $email, $address,
						  $city, $state, $zip) {
		if (strlen($firstName) >= 30 || $firstName == NULL)
			returnWithError("The contact first name is invalid.");
		else if (strlen($lastName) >= 30 || $lastName == NULL)
			returnWithError("The contact last name is invalid.");
		else if (strlen($phone) >= 15 || $phone == NULL)
			returnWithError("The contact phone is invalid.");
		else if (strlen($email) >= 20 || $email == NULL)
			returnWithError("The contact email is invalid.");
		else if (strlen($address) >= 100 || $address == NULL)
			returnWithError("The contact adress is invalid.");
		else if (strlen($city) >= 20 || $city == NULL)
			returnWithError("The contact city is invalid.");
		else if (strlen($state) >= 20 || $state == NULL)
			returnWithError("The contact state is invalid.");
		else if (strlen($zip) >= 7 || $zip == NULL)
			returnWithError("The contact zip is invalid.");
	}

	function db_connection() {
		return new mysqli("localhost", "root", "COP4331Team21", "COP4331");
	} 
?>
