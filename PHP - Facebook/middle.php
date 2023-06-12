<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<style>
		/* Set default styles for body and container */
		body {
			background-color: #f2f2f2;
			margin: 0;
			padding-top: 80px; /* Adjust this value to match the height of your fixed navbar */
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

        $uploads_result = mysqli_query($conn, "SELECT * FROM uploads ORDER BY post_date DESC");

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