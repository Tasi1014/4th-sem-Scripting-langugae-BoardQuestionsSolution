<?php
// Database connection (adjust credentials)
$conn = mysqli_connect("localhost", "root", "", "testdb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = array();

if (isset($_POST['submit'])) {
    // Trim inputs
    $regno = trim($_POST['regno']);
    $email = trim($_POST['email']);

    // Validate Registration number
    if (empty($regno)) {
        $errors['regno'] = "Registration number is required.";
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    // Validate file upload
    if (!isset($_FILES['myfile']) || $_FILES['myfile']['error'] == 4) {
        $errors['file'] = "Please select a file to upload.";
    } else {
        $fileName = $_FILES['myfile']['name'];
        $fileTmp = $_FILES['myfile']['tmp_name'];
        $fileSize = $_FILES['myfile']['size'];
        $fileType = $_FILES['myfile']['type'];

        // Allowed file types
        $allowedTypes = [
            'application/pdf',
            'application/msword', // doc
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // docx
            'application/vnd.ms-powerpoint', // ppt
            'application/vnd.openxmlformats-officedocument.presentationml.presentation', // pptx
            'image/jpeg'
        ];

        // Maximum size 5MB
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($fileType, $allowedTypes)) {
            $errors['file'] = "Invalid file type! Only PDF, DOC, DOCX, PPT, PPTX, JPEG allowed.";
        }

        if ($fileSize > $maxSize) {
            $errors['file'] = "File size too large! Must be less than 5MB.";
        }
    }

    // If no errors, move file and insert into database
    if (empty($errors)) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . basename($fileName);
        if (move_uploaded_file($fileTmp, $targetFile)) {
            $query = "INSERT INTO registration (regno, email, filename) 
                      VALUES ('$regno', '$email', '$fileName')";
            if (mysqli_query($conn, $query)) {
                $errors['result'] = "Registration successful and file uploaded.";
            } else {
                $errors['result'] = "Database insertion failed.";
            }
        } else {
            $errors['result'] = "File upload failed.";
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form with File Upload</title>
</head>
<body>
    <h2>Registration Form</h2>
    <form method="POST" enctype="multipart/form-data">
        Registration Number: 
        <input type="text" name="regno" value="<?= $regno ?? '' ?>"><br>
        <p style="color:red"><?= $errors['regno'] ?? '' ?></p>

        Email: 
        <input type="text" name="email" value="<?= $email ?? '' ?>"><br>
        <p style="color:red"><?= $errors['email'] ?? '' ?></p>

        Upload File: 
        <input type="file" name="myfile"><br>
        <p style="color:red"><?= $errors['file'] ?? '' ?></p>

        <br>
        <input type="submit" name="submit" value="Register">
        <p style="color:green"><?= $errors['result'] ?? '' ?></p>
    </form>
</body>
</html>
