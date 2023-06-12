<!DOCTYPE html>
<html>
<head>
    <title>Top 3 Liked Photos</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .post {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }
        .post img {
            width: 300px;
            height: 300px;
            object-fit: cover;
        }
        .like_count {
            font-size: 24px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Connect to the database
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "login_page";
        $conn = new mysqli($host, $username, $password, $dbname);

        // Query the database to get the top 3 liked photos
        $result = mysqli_query($conn, "SELECT u.key_id, u.id, u.post_text, u.profile_pic, COUNT(*) AS like_count
                                       FROM uploads AS u
                                       INNER JOIN likes AS l ON u.key_id = l.key_id
                                       GROUP BY u.key_id
                                       ORDER BY like_count DESC
                                       LIMIT 3");
    
        // Display the top 3 liked photos
        while ($row = mysqli_fetch_assoc($result)) {
            $profile_pic = ($row['profile_pic'] != '') ? 'uploads/' . $row['profile_pic'] : 'default.png';
            echo "<div class='post'>";
            echo "<img src='$profile_pic'>";
            echo "<div class='like_count'>{$row['like_count']} likes</div>";
            echo "</div>";
        }
    
        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>    