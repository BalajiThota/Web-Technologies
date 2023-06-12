<?php
session_start();

// Connect to the database
$host = "localhost";
$username = "Akil";
$password = "Akilamu@321";
$dbname = "login_page";

$conn = new mysqli($host, $username, $password, $dbname);

// Get the key_id and user_id from the AJAX request
$key_id = $_POST["key_id"];
$user_id = $_SESSION["name_of"];

// Check if the user has already liked the post
$check_result = mysqli_query($conn, "SELECT * FROM likes WHERE key_id = '$key_id' AND u_name = '$user_id'");
if (mysqli_num_rows($check_result) > 0) {
  // The user has already liked the post, so unlike it
  mysqli_query($conn, "DELETE FROM likes WHERE key_id = '$key_id' AND u_name = '$user_id'");
  echo "unliked";
} else {
  // The user has not yet liked the post, so like it
  mysqli_query($conn, "INSERT INTO likes (key_id, u_name) VALUES ('$key_id', '$user_id')");
  echo "liked";
}
