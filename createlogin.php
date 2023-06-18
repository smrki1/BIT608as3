<?php
include "config.php"; 

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

$query = "INSERT INTO member (first_name, last_name, email, password, role) VALUES (?,?,?,?,?)"; 
$stmt = mysqli_prepare($db_connection, $query);  
$password="temp1234"; 
$hashed_password = password_hash($password, PASSWORD_DEFAULT); 
$firstname = "S"; 
$lastname = "M"; 
$email = "mrkflux@gmail.com"; 
$role = 9; 
mysqli_stmt_bind_param($stmt,'ssssi', $firstname, $lastname, $email, $hashed_password, $role);  
mysqli_stmt_execute($stmt); 
$firstname = "Ordinary"; 
$lastname = "Member"; 
$email = "amember@amember.co.nz"; 
$role = 1; 
mysqli_stmt_bind_param($stmt,'ssssi', $firstname, $lastname, $email, $hashed_password, $role);  
mysqli_stmt_execute($stmt); 
mysqli_stmt_close($stmt);
?>