<?php
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

$quiz_id = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 1;

$query = $pdo->prepare(" SELECT u.name, r.score 
        FROM user_quiz_ranking r
        JOIN users u ON r.user_id = u.id
        WHERE r.quiz_id = :quiz_id
        ORDER BY r.score DESC");
$query->execute(['quiz_id' => $quiz_id]);
$rankings = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($rankings);
?>
