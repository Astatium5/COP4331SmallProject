<?php
    include 'util.php';
    include 'classes/user.php';

    $inData = getRequestInfo();

    try {
        $user = new User(0, "", "", $inData["login"], $inData["password"]);
    } catch (Exception $e) {
	    echo 'Caught Exception: ', $e->getMessage(), '\n';
	    returnWithError($e->getMessage());
    }

    $connection = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");

    if ($connection->connect_error) {
        returnWithError($connection->connect_error);
    } else {
        $sql = "SELECT uid, firstName, lastName FROM Users where 
        login=`" . $user.get_login() . "` and password=`" . $user.get_password() . "`;";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user.set_firstName($row["firstName"]);
            $user.set_lastName($row["lastName"]);
            $user.set_uid($row["uid"]);

            returnWithInfoUser($user.get_login(), $user.get_firstName(), $user.get_lastName(), $user.get_uid());
        } else returnWithError("The account with the given login and password does not exist.");

        $connection->close();
    }
?>
