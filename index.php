<!DOCTYPE HTML>
<html>
<head>
<title>Member menu</title>    
</head>
<body>
<h1>Member Menu</h1>
<?php
session_start(); 
$_SESSION['loggedin'] = false;  
 $_SESSION['email'] = ''; 
 $_SESSION['role'] = 0;
?>
<p>
<h2><a href='registermember.php'>New Member Registration</a></h2>
</p>

<p>
<h2><a href='login.php'>Login to make a booking</a></h2>
</p>
<p>
<h2><a href='listbookings.php'>Bookings page. View, edit or delete bookings. Admin only!</a></h2>
</p>

<p>
<h2><a href='logout.php'>Logout</a></h2>
</p>
</body>
</html>