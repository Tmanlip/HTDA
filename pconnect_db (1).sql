-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 01:39 PM
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
-- Database: `pconnect_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `session_name` varchar(255) NOT NULL,
  `experience_level` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `members` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `session_name`, `experience_level`, `time`, `location`, `max_participants`, `members`) VALUES
(1, 'Mathematics', 'Beginner', 'Weekdays Morning', 'Library', 3, 3),
(2, 'Mathematics', 'Advanced', 'Weekdays Morning', 'Library', 2, 0),
(3, 'Mathematics', 'Advanced', 'Weekends Morning', 'Library', 1, 0),
(4, 'Digital logic', 'Beginner', 'Weekends Morning', 'Library', 2, 0),
(5, 'Digital logic', 'Beginner', 'Weekends Evening', 'Library', 5, 0),
(6, 'kjn', 'Intermediate', 'Weekdays Evening', 'ljn', 10, 0),
(7, 'mathematics', 'Beginner', 'Weekdays Evening', 'library', 2, 0),
(8, 'science', 'Advanced', 'Weekends Afternoon', 'MA156', 200, 0),
(9, 'mathematics', 'Intermediate', 'Weekdays Evening', 'library', 5, 0),
(10, 'science', 'Intermediate', 'Weekdays Afternoon', 'library', 3, 0),
(11, 'science', 'Intermediate', 'Weekdays Morning', 'library', 3, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
