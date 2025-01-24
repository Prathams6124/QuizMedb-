<?php
session_start();

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
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id']; 
            echo "<script>alert('Login successful!'); window.location.href='interests.php';</script>";
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('User not found. Please sign up first.'); window.location.href='signup.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizMe - Login</title>
    <style>
        /* Login page styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('https://i.ibb.co/Hg3J00B/Pngtree-abstract-background-orange-yellow-gradient-1308307.png') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #ff8a00;
            margin-bottom: 1.5rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #333;
            font-family: 'Times New Roman';
        }
        input {
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 25px;
            font-size: 1rem;
        }
        button {
            background-color: #ff8a00;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #ffa500;
        }
        .switch-form {
            text-align: center;
            margin-top: 1rem;
        }
        .switch-form a {
            color: #ff8a00;
            text-decoration: none;
        }
        .switch-form a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>QuizMe Login</h1>
        <form id="login-form" action="login.php" method="POST">
            <label for="login-id">ID</label>
            <input type="text" id="login-id" name="username" required>
            <label for="login-password">Password</label>
            <input type="password" id="login-password" name="password" required>
            <button type="submit">Sign In</button>
        </form>
        <div class="switch-form">
            <p>New user? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
    <!-- <?php
    if (isset($_SESSION['username'])) {
        echo "<pre>";
        print_r($_SESSION['username']);
        echo "</pre>";
    } else {
        echo "<pre>Username is not set in the session.</pre>";
    }
    
    ?> -->
</body>
</html>
