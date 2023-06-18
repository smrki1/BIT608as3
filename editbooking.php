<!DOCTYPE HTML>
<html><head><title>Edit Booking</title> </head>
<body>
 
<?php
include "config.php"; 

include 'checksession.php'; 
/*checkLoggedIn(); 
 
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
 

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid booking ID</h2>"; 
        exit;
    } 
}
 

if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
       

    $error = 0; 
    $msg = 'Error: ';  
     

    if (isset($_POST['id']) and !empty($_POST['id']) 
        and is_integer(intval($_POST['id']))) {
       $id = clean_input($_POST['id']); 
    } else {
       $error++; 
       $msg .= 'Invalid booking ID'; 
       $id = 0;  
    }   

       
       $checkin = clean_input($_POST['checkin']);

       $checkout = clean_input($_POST['checkout']);        

       $email = clean_input($_POST['email']);        

       $room = clean_input($_POST['room']);        
    
    if ($error == 0 and $id > 0) {
      mysqli_query($db_connection, "USE motueka");
        $query = "UPDATE booking SET checkin=?,checkout=?,email=?,room=? WHERE bookingID=? ";
        $stmt = mysqli_prepare($db_connection, $query); 
        mysqli_stmt_bind_param($stmt,'ssssi', $checkin, $checkout, $email,$room,$id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>Booking details updated.</h2> ";
    }
	else
	{ 
      echo "<h2>$msg</h2>";
    }
}

mysqli_query($db_connection, "USE motueka");


$query = "SELECT bookingid,checkin,checkout,email,room FROM booking WHERE bookingid=".$id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0)
{
  $row = mysqli_fetch_assoc($result);
?>
<h1>Booking update</h1>
<h2><a href='listbookings.php'>[Return to the booking listing]</a></h2>
 
<form method="POST" action="editbooking.php">
 
  <input type="hidden" name="id" value="<?php echo $id;?>">
  <p>
    <label for="checkin">Checkin: </label>
 
    <input type="text" id= "checkin" name="checkin" minlength= "5" 
           maxlength="50" required value="<?php echo $row['checkin']; ?>"> 
  </p> 
  <p>
    <label for= "checkout">Checkout: </label>
 
    <input type= "text" id= "checkout" name="checkout" minlength= "5" 
           maxlength="50" required value="<?php echo $row['checkout']; ?>">
  </p>  
  <p>  
    <label for="email">Email: </label>
 
    <input type="email" id="email" name="email" maxlength= "100" 
           size="50" required value="<?php echo $row['email']; ?>">
   </p>
  <p>
    <label for="room">Room: </label>
 
    <input type="text" id= "room" name="room" minlength= "8" 
           maxlength="32" required value="<?php echo $row['room']; ?>">
  </p> 
   <input type= "submit" name= "submit" value= "Update">
 </form>
 

<?php 
}
else
{ 
  echo  "<h2>Booking not found with that ID</h2> "; 
}
mysqli_close($db_connection); 
?>
</body>
</html>