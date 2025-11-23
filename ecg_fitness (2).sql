-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 06:16 PM
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
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `session_count` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booked_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dietary_logs`
--

CREATE TABLE `dietary_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_date` date NOT NULL,
  `meal_type` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `calories` decimal(8,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logsheet`
--

CREATE TABLE `logsheet` (
  `Name` varchar(100) NOT NULL,
  `Membership` varchar(50) DEFAULT NULL,
  `Start` date DEFAULT NULL,
  `End` date DEFAULT NULL,
  `Remaining` int(11) DEFAULT NULL,
  `Terms` enum('Monthly','Yearly','Daily') DEFAULT NULL,
  `Months` int(11) DEFAULT NULL,
  `Program` varchar(100) DEFAULT NULL,
  `Monthly_Terms` text DEFAULT NULL,
  `Start_of_Term` date DEFAULT NULL,
  `End_of_Term` date DEFAULT NULL,
  `Days` int(11) DEFAULT NULL,
  `Remaining_Days` int(11) DEFAULT NULL,
  `Status` enum('Active','Expired','On Hold') DEFAULT NULL,
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_list`
--

CREATE TABLE `master_list` (
  `Name` varchar(100) NOT NULL,
  `Notes` text DEFAULT NULL,
  `CP_No` varchar(15) DEFAULT NULL,
  `Membership` varchar(50) DEFAULT NULL,
  `Start` date DEFAULT NULL,
  `End` date DEFAULT NULL,
  `Remaining` int(11) DEFAULT NULL,
  `Terms` enum('Monthly','Yearly','Daily') DEFAULT NULL,
  `Months` int(11) DEFAULT NULL,
  `Program` varchar(100) DEFAULT NULL,
  `Monthly_Terms` text DEFAULT NULL,
  `Start_of_Term` date DEFAULT NULL,
  `End_of_Term` date DEFAULT NULL,
  `Days` int(11) DEFAULT NULL,
  `Remaining_Days` int(11) DEFAULT NULL,
  `Status` enum('Active','Expired','On Hold') DEFAULT NULL,
  `NoID` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_transaction`
--

CREATE TABLE `payment_transaction` (
  `id` int(11) NOT NULL,
  `Time` datetime DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `Training` varchar(255) DEFAULT NULL,
  `Amount` float DEFAULT NULL,
  `Payment_type` enum('Paypal','Gcash','Cash') NOT NULL,
  `program_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_transaction`
--

INSERT INTO `payment_transaction` (`id`, `Time`, `client_id`, `Training`, `Amount`, `Payment_type`, `program_id`) VALUES
(38, '2025-11-24 00:18:00', 106, 'Student - Lifetime', 1, 'Paypal', NULL),
(39, '2025-11-24 00:24:38', 107, 'Student - 6 Months', 1, 'Paypal', NULL),
(40, '2025-11-24 00:37:55', 108, 'Student - 1 Year', 1, 'Paypal', NULL),
(41, '2025-11-24 00:47:54', 109, 'Student - Lifetime', 1, 'Paypal', NULL),
(42, '2025-11-24 00:55:55', 110, 'Student - Lifetime', 1, 'Paypal', NULL),
(43, '2025-11-24 00:59:02', 111, 'Student - 1 Year', 1, 'Paypal', NULL),
(44, '2025-11-24 01:03:41', 112, 'Student - 1 Year', 1, 'Paypal', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `trainer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`trainer_id`, `name`, `email`, `password`) VALUES
(20, 'Alberto', 'Alberto@gmail.com', 'Alberto12345');

-- --------------------------------------------------------

--
-- Table structure for table `trainer_profiles`
--

CREATE TABLE `trainer_profiles` (
  `id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `about_me` text DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `schedule` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`schedule`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer_profiles`
--

INSERT INTO `trainer_profiles` (`id`, `trainer_id`, `profile_pic`, `about_me`, `specialization`, `location`, `schedule`) VALUES
(9, 20, 'uploads/trainer_20.jpg', 'Jorge Alberto', 'Circuit Training', 'Ecg Pro', '{\"Monday\":true,\"Tuesday\":false,\"Wednesday\":true,\"Thursday\":false,\"Friday\":false,\"Saturday\":true,\"Sunday\":false}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `cp_no` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `focus` varchar(100) DEFAULT NULL,
  `goal` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `training_days` int(11) DEFAULT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL,
  `weight_kg` decimal(5,2) DEFAULT NULL,
  `height_cm` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `cp_no`, `fullname`, `email`, `password`, `gender`, `focus`, `goal`, `activity`, `training_days`, `bmi`, `Age`, `verified`, `verification_token`, `weight_kg`, `height_cm`) VALUES
(112, '09924123347', 'FAHGOT', 'matthew13cabulong@gmail.com', '$2y$10$RdHfm25EahfuZGhBn/pOSOaLpoj0bcP0VrZlkkCMep85v5M./ZNxm', 'Male', 'Arms', 'Lose Weight', 'Moderate', 0, 22.59, 21, 0, NULL, 63.00, 167.00);

-- --------------------------------------------------------

--
-- Table structure for table `workout_journal`
--

CREATE TABLE `workout_journal` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day_of_week` varchar(10) NOT NULL,
  `exercise_name` varchar(255) NOT NULL,
  `sets` int(5) DEFAULT NULL,
  `reps_time` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workout_sessions`
--

CREATE TABLE `workout_sessions` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_date` date NOT NULL,
  `total_duration_seconds` int(11) NOT NULL,
  `workout_day` varchar(10) DEFAULT NULL,
  `exercises_completed` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `dietary_logs`
--
ALTER TABLE `dietary_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `master_list`
--
ALTER TABLE `master_list`
  ADD PRIMARY KEY (`program_id`);

--
-- Indexes for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_program` (`program_id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`trainer_id`);

--
-- Indexes for table `trainer_profiles`
--
ALTER TABLE `trainer_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `workout_journal`
--
ALTER TABLE `workout_journal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `workout_sessions`
--
ALTER TABLE `workout_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `dietary_logs`
--
ALTER TABLE `dietary_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `master_list`
--
ALTER TABLE `master_list`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `trainer_profiles`
--
ALTER TABLE `trainer_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `workout_journal`
--
ALTER TABLE `workout_journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `workout_sessions`
--
ALTER TABLE `workout_sessions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`trainer_id`);

--
-- Constraints for table `dietary_logs`
--
ALTER TABLE `dietary_logs`
  ADD CONSTRAINT `dietary_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  ADD CONSTRAINT `fk_program` FOREIGN KEY (`program_id`) REFERENCES `master_list` (`program_id`);

--
-- Constraints for table `workout_journal`
--
ALTER TABLE `workout_journal`
  ADD CONSTRAINT `workout_journal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `workout_sessions`
--
ALTER TABLE `workout_sessions`
  ADD CONSTRAINT `workout_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
