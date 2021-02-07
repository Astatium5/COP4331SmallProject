<?php
    include 'util.php';
    include 'classes/contact.php';
    
    $inData = getRequestInfo();

    $searchResults = array();
    $searchCount = 0;

    $conn = new mysqli("localhost", "Team21", "COP433121Team", "COP4331");
    
    if ($conn->connect_error) {
        returnWithError($conn->connect_error);
    } else {
        $sql = "SELECT * FROM Contacts WHERE lastName LIKE '%" 
        . $inData["searchLastName"] . "%' OR firstName LIKE '%" 
        . $inData["searchFirtName"] . "%' AND UserID=" . $inData["uid"] . ";";

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