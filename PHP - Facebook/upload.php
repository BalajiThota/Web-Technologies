<?php
session_start();
$user_id = $_SESSION['user_id'];

$host = "localhost";
$username = "root";
$password = "";
$dbname = "login_page";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get caption and image file from POST data
  $caption = $_POST['caption'];
  $image = $_FILES['image']['name'];

  // Check if image file was uploaded successfully
  if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($_FILES['image']['name']);

    // Move uploaded image to server directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
      // Insert new upload record into database
      $conn = mysqli_connect($host, $username, $password, $dbname);
      $stmt = $conn->prepare("INSERT INTO uploads (id, post_text, profile_pic,post_date) VALUES (?, ?, ?, NOW())");
      $stmt->bind_param('iss', $user_id, $caption, $image);
      $stmt->execute();

      // Redirect to dashboard on successful upload
      header('Location: dashboard.php');
      exit();
    } else {
      echo 'Error uploading file.';
    }
  } else {
    echo 'Error uploading file.';
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Upload Image</title>
	<style type="text/css">
		body {
			background-color: #f2f2f2;
			font-family: Arial, sans-serif;
		}

		form {
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
			margin: 50px auto;
			max-width: 500px;
		}

		h2 {
			text-align: center;
			margin-top: 0;
		}

		label {
			display: block;
			font-weight: bold;
			margin-bottom: 10px;
		}

		input[type="text"],
		input[type="file"] {
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 3px;
			width: 100%;
			margin-bottom: 20px;
		}

		input[type="submit"] {
			background-color: #4CAF50;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			width: 100%;
		}

		input[type="submit"]:hover {
			background-color: #45a049;
		}
	</style>
</head>
<body>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<h2>Upload Image</h2>
		<label for="caption">Caption:</label>
		<input type="text" id="caption" name="caption" placeholder="Enter caption...">

		<label for="image">Picture:</label>
		<input type="file" id="image" name="image">

		<input type="submit" name="submit" value="Upload">
	</form>
</body>
</html>

