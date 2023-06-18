<!DOCTYPE HTML>
<html>
<head>
    <title>Register Member</title>
</head>
<body>
 
<?php

include "config.php";
include "cleaninput.php";

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}

if (isset($_POST['submit']) && !empty($_POST['submit']) && ($_POST['submit'] == 'Register')) {

    $error = 0; // error flag
    $msg = 'Error: ';

    if (isset($_POST['first_name']) && !empty($_POST['first_name']) && is_string($_POST['first_name'])) {
        $fn = clean_input($_POST['first_name']);
        $firstname = (strlen($fn) > 50) ? substr($fn, 1, 50) : $fn;
    } else {
        $error++;
        $msg .= 'Invalid firstname ';
        $firstname = ' ';
    }

    $lastname = clean_input($_POST['last_name']);
    $email = clean_input($_POST['email']);
    $password = clean_input($_POST['password']);
    $role = 1;

    if ($error == 0) {
        $query = "INSERT INTO member (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($db_connection, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi', $firstname, $lastname, $email, $password, $role);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Member saved</h2>";
    } else {
        echo "<h2>$msg</h2>";
    }

    mysqli_close($db_connection);
}
?>
 
<h1>Member registration</h1>
<h2><a href='index.php'>[Back to home page]</a></h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <p>
        <label for="first_name">First name: </label>
        <input type="text" id="first_name" name="first_name" minlength="5" maxlength="50" required>
    </p>
    <p>
        <label for="last_name">Last name: </label>
        <input type="text" id="last_name" name="last_name" minlength="5" maxlength="50" required>
    </p>
    <p>
        <label for="email">Email: </label>
        <input type="email" id="email" name="email" minlength="5" maxlength="50" required>
    </p>
    <p>
        <label for="password">Password: </label>
        <input type="password" id="password" name="password" minlength="8" maxlength="32" required>
    </p>
    <input type="submit" name="submit" value="Register">
</form>

</body>
</html>

