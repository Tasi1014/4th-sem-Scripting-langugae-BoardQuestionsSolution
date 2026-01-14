<?php
$conn = mysqli_connect("localhost", "root", "", "testdb");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = array();
if (isset($_POST['submit'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $education = trim($_POST['education']);

    // Validation
    
    $nameRegex = '/^[A-Za-z ]{3,30}$/';
    if(empty($name)){
        $errors['name'] = "Name cannot be empty";
    }else if (!preg_match($nameRegex, $name)) {
        $errors['name'] = "Name cannot contain special characters and length should be between 3 to 30 characters.";
    }

    if(empty($email)){
        $errors['email'] = "Email cannot be empty";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email is in invalid Format";
    }

    if(empty($gender)){
        $errors['gender'] = "Gender cannot be empty";
    }

    if(empty($education)){
        $errors['education'] = "Education cannot be empty";
    }

   if(empty($errors)){
     $query = "INSERT INTO registration(name, email, gender, education)
              VALUES ('$name', '$email', '$gender', '$education')";

    if (mysqli_query($conn, $query)) {
        $errors['result'] = "Registration successful.";
    } else {
        $errors['result'] = "Registration unsuccessful.";
    }
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
        Name: <input type="text" name="name" value="<?= $name ?? "" ?>"><br><br>
        <p><?= $errors['name'] ?? "" ?></p>
        Email: <input type="text" name="email" value="<?= $email ?? "" ?>"><br><br>
        <p><?= $errors['email'] ?? "" ?></p>
        <br><br>
        Gender:
        <input type="radio" name="gender" value="Male" <?= ($gender ?? '')=="Male" ? "checked" : ""?> > Male
        <input type="radio" name="gender" value="Female" <?= ($gender ?? '')== "Female" ? "checked" : ""?> > Female
        <input type="radio" name="gender" value="Other" <?= ($gender ?? '') == "Other" ? "checked" : ""?> > Other
        <br><br>
        <p><?= $errors['gender'] ?? "" ?></p>
        <br><br>

        Education:
        <select name="education">
            <option value="">--Select--</option>
            <option value="High School" <?= ($education ?? '') == "High School"? "selected" : ""?>   >High School</option>
            <option value="Bachelor" <?= ($education ?? '')== "Bachelor"? "selected" : ""?>  >Bachelor</option>
            <option value="Master" <?=($education ?? '')== "Master"? "selected" : ""?> >Master</option>
        </select>
        <br><br>
        <p><?= $errors['education'] ?? "" ?></p>
        <br><br>

        <input type="submit" name="submit" value="Register">
        <p><?= $errors['result'] ?? "" ?></p>
    </form>
</body>

</html>