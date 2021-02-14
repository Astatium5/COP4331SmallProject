<?php
    include 'util.php';

    $inData = getRequestInfo();

    $cid = $inData["cid"];
    
	$connecttion = db_connection();

    if ($connection->connect_error) {
        returnWithErrorContact($connection->connect_error);
    } else {
        $sql = "DELETE FROM CONTACTS WHERE cid = " . $cid . ";";

        $result = $connection->query($sql);
        
        // actually returns no error
        returnWithErrorContact("");
        $connection->close;
    }
?>