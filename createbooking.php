<!DOCTYPE HTML>
<html>
<head>
    
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <title>Create a booking</title> 

</head>
 <body>

<?php

include 'checksession.php'; 
checkLoggedIn(); 
//loginStatus(); 
include "config.php";
include "cleaninput.php";

if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Add')) {
     include_once "config.php"; //load in any variables
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
        exit; //stop processing the page further
    };


    $error = 0; 
    $msg = 'Error: ';


     //checkindate     
     if (isset($_POST['checkin']) and !empty($_POST['checkin']) and is_string($_POST['checkin'])) 
     {       $checkin = clean_input($_POST['checkin']);     } 
     else {       $error++; //bump the error flag       
        $msg .= 'Invalid checkin '; //append eror message      
         $checkin = '';     }

 
       $email = clean_input($_POST['email']);    

       $bookingextras = clean_input($_POST['bookingextras']); 

        $roomID = clean_input($_POST['roomID']);
        $customerID = clean_input($_POST['customerID']);
        $room = clean_input($_POST['room']);
        $checkin = DateTime::createFromFormat('m/d/Y', clean_input($_POST['checkin']))->format('Y-m-d');
        $checkout = DateTime::createFromFormat('m/d/Y', clean_input($_POST['checkout']))->format('Y-m-d');
         
  // Room ID
 // $room_ID = cleanInput($_POST['room_ID']); 
  //customer ID
        // $customer_ID = cleanInput($_POST['customer_ID']);         

        //save the room data if the error flag is still clear
    if ($error == 0) {
        mysqli_query($db_connection, "USE unaux_34388954_motuekabit");
        $query = "INSERT INTO booking (roomID,customerID,checkin,checkout,email,bookingextras,room) VALUES (?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($db_connection, $query); //prepare the query
        mysqli_stmt_bind_param($stmt,'iisssss', $roomID,$customerID, $checkin, $checkout, $email,$bookingextras,$room); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>New booking added </h2>";        
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
    mysqli_close($db_connection); //close the connection once done
}
?>
<h2><a href='index.php'>[Return to the main page]</a></h2>


<h1>Add a new booking</h1>

</p>
  

<!--  <p><span>Checkin  (dd-mm-yyyy)</span><input type="text" id="checkin" name = "checkin" required></p>  
<p><span> Checkout (dd-mm-yyyy) </span><input type="text" id="checkout" name = "checkout"required></p>-->

<script>
    $(document).ready(function() {
        $("#checkin").datepicker({
            minDate: 0,
            onSelect: function(selectedDate) {
                $("#checkout").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#checkout").datepicker({
            minDate: 1,
            onSelect: function(selectedDate) {
                $("#checkin").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>

<p>


<form method="POST" action="createbooking.php">
<p>
    <label for="checkin">Checkin: </label>
    <input type="text" id="checkin" name="checkin" minlength="1" maxlength="50" required> 
  </p> 

  <p>
    <label for="checkout">Checkout: </label>
    <input type="text" id="checkout" name="checkout" minlength="1" maxlength="50" required> 
  </p> 
<p>
    <label for="roomID">Room ID: </label>
    <input type="text" id="roomID" name="roomID" minlength="1" maxlength="50" required> 
  </p> 
  <p>
    <label for="customerID">customerID: </label>
    <input type="text" id="customerID" size="20" name="customerID" minlength="1" maxlength="200" required> 
  </p>  

  <p>
    <label for="email">Email: </label>
    <input type="email" id="email" name="email" required> 
  </p> 
  <p>
    <label for="bookingextras">booking extras: </label>
    <input type="text" id="bookingextras" size="100" name="bookingextras" minlength="5" maxlength="200" required> 
  </p>
  <p>
     <?php
include_once "config.php"; 
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
if (mysqli_connect_errno()) {
    echo  "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
  }
$mysql = NEW mysqli('sql201.unaux.com','unaux_34388954','udmchyo4ppb61z','unaux_34388954_motuekabit');
$result = $mysql->query("SELECT roomname FROM room");

?>
     <label for="room">room: </label> 
    <!-- <input type="text" id="room" size="50" name="room" minlength="5" maxlength="30" required>  -->
 

  <select name="room" 

<?php
while($rows=$result->fetch_assoc())
{
    $room=$rows['roomname'];
    echo "<option value='$room'>$room</option>";
}
?>

</select>
</p>  
   <input type="submit" name="submit" value="Add">
 </form>





</body>
</html>
  