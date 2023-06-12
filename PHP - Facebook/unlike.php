<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get key_id from POST data
$key_id = $_POST['key_id'];

// Connect to the database
$host = "localhost";
$username = "Akil";
$password = "Akilamu@321";
$dbname = "login_page";
$conn = new mysqli($host, $username, $password, $dbname);

// Check if user has already liked the post
$user_id = $_SESSION['name_of'];
$like_result = mysqli_query($conn, "SELECT * FROM likes WHERE key_id = '$key_id' AND u_name = '$user_id'");
if (mysqli_num_rows($like_result) > 0) {
    // User has already liked the post, so remove the like
    mysqli_query($conn, "DELETE FROM likes WHERE key_id = '$key_id' AND u_name = '$user_id'");
}

// Get the updated like count for the post
$likes_result = mysqli_query($conn, "SELECT COUNT(*) AS like_count FROM likes WHERE key_id = '$key_id'");
$likes_row = mysqli_fetch_assoc($likes_result);
$like_count = $likes_row['like_count'];

// Return the updated like count
echo $like_count;
?>
