<?php
$conn = mysqli_connect("localhost", "root", "", "testdb");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $education = $_POST['education'];

    // Validation
    if ($name == "" || $email == "" || $gender == "" || $education == "") {
        echo "All fields are required.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }
    $query = "INSERT INTO registration(name, email, gender, education)
              VALUES ('$name', '$email', '$gender', '$education')";

    if (mysqli_query($conn, $query)) {
        echo "Registration successful.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>




<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <h2>Registration</h2>

    <form method="post" action="">
        Name: <input type="text" name="name"><br><br>
        Email: <input type="text" name="email"><br><br>

        Gender:
        <input type="radio" name="gender" value="Male"> Male
        <input type="radio" name="gender" value="Female"> Female
        <input type="radio" name="gender" value="Other"> Other
        <br><br>

        Education:
        <select name="education">
            <option value="">--Select--</option>
            <option value="High School">High School</option>
            <option value="Bachelor">Bachelor</option>
            <option value="Master">Master</option>
        </select>
        <br><br>

        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>

