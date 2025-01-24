<!-- interests.php -->
<?php
session_start();
// echo "<pre>";
// print_r($_SESSION['username']);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QuizMe - Select Interests</title>
    <style>
        /* Use your CSS code here for styling */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://i.ibb.co/Hg3J00B/Pngtree-abstract-background-orange-yellow-gradient-1308307.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #f9f9f9; /* Fallback color */
            height:100vh;
            display:flex;
            justify-content:center; /* Centering the container */
            align-items:center;
        }

        .container {
            max-width: 900px; /* Max width of the box */
            height: 70vh; /* Height of the box set to 40% of the viewport height */
            margin: 50px auto; /* Center the box */
            padding: 20px;
            background-color: white; /* Solid white background */
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex; /* Use flexbox for vertical alignment */
            flex-direction: column; /* Arrange children vertically */
            align-items:center; /* Space out children */
            position: relative;
        }

        .header {
            margin-bottom: 10px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            color: #ff6600;
        }

        .content-container {
            position: relative;
            width: 90%;
            height:50%;
            top: -30px; /* Moves the content upwards within the white box */
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            gap: 15px; /* Spacing between the input and buttons */
            
        }

        .search-container {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .search-input {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 16px;
            background-color: #f5f5f5;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .interests-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; 
            justify-content: center;
        }

        .interest-button {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 20px;
            background-color: white;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            min-width: 120px;
            font-size: 16px;
            font-weight: bold;
        }

        .interest-button.active {
            background-color: #ff6600;
            color: white;
        }

        .interest-button span {
            margin-right: 8px;
        }
       
        .next-skip-container{
            flex-direction: row;
            display: flex;
            justify-content: space-between;
            gap:3%;

        }
        .toggle-icon {
            width: 16px;
            height: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        #snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 25
            px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
        }
        .skip-link{
            background-color: #ff6600;  /* Orange background */
            color: white;  /* White text */
            padding: 10px 20px;  /* Add padding for spacing */
            border-radius: 5px;  /* Round corners */
            text-decoration: none;  /* Remove underline */
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s ease; 

        }

        .skip-link:hover {
    background-color: #ff4500;  /* Darker orange on hover */
}
       
.next-button{
    background-color:white;  /* Orange background */
            color:black;  /* White text */
            padding: 10px 20px; 
            border:none; /* Add padding for spacing */
            border-radius: 5px;  /* Round corners */
            text-decoration: none;  /* Remove underline */
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s ease; 
}
.next-button:hover {
    background-color:#d3d3d3; 
}
        #snackbar.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;} 
            to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;} 
            to {bottom: 0; opacity: 0;}
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>QuizMe</h1>
        </div>

        <div class="content-container">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Tell us about your interests...">
            </div>

            <div class="interests-container">
                <?php 
                $interests = ["Mathematics", "Entertainment", "Science", "Superheroes", "Anime", "Marvel", "DC", "Geography", "History", "Music", "Fashion", "Sports"];
                foreach ($interests as $interest) {
                    echo "<button class='interest-button' data-interest='$interest'><span>$interest</span><div class='toggle-icon'>+</div></button>";
                }
                ?>
            </div>
        </div>

        <div class="next-skip-container">
            <a href="home.php" class="skip-link ">Skip</a>
            <button class="next-button" onclick="submitInterests()">Next</button>
        </div>
        <div id="snackbar"></div>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', () => {
            let selectedInterests = [];

            document.querySelectorAll('.interest-button').forEach(button => {
                button.addEventListener('click', function () {
                    const interest = this.getAttribute('data-interest');
                    const icon = this.querySelector('.toggle-icon');
                    const snackbar = document.getElementById('snackbar');

                    this.classList.toggle('active'); // Toggle the 'active' class on button

                    if (selectedInterests.includes(interest)) {
                        selectedInterests = selectedInterests.filter(i => i !== interest);
                        icon.textContent = '+';
                        snackbar.textContent = "Removed from interests";
                    } else {
                        selectedInterests.push(interest);
                        icon.textContent = '−';
                        snackbar.textContent = "Added to interests";
                    }

                    snackbar.className = "show";
                    setTimeout(() => { snackbar.className = snackbar.className.replace("show", ""); }, 3000);

                    console.log("Selected Interests:", selectedInterests);
                });
            });

            window.submitInterests = function () {
                fetch('save_interests.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(selectedInterests)
                }).then(() => {
                    window.location.href = 'home.php';
                });
            };
        });
    </script>
 
</body>
</html>
