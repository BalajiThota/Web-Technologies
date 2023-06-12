<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "login_page";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "SELECT * FROM registration WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $_SESSION['email'] = $email;
    header("Location: dashboard.php");
    
} else {
    header("Location: login.php?status=failed");
}
mysqli_close($conn);
?>


