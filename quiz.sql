-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 21, 2023 at 06:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `options` text NOT NULL,
  `correct` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `options`, `correct`) VALUES
(189, 'In Pali texts, who among the following is referred to as Nigantha Nataputta?', '[\"Gautam Buddha\",\"Mahavira\",\"Parshvanatha\"]', 'Mahavira'),
(191, 'Which ruler is credited for the spread of Jainism in Karnataka?', '[\"Chandragupta Maurya\",\"Bimbisara\"]', 'Chandragupta Maurya'),
(192, 'Sharks are mammals?', '[\"True\",\"False\"]', 'False'),
(193, 'What does CSS stand for?', '[\"Counter Style Sheets\",\"Cascading Style Sheets\",\"Computer Style Sheets\",\"Colorful Style Sheets\"]', 'Cascading Style Sheets'),
(206, 'Which of the following is not a Capital City?', '[\"New York\",\"Berlin\",\"Moscow\",\"Dhaka\"]', 'New York'),
(208, 'I study stars , moons , planets , comets , galaxies', '[\"Astrologer\",\"Astronomer\",\"Meteorologist\"]', 'Astronomer'),
(209, 'Where is basketball played?', '[\"In a ring\",\"On pitch\",\"On court\",\"In stadium\"]', 'On court'),
(210, 'Herbivores are animal eaters.', '[\"True\",\"False\"]', 'False'),
(221, 'Greenland is the largest island in the world', '[\"True\",\"False\"]', 'True'),
(223, 'Venezuela is home to the world\'s highest waterfall.', '[\"True\",\"False\"]', 'True');

-- --------------------------------------------------------

--
-- Table structure for table `quizHistory`
--

CREATE TABLE `quizHistory` (
  `id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `score` int(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizHistory`
--

INSERT INTO `quizHistory` (`id`, `name`, `score`, `date`) VALUES
(19, 'Henil\r\n', 3, '2023-12-18'),
(22, 'Henil\r\n', 4, '2023-12-19'),
(23, 'Henil\r\n', 8, '2023-12-19'),
(24, 'Henil\r\n', 10, '2023-12-19'),
(25, 'Henil', 8, '2023-12-19'),
(28, 'Henil', 7, '2023-12-19'),
(29, 'Henil\r\n', 10, '2023-12-19'),
(33, 'Henil', 0, '2023-12-19'),
(34, 'Henil', 8, '2023-12-19'),
(40, 'Henil', 0, '2023-12-20'),
(43, 'Henil', 8, '2023-12-20'),
(44, 'Henil', 8, '2023-12-20'),
(49, 'Henil', 0, '2023-12-20'),
(50, 'Henil', 0, '2023-12-20'),
(51, 'Henil', 0, '2023-12-20'),
(52, 'Henil', 0, '2023-12-20'),
(53, 'Henil', 0, '2023-12-20'),
(54, 'Henil', 0, '2023-12-20'),
(55, 'Henil', 0, '2023-12-20'),
(56, 'Henil', 0, '2023-12-20'),
(57, 'Henil', 5, '2023-12-20'),
(58, 'Henil', 9, '2023-12-20'),
(59, 'Henil', 1, '2023-12-20'),
(60, 'Henil', 1, '2023-12-20'),
(61, 'Henil', 0, '2023-12-20'),
(62, 'Henil', 0, '2023-12-21'),
(63, 'Henil', 0, '2023-12-21'),
(64, 'Henil', 8, '2023-12-21'),
(65, 'Henil\r\n', 5, '2023-12-21'),
(66, 'Henil', 0, '2023-12-21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `name`) VALUES
(4, 'henilsuhagiya0@gmail.com', '1234', 'customer', 'Henil'),
(5, 'henilsuhagiya0@gmail.com', 'admin', 'admin', 'Henil\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizHistory`
--
ALTER TABLE `quizHistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `quizHistory`
--
ALTER TABLE `quizHistory`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
