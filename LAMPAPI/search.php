<?php
    include 'util.php';
    
    $inData = getRequestInfo();

    $uid = $inData["uid"];
    $search = $inData["search"];
    $searchResults = array();
    $searchCount = 0;

    $conn = db_connection();
    
    if ($conn->connect_error) {
        returnWithErrorContact($conn->connect_error);
    } else {
        if ($partial) {
            $sql = "SELECT * FROM CONTACTS WHERE (uid=" 
            . $uid . " AND (firstName LIKE '%" 
            . $search . "%' OR lastName LIKE '%" 
            . $search . "%' OR phone LIKE '%"
            . $search . "%' OR email LIKE '%"
            . $search . "%' OR address LIKE '%"
            . $search . "%' OR city LIKE '%"
            . $search . "%' OR state LIKE '%"
            . $search . "%' OR zip LIKE '%"
            . $search . "%' OR CONCAT(firstName, ' ', lastName) LIKE '%"
            . $search . "%' OR CONCAT(lastName, ' ', firstName) LIKE '%"
            . $search . "%'));";

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