<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
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

        .right-section input[type="text"],
        .right-section input[type="number"],
        .right-section input[type="email"],
        .right-section input[type="tel"],
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
		.right-section label[for="dob"] {
			font-size: 16px;
			margin-bottom: 10px;
		}

		.right-section input[type="date"] {
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			box-sizing: border-box;
			border: none;
			border-radius: 5px;
		}
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <h1>Welcome to MyFacebook</h1>
        </div>
        <div class="right-section">
            <h1>Create Account</h1>
            <form method="POST" action="sucess.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
				<label for="dob">Date of Birth:</label>
				<input type="date" id="dob" name="dob" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="cpassword" name="cpassword" placeholder="Enter your password again" required>
		<input type="submit" value="Submit">
	</form>
</body>
</html>
