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
    die(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check for receiver_id in the request
if (isset($_POST['receiver_id'])) {
    $receiver_id = $_POST['receiver_id'];

    // Check if there's already a pending or accepted friend request
    $checkRequest = $pdo->prepare("SELECT * FROM friend_requests WHERE sender_id = :sender_id AND receiver_id = :receiver_id");
    $checkRequest->execute(['sender_id' => $user_id, 'receiver_id' => $receiver_id]);
    $existingRequest = $checkRequest->fetch(PDO::FETCH_ASSOC);

    if (!$existingRequest) {
        // Insert a new friend request
        $insertRequest = $pdo->prepare("INSERT INTO friend_requests (sender_id, receiver_id, status) VALUES (:sender_id, :receiver_id, 'pending')");
        $insertRequest->execute(['sender_id' => $user_id, 'receiver_id' => $receiver_id]);
        echo json_encode(['status' => 'success', 'message' => 'Friend request sent!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'You have already sent a request to this user.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
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
            min-height: 100vh;
        }
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
        .search-bar {
            margin-bottom: 20px;
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
        .user-list {
            margin-top: 20px;
        }
        .user-card {
            display: flex;
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
        .user-card button:hover {
            background-color: #218838;
        }
    </style>
    <script>
        function sendFriendRequest(button, receiverId) {
            const formData = new FormData();
            formData.append('receiver_id', receiverId);

            fetch('send_request.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    button.textContent = 'Sent';
                    button.disabled = true;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Find Friends</h1>

        <!-- Search bar -->
        <div class="search-bar">
            <form method="POST">
                <input type="text" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- User list -->
        
        <div class="user-list">
            <?php foreach ($users as $user) { ?>
                <div class="user-card">
                    <span><?php echo htmlspecialchars($user['username']); ?></span>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="receiver_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" name="send_request">Send Friend Request</button>
                    </form>
                </div>
            <?php } ?>
        </div>
        
    </div>
</body>
</html>
