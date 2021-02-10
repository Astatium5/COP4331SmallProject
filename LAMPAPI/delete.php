<?php
    include 'util.php';
    include 'classes/contact.php';

    $inData = getRequestInfo();

    $cid = $inData["cid"];
    
	$conn = db_connection();

    if ($connection->connect_error) {
        returnWithError($connection->connect_error);
    } else {
        $sql = "DELETE FROM CONTACTS WHERE cid = " . $cid . ";";

        $result = $connection->query($sql);
        $connection->close;
    }
?>