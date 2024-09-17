<?php
session_start();

// Check if the user is already signed in
if (isset($_SESSION['username'])) {
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Already Signed In</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .message { border: 1px solid #4CAF50; color: #4CAF50; padding: 20px; display: inline-block; border-radius: 5px; }
        a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class='message'>
        <h2>You are already signed in!</h2>
        <p>You are already signed in. <a href='index.php'>Go back to the main page</a>.</p>
    </div>
</body>
</html>";
    exit();
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "101bbs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];
$confirmPass = $_POST['confirmPassword'];

// Check if passwords match
if ($pass !== $confirmPass) {
    die("Passwords do not match.");
}

// Hash the password
$hashedPass = password_hash($pass, PASSWORD_DEFAULT);

// Insert new user
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user, $email, $hashedPass);

if ($stmt->execute()) {
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Sign Up Success</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .message { border: 1px solid #4CAF50; color: #4CAF50; padding: 20px; display: inline-block; border-radius: 5px; }
        a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class='message'>
        <h2>Sign Up Successful!</h2>
        <p>Your account has been created successfully. <a href='index.php'>Go back to the main page</a>.</p>
    </div>
</body>
</html>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
