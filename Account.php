<?php
session_start();

// Database connection
$host = 'localhost:3307';
$dbname = 'quizmedb';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$query->execute(['id' => $user_id]);
$userData = $query->fetch(PDO::FETCH_ASSOC);

// Handle form submission
$successMessage = '';  // Initialize success message as an empty string
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];

    // Update user data in the database
    $updateQuery = $pdo->prepare("UPDATE users SET username = :username, email = :email, dob = :dob WHERE id = :id");
    $updateQuery->execute([
        'username' => $username,
        'email' => $email,
        'dob' => $dob,
        'id' => $user_id
    ]);

    // Refresh user data after update
    $query->execute(['id' => $user_id]);
    $userData = $query->fetch(PDO::FETCH_ASSOC);

    // Set success message after successful form submission
    $successMessage = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f7b7a3, #6a4b93);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            position: relative;
        }
        h1 {
            text-align: center;
            color: #4a4a4a;
            font-size: 28px;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
        }
        input {
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f7f7f7;
            transition: border-color 0.3s ease;
        }
        input:focus {
            border-color: #6a4b93;
            outline: none;
        }
        button {
            background-color: #6a4b93;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #5b3a78;
        }
        .success {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 16px;
            opacity: 1;
            animation: fadeOut 3s forwards;
        }
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            80% {
                opacity: 0.6;
            }
            100% {
                opacity: 0;
                top: -60px;
            }
        }
        .container p {
            font-size: 14px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Account Page</h1>
        
        <!-- Show the success message only after form submission -->
        <?php if ($successMessage): ?>
            <div class="success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($userData['dob']); ?>" required>

            <button type="submit">Update Profile</button>
        </form>

        <p>Feel free to edit your details above.</p>
    </div>

</body>
</html>
