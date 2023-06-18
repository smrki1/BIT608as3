<!DOCTYPE HTML>
<html><head><title>Member List</title> </head>
<body>
 
<?php

include "config.php"; 
include "checksession.php";

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
if (mysqli_connect_errno())
{
    echo  "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit;
}
$query = "SELECT memberID, first_name, last_name FROM member ORDER BY last_name";
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result); 
?>
 
<h1>Member List</h1>
 
<h2>Member count <?php echo $rowcount; ?></h2>
<h2><a href='registermember.php'>[Create new member]</a></h2>
<table border= "1">
<thead><tr><th>First name</th><th>Last name</th><th>Actions</th></tr></thead>
 

<?php

if ($rowcount > 0)
{  
 
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['memberID'];    
        echo '<tr><td>'.$row['first_name'].'</td><td>'.$row['last_name'].'</td>';
        echo '<td><a href= "viewmember.php?id='.$id.' ">[view]</a>';
        echo '<a href= "editmember.php?id='.$id.' ">[edit]</a>';
        echo '<a href= "deletemember.php?id='.$id.' ">[delete]</a></td>';
        echo '</tr>';
   }
} 
else
{
    echo "<h2>No members found!</h2> "; 
}
mysqli_free_result($result); 
mysqli_close($db_connection);
?>
 
</table>
</body>
</html>

