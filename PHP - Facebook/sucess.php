<?php
// Define database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_page";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $dob = $reg_no = $gender = $email = $phone_no = "";

    //validate name
    if (empty($_POST["name"])) {
        die("Name is required");
    } else {
        $name = test_input($_POST["name"]);
        // Check if name contains only letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            die("Name should not contain numbers");
        }
    }

    // Validate dob
    if (empty($_POST["dob"])) {
        die("Date of Birth is required");
    } else {
        $dob = test_input($_POST["dob"]);
        $age = date_diff(date_create($dob), date_create('today'))->y;
        // Check if age is over 18
        if ($age < 18) {
            die("You must be over 18 to register");
        }
    }

    // validate email
    if (!empty($_POST["email"])) {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format");
        }
    } else {
        die("Email is required");
    }

    // validate phoneno
    if (!empty($_POST["phone"])) {
        $phone_no = test_input($_POST["phone"]);
        if (!preg_match("/^[0-9]{10}$/", $phone_no)) {
            die("Invalid phone number");
        }
    } else {
        die("Phone Number is required");
    }

	//Validates password & confirm passwords.
    $password = test_input($_POST["password"]);
    $confirm_password = test_input($_POST["cpassword"]);

    if(!empty($_POST["password"]) && ($password == $confirm_password)) {
        // $password = test_input($_POST["password"]);
        // $confirm_password = test_input($_POST["confirm_password"]);
        if (strlen($_POST["password"]) <= '8') {
            die("Your Password Must Contain At Least 8 Characters!");
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
            die("Your Password Must Contain At Least 1 Number!");
        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            die("Your Password Must Contain At Least 1 Capital Letter!");
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            die("Your Password Must Contain At Least 1 Lowercase Letter!");
        }
    }
	else{
		die("Password and confirm password are not same");
	}

    // Insert form data into database
	$sql = "INSERT INTO registration (name, dob, email, phone_number, password) 
	VALUES ('$name', '$dob', '$email', '$phone_no', '$password')";

    if (mysqli_query($conn, $sql)) {
        // echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}

// Function to validate and sanitize form input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration Success</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
	<div class="container">
		<h1>Registration Successful</h1>
		<p>Your account has been created successfully.</p>
		<a href="login.php" class="btn">Login</a>
	</div>
</body>
</html>
