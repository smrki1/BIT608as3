<!DOCTYPE HTML>
<html><head><title>List Bookings</title> </head>
<body>
 
<?php
include "config.php"; 
session_start();





$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
if (mysqli_connect_errno())
{
    echo  "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit;
}
mysqli_query($db_connection, "USE motueka");
$query = "SELECT bookingID, roomID, customerID, checkin, checkout, email,bookingextras,room FROM booking ORDER BY bookingID";
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result); 
?>
 
<h1>Booking List</h1>
<h2><a href='index.php'>[Back to home page]</a></h2>
<h2>Booking count <?php echo $rowcount; ?></h2>
<!-- <h2><a href='registermember.php'>[Create new member]</a></h2> -->
<table border= "1">
<thead><tr><th>Checkin date</th><th>Checkout date</th><th>Email</th><th>Booking extras</th><th>Room</th><th>Actions</th></tr></thead> 
 

<?php

if ($rowcount > 0)
{  
 
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['bookingID'];    
        echo '<tr><td>'.$row['checkin'].'</td><td>'.$row['checkout'].'</td><td>'.$row['email'].'</td><td>'.$row['bookingextras'].'</td><td>'.$row['room'].'</td>';
        echo '<td><a href= "viewbooking.php?id='.$id.' ">[view]</a>';
        echo '<a href= "editbooking.php?id='.$id.' ">[edit]</a>';
        echo '<a href= "deletebooking.php?id='.$id.' ">[delete]</a></td>';
        echo '</tr>';
   }
} 
else
{
    echo "<h2>No booking found!</h2> "; 
}
mysqli_free_result($result); 
mysqli_close($db_connection);
?>
 
</table>
</body>
</html>