<!DOCTYPE HTML>
<html>
<head>
<title>Log in</title>
</head>

<body>


<form method="POST" action="login.php"> 
<h1>Customer Login</h1> 
    <label for="username">User name: </label> 
    <input type="email" id="email" size="30" name="email" required>  
  <p> 
    <label for="password">Password: </label> 
    <input type="password" id="password" size="15" name="password" min="10" max="30" required>  
</p> 
<input type = "submit" name="submit" value="Login"> 
</form>

<?php
session_start();
include_once "config.php";
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

if (isset($_POST['email'])) 
    { 
        $email = $_POST['email']; 
        $password = $_POST['password']; 
 

        $stmt = mysqli_stmt_init($db_connection); 
        mysqli_stmt_prepare($stmt, "SELECT memberID, password, role FROM member WHERE email=?"); 
        mysqli_stmt_bind_param($stmt, "s", $email); 
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_bind_result($stmt, $memberID, $hashpassword, $role); 
        mysqli_stmt_fetch($stmt); 
        mysqli_stmt_close($stmt);

        if(!$memberID) 
        { 
            echo '<p class="error">Unable to find member with email: '.$email.'</p>'; 
        } 
        else 
        { 
            if (password_verify($password, $hashpassword)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                $_SESSION['memberID'] = $memberID;
            
                header('Location: http://sbit608.unaux.com/createbooking.php');
                exit();
            } else {
                echo '<p>Username/password combination is wrong!</p>';
            }
            
        } 
    }

 
mysqli_close($db_connection);   
?>
    
</body>

</html>

