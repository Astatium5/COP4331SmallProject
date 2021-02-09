<?php
    include 'util.php';

    $inData = getRequestInfo();

    $results = array();
    $resCount = 0;
    $uid = $inData["uid"];

    $conn = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");
    
    if ($conn->connect_error) {
        returnWithError($conn->connect_error);
    } else {
        $sql = "SELECT * FROM CONTACTS WHERE uid=" . $uid . ";";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $results[$resCount] = createJSONContact($row["uid"], $row["cid"],
                                                        $row["firstName"], $row["lastName"], 
                                                        $row["phone"], $row["email"],
                                                        $row["address"], $row["city"],
                                                        $row["state"], $row["zip"]);
                $resCount++;
            }
        } else {
            returnWithError("No records found");
        }

        $conn->close();
    }

    sendResultInfoAsJSON(json_encode($results));
?>