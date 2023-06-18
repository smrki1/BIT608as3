<!DOCTYPE HTML>
<html><head><title>Delete Member</title> </head>
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
 

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $id = $_GET['id'];
    if(empty($id) or !is_numeric($id))
	{
        echo "<h2>Invalid memberID</h2> "; 
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
        $msg .= 'Invalid member ID '; 
        $id = 0;  
    }        
    
    if($error == 0 and $id > 0)
	{
        $query = "DELETE FROM member WHERE memberID=?";
        $stmt = mysqli_prepare($db_connection, $query); 
        mysqli_stmt_bind_param($stmt,'i', $id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>Member details deleted.</h2>";        
    }
	else
	{ 
      echo  "<h2>$msg</h2>";
    }      
}
 

$query = 'SELECT * FROM member WHERE memberid='.$id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result); 
?>
<h1>Member details</h1>
<h2><a href='listmembers.php'>[Return to the member listing]</a></h2>
 
<?php
 

if ($rowcount > 0) {  
   echo "<fieldset><legend>Member detail #$id</legend><dl> "; 
   $row = mysqli_fetch_assoc($result);
   echo "<dt>First name:</dt><dd> ".$row['firstname']."</dd> ";
   echo "<dt>Last name:</dt><dd>".$row['lastname']."</dd> ";
   echo "<dt>Email:</dt><dd>".$row['email']. "</dd>";
   echo "<dt>Username:</dt><dd>".$row['username']."</dd> ";
   echo "<dt>Password:</dt><dd>".$row['password']."</dd> "; 
   echo "<dt>Role:</dt><dd>".$row['role']."</dd>";  
   echo "</dl></fieldset>";  
   ?>
<form method= "POST" action= "deletemember.php">
     <h2>Are you sure you want to delete this member?</h2>
 
     <input type= "hidden" name= "id" value= "<?php echo $id; ?>">
     <input type= "submit" name= "submit" value= "Delete">
     <a href= "listmembers.php">[Cancel]</a>
     </form>
 
<?php    
} 
else
{
    echo  "<h2>No member found, possibly deleted!</h2>"; 
}
mysqli_free_result($result); 
mysqli_close($db_connection); 
?>
</table>
</body>
</html>