<?php
session_start();

require 'C:\Users\PRATHAMESH\Phpmailer\vendor\autoload.php'; // Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

$user_id = $_SESSION['user_id'];

// Handle AJAX request for friend request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receiver_id'])) {
    $receiver_id = $_POST['receiver_id'];

    // Fetch receiver's username and email
    $getUserInfo = $pdo->prepare("SELECT username, email FROM users WHERE id = :receiver_id");
    $getUserInfo->execute(['receiver_id' => $receiver_id]);
    $receiver = $getUserInfo->fetch(PDO::FETCH_ASSOC);

    if ($receiver) {
        $receiver_username = $receiver['username'];
        $receiver_email = $receiver['email'];

        // Check for an existing friend request
        $checkRequest = $pdo->prepare("SELECT * FROM friend_requests WHERE sender_id = :sender_id AND receiver_id = :receiver_id");
        $checkRequest->execute(['sender_id' => $user_id, 'receiver_id' => $receiver_id]);
        $existingRequest = $checkRequest->fetch(PDO::FETCH_ASSOC);

        if (!$existingRequest) {
            // Insert a new friend request
            $insertRequest = $pdo->prepare("INSERT INTO friend_requests (sender_id, receiver_id, status) VALUES (:sender_id, :receiver_id, 'pending')");
            $insertRequest->execute(['sender_id' => $user_id, 'receiver_id' => $receiver_id]);

            // Send email notification using PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'p.salunke@somaiya.edu'; // Your email address
                $mail->Password = 'eelp sugz uaou hjqg';   // Your email password or app-specific password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('p.salunke@somaiya.edu', 'Prathamesh_Salunke'); // Sender's email and name
                $mail->addAddress($receiver_email, $receiver_username);   // Recipient's email and name

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'You have a new friend request!';
                $mail->Body = "
                    <p>Hi <b>{$receiver_username}</b>,</p>
                    <p>You have received a new friend request from user ID: {$user_id}.</p>
                    <p>Log in to your account to respond to the request.</p>
                    <p>Best regards,<br>Your App Team</p>
                ";
                $mail->AltBody = "Hi {$receiver_username}, you have received a new friend request. Log in to your account to respond.";

                // Send the email
                $mail->send();

                echo json_encode(['status' => 'success', 'message' => 'Friend request sent and email notification delivered!']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Friend request sent, but email could not be sent. Error: ' . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'You have already sent a request to this user.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Recipient not found.']);
    }
    exit;
}

// Search functionality
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Fetch users and their request status
$query = $pdo->prepare("
    SELECT u.id, u.username, 
           (SELECT COUNT(*) 
            FROM friend_requests fr 
            WHERE fr.sender_id = :user_id AND fr.receiver_id = u.id) AS request_sent 
    FROM users u 
    WHERE u.id != :user_id AND u.username LIKE :search
");
$query->execute([
    'user_id' => $user_id,
    'search' => '%' . $search . '%'
]);
$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f7b7a3, #6a4b93);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh; }

        .container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin-top: 50px;
             }

        h1 { 
            text-align: center;
            color: #4a4a4a;
            font-size: 28px;
            margin-bottom: 20px;
         }

        .search-bar {margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            }

        .search-bar input {
            padding: 10px;
            width: 80%;
            border: 1px solid #ccc;
            border-radius: 5px; 
            }

            .search-bar button {
            background-color: #6a4b93;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .user-list{
            margin-top: 20px;
        }
         .user-card {  display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9f9f9;
            margin: 10px 0;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
             }

             .user-card button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .user-card button:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
    </style>
    <script>
        function sendFriendRequest(button, receiverId) {
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `receiver_id=${receiverId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    button.textContent = 'Sent';
                    button.disabled = true;
                } else {
                    alert(data.message);
                }
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Find Friends</h1>
        <div class="search-bar">
            <form method="GET">
                <input type="text" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="user-list">
            <?php foreach ($users as $user) { ?>
                <div class="user-card">
                    <span><?php echo htmlspecialchars($user['username']); ?></span>
                    <?php if ($user['request_sent'] > 0) { ?>
                        <button disabled>Sent</button>
                    <?php } else { ?>
                        <button onclick="sendFriendRequest(this, <?php echo $user['id']; ?>)">Send Friend Request</button>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
