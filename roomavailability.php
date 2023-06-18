<?php
include "config.php"; 

/*include 'checksession.php'; 
checkLoggedIn(); */
 


$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
if (mysqli_connect_errno())
{
    echo  "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit;
}


$searchStr = $_GET['searchfor'];


$sql = "SELECT room.roomID, roomname, roomtype, beds FROM room 
LEFT JOIN booking ON booking.roomID = room.roomID 
WHERE (booking.checkin IS NULL OR booking.checkout IS NULL OR (NOT (booking.checkin <= CURDATE() AND booking.checkout >= CURDATE()))) 
AND roomname LIKE ?";

$stmt = $db_connection->prepare($sql);


$searchStr = "%" . $searchStr . "%"; 
$stmt->bind_param("s", $searchStr);
$stmt->execute();

$result = $stmt->get_result();
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}


header('Content-type: application/json');
echo json_encode($data);
?>
