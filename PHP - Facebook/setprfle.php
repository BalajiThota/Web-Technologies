<?php
// Start the session and check if the user is logged in
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

// Connect to the database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "login_page";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Check if a file has been uploaded
  if (isset($_FILES['image'])) {
    $errors = array();

    // Get the file name and type
    $file_name = $_FILES['image']['name'];
    $file_type = $_FILES['image']['type'];

    // Check if the uploaded file is an image
    if (!getimagesize($_FILES['image']['tmp_name'])) {
      $errors[] = 'The file must be an image';
    }

    // Check if there are any errors
    if (empty($errors)) {
      // Get the user's ID from the session
      $user_id = $_SESSION['user_id'];

      // Generate a unique file name
      $file_name = uniqid() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);

      // Move the uploaded file to the uploads directory
      move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $file_name);

      // Check if the user's profile picture already exists in the database
      $sql = "SELECT * FROM users WHERE id=$user_id";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);

      if ($row['profile_pic'] != '') {
        // Update the user's profile picture in the database
        $sql = "UPDATE users SET profile_pic='$file_name' WHERE id=$user_id";
      } else {
        // Insert the user's ID, username and profile picture into the database
        $sql = "INSERT INTO users (id, profile_pic) VALUES ('$user_id', '$file_name')";
      }

      if ($conn->query($sql) === TRUE) {
        // Redirect to the profile page
        header("Location: dashboard.php");
        exit();
      } else {
        echo "Error updating record: " . $conn->error;
      }
    } else {
      // Display the error messages
      foreach ($errors as $error) {
        echo "<p>$error</p>";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Set Profile Picture</title>
  <style>
    /* Center the form and heading */
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

h1 {
  text-align:center;
  font-size: 36px;
  margin: 20px 0;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 20px auto;
  max-width: 500px;
}

input[type="file"] {
  margin-bottom: 20px;
}

input[type="submit"] {
  background-color: #007bff;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
  font-size: 16px;
  padding: 10px 20px;
  transition: all 0.3s ease;
}

input[type="submit"]:hover {
  background-color: #0062cc;
}


  </style>
</head>
<body>
  <h1>Upload Profile Picture</h1>
  <form action="setprfle.php" method="post" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/jpg"><br>
    <input type="submit" name="submit" value="Submit Picture">
  </form>
</body>
</html>

