<!DOCTYPE HTML><html>
<head>    <title>View Booking</title></head>
<body>
    <h1>View booking</h1>    <h2><a 
href='listbookings.php'>[Return to the bookings listing]</a></h2>
    <?php    
    include "config.php"; 
    


include "cleaninput.php";
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);   
     if (mysqli_connect_errno())        
     {            
      echo  "Error: Unable to connect to MySQL. ".mysqli_connect_error(); 
                 exit;        
                }  
  if($_SERVER["REQUEST_METHOD"]=="GET")    
  {         
    $id = $_GET['id']; 
        if(empty($id) or !is_string($id))        
         {            
          echo "<h2>Invalid booking ID</h2>";            
          exit;         
        }   
       }
       mysqli_query($db_connection, "USE motueka");
     
       $query = "SELECT bookingID, roomID, customerID, email, checkin, checkout, bookingextras,room FROM booking WHERE bookingID=".$id;   
       $result = mysqli_query($db_connection, $query); 
      $row_count= mysqli_num_rows($result);
    
 
 if($row_count > 0)    
  {               
    echo "<fieldset>    <legend>Booking ID#$id</legend>    <dl>";     
$row = mysqli_fetch_assoc($result); 
        echo "<dt>bookingID:</dt>        <dd>".$row['bookingID']."</dd>";                
        echo "<dt>roomID:</dt>        <dd>".$row['roomID']."</dd>";               
        echo "<dt>customerID:</dt>        <dd>".$row['customerID']."</dd>";     
        
        echo "<dt>checkin:</dt>        <dd>".$row['checkin']."</dd>";
        echo "<dt>checkout:</dt>        <dd>".$row['checkout']."</dd>";  

        echo "<dt>email:</dt>        <dd>".$row['email']."</dd>";                       
        echo "<dt>bookingextras:</dt>        <dd>".$row['bookingextras']."</dd>";               
        echo "<dt>room:</dt>        <dd>".$row['room']."</dd>";
        echo "</dl></fieldset>";    
}        

mysqli_free_result($result);

   
mysqli_close($db_connection); 
?>
</body>
</html>