<?php
    $inData = getRequestInfo();

    $id = 0;
    $firstName = "";
    $lastName = "";

    $connection = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");

    if ($connection->connect_error) {
        returnWithError($connection->connect_error);
    } else {
        $sql = "SELECT uid, firstName, lastName FROM Users where Login='" . $inData["login"] . "' and Password='" . $inData["password"] . "'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $firstName = $row["firstName"];
            $lastName = $row["lastName"];
            $id = $row["uid"];


            returnWithInfo($firstName, $lastName, $id);
        } else returnWithError("No record found");

        $connection->close();
    }

    function getRequestInfo() {
        return json_decode(file_get_contents('php://input'), true);
    }

    function sendResultInfoAsJSON($obj) {
        header('Content-type: application/json');
        echo $obj;
    }

    function returnWithError($error) {
        $returnValue = '{"id": ' . ', "firstName": ' . ', "lastName": ' . ', "error": ' . $error;
        sendResultInfoAsJSON($returnValue);
    }

    function returnWithInfo($firstName, $lastName, $id) {
        $returnValue = '{"id": ' . $id . ', "firstName": ' . $firstName . ', "lastName": ' . $lastName . '"error":""'};
        sendResultInfoAsJSON($returnValue);
    }

?>