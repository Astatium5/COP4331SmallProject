<?php
	function getRequestInfo() {
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJSON($obj) {
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError($err) {
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
    }
    
    function returnWithInfoUser($firstName, $lastName, $uid) {
		$returnValue = '{"id": "' . $uid . '", "firstName": "' . $firstName . '", "lastName": "' . 
						$lastName . '", error":""}';
        sendResultInfoAsJSON($returnValue);
	}
	
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
		sendResultInfoAsJson($returnValue);
	}

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
