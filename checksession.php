<?php
session_start();
function isAdmin() { 
    if ($_SESSION['role'] == 9) 
        return true; 
    else  
        return false; 
   }

function loginStatus() 
{ 
    $customerID = $_SESSION['customerID']; 
    if ($_SESSION['loggedin'] == true) { 
        echo 'Logged in as: ' . $_SESSION['customerID']; 
    } else {
        echo 'No login credentials';             
    }
}



function checkLoggedIn() 
{ 
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['role']) && $_SESSION['role'] == 9) 
       return true; 
    else { 
       header('Location: http://localhost/demo/notallowed.php');  
       exit();       
    }        
}









function logout(){ 
    session_start(); 
    $_SESSION['loggedin'] = false; 
    $_SESSION['email'] = '';         
    $_SESSION['role'] = 0;
    session_destroy(); 
    header('Location: http://localhost/demo/index.php'); 
    exit();   
  }
?>