-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Sep 22, 2024 at 02:06 AM
-- Server version: 9.0.1
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `products`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int NOT NULL,
  `product_image` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_category` varchar(255) NOT NULL,
  `product_price` decimal(19,4) NOT NULL,
  `product_stocks` int NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `product_image`, `product_name`, `product_description`, `product_category`, `product_price`, `product_stocks`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, '', 'Kiwi', 'This is a test', 'Fruits', 50.0000, 50, '', '', '2024-09-08 08:26:39', '2024-09-08 08:26:39'),
(6, '', 'Banana', 'This is a test', 'Fruits', 40.0000, 50, '', '', '2024-09-08 08:25:51', '2024-09-08 08:25:51'),
(8, NULL, 'Orange', 'This is a test', 'Fruits', 35.0000, 50, '', '', '2024-09-08 11:04:10', '2024-09-08 11:04:10'),
(9, '1725797246629_9.jpg', 'PineApple', 'this is a pineapple', 'fruits', 55.0000, 50, '', '', '2024-09-08 11:07:51', '2024-09-08 11:07:51'),
(12, '12.jpg', 'Camera', 'this is  a camera', 'Tools', 16600.0000, 50, '', '', '2024-09-08 11:33:23', '2024-09-08 11:33:23'),
(13, 'Error: File uploaded.', 'Mocha', 'Coffe flavored test', 'Coffee', 300.0000, 50, '', '', '2024-09-15 15:01:38', '2024-09-15 15:01:38'),
(14, '1726414608225_14.jpg', 'DJI Action 3', 'Action camera test 3,updated', 'Camera', 25500.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-15 15:25:18', '2024-09-15 15:36:48'),
(15, '', 'Kiwi', 'This is a test', 'Fruits', 40.0000, 50, '', '', '2024-09-08 08:26:39', '2024-09-08 08:26:39'),
(16, 'Error: File uploaded.', 'chia seeds', 'test 1', 'fruits', 50.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:27:34', '2024-09-16 13:27:34'),
(17, 'Error: File uploaded.', 'colgate', 'test', 'Daily', 25.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:27:53', '2024-09-16 13:27:53'),
(18, 'Error: File uploaded.', 'Internet', 'test 4', 'Tool', 30.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:28:27', '2024-09-16 13:28:27'),
(19, 'Error: File uploaded.', 'Rambutan', 'test 5', 'Fruits', 40.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:28:40', '2024-09-16 13:28:40'),
(20, 'Error: File uploaded.', 'Banana', 'test', 'Fruits', 50.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:28:48', '2024-09-16 13:28:48'),
(21, 'Error: File uploaded.', 'Strawberry ', 'test', 'Fruits', 60.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:36:54', '2024-09-16 13:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `user_image`, `email`, `password`, `first_name`, `last_name`, `role`, `status`, `created_at`) VALUES
(14, NULL, 'roger@email.test', '$2y$10$ANd4clveQhQr1JbhaDSSMuotAXxKnlwc8eGmsvIIdxJ0iHOPAgzs6', 'Roger', 'Baker', 'customer', 'active', '2024-09-22 01:54:14'),
(15, NULL, 'johnny@email.test', '$2y$10$Kechu7uC.rB2DGKhdVDsze/OskzyRUbMy6WSGhIjYgzkAvbWsoeDi', 'Johnn', 'Bravo', 'customer', 'active', '2024-09-22 01:54:28'),
(16, NULL, 'janice@email.test', '$2y$10$vUqou.BuFhbhItFuAOqIGO0CycYeyuv4/DAiunsjp59Zd3TwJ.SMa', 'Janice', 'Dilaw', 'customer', 'active', '2024-09-22 01:54:39'),
(17, NULL, 'gambino@email.test', '$2y$10$s9OSY8YFNX.QEaIppuS4eOmaHPLuvFOr/7F6YRLzcLV3PMhayaSJK', 'Childish', 'Gambino', 'customer', 'active', '2024-09-22 01:54:58'),
(18, NULL, 'fatima@email.test', '$2y$10$ubEAY1fo.4K1dXWO6bmkJOmPfYh.q/ufpLk.FpmqRz.efpaEbbLcW', 'Fatima', 'Timbers', 'customer', 'active', '2024-09-22 01:55:20'),
(19, NULL, 'stephanie@email.test', '$2y$10$us1TlfVrresnemmcElObXeH8OKfaHKrDy6TnRQ.NqOEbt5PJgeZQK', 'Stephanie', 'Silvers', 'customer', 'active', '2024-09-22 01:55:41'),
(20, NULL, 'admin@email.test', '$2y$10$FtXQYkNL6jc8DhilcwpAT.BV2Oobbm0nS09UuXGBcR2g9fpsPUY3C', 'admin', 'admin', 'administrator', 'active', '2024-09-22 02:05:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
