<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "login_page";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_SESSION['email'];
$sql = "SELECT name FROM registration WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$_SESSION['name_of']=$name;

$sql = "SELECT id FROM registration WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$_SESSION['user_id']=$id;

// Get the user's profile picture from the database
$sql = "SELECT profile_pic FROM users WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Check if the user has a profile picture
if (mysqli_num_rows($result) >0 && $row['profile_pic'] != '') {
  $profile_pic = 'uploads/' . $row['profile_pic'];
} else {
  $profile_pic = 'default.png';
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
  
    <style>
        img {
  width: 80%;
  margin-top:8.5px;
  height: 135px;
  border-radius: 10%;
  margin-left:20px;
}
.user {
  display: flex;
  align-items: center;
}

.name {
  margin-left: 20px;
}


        header {
    position:fixed;
    background-size:cover;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 150px;
    background-color: #3b5998;
    color: #fff;
    top:0px;
    right:0px;
    left:0px;
}

.navbar {
    display: flex;
}

.navbar-left {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar-left li {
    margin-right: 20px;
}

.navbar-left li:last-child {
    margin-right: 0;
}

.navbar-left li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
}

.navbar-right {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar-right li {
    margin-left: 20px;
}

.navbar-right li:first-child {
    margin-left: 0;
}

.navbar-right li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 80px);
}

.middle-section {
    text-align: center;
}

.middle-section h1 {
    font-size: 48px;
    margin-bottom: 40px;
}

.logout-btn {
    background-color: transparent;
    border: 2px solid #fff;
    padding: 10px 20px;
    border-radius: 5px;
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: all 0.2s ease-in-out;
}

.logout-btn:hover {
    background-color: #fff;
    color: #333;
}

.logout-img {
    display: inline-block;
    background-image: url("logout.png");
    background-size: contain;
    width: 20px;
    height: 20px;
    margin-right: 10px;
}
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 999;
}

.container {
    margin-top: 100px;
    height: calc(100vh - 100px);
    overflow-y: auto;
}
h1{
    padding-top:420px;
}

    </style>
</head>
<body>
    <header>
        <div class="user">
            <img src="<?php echo $profile_pic; ?>" alt="Profile Picture">
            <h3 class="name"><?php echo $name; ?></h3>
        </div>
        <nav class="navbar">
            <ul class="navbar-left">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="setprfle.php">Set Profile Picture</a></li>
                <li><a href="viewprofile.php">View your profile </a></li><br>
            </ul>
            <ul class="navbar-right">
                <li><a href="upload.php">Upload pic</a></li>
                <li><a href="view_photo.php">View your photo</a></li>
                <li><a href="logout.php" class="logout-btn"><span class="logout-img"></span> Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="middle-section">
            <h1>Welcome <?php echo $name; ?></h1>
            
            <!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<style>
		/* Set default styles for body and container */
		body {
			background-color: #f2f2f2;
			margin: 0;
			padding-top: 160px; /* Adjust this value to match the height of your fixed navbar */
		}
		.container1 {
			max-width: 800px;
			margin: 0 auto;
		}
		/* Style the post and its contents */
		.post {
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 5px;
			padding: 10px;
			margin-bottom: 20px;
		}
		.post b {
			font-weight: bold;
		}
		.post .time {
			font-size: 12px;
			color: #999;
			margin-top: 5px;
		}
		.post img {
			max-width: 100%;
			height: auto;
			display: block;
			margin: 10px auto;
		}
		/* Style the like and comment buttons */
		.actions button {
			border: none;
			background-color: #fff;
			color: #666;
			cursor: pointer;
			font-size: 14px;
			margin-right: 10px;
		}
		.actions button.liked {
			color: #007bff;
		}
		.actions button:hover {
			text-decoration: underline;
		}
		.actions button:focus {
			outline: none;
		}
		/* Set a max-width for the container and center it */
		.container1 {
			max-width: 800px;
			margin: 0 auto;
		}
	</style>
<script>
function likePost(key_id) {
    var like_button = document.getElementById('like_button_'+key_id);
    var like_count = document.getElementById('like_count_'+key_id);

    // Check if the user has already liked the post
    if (like_button.classList.contains('liked')) {
        // Remove the like from the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'unlike.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Decrement the like count
                like_count.innerHTML = parseInt(like_count.innerHTML) - 1;
                // Update the button appearance
                like_button.classList.remove('liked');
                like_button.innerHTML = 'Like ('+like_count.innerHTML+')';
            }
        };
        xhr.send('key_id=' + key_id);
    } else {
        // Add the like to the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'like.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Increment the like count
                like_count.innerHTML = parseInt(like_count.innerHTML) + 1;
                // Update the button appearance
                like_button.classList.add('liked');
                like_button.innerHTML = 'Liked ('+like_count.innerHTML+')';
            }
        };
        xhr.send('key_id=' + key_id);
    }
    // Reload the current page after like or unlike
    location.reload();
}

    </script>
</head>
<body>
    <div class="container1">
        <?php
        // Connect to the database
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "login_page";

        $conn = new mysqli($host, $username, $password, $dbname);
        $userid=$_SESSION['user_id'];
        // $uploads_result = mysqli_query($conn, "SELECT * FROM uploads ORDER BY post_date DESC");
        $uploads_result = mysqli_query($conn, "SELECT * FROM uploads WHERE id = '$userid' ORDER BY post_date DESC");

        // Combine the posts and photos into one array and sort by date
        $combined_array = array();
       
       
        while ($row = mysqli_fetch_assoc($uploads_result)) {
            $combined_array[] = $row;
        }
        usort($combined_array, function($a, $b) {
            return strtotime($b['post_date']) - strtotime($a['post_date']);
        });

        // Display the posts and photos with the username
        foreach ($combined_array as $row) {

            $likes_result = mysqli_query($conn, "SELECT COUNT(*) AS like_count FROM likes WHERE key_id = '{$row['key_id']}'");
            $likes_row = mysqli_fetch_assoc($likes_result);
            $like_count = $likes_row['like_count'];

            $userid = $row['id'];
            $user_result = mysqli_query($conn, "SELECT name FROM registration WHERE id='$userid'");
            $user_row = mysqli_fetch_assoc($user_result);
            $name = $user_row['name'];

            if (isset($row['post_text']) && empty($row['profile_pic'])) {
                // This is a post
                echo "<div class='post'><b>$name:</b> {$row['post_text']}";
                echo "<div class='time'>{$row['post_date']}</div>";
                echo "<div class='actions'><button id='like_button_{$row['key_id']}' onclick='likePost({$row['key_id']})'>Like ($like_count)</button><button>Comment</button></div></div>";
            } else {
                // This is a photo
                if(isset($row['profile_pic'])){
                    if ($row['profile_pic'] != '') {
                        if ($row['profile_pic'] != '') {
                            $profile_pic = 'uploads/' . $row['profile_pic'];
                        } else {
                            $profile_pic = 'default.png';
                        }
                        echo "<div class='post'><b>$name:</b> {$row['post_text']}";
                        echo "<div class='time'>{$row['post_date']}</div>";
                        echo "<img src='$profile_pic'>";
                        echo "<div class='actions'><button id='like_button_{$row['key_id']}' onclick='likePost({$row['key_id']})'>Like ($like_count)</button><button>Comment</button></div></div>";
    
                    } 
                }
            }
        }
        ?>
    </div>
    </html>
        </div>
    </div>
</body>

</html>
