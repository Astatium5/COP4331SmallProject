<?php
    include 'util.php';

    $inData = getRequestInfo();
    echo $inData["login"] . $inData["password"];

	$login = $inData["login"];
    $password = $inData["password"];
    $uid = 0;
    $firstName = "";
    $lastName = "";

	checkUser($login, $password, "", "");

	$conn = db_connection();

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
