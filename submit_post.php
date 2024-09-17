<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die("You must be logged in to post.");
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $lostAndFound = isset($_POST['lost-and-found']) ? 1 : 0;
    $image = null;
    $author = $_SESSION['username'];  // Get the logged-in username from the session

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if file is a real image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Move the uploaded file to the server
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]);
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }

    // Insert post into the database, including the author
    $sql = "INSERT INTO posts (title, text, image, author, lost_and_found, created_at) VALUES ('$title', '$content', '$image', '$author', '$lostAndFound', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to the homepage after successful submission
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
