<?php
    include 'util.php';

    $inData = getRequestInfo();
	checkUser(" ", " ", $inData["login"], $inData["password"]);

	$login = $inData["login"];
    $password = $inData["password"];
    $uid = 0;
    $firstName = "";
    $lastName = "";

    $connection = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");

    if ($connection->connect_error) {
        returnWithError($connection->connect_error);
    } else {
        $sql = "SELECT uid, firstName, lastName FROM Users where 
        login='" . $login . "' and password='" . $password . "';";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $firstName = $row["firstName"];
            $lastName = $row["lastName"];
            $uid = $row["uid"];

            returnWithInfoUser($login, $firstName, $lastName, $uid);
        } else returnWithError("The account with the given login and password does not exist.");

        $connection->close();
    }
?>
