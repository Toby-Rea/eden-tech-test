-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Apr 19, 2023 at 11:00 PM
-- Server version: 8.0.33
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eden-tech-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `title` enum('Mr','Mrs','Miss','Ms','Dr') NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `informal_name` varchar(20) DEFAULT NULL,
  `address` varchar(60) NOT NULL,
  `town` varchar(20) DEFAULT NULL,
  `postcode` varchar(8) NOT NULL,
  `ni_number` varchar(9) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `mobile_tel` varchar(17) DEFAULT NULL,
  `home_tel` varchar(17) DEFAULT NULL,
  `other_tel` varchar(17) DEFAULT NULL,
  `personal_email` varchar(50) DEFAULT NULL,
  `initials` varchar(6) DEFAULT NULL,
  `emergency_contact_name` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `surname`, `title`, `gender`, `informal_name`, `address`, `town`, `postcode`, `ni_number`, `date_of_birth`, `mobile_tel`, `home_tel`, `other_tel`, `personal_email`, `initials`, `emergency_contact_name`) VALUES
(1, 'Toby', 'Rea', 'Mr', 'male', NULL, '3 Brympton Close', NULL, 'SP6 1DW', NULL, '2000-09-07', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Ada', 'Lovelace', 'Mrs', 'female', NULL, 'Marylebone, London', NULL, 'NW1 4LB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'John', 'Wick', 'Mr', 'male', NULL, '1 Wall Street Court', NULL, 'NY 10005', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
