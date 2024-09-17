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

// If a user is logged in, display their username
$userLoggedIn = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Get search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Sanitize search query to prevent SQL injection
$searchQuery = $conn->real_escape_string($searchQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Posting Website</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>101 Bulletin Board</h1>
</header>

<nav>
    <a href="#home">Home</a>
    <a href="#lost-and-found">Lost and Found</a>
    <a href="#donation">Donation</a>
    <a href="#new-post">New Post</a>
    
    <?php if ($userLoggedIn): ?>
        <a href="logout.php">Log out</a>
        <div class="user-info">Welcome, <?= htmlspecialchars($userLoggedIn) ?>!</div>
    <?php else: ?>
        <a href="#login">Log in</a>
        <a href="#sign-up">Sign up</a>
    <?php endif; ?>
    
    <!-- Search Form -->
    <form action="index.php" method="get" class="search-form">
        <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($searchQuery) ?>">
        <button type="submit">Search</button>
    </form>
</nav>



<!-- Home Section: Display all posts -->
<div class="container" id="home">
    <h2 style="text-align: center;">Home</h2>
    <p>Welcome to 101 bulletin board! Here you can see all the posts from students and post whatever you like for free!</p>
    <div class="posts-cards" id="postsCards">
        <?php
        // Fetch all regular posts with title, text, image, author, and created_at
        $sql = "SELECT title, text, image, author, created_at FROM posts WHERE lost_and_found = 0";
        if ($searchQuery) {
            $sql .= " AND (title LIKE '%$searchQuery%' OR text LIKE '%$searchQuery%' OR author LIKE '%$searchQuery%')";
        }
        $sql .= " ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>
                    <div class='post-content'>
                        <h3>" . htmlspecialchars($row['title']) . "</h3>
                        <p>" . htmlspecialchars($row['text']) . "</p>
                    </div>
                    <div class='post-image'>";
                
                if ($row['image']) {
                    echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Post Image'>";
                }
                
                echo "</div>
                    <p class='post-author'>
                        Posted by: " . htmlspecialchars($row['author']) . 
                        " on " . htmlspecialchars(date("F j, Y, g:i a", strtotime($row['created_at']))) . 
                    "</p>
                </div>";
            }
        } else {
            echo "<p>No posts available.</p>";
        }
        ?>
    </div>
</div>

<!-- Lost and Found Section -->
<div class="container" id="lost-and-found">
    <h2 style="text-align: center;">Lost and Found</h2>
    <p>Find or report lost items here.</p>
    <div class="posts-cards" id="lostAndFoundCards">
        <?php
        // Fetch lost and found posts with title, text, image, author, and created_at
        $sql = "SELECT title, text, image, author, created_at FROM posts WHERE lost_and_found = 1";
        if ($searchQuery) {
            $sql .= " AND (title LIKE '%$searchQuery%' OR text LIKE '%$searchQuery%' OR author LIKE '%$searchQuery%')";
        }
        $sql .= " ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>
                    <div class='post-content'>
                        <h3>" . htmlspecialchars($row['title']) . "</h3>
                        <p>" . htmlspecialchars($row['text']) . "</p>
                    </div>
                    <div class='post-image'>";
                
                if ($row['image']) {
                    echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Post Image'>";
                }
                
                echo "</div>
                    <p class='post-author'>
                        Posted by: " . htmlspecialchars($row['author']) . 
                        " on " . htmlspecialchars(date("F j, Y, g:i a", strtotime($row['created_at']))) . 
                    "</p>
                </div>";
            }
        } else {
            echo "<p>No lost and found posts available.</p>";
        }
        ?>
    </div>
</div>

<!-- Donation Section -->
<div class="container" id="donation">
    <h2 style="text-align: center;">Donation</h2>
    <p>Thank you for your kindly help! Your donations help keep the website running.</p>
    <div class="donation-container">
        <img src="uploads/smallqrcode.jpg" alt="Donation QR Code" width="200" height="200">
    </div>
</div>

<!-- New Post Section: Only visible if the user is logged in -->
<?php if ($userLoggedIn): ?>
    <div class="container" id="new-post">
        <h2 style="text-align: center;">Create a New Post</h2>
        <form class="post-form" action="submit_post.php" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="5" required></textarea>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <label>
                <input type="checkbox" id="lostAndFound" name="lost-and-found" value="1"> Mark as Lost and Found
            </label>

            <input type="submit" value="Post">
        </form>
    </div>
<?php else: ?>
    <div class="container" id="new-post">
        <p>You must be logged in to create a post. <a href="#login">Log in here</a>.</p>
    </div>
<?php endif; ?>

<!-- Login Section -->
<div class="container" id="login">
    <h2 style="text-align: center;">Log In</h2>
    <form class="log-in-form" action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Log In">
    </form>
    <p>Don't have an account? <a href="#sign-up">Sign Up</a></p>
</div>

<!-- Sign Up Section -->
<div class="container" id="sign-up">
    <h2 style="text-align: center;">Sign Up</h2>
    <form class="sign-up-form" action="sign_up.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>

        <input type="submit" value="Sign Up">
    </form>
    <p>Already have an account? <a href="#login">Log In</a></p>
</div>

<footer>
    <p>&copy; 2024 101 bulletin board. Contact us on WeChat at 18210047821.</p>
</footer>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
