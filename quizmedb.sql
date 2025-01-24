-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jan 24, 2025 at 01:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizmedb`
--
CREATE DATABASE IF NOT EXISTS `quizmedb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `quizmedb`;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

DROP TABLE IF EXISTS `friend_requests`;
CREATE TABLE `friend_requests` (
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`sender_id`, `receiver_id`, `status`) VALUES
(4, 5, 'pending'),
(4, 7, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question_text` varchar(255) DEFAULT NULL,
  `option1` varchar(100) DEFAULT NULL,
  `option2` varchar(100) DEFAULT NULL,
  `option3` varchar(100) DEFAULT NULL,
  `option4` varchar(100) DEFAULT NULL,
  `correct_option` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `option1`, `option2`, `option3`, `option4`, `correct_option`) VALUES
(11, 1, 'What is 5 + 7?', '10', '11', '12', '13', 3),
(12, 1, 'What is the square root of 81?', '7', '8', '9', '10', 3),
(13, 1, 'If x = 3, what is x^2 + 2x + 1?', '10', '16', '13', '14', 2),
(14, 1, 'What is 15 divided by 3?', '3', '4', '5', '6', 3),
(15, 1, 'What is the value of π (pi) to 2 decimal places?', '3.12', '3.13', '3.14', '3.15', 3),
(16, 1, 'Solve: 6 × 7', '42', '49', '36', '40', 1),
(17, 1, 'What is 100 - 57?', '41', '43', '42', '44', 2),
(18, 1, 'If a triangle has two equal sides, what type is it?', 'Scalene', 'Isosceles', 'Equilateral', 'Right-Angled', 2),
(19, 1, 'Solve: 9 × 8', '64', '72', '81', '69', 2),
(20, 1, 'What is the result of 7 + (6 × 5)?', '37', '47', '57', '67', 1),
(21, 2, 'Who founded Microsoft?', 'Steve Jobs', 'Bill Gates', 'Elon Musk', 'Larry Page', 2),
(22, 2, 'What does CPU stand for?', 'Central Processing Unit', 'Control Processing Unit', 'Computer Personal Unit', 'Central Processor Utility', 1),
(23, 2, 'What does HTTP stand for?', 'HyperText Transfer Protocol', 'HyperText Transmission Protocol', 'Hyper Transfer Text Protocol', 'Hyper Text Protocol', 1),
(24, 2, 'Which programming language is known as the \"language of the web\"?', 'Python', 'C++', 'JavaScript', 'Java', 3),
(25, 2, 'Which company created the iPhone?', 'Microsoft', 'Samsung', 'Google', 'Apple', 4),
(26, 2, 'What does AI stand for?', 'Artificial Intelligence', 'Automated Information', 'Automated Intelligence', 'Artificial Information', 1),
(27, 2, 'Who founded Tesla?', 'Mark Zuckerberg', 'Elon Musk', 'Larry Page', 'Bill Gates', 2),
(28, 2, 'Which social media platform has a bird logo?', 'Facebook', 'Twitter', 'Instagram', 'LinkedIn', 2),
(29, 2, 'What does GPU stand for?', 'Graphics Processing Unit', 'Global Processor Unit', 'Graphical Processor Utility', 'General Processor Unit', 1),
(30, 2, 'What year was the World Wide Web invented?', '1989', '1990', '1991', '1992', 1),
(31, 3, 'What planet is known as the Red Planet?', 'Venus', 'Earth', 'Mars', 'Jupiter', 3),
(32, 3, 'What is the chemical symbol for water?', 'H2', 'O2', 'H2O', 'HO', 3),
(33, 3, 'What gas do plants absorb from the atmosphere?', 'Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Helium', 3),
(34, 3, 'What is the speed of light?', '300,000 km/s', '150,000 km/s', '3,000 km/s', '30,000 km/s', 1),
(35, 3, 'Who developed the theory of relativity?', 'Isaac Newton', 'Albert Einstein', 'Galileo Galilei', 'Nikola Tesla', 2),
(36, 3, 'What planet is known as the Earth’s twin?', 'Mars', 'Venus', 'Jupiter', 'Saturn', 2),
(37, 3, 'What is the powerhouse of the cell?', 'Nucleus', 'Ribosome', 'Mitochondria', 'Chloroplast', 3),
(38, 3, 'What is the most abundant gas in Earth’s atmosphere?', 'Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Hydrogen', 3),
(39, 3, 'What does DNA stand for?', 'Deoxyribonucleic Acid', 'Deoxyribonitric Acid', 'Deoxynucleic Acid', 'None of these', 1),
(40, 3, 'What is the largest planet in our Solar System?', 'Earth', 'Saturn', 'Jupiter', 'Neptune', 3),
(41, 4, 'Who is known as the Dark Knight?', 'Superman', 'Batman', 'Spider-Man', 'Iron Man', 2),
(42, 4, 'What is Spider-Man’s real name?', 'Clark Kent', 'Bruce Wayne', 'Peter Parker', 'Tony Stark', 3),
(43, 4, 'Which superhero has a hammer called Mjolnir?', 'Thor', 'Iron Man', 'Hulk', 'Captain America', 1),
(44, 4, 'Which superhero is from Wakanda?', 'Black Panther', 'Hawkeye', 'Doctor Strange', 'Spider-Man', 1),
(45, 4, 'Who is known as the “Man of Steel”?', 'Batman', 'Superman', 'Iron Man', 'Captain America', 2),
(46, 4, 'What color is the Hulk?', 'Green', 'Blue', 'Red', 'Yellow', 1),
(47, 4, 'Which superhero is blind but has heightened other senses?', 'Daredevil', 'Iron Man', 'Doctor Strange', 'Wolverine', 1),
(48, 4, 'Which superhero is a billionaire?', 'Spider-Man', 'Superman', 'Batman', 'Flash', 3),
(49, 4, 'Who is Tony Stark?', 'Hulk', 'Iron Man', 'Captain America', 'Thor', 2),
(50, 4, 'Which superhero has a shield?', 'Iron Man', 'Batman', 'Captain America', 'Superman', 3),
(51, 5, 'Who is known as the \"Pirate King\" in One Piece?', 'Luffy', 'Shanks', 'Whitebeard', 'Gol D. Roger', 4),
(52, 5, 'What is Naruto’s dream?', 'To become Hokage', 'To be a legendary warrior', 'To travel the world', 'To find peace', 1),
(53, 5, 'In Attack on Titan, what are the Titans trying to break into?', 'A forest', 'The walls', 'A castle', 'An island', 2),
(54, 5, 'Which anime features a notebook that can kill people?', 'Naruto', 'Bleach', 'Death Note', 'One Piece', 3),
(55, 5, 'Who is the strongest Saiyan in Dragon Ball Z?', 'Goku', 'Vegeta', 'Broly', 'Gohan', 1),
(56, 5, 'What is Luffy’s power in One Piece?', 'Flying', 'Ice control', 'Elasticity', 'Teleportation', 3),
(57, 5, 'Which character has Sharingan eyes?', 'Naruto', 'Sasuke', 'Luffy', 'Ichigo', 2),
(58, 5, 'What is Saitama’s superhero name?', 'Genos', 'One Punch Man', 'Mumen Rider', 'S-Class Hero', 2),
(59, 5, 'Which anime is about a virtual reality MMORPG?', 'Naruto', 'Sword Art Online', 'Attack on Titan', 'My Hero Academia', 2),
(60, 5, 'Who is the main character in \"My Hero Academia\"?', 'Deku', 'Bakugo', 'All Might', 'Shoto', 1),
(61, 6, 'What is Captain America’s shield made of?', 'Iron', 'Adamantium', 'Vibranium', 'Steel', 3),
(62, 6, 'Who is known as the God of Thunder?', 'Iron Man', 'Thor', 'Hawkeye', 'Hulk', 2),
(63, 6, 'Who is Tony Stark’s AI assistant?', 'Friday', 'Jarvis', 'Alexa', 'Siri', 2),
(64, 6, 'What is Black Widow’s real name?', 'Natasha Romanoff', 'Wanda Maximoff', 'Peggy Carter', 'Jane Foster', 1),
(65, 6, 'Which superhero turns green when angry?', 'Thor', 'Iron Man', 'Captain America', 'Hulk', 4),
(66, 6, 'Who is Peter Parker?', 'Batman', 'Spider-Man', 'Iron Man', 'Hulk', 2),
(67, 6, 'Who leads the Guardians of the Galaxy?', 'Rocket', 'Drax', 'Star-Lord', 'Gamora', 3),
(68, 6, 'What is Wolverine’s skeleton made of?', 'Iron', 'Steel', 'Vibranium', 'Adamantium', 4),
(69, 6, 'Who can manipulate reality?', 'Thor', 'Doctor Strange', 'Scarlet Witch', 'Spider-Man', 3),
(70, 6, 'Who is the Winter Soldier?', 'Steve Rogers', 'Tony Stark', 'Bucky Barnes', 'Sam Wilson', 3),
(71, 7, 'Who is known as the Caped Crusader?', 'Superman', 'Batman', 'Green Lantern', 'Flash', 2),
(72, 7, 'What is Superman’s weakness?', 'Kryptonite', 'Fire', 'Silver', 'Ice', 1),
(73, 7, 'Who is the Joker’s main adversary?', 'Superman', 'Flash', 'Wonder Woman', 'Batman', 4),
(74, 7, 'What is Wonder Woman’s real name?', 'Diana Prince', 'Selina Kyle', 'Harley Quinn', 'Lois Lane', 1),
(75, 7, 'Which city does Batman protect?', 'Metropolis', 'Star City', 'Gotham', 'Central City', 3),
(76, 7, 'Who is known as the Fastest Man Alive?', 'Superman', 'Flash', 'Batman', 'Aquaman', 2),
(77, 7, 'Who is the ruler of Atlantis?', 'Batman', 'Flash', 'Aquaman', 'Green Lantern', 3),
(78, 7, 'Who has a power ring?', 'Wonder Woman', 'Green Lantern', 'Flash', 'Superman', 2),
(79, 7, 'What does Batman use to signal for help?', 'Bat-Signal', 'Radio', 'Phone', 'Lantern', 1),
(80, 7, 'Who is known as the Amazon Princess?', 'Catwoman', 'Wonder Woman', 'Supergirl', 'Harley Quinn', 2),
(81, 8, 'What is the largest continent?', 'Africa', 'Asia', 'Europe', 'Australia', 2),
(82, 8, 'Which country has the most population?', 'India', 'United States', 'China', 'Brazil', 3),
(83, 8, 'What is the smallest country by land area?', 'Monaco', 'San Marino', 'Vatican City', 'Malta', 3),
(84, 8, 'What is the capital of Australia?', 'Sydney', 'Melbourne', 'Canberra', 'Brisbane', 3),
(85, 8, 'What is the longest river in the world?', 'Amazon', 'Yangtze', 'Mississippi', 'Nile', 4),
(86, 8, 'What ocean is the largest?', 'Atlantic', 'Indian', 'Pacific', 'Arctic', 3),
(87, 8, 'In which country is Mount Everest located?', 'China', 'India', 'Nepal', 'Bhutan', 3),
(88, 8, 'What is the capital of Japan?', 'Tokyo', 'Seoul', 'Beijing', 'Osaka', 1),
(89, 8, 'Which desert is the largest in the world?', 'Sahara', 'Gobi', 'Kalahari', 'Arctic', 1),
(90, 8, 'What is the currency of the UK?', 'Dollar', 'Euro', 'Pound', 'Yen', 3),
(91, 9, 'Who was the first President of the United States?', 'Thomas Jefferson', 'Abraham Lincoln', 'George Washington', 'John Adams', 3),
(92, 9, 'Which civilization built the Pyramids?', 'Roman', 'Greek', 'Egyptian', 'Persian', 3),
(93, 9, 'Who was known as the Iron Lady?', 'Angela Merkel', 'Margaret Thatcher', 'Indira Gandhi', 'Hillary Clinton', 2),
(94, 9, 'What year did World War II end?', '1942', '1945', '1947', '1950', 2),
(95, 9, 'Who discovered America?', 'Christopher Columbus', 'James Cook', 'Marco Polo', 'Ferdinand Magellan', 1),
(96, 9, 'Who was the first man on the moon?', 'Neil Armstrong', 'Buzz Aldrin', 'Yuri Gagarin', 'John Glenn', 1),
(97, 9, 'What was the Titanic?', 'Warship', 'Passenger liner', 'Cargo ship', 'Fishing boat', 2),
(98, 9, 'What empire was Julius Caesar part of?', 'Egyptian', 'Roman', 'Greek', 'Persian', 2),
(99, 9, 'Who was the last Emperor of Russia?', 'Peter the Great', 'Alexander II', 'Nicholas II', 'Ivan the Terrible', 3),
(100, 9, 'Who painted the Mona Lisa?', 'Vincent van Gogh', 'Leonardo da Vinci', 'Pablo Picasso', 'Claude Monet', 2),
(101, 5, 'Who is known as the \"Pirate King\" in One Piece?', 'Luffy', 'Shanks', 'Whitebeard', 'Gol D. Roger', 4),
(102, 5, 'What is Naruto’s dream?', 'To become Hokage', 'To be a legendary warrior', 'To travel the world', 'To find peace', 1),
(103, 5, 'In Attack on Titan, what are the Titans trying to break into?', 'A forest', 'The walls', 'A castle', 'An island', 2),
(104, 5, 'Which anime features a notebook that can kill people?', 'Naruto', 'Bleach', 'Death Note', 'One Piece', 3),
(105, 5, 'Who is the strongest Saiyan in Dragon Ball Z?', 'Goku', 'Vegeta', 'Broly', 'Gohan', 1),
(106, 5, 'What is Luffy’s power in One Piece?', 'Flying', 'Ice control', 'Elasticity', 'Teleportation', 3),
(107, 5, 'Which character has Sharingan eyes?', 'Naruto', 'Sasuke', 'Luffy', 'Ichigo', 2),
(108, 5, 'What is Saitama’s superhero name?', 'Genos', 'One Punch Man', 'Mumen Rider', 'S-Class Hero', 2),
(109, 5, 'Which anime is about a virtual reality MMORPG?', 'Naruto', 'Sword Art Online', 'Attack on Titan', 'My Hero Academia', 2),
(110, 5, 'Who is the main character in \"My Hero Academia\"?', 'Deku', 'Bakugo', 'All Might', 'Shoto', 1),
(111, 6, 'What is Captain America’s shield made of?', 'Iron', 'Adamantium', 'Vibranium', 'Steel', 3),
(112, 6, 'Who is known as the God of Thunder?', 'Iron Man', 'Thor', 'Hawkeye', 'Hulk', 2),
(113, 6, 'Who is Tony Stark’s AI assistant?', 'Friday', 'Jarvis', 'Alexa', 'Siri', 2),
(114, 6, 'What is Black Widow’s real name?', 'Natasha Romanoff', 'Wanda Maximoff', 'Peggy Carter', 'Jane Foster', 1),
(115, 6, 'Which superhero turns green when angry?', 'Thor', 'Iron Man', 'Captain America', 'Hulk', 4),
(116, 6, 'Who is Peter Parker?', 'Batman', 'Spider-Man', 'Iron Man', 'Hulk', 2),
(117, 6, 'Who leads the Guardians of the Galaxy?', 'Rocket', 'Drax', 'Star-Lord', 'Gamora', 3),
(118, 6, 'What is Wolverine’s skeleton made of?', 'Iron', 'Steel', 'Vibranium', 'Adamantium', 4),
(119, 6, 'Who can manipulate reality?', 'Thor', 'Doctor Strange', 'Scarlet Witch', 'Spider-Man', 3),
(120, 6, 'Who is the Winter Soldier?', 'Steve Rogers', 'Tony Stark', 'Bucky Barnes', 'Sam Wilson', 3),
(121, 7, 'Who is known as the Caped Crusader?', 'Superman', 'Batman', 'Green Lantern', 'Flash', 2),
(122, 7, 'What is Superman’s weakness?', 'Kryptonite', 'Fire', 'Silver', 'Ice', 1),
(123, 7, 'Who is the Joker’s main adversary?', 'Superman', 'Flash', 'Wonder Woman', 'Batman', 4),
(124, 7, 'What is Wonder Woman’s real name?', 'Diana Prince', 'Selina Kyle', 'Harley Quinn', 'Lois Lane', 1),
(125, 7, 'Which city does Batman protect?', 'Metropolis', 'Star City', 'Gotham', 'Central City', 3),
(126, 7, 'Who is known as the Fastest Man Alive?', 'Superman', 'Flash', 'Batman', 'Aquaman', 2),
(127, 7, 'Who is the ruler of Atlantis?', 'Batman', 'Flash', 'Aquaman', 'Green Lantern', 3),
(128, 7, 'Who has a power ring?', 'Wonder Woman', 'Green Lantern', 'Flash', 'Superman', 2),
(129, 7, 'What does Batman use to signal for help?', 'Bat-Signal', 'Radio', 'Phone', 'Lantern', 1),
(130, 7, 'Who is known as the Amazon Princess?', 'Catwoman', 'Wonder Woman', 'Supergirl', 'Harley Quinn', 2),
(131, 8, 'What is the largest continent?', 'Africa', 'Asia', 'Europe', 'Australia', 2),
(132, 8, 'Which country has the most population?', 'India', 'United States', 'China', 'Brazil', 3),
(133, 8, 'What is the smallest country by land area?', 'Monaco', 'San Marino', 'Vatican City', 'Malta', 3),
(134, 8, 'What is the capital of Australia?', 'Sydney', 'Melbourne', 'Canberra', 'Brisbane', 3),
(135, 8, 'What is the longest river in the world?', 'Amazon', 'Yangtze', 'Mississippi', 'Nile', 4),
(136, 8, 'What ocean is the largest?', 'Atlantic', 'Indian', 'Pacific', 'Arctic', 3),
(137, 8, 'In which country is Mount Everest located?', 'China', 'India', 'Nepal', 'Bhutan', 3),
(138, 8, 'What is the capital of Japan?', 'Tokyo', 'Seoul', 'Beijing', 'Osaka', 1),
(139, 8, 'Which desert is the largest in the world?', 'Sahara', 'Gobi', 'Kalahari', 'Arctic', 1),
(140, 8, 'What is the currency of the UK?', 'Dollar', 'Euro', 'Pound', 'Yen', 3),
(141, 9, 'Who was the first President of the United States?', 'Thomas Jefferson', 'Abraham Lincoln', 'George Washington', 'John Adams', 3),
(142, 9, 'Which civilization built the Pyramids?', 'Roman', 'Greek', 'Egyptian', 'Persian', 3),
(143, 9, 'Who was known as the Iron Lady?', 'Angela Merkel', 'Margaret Thatcher', 'Indira Gandhi', 'Hillary Clinton', 2),
(144, 9, 'What year did World War II end?', '1942', '1945', '1947', '1950', 2),
(145, 9, 'Who discovered America?', 'Christopher Columbus', 'James Cook', 'Marco Polo', 'Ferdinand Magellan', 1),
(146, 9, 'Who was the first man on the moon?', 'Neil Armstrong', 'Buzz Aldrin', 'Yuri Gagarin', 'John Glenn', 1),
(147, 9, 'What was the Titanic?', 'Warship', 'Passenger liner', 'Cargo ship', 'Fishing boat', 2),
(148, 9, 'What empire was Julius Caesar part of?', 'Egyptian', 'Roman', 'Greek', 'Persian', 2),
(149, 9, 'Who was the last Emperor of Russia?', 'Peter the Great', 'Alexander II', 'Nicholas II', 'Ivan the Terrible', 3),
(150, 9, 'Who painted the Mona Lisa?', 'Vincent van Gogh', 'Leonardo da Vinci', 'Pablo Picasso', 'Claude Monet', 2),
(151, 10, 'Who is known as the King of Pop?', 'Elvis Presley', 'Michael Jackson', 'Prince', 'Freddie Mercury', 2),
(152, 10, 'Who is the lead singer of the band Queen?', 'Mick Jagger', 'David Bowie', 'Freddie Mercury', 'Elton John', 3),
(153, 10, 'Who sang \"Rolling in the Deep\"?', 'Adele', 'Beyoncé', 'Taylor Swift', 'Lady Gaga', 1),
(154, 10, 'Who is known for the song \"Shape of You\"?', 'Ed Sheeran', 'Justin Bieber', 'Drake', 'Shawn Mendes', 1),
(155, 10, 'Who sang \"Thriller\"?', 'Prince', 'Michael Jackson', 'Madonna', 'David Bowie', 2),
(156, 10, 'Who is known as the Material Girl?', 'Britney Spears', 'Madonna', 'Lady Gaga', 'Christina Aguilera', 2),
(157, 10, 'Who is the lead singer of the band U2?', 'Freddie Mercury', 'Bono', 'Bruce Springsteen', 'Sting', 2),
(158, 10, 'Who sang \"Hello\" released in 2015?', 'Adele', 'Beyoncé', 'Taylor Swift', 'Rihanna', 1),
(159, 10, 'Which artist is known for the song \"Bad Romance\"?', 'Katy Perry', 'Lady Gaga', 'Britney Spears', 'Rihanna', 2),
(160, 10, 'Who is known as the Queen of Soul?', 'Aretha Franklin', 'Whitney Houston', 'Diana Ross', 'Tina Turner', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `quiz_name` varchar(255) NOT NULL,
  `classs` varchar(15) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `quiz_name`, `classs`, `image_url`) VALUES
(1, 'Math', 'Mathematics', '/miniprojwp/img12.jpg'),
(2, 'Science', 'Science', '/miniprojwp/img4.png'),
(3, 'Sports', 'Sports', '/miniprojwp/img17.jpg'),
(4, 'Movies', 'Entertainment', '/miniprojwp/img5.jpg'),
(5, 'Anime', 'Anime', '/miniprojwp/img15.jpeg'),
(6, 'Marvel', 'Marvel', '/miniprojwp/img3.png'),
(7, 'DC', 'Entertainment', '/miniprojwp/img2.png'),
(8, 'Geography', 'Geography', '/miniprojwp/img81.png'),
(9, 'History', 'History', '/miniprojwp/img77.webp'),
(10, 'Singers', 'Music', '/miniprojwp/img19.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ranking`
--

DROP TABLE IF EXISTS `ranking`;
CREATE TABLE `ranking` (
  `ranking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `dob`, `email`, `username`, `password`) VALUES
(4, 'Prathamesh', '2024-06-04', 'pratham12345@gmail.com', 'Prathamesh', '$2y$10$GParZfV5Cdr8A/AYmxbz8u8ma6nYj2FINQjaxLc/O2KTXDyfB3B8y'),
(5, 'Aarush', '2024-12-06', 'Prathameshsalunke83@gmail.com', 'Aarush123', '$2y$10$vbqYSAF2r4JH9MD76zJFrepk.UIb4w6rBymeYKCzQzuGkkHEGVn/m'),
(6, 'Shreya', '2024-12-15', 'Shreya@gmail.com', 'Shreya123', '$2y$10$mzkSiok4kvORsAFVzIqfZu4Nf3urt1dUwpPZaYA8Qdm.ypi6M72Ym'),
(7, 'Sau', '2024-08-26', 'Prathameshsalunke.67@gmail.com', 'Sau123', 'Sau'),
(8, 'Naman', '2025-01-17', 'naman123@gmail.com', 'naman123', 'naman');

-- --------------------------------------------------------

--
-- Table structure for table `user_quiz_ranking`
--

DROP TABLE IF EXISTS `user_quiz_ranking`;
CREATE TABLE `user_quiz_ranking` (
  `ranking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_quiz_ranking`
--

INSERT INTO `user_quiz_ranking` (`ranking_id`, `user_id`, `quiz_id`, `score`) VALUES
(8, 4, 1, 14),
(9, 4, 2, 6),
(10, 6, 1, 12),
(11, 6, 2, 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`sender_id`,`receiver_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`ranking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_quiz_ranking`
--
ALTER TABLE `user_quiz_ranking`
  ADD PRIMARY KEY (`ranking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ranking`
--
ALTER TABLE `ranking`
  MODIFY `ranking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_quiz_ranking`
--
ALTER TABLE `user_quiz_ranking`
  MODIFY `ranking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `friend_requests_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`);

--
-- Constraints for table `ranking`
--
ALTER TABLE `ranking`
  ADD CONSTRAINT `ranking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ranking_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`);

--
-- Constraints for table `user_quiz_ranking`
--
ALTER TABLE `user_quiz_ranking`
  ADD CONSTRAINT `user_quiz_ranking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_quiz_ranking_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
