<!DOCTYPE HTML>
<html><head><title>Edit Member</title> </head>
<body>
 
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
 
if (mysqli_connect_errno()) {
  echo  "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
  exit; 
}
 

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid memberID</h2>"; 
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
       $msg .= 'Invalid member ID';
       $id = 0;  
    }   

       $firstname = clean_input($_POST['firstname']); 

       $lastname = clean_input($_POST['lastname']);        

       $email = clean_input($_POST['email']);        

       $username = clean_input($_POST['username']);        
    

    if ($error == 0 and $id > 0) {
        $query = "UPDATE member SET first_name=?,last_name=?,email=? WHERE memberID=? ";
        $stmt = mysqli_prepare($db_connection, $query); 
        mysqli_stmt_bind_param($stmt,'ssssi', $firstname, $lastname, $email,$username,$id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>Member details updated.</h2> ";
    }
	else
	{ 
      echo "<h2>$msg</h2>";
    }
}

$query = "SELECT memberid,first_name,last_name,email FROM member WHERE memberid=".$id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0)
{
  $row = mysqli_fetch_assoc($result);
?>
<h1>Member update</h1>
<h2><a href='listmembers.php'>[Return to the member listing]</a></h2>
 
<form method="POST" action="editmember.php">
 
  <input type="hidden" name="id" value="<?php echo $id;?>">
  <p>
    <label for="firstname">First name: </label>
 
    <input type="text" id= "firstname" name="firstname" minlength= "5" 
           maxlength="50" required value="<?php echo $row['firstname']; ?>"> 
  </p> 
  <p>
    <label for= "lastname">Last name: </label>
 
    <input type= "text" id= "lastname" name="lastname" minlength= "5" 
           maxlength="50" required value="<?php echo $row['lastname']; ?>">
  </p>  
  <p>  
    <label for="email">Email: </label>
 
    <input type="email" id="email" name="email" maxlength= "100" 
           size="50" required value="<?php echo $row['email']; ?>">
   </p>
  <p>
    <label for="username">Username: </label>
 
    <input type="text" id= "username" name="username" minlength= "8" 
           maxlength="32" required value="<?php echo $row['username']; ?>">
  </p> 
   <input type= "submit" name= "submit" value= "Update">
 </form>
 

<?php 
}
else
{ 
  echo  "<h2>Member not found with that ID</h2> "; 
}
mysqli_close($db_connection); 
?>
</body>
</html>