<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            height: 100vh;
        }

        .left-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 70%;
            background-color: #3b5998;
            color: #fff;
            padding: 40px;
            box-sizing: border-box;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
        }

        .left-section h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .left-section p {
            font-size: 24px;
            line-height: 1.5;
            margin-top: 20px;
        }

        .left-section img {
            right: 0;
            bottom: 0;
            width: 10%;
        }

        .right-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 30%;
            padding: 40px;
            box-sizing: border-box;
            margin-left: 70%;
        }

        .right-section h1 {
            font-size: 32px;
            margin-bottom: 28px;
        }

        .right-section form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .right-section label {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .right-section input[type="email"],
        .right-section input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: none;
            border-radius: 5px;
        }

        .right-section input[type="submit"] {
            background-color: #3b5998;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .right-section input[type="submit"]:hover {
            background-color: #2d4373;
        }

        .not-registered {
            font-size: 14px;
            margin-top: 20px;
            text-align: center;
        }

        .not-registered a {
            color: #3b5998;
            text-decoration: none;
        }

        .not-registered a:hover {
            color:#42a1f5;
            transition:2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
           
            <h1>Welcome to My Facebook</h1>
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
        img:hover {
        transform: scale(1.1); /* increase scale to zoom in more */
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
        </div>
        <div class="right-section">
            <h1>Login Here</h1>
            <?php if(isset($_GET['status']) && $_GET['status']=='failed') { ?>
            <p style="color:red">Wrong Email or Password</p>
            <?php } ?>
            <form method="POST" action="verify.php">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <p class="not-registered">Not a User? <a href="signup.php" target="_self">Create Account</a></p>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>
