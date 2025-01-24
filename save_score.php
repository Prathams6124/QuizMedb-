<?php
session_start();
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

$data = json_decode(file_get_contents("php://input"), true);
$score = $data['score'];
$quiz_id = $data['quiz_id'];
$username = $_SESSION['username'] ?? null;

if (!$username) {
    echo "User not logged in.";
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_id = $user['id'];

    $stmt = $pdo->prepare("SELECT score FROM user_quiz_ranking WHERE user_id = :user_id AND quiz_id = :quiz_id");
    $stmt->execute(['user_id' => $user_id, 'quiz_id' => $quiz_id]);
    $existingScore = $stmt->fetchColumn();

    if ($existingScore !== false) {
        if ($score > $existingScore) {
            $stmt = $pdo->prepare("UPDATE user_quiz_ranking SET score = :score WHERE user_id = :user_id AND quiz_id = :quiz_id");
            $stmt->execute(['score' => $score, 'user_id' => $user_id, 'quiz_id' => $quiz_id]);
            echo "Score updated.";
        } else {
            echo "No update needed.";
        }
    } else {
        $stmt = $pdo->prepare("INSERT INTO user_quiz_ranking (user_id, quiz_id, score) VALUES (:user_id, :quiz_id, :score)");
        $stmt->execute(['user_id' => $user_id, 'quiz_id' => $quiz_id, 'score' => $score]);
        echo "Score saved.";
    }
} else {
    echo "User not found.";
}
?>
