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

// Retrieve quiz_id from URL
$quiz_id = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 1;

// Fetch questions for the selected quiz_id
$query = $pdo->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
$query->execute(['quiz_id' => $quiz_id]);
$questions = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Quiz with Leaderboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
            height: 100vh;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .question {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .options-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        .option {
            padding: 25px 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
            background: #fff;
            font-size: 20px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }
        .option.correct { border-color: #28a745; background-color: #d4edda; }
        .option.incorrect { border-color: #dc3545; background-color: #f8d7da; }
        .controls { text-align: center; margin-top: 20px; }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s ease;
        }
        button:hover { background: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($questions)) { ?>
            <div class="question" id="question-text"></div>
            <form id="quiz-form" method="POST">
                <div class="options-grid" id="options-container"></div>
                <div class="controls">
                    <button type="button" id="next-button" onclick="nextQuestion()">Next Question</button>
                </div>
            </form>
        <?php } else { ?>
            <div class="question">No questions available in the quiz.</div>
        <?php } ?>
    </div>

    <script>
        const questions = <?php echo json_encode($questions); ?>;
        let currentQuestionIndex = 0;
        let score = 0;

        function displayQuestion(index) {
            const questionText = document.getElementById("question-text");
            const optionsContainer = document.getElementById("options-container");
            optionsContainer.innerHTML = '';

            const question = questions[index];
            questionText.textContent = question.question_text;

            for (let i = 1; i <= 4; i++) {
                const option = document.createElement("label");
                option.classList.add("option");
                option.innerHTML = `
                    <input type="radio" name="option" value="${i}" style="display: none;">
                    ${question["option" + i]}
                `;
                option.onclick = () => checkAnswer(option, i, question.correct_option);
                optionsContainer.appendChild(option);
            }
        }

        function checkAnswer(selectedOption, selectedValue, correctOption) {
            if (selectedValue == correctOption) {
                selectedOption.classList.add("correct");
                score++;
            } else {
                selectedOption.classList.add("incorrect");
                document.querySelectorAll(".option")[correctOption - 1].classList.add("correct");
            }
            document.querySelectorAll(".option").forEach(opt => opt.style.pointerEvents = "none");
            document.getElementById("next-button").style.display = "block";
        }

        function nextQuestion() {
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                document.querySelectorAll(".option").forEach(opt => opt.style.pointerEvents = "auto");
                displayQuestion(currentQuestionIndex);
                document.getElementById("next-button").style.display = "none";
            } else {
                showScore();
                saveScore();
            }
        }

        function showScore() {
            const container = document.querySelector(".container");
            container.innerHTML = `<div class="question">You scored ${score} out of ${questions.length}</div>`;
        }

        function saveScore() {
            fetch('save_score.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ score: score, quiz_id: <?php echo $quiz_id; ?> })
            }).then(response => response.text()).then(data => {
                fetchRankings(<?php echo $quiz_id; ?>);
                
            });
        }

        function fetchRankings(quiz_id) {
    fetch(`get_rankings.php?quiz_id=${quiz_id}`)
        .then(response => response.json())
        .then(rankings => {
            let rankingHTML = '<h2>Leaderboard</h2><table><tr><th>Rank</th><th>User</th><th>Score</th></tr>';
            rankings.forEach((rank, index) => {
                rankingHTML += `<tr><td>${index + 1}</td><td>${rank.name}</td><td>${rank.score}</td></tr>`;
            });
            rankingHTML += '</table>';
            document.querySelector(".container").innerHTML += rankingHTML;

            rankingHTML += `
                <div style="margin-top: 200px;">
                    <button id="navigateHome" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">
                        Go to Home
                    </button>
                </div>
            `;

            // Update the container with leaderboard and button
            document.querySelector(".container").innerHTML = rankingHTML;

            // Add event listener to navigate to home.php
            document.getElementById("navigateHome").addEventListener("click", () => {
                window.location.href = "home.php";
            });
        
        })
        .catch(error => {
            console.error("Error fetching rankings:", error);
            document.querySelector(".container").innerHTML += "<p>Error loading leaderboard. Please try again later.</p>";

           
        });
}


        displayQuestion(currentQuestionIndex);
    </script>
</body>
</html>
