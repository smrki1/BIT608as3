<!DOCTYPE HTML>
<html><head><title>Delete Booking</title> </head>
 <body>
 
<?php

include "config.php"; 

/*include 'checksession.php'; 
checkLoggedIn(); 

if(!isAdmin()) 
{ 
    
    header('Location: http://localhost/demo/notallowed.php');  
    exit(); 
}*/
include "cleaninput.php";
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
 

if (mysqli_connect_errno()) {
    echo  "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; 
}
 

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $id = $_GET['id'];
    if(empty($id) or !is_numeric($id))
	{
        echo "<h2>Invalid booking ID</h2> "; 
        exit;
    } 
}
 
if (isset($_POST['submit']) and !empty($_POST['submit']) 
    and ($_POST['submit'] == 'Delete'))
{     
    $error = 0; 
    $msg = 'Error: ';  
    if (isset($_POST['id']) and !empty($_POST['id']) 
        and is_integer(intval($_POST['id'])))
	{
        $id = clean_input($_POST['id']); 
    }
	else
	{
        $error++; 
        $msg .= 'Invalid booking ID '; 
        $id = 0;  
    }        
    
    if($error == 0 and $id > 0)
	{
        mysqli_query($db_connection, "USE motueka");
        $query = "DELETE FROM booking WHERE bookingID=?";
        $stmt = mysqli_prepare($db_connection, $query); 
        mysqli_stmt_bind_param($stmt,'i', $id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>Booking deleted.</h2>";        
    }
	else
	{ 
      echo  "<h2>$msg</h2>";
    }      
}
 
       mysqli_query($db_connection, "USE motueka");

$query = 'SELECT * FROM booking WHERE bookingid='.$id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result); 
?>
<h1>Booking details</h1>
<h2><a href='listbookings.php'>[Return to the booking listing]</a></h2>
 
<?php
 

if ($rowcount > 0) {  
   echo "<fieldset><legend>Booking detail #$id</legend><dl> "; 
   $row = mysqli_fetch_assoc($result);
   echo "<dt>Checkin date:</dt><dd> ".$row['checkin']."</dd> ";
   echo "<dt>Checkout date:</dt><dd>".$row['checkout']."</dd> ";
   echo "<dt>Email:</dt><dd>".$row['email']. "</dd>";
   echo "<dt>Booking extras:</dt><dd>".$row['bookingextras']."</dd> ";
   echo "<dt>Room:</dt><dd>".$row['room']."</dd> "; 
   echo "</dl></fieldset>";  
   ?>
<form method= "POST" action= "deletebooking.php">
     <h2>Are you sure you want to delete this booking?</h2>
 
     <input type= "hidden" name= "id" value= "<?php echo $id; ?>">
     <input type= "submit" name= "submit" value= "Delete">
     <a href= "listbookings.php">[Cancel]</a>
     </form>
 
<?php    
} 
else
{
    echo  "<h2>No booking found, possibly deleted!</h2>"; 
}
mysqli_free_result($result); 
mysqli_close($db_connection); 
?>
</table>
</body>
</html>