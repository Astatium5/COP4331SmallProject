<?php
    include 'util.php';
    
    $inData = getRequestInfo();

    $searchResults = array();
    $searchCount = 0;

	$conn = db_connection();
    
    if ($conn->connect_error) {
        returnWithErrorContact($conn->connect_error);
    } else {
        $sql = "SELECT * FROM CONTACTS WHERE lastName LIKE '%" 
        . $inData["search"] . "%' OR firstName LIKE '%" 
        . $inData["search"] . "%' AND uid=" . $inData["uid"] . ";";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $searchResults[$searchCount] = createObjectContact($row["uid"], $row["cid"],
                                                                   $row["firstName"], $row["lastName"], 
                                                                   $row["phone"], $row["email"],
                                                                   $row["address"], $row["city"],
                                                                   $row["state"], $row["zip"], "");
                $searchCount++;
            }
        } else {
            returnWithErrorContact("No records found");
        }

        $conn->close();
    }

    sendResultInfoAsJSON(json_encode($searchResults));
?>