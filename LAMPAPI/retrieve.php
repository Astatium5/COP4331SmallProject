<?php
    include 'util.php';

    $inData = getRequestInfo();

    $results = array();
    $resCount = 0;
    $uid = $inData["uid"];

	$conn = db_connection();
    
    if ($conn->connect_error) {
        returnWithErrorContact($conn->connect_error);
    } else {
        $sql = "SELECT * FROM CONTACTS WHERE uid=" . $uid . ";";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $results[$resCount] = createObjectContact($row["uid"], $row["cid"],
                                                          $row["firstName"], $row["lastName"], 
                                                          $row["phone"], $row["email"],
                                                          $row["address"], $row["city"],
                                                          $row["state"], $row["zip"], "");
                $resCount++;
            }
        } else {
            returnWithErrorContact("No records found");
        }

        $conn->close();
    }

    sendResultInfoAsJSON(json_encode($results));
?>