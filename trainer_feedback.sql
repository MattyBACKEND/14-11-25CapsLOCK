-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 07:57 PM
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
-- Database: `ecg_fitness`
--

-- --------------------------------------------------------

--
-- Table structure for table `trainer_feedback`
--

CREATE TABLE `trainer_feedback` (
  `feedback_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer_feedback`
--

INSERT INTO `trainer_feedback` (`feedback_id`, `trainer_id`, `rating`, `comment`, `created_at`) VALUES
(1, 20, 5, 'heheeh', '2025-11-24 02:53:25'),
(2, 20, 5, 'Genrev Matulog kana', '2025-11-24 02:54:28'),
(3, 20, 4, 'njhn', '2025-11-24 02:55:05'),
(4, 22, 3, 'sdfasdfa', '2025-11-24 02:56:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `trainer_feedback`
--
ALTER TABLE `trainer_feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trainer_feedback`
--
ALTER TABLE `trainer_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
