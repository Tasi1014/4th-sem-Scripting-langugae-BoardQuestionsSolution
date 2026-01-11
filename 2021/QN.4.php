<!-- Write PHP function that accepts username and password as arguments and check with student table, 
 if credential match, redirect to dashboard page otherwise display 'Invalid username/password'. -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
    <form method="post">
  Username: <input type="text" name="username"><br>
  Password: <input type="password" name="password"><br>
  <button name="login">Login</button>
</form>

</body>
</html>

<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "Scripting_2025";

$conn = new mysqli($host, $username, $password, $db);
if(!$conn){
    die("Connection Error".$conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    function checkLogin($username, $password, $conn) {
    $sql = "SELECT * FROM student WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid username/password";
    }
}

    $u = $_POST['username'];
    $p = $_POST['password'];
    checkLogin($u, $p, $conn);
}
?>