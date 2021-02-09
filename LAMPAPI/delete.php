<?php
    include 'util.php';
    include 'classes/contact.php';

    $inData = getRequestInfo();

    $cid = $inData["cid"];
    
    $connection = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");

    if ($connection->connect_error) {
        returnWithError($connection->connect_error);
    } else {
        $sql = "DELETE FROM CONTACTS WHERE cid = " . $cid . ";";

        $result = $connection->query($sql);
        $connection->close;
    }
?>