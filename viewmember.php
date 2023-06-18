<!DOCTYPE HTML><html>
<head>    <title>View Member</title></head>
<body>
    <h1>Member registration</h1>    <h2><a 
href='listmembers.php'>[Return to the member listing]</a></h2>
    <?php    
    include "config.php"; 


include 'checksession.php'; 
checkLoggedIn(); 
 
if(!isAdmin()) 
{ 
    
    header('Location: http://localhost/demo/notallowed.php');  
    exit(); 
}   
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
          echo "<h2>Invalid member ID</h2>";            
          exit;         
        }   
       }
  
      
       $query = "SELECT customerID, firstname, lastname, email, password FROM customer WHERE customerID=".$id;   
       $result = mysqli_query($db_connection, $query);
      $row_count= mysqli_num_rows($result);
 
    
 
 if($row_count > 0)    
  {               
    echo "<fieldset>    <legend>Member ID#$id</legend>    <dl>";     
$row = mysqli_fetch_assoc($result); 
        echo "<dt>First name:</dt>        <dd>".$row['firstname']."</dd>";                
        echo "<dt>Last name:</dt>        <dd>".$row['lastname']."</dd>";               
        echo "<dt>Email:</dt>        <dd>".$row['email']."</dd>";                
        echo "<dt>Password:</dt>        <dd>".$row['password']."</dd>";               
        echo "</dl></fieldset>";    
}        

mysqli_free_result($result);

  
mysqli_close($db_connection);   
?>
</body>
</html>