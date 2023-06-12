<?php
session_start();
// Connect to the database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "login_page";

$conn = new mysqli($host, $username, $password, $dbname);

// Retrieve user's profile picture from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT profile_pic FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
// $profile_pic = $row['profile_pic'];

if ($row['profile_pic'] != '') {
	$profile_pic = 'uploads/' . $row['profile_pic'];
  } else {
	$profile_pic = 'default.png';
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>View Profile</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		/* body {
			margin: 0;
			padding: 0;
			margin-left:450px;
		}
		.container {
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			height: 100vh;
			background-color: #f2f2f2;
		}
		img {
			max-width: 40%;
			height: auto;
			margin-bottom: 30px;
		}
		.back-btn {
			margin-left:270px;
			background-color: #4287f5;
			border: none;
			color: white;
			padding: 10px 20px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			border-radius: 5px;
			cursor: pointer;
		}
		.back-btn:hover {
			background-color: #3e8e41;
		} */
	</style>
</head>
<body>
	<div>
		<img src="<?php echo $profile_pic; ?>" alt="Profile Picture" style="max-width: 100%;" width="60%">
	</div>
	<div>
		<button class="back-btn" onclick="goBack()">GO BACK</button>
	</div>

	<script>
		// Go back to the dashboard page when the back button is clicked
		function goBack() {
			window.location.href = "dashboard.php";
		}

		// Automatically go back to the dashboard page after 10 seconds
		setTimeout(function() {
			goBack();
		}, 10000);
	</script>
</body>
</html>
