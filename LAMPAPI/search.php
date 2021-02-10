<?php
    include 'util.php';
    
    $inData = getRequestInfo();

    $searchResults = array();
    $searchCount = 0;

	$conn = db_connection();
    
    if ($conn->connect_error) {
        returnWithError($conn->connect_error);
    } else {
        $sql = "SELECT * FROM Contacts WHERE lastName LIKE '%" 
        . $inData["lastName"] . "%' OR firstName LIKE '%" 
        . $inData["firstName"] . "%' AND uid=" . $inData["uid"] . ";";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $searchResults[$searchCount] = createJSONContact($row["uid"], $row["cid"],
                                                                 $row["firstName"], $row["lastName"], 
                                                                 $row["phone"], $row["email"],
                                                                 $row["address"], $row["city"],
                                                                 $row["state"], $row["zip"]);
                $searchCount++;
            }
        } else {
            returnWithError("No records found");
        }

        $conn->close();
    }

    sendResultInfoAsJSON(json_encode($searchResults));
?>