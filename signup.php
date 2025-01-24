<?php
// Database connection
$servername = "localhost:3307";
$dbusername = "root";
$dbpassword = "";
$dbname = "quizmedb";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkUserQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $checkResult = $conn->query($checkUserQuery);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Username or email already exists.');</script>";
    } else {
        $sql = "INSERT INTO users (name, dob, email, username, password) VALUES ('$name', '$dob', '$email', '$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Signup successful!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizMe - Signup</title>
    <style>
        /* Signup page styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: url('https://i.ibb.co/Hg3J00B/Pngtree-abstract-background-orange-yellow-gradient-1308307.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            display: flex;
            justify-content: space-between;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 900px;
            overflow: hidden;
        }
        .welcome-section {
            background-color: #ff8a00;
            padding: 3rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }
        .welcome-section h2 {
            font-size: 4.5rem;
            font-family: 'Brush Script MT', cursive;
            margin-bottom: 1rem;
        }
        .welcome-section p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        .welcome-section button {
            background-color: white;
            color: #ff8a00;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .welcome-section button:hover {
            background-color: #f5f5f5;
        }
        .form-section {
            flex: 1;
            padding: 3rem;
            background-color: #f9f9f9;
        }
        .form-section h1 {
            text-align: center;
            color: #ff8a00;
            margin-bottom: 2rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 0.5rem;
            color: #333;
        }
        input {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
        }
        .form-section button {
            background-color: #ff8a00;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .form-section button:hover {
            background-color: #ffa500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <h2>Welcome user,</h2>
            <p>Already have an account?</p>
            <button onclick="window.location.href='login.php'">SIGN IN</button>
        </div>
        <div class="form-section">
            <h1>QuizMe Signup</h1>
            <form action="signup.php" method="POST">
                <label for="signup-name">Name</label>
                <input type="text" id="signup-name" name="name" placeholder="Enter your name" required>

                <label for="signup-dob">Date of Birth</label>
                <input type="date" id="signup-dob" name="dob" required>

                <label for="signup-email">Email</label>
                <input type="email" id="signup-email" name="email" placeholder="Enter your email id" required>

                <label for="signup-username">Username</label>
                <input type="text" id="signup-username" name="username" required minlength="8"  placeholder="Enter your username" maxlength="20">

                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="password" placeholder="Enter your password" required minlength="8" maxlength="20">

                <button type="submit">SIGN UP</button>
            </form>
        </div>
    </div>
</body>
</html>
