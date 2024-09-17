<?php
session_start();

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
$pass = $_POST['password'];

// Fetch user record from database
$sql = "SELECT password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("Username not found.");
}

$stmt->bind_result($hashedPass);
$stmt->fetch();

// Verify password
if (password_verify($pass, $hashedPass)) {
    $_SESSION['username'] = $user;
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Log In Success</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .message { border: 1px solid #4CAF50; color: #4CAF50; padding: 20px; display: inline-block; border-radius: 5px; }
        a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class='message'>
        <h2>Log In Successful!</h2>
        <p>Welcome back, $user! <a href='index.php'>Go back to the main page</a>.</p>
    </div>
</body>
</html>";
} else {
    echo "Invalid password.";
}

$stmt->close();
$conn->close();
?>
