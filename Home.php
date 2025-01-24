<!-- home.php -->
<?php
session_start();
$selectedInterests = isset($_SESSION['selected_interests']) ? $_SESSION['selected_interests'] : [];

// Connect to database
$conn = new mysqli("localhost:3307", "root", "", "quizmedb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!empty($selectedInterests)){
// Prepare an SQL statement to get quizzes based on selected interests
$placeholders = implode(',', array_fill(0, count($selectedInterests), '?'));
$sql = "SELECT * FROM quizzes WHERE classs IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat("s", count($selectedInterests)), ...$selectedInterests);
$stmt->execute();
/*$result = $stmt->get_result();*/
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}

$stmt->bind_param(str_repeat("s", count($selectedInterests)), ...$selectedInterests);
}
else {
    // Query to fetch all quizzes if no interests are selected
    $sql = "SELECT * FROM quizzes";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }
}
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if (!$result) {
        die("Error getting result: " . $stmt->error);
    }
} else {
    die("Query execution failed: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizMe</title>
    <style>
        body {
            background-color: #f7fafc;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        header {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            position: relative;
            z-index: 1000;
            transition: z-index 0.3s ease-in-out;
            border-bottom: 2px solid #ff6b00;
        }

        header.active {
            z-index: 997;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            color:#ff7f50;
            font-weight: bold;
            font-size: 1.8rem;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Menu Overlay */
        .menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        /* Side Menu Styles */
        .side-menu {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background: white;
            transition: left 0.3s ease-in-out;
            z-index: 999;
            padding: 20px;
        }

        .side-menu.active {
            left: 0;
        }

        /* Menu Links */
        .side-menu nav a {
            display: block;
            margin: 10px 0;
            text-decoration: none;
            font-size: 18px;
            font-family: 'sans-serif'; /* Font change */
            color: black;
            font-weight: 500; /* Font weight */
            letter-spacing: 0.05em; /* Letter spacing */
            text-transform: uppercase; /* Uppercase style */
            transition: color 0.3s ease;
            padding: 10px;
            border-radius: 8px;
        }

        .side-menu nav a:hover {
            color: #ff7f50; /* Hover effect */
            background-color: #f0f0f0; /* Slight background change on hover */
        }

        /* Highlight the active link */
        .side-menu nav a.active {
            color: white;
            background-color: #ff7f50; /* Highlighted background color for active link */
            font-weight: bold; /* Bold font for active link */
        }

        /* Quiz Card and Main Layout */
        .quiz-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 40px auto;
        }

        .quiz-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .quiz-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .quiz-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .quiz-card h3 {
            margin: 16px;
            font-weight: bold;
        }

        .quiz-card p {
            margin: 0 16px 16px;
            color: #555;
            font-size: 0.9rem;
        }

        .quiz-card .actions {
            display: flex;
            justify-content: space-between;
            padding: 0 16px 16px;
        }

        .quiz-card button {
            background-color: #ff7f50;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .quiz-card button:hover {
            background-color: #ff6347;
        }

        /* Trending Section */
        /* Trending Section */
.trending-section {
    width: 90%;
    margin: 40px auto;
    background: #ff7f50 /* Gradient background */
    border-radius: 20px;
    padding: 20px;
    color: white;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Add subtle shadow */
    position: relative;
    overflow: hidden; /* Ensures cleaner boundaries */
}

.trending-section h2 {
    text-align: center;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 20px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color:#ff6347 ;
}

.slider {
    display: flex;
    gap: 20px;
    overflow: hidden;
    scroll-snap-type: x mandatory;
    padding: 10px 0; /* Adjusted for spacing */
}

.slider .slide {
    min-width: 95%; /* Reduced size for spacing */
    background: white;
    border-radius: 15px;
    scroll-snap-align: start;
    padding: 10px;
    text-align: center;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: #333;
}

.slider .slide:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
}

.slider .slide img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 10px;
}

.slider .slide h3 {
    font-size: 1.5rem;
    font-weight: bold;
    margin: 10px 0;
    color: #ff6347;
}

.slider .slide .actions {
    margin-top: 10px;
}

.slider .slide button {
    background-color: #ff7f50;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    margin: 0 5px;
}

.slider .slide button:hover {
    background-color: #ff4500;
    transform: translateY(-2px);
}

.dots-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: white;
    border:0.5px solid grey;
    margin: 0 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.dot.active {
    background-color:#ff7f50;
}

/* Add subtle animation to trending section on page load */
.trending-section {
    animation: fadeIn 0.8s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


        /* Your CSS styles from the provided template */
        /* ... include all the CSS from your template here ... */
    </style>
</head>
<body>
    <!-- Header -->
    <header id="header">
        <button id="menuBtn">☰</button>
        <h1>QuizMe</h1>
    </header>

    <!-- Side Menu and Overlay -->
    <div id="menuOverlay" class="menu-overlay"></div>
    <div id="sideMenu" class="side-menu">
        <nav>
            <a href="/" class="active">HOME</a>
            <a href="login.html">SEARCH</a>
            <a href="Account.php">ACCOUNT</a>
            <a href="Dashboard.html">DASHBOARD</a>
            <a href="phpmailer_final.php">FRIENDS</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    
        <!-- Trending Quiz -->
        <div class="trending-section">
    <h2>Trending Quizzes</h2>
    <div class="slider" id="slider">
        <div class="slide">
            <img src="newimg.webp" alt="Winter Adventure">
            <h3>Quiz 1: Winter Adventure</h3>
            <div class="actions">
                <button class="view-button" onclick="location.href='quiz.php?quiz_id=1'">View</button>
                <button onclick="location.href='tp3.php?quiz_id=1'">Start</button>
            </div>
        </div>
        <div class="slide">
            <img src="img10.webp" alt="Summer Fun">
            <h3>Quiz 2: Summer Fun</h3>
            <div class="actions">
                <button class="view-button" onclick="location.href='quiz.php?quiz_id=2'">View</button>
                <button onclick="location.href='tp3.php?quiz_id=2'">Start</button>
            </div>
        </div>
    </div>
    <div class="dots-container" id="dotsContainer"></div>
</div>

    <main>
        <!-- Quiz Grid for selected interests -->
        <div class="quiz-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="quiz-card">
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo $row['quiz_name']; ?>" />
                    <h3><?php echo $row['quiz_name']; ?></h3>
                    <p><?php echo $row['classs']; ?></p>
                    <div class="actions">
                    <button class="view-button" onclick="location.href='quiz.php?quiz_id=<?php echo $row['quiz_id']; ?>'">View</button>
                        <button onclick="location.href='tp3.php?quiz_id=<?php echo $row['quiz_id']; ?>'">Start</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <script>
        // JavaScript to toggle the side menu
        const menuBtn = document.getElementById('menuBtn');
        const sideMenu = document.getElementById('sideMenu');
        const menuOverlay = document.getElementById('menuOverlay');
        const header = document.getElementById('header');
        const slider = document.getElementById('slider');
;
        const slides = Array.from(slider.children);
        const dotsContainer = document.getElementById('dotsContainer');

        // Toggle Side Menu and Overlay
        menuBtn.addEventListener('click', () => {
            const isActive = sideMenu.classList.toggle('active');
            menuOverlay.style.display = isActive ? 'block' : 'none';
            
            // Change header z-index when menu is active
            if (isActive) {
                header.classList.add('active');
            } else {
                header.classList.remove('active');
            }
        });

        // Hide Menu When Clicking Outside
        menuOverlay.addEventListener('click', () => {
            sideMenu.classList.remove('active');
            menuOverlay.style.display = 'none';
            header.classList.remove('active');  // Reset header z-index
        });

        // Create dots for each slide
        slides.forEach((slide, index) => {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if (index === 0) dot.classList.add('active'); // Set the first dot as active initially
            dot.addEventListener('click', () => goToSlide(index));
            dotsContainer.appendChild(dot);
        });

        function goToSlide(index) {
            slider.scrollTo({
                left: slides[index].offsetLeft,
                behavior: 'smooth'
            });
            updateDots(index);
        }

        function updateDots(activeIndex) {
            const dots = Array.from(dotsContainer.children);
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === activeIndex);
            });
        }

        // Automatically update dots on slide scroll
        slider.addEventListener('scroll', () => {
            const scrollPosition = slider.scrollLeft + slider.offsetWidth / 2;
            const activeIndex = slides.findIndex(slide => slide.offsetLeft <= scrollPosition && slide.offsetLeft + slide.offsetWidth > scrollPosition);
            updateDots(activeIndex);
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
