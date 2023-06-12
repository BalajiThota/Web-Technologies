<?php
// Connect to the MySQL database
$host = "localhost"; // Replace with your host
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "login_page"; // Replace with your database name
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to create the likes table
$sql = "CREATE TABLE uploads (
  key_id INT AUTO_INCREMENT PRIMARY KEY,
  id INT,
  post_text VARCHAR(255),
  profile_pic VARCHAR(255),
  post_date DATETIME
);
";

// Execute the SQL query
if (mysqli_query($conn, $sql)) {
    echo "Table likes created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>