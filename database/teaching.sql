-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2026 at 03:47 AM
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
-- Database: `teaching`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_hash` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token_hash`, `expires_at`, `used_at`, `created_at`) VALUES
(1, 2, '$2y$10$qEpMVDOoyTwRmqBMV/zJbefJ84BGISqJYqzcIJewhTNTMSsDTkZje', '2026-04-09 18:27:18', '2026-04-09 18:13:45', '2026-04-09 17:57:18'),
(2, 2, '$2y$10$sSgdl3lLZUnzaCNjHPfMguIs6Ik.2.BejSiugcagIx0D6ODWm4n6e', '2026-04-09 18:43:45', '2026-04-09 18:22:34', '2026-04-09 18:13:45'),
(3, 2, '$2y$10$D3RXVZTpXaoXe3Mj78HMDuSf44Em8bHR7f.fhVNcyPjXEp//vmEQ2', '2026-04-09 18:52:34', '2026-04-09 18:24:55', '2026-04-09 18:22:34'),
(4, 2, '$2y$10$6.gURWm1Ph6eZuN0wACu4uTSFO./hof8of0l7Rj/H7SBYfDc/e.qW', '2026-04-09 18:54:55', '2026-04-09 18:25:06', '2026-04-09 18:24:55'),
(5, 2, '$2y$10$ubFhPHyysYR6NFhRE6WRXuYLlHCqVwLM2JPvZIxW39oV1P5OlMuOG', '2026-04-09 18:55:06', '2026-04-10 21:28:34', '2026-04-09 18:25:06'),
(6, 2, '$2y$10$N7gkvnbxiWO5xWs9/j0ZsOePyxgBR2gT5rNanMs9vAsEITaCBFtA.', '2026-04-10 21:58:35', '2026-04-10 21:35:39', '2026-04-10 21:28:35'),
(7, 2, '$2y$10$N8GVmR2J0Qq8m8viyhbgw.ySMoz1QTVl1TEqlyypm52.VB/4l/djO', '2026-04-10 22:05:39', '2026-04-10 22:25:12', '2026-04-10 21:35:39'),
(8, 2, '$2y$10$i.OfmQmVCQ325d7Xa49ApuMVIUxnXl35WNpVt/98lKGjTV0gZtwii', '2026-04-10 22:55:12', NULL, '2026-04-10 22:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'Primary Key',
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password_hash`) VALUES
(2, 'Jennisha', 'Smith', 'Jennisha', 'smithjennisha15@gmail.com', '$2y$10$Rgbvz/KGmJDcGwrE36H3hel9n6o2Z14UN5Ab81y4G0cOnS3qWCOb.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_password_resets_user_id` (`user_id`),
  ADD KEY `idx_password_resets_expires_at` (`expires_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `fk_password_resets_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
