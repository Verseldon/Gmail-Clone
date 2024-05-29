-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 10:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gmaildb`
--

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` int(12) NOT NULL,
  `sender_id` int(12) NOT NULL,
  `receiver_id` int(12) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`id`, `sender_id`, `receiver_id`, `subject`, `body`) VALUES
(31, 2, 1, '123', '123'),
(32, 2, 1, '123', '123'),
(33, 1, 1, '123', '123'),
(34, 1, 3, 'sss', '123'),
(35, 1, 3, 'Doggy', '2'),
(36, 1, 1, 'compose test', 'email body'),
(37, 1, 3, '123', '123'),
(38, 3, 3, '123', '123'),
(39, 3, 2, 'dog', 'dogdog'),
(40, 3, 3, 'tara', 'tagay balik'),
(41, 3, 3, 'tara', 'tagay balik'),
(42, 4, 1, 'Hello', 'Goodbye'),
(43, 4, 4, 'Testing', 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `email_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`id`, `user_id`, `email_id`) VALUES
(50, 1, 31),
(51, 2, 31),
(52, 1, 32),
(53, 2, 32),
(54, 1, 33),
(55, 3, 34),
(56, 1, 34),
(57, 3, 35),
(58, 1, 35),
(59, 1, 36),
(60, 3, 37),
(61, 1, 37),
(62, 3, 38),
(63, 2, 39),
(64, 3, 39),
(65, 3, 40),
(66, 3, 41),
(67, 1, 42),
(68, 4, 42),
(69, 4, 43);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'Johndu', '$2y$10$gvf4/aA42sCdXVq4uw1w4ekRbrd6PDcR3XpKUzdyiwetgr.lhHcRK', 'johndu@gmail.com'),
(2, 'obese dog', '$2y$10$iOmxDnOSCMB2VbQoOAZr/.P/c2GthvLrGOq6eXryDaK1d/URVIsDu', 'obesedog@gmail.com'),
(3, 'nate', '$2y$10$nkMcysY3Jgsdc06MTGClJO1qUYbjmZW46x7wM5sKTDIUg6t4c69W2', 'nate@gmail.com'),
(4, 'Jefferson Tan', '$2y$10$PKwatV1xSK2k.3TFNlbkFuCGaNhpmCY5qo0p0uHK1N90zaKmW4BLe', 'jeffersontan@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `email_id` (`email_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `receiver_id` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sender_id` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `inbox`
--
ALTER TABLE `inbox`
  ADD CONSTRAINT `email_id` FOREIGN KEY (`email_id`) REFERENCES `emails` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
