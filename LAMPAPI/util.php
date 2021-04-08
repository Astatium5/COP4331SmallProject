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
	
	// sends the info about a user in a JSON package to front end
 	function returnWithInfoUser($uid, $login, $password, $firstName, $lastName, $error) {
		$obj = createObjectUser($uid, $login, $password, $firstName, $lastName, $error);

		$json = json_encode($obj);
    		sendResultInfoAsJSON($json);
	}
	
	// sends the info about a contact in a JSON package to front end
	function returnWithInfoContact($uid, $cid, $firstName, $lastName, $phone, $email,
				       $address, $city, $state, $zip, $error) {

		$obj = createObjectContact($uid, $cid, $firstName, $lastName, $phone, $email,
					   $address, $city, $state, $zip, $error);

		$json = json_encode($obj);
		sendResultInfoAsJson($json);
	}

	// returns an error in case a user json should be returned
	function returnWithErrorUser($error) {
		returnWithInfoUser(-1, "", "", "", "", $error);
		die(1);
	}

	// returns an error in case a user json should be returned
	function returnWithErrorContact($error) {
		returnWithInfoContact(-1, -1, "", "", "", "", "", "", "", "", $error);
		die(1);
	}

	// creates an object with info about a contact
	function createObjectContact($uid, $cid, $firstName, $lastName, $phone, $email,
				     $address, $city, $state, $zip, $error) {
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
		$obj->error = $error;

		return $obj;
	}

	// creates an object with user info
	function createObjectUser($uid, $login, $password, $firstName, $lastName, $error) {
		$obj->uid = $uid;
		$obj->login = $login;
		$obj->password = $password;
		$obj->firstName = $firstName;
		$obj->lastName = $lastName;
		$obj->error = $error;

		return $obj;
	}

	function checkUser($login, $password, $firstName, $lastName) {
		if (strlen($login) >= 20)
			returnWithErrorUser("The login is invalid.");
		else if (strlen($password) >= 70 || $password == NULL)
			returnWithErrorUser("The password is invalid.");
		else if (strlen($firstName) >= 30 || $firstName == NULL)
			returnWithErrorUser("The first name is invalid.");
		else if (strlen($lastName) >= 30 || $lastName == NULL)
			returnWithErrorUser("The last name is invalid.");
	}

	function checkContact($firstName, $lastName, $phone, $email, $address,
			      $city, $state, $zip) {
		if (strlen($firstName) >= 30 || $firstName == NULL)
			returnWithErrorContact("The contact first name is invalid.");
		else if (strlen($lastName) >= 30 || $lastName == NULL)
			returnWithErrorContact("The contact last name is invalid.");
		else if (strlen($phone) >= 15)
			returnWithErrorContact("The contact phone is invalid.");
		else if (strlen($email) >= 20)
			returnWithErrorContact("The contact email is invalid.");
		else if (strlen($address) >= 100)
			returnWithErrorContact("The contact adress is invalid.");
		else if (strlen($city) >= 20)
			returnWithErrorContact("The contact city is invalid.");
		else if (strlen($state) >= 20)
			returnWithErrorContact("The contact state is invalid.");
		else if (strlen($zip) >= 7)
			returnWithErrorContact("The contact zip is invalid.");
	}

	function db_connection() {
		return new mysqli("localhost", "root", "COP4331Team21", "COP4331");
	} 
?>
