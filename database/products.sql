-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Sep 24, 2024 at 11:16 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `product_image`, `product_name`, `product_description`, `product_category`, `product_price`, `product_stocks`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, '1727123408510_7.png', 'Pandesal', 'this is a pandesal', 'Food', 50.0000, 10, '', 'admin@email.test', '2024-09-08 08:26:39', '2024-09-23 21:17:23'),
(9, '1725797246629_9.jpg', 'PineApple', 'this is a pineapple', 'fruits', 55.0000, 0, '', 'admin@email.test', '2024-09-08 11:07:51', '2024-09-23 21:22:52'),
(12, '12.jpg', 'Camera', 'this is  a camera', 'Tools', 16600.0000, 50, '', '', '2024-09-08 11:33:23', '2024-09-08 11:33:23'),
(13, 'Error: File uploaded.', 'Mocha', 'Coffe flavored test', 'Coffee', 300.0000, 50, '', '', '2024-09-15 15:01:38', '2024-09-15 15:01:38'),
(14, '1726414608225_14.jpg', 'DJI Action 3', 'Action camera test 3,updated', 'Camera', 25500.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-15 15:25:18', '2024-09-15 15:36:48'),
(15, '', 'Kiwi', 'This is a test', 'Fruits', 40.0000, 50, '', '', '2024-09-08 08:26:39', '2024-09-08 08:26:39'),
(16, 'Error: File uploaded.', 'chia seeds', 'test 1', 'fruits', 50.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:27:34', '2024-09-16 13:27:34'),
(17, 'Error: File uploaded.', 'colgate', 'test', 'Daily', 25.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:27:53', '2024-09-16 13:27:53'),
(18, 'Error: File uploaded.', 'Internet', 'test 4', 'Tool', 30.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:28:27', '2024-09-16 13:28:27'),
(19, 'Error: File uploaded.', 'Rambutan', 'test 5', 'Fruits', 40.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:28:40', '2024-09-16 13:28:40'),
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
(17, '1727036240591_17.jpg', 'gambino@email.test', '$2y$10$s9OSY8YFNX.QEaIppuS4eOmaHPLuvFOr/7F6YRLzcLV3PMhayaSJK', 'Childish', 'Gambino', 'customer', 'inactive', '2024-09-22 01:54:58'),
(20, '1727036277926_20.jpg', 'admin@email.test', '$2y$10$FtXQYkNL6jc8DhilcwpAT.BV2Oobbm0nS09UuXGBcR2g9fpsPUY3C', 'admin', 'admin', 'administrator', 'active', '2024-09-22 02:05:19'),
(21, '1727036240591_17.jpg', 'roger@email.test', '$2y$10$zpwIFFAQNGEWUu3eEVIwc.hodej4q0Hx/cWUlKLRtDD7ASMKpwtiW', 'Roger', 'Baker', 'customer', 'active', '2024-09-22 20:41:19'),
(22, '1727036240591_17.jpg', 'paulo@email.test', '$2y$10$jIDD4Xw7v23K6/r0beQYB.37O5I3DhRbV3oenIt5ov..5IvZynkzu', 'Paulo', 'Banchero', 'customer', 'active', '2024-09-22 20:41:42'),
(24, '1727036240591_17.jpg', 'ej@email.test', '$2y$10$/n72EBflqbOFhabdH7/MQujlXytNdAXGDQiwA4pouEUvvDL5OiSnq', 'Ej', 'Santos', 'customer', 'active', '2024-09-22 20:51:46'),
(25, '1727036240591_17.jpg', 'lisa@email.test', '$2y$10$Vy.EbR1h3uEJp0IeS27RVeDXBua0Of7XXS6urVEfQ4/a460ZCaBiO', 'Lisa', 'Manoban', 'customer', 'active', '2024-09-22 20:54:01'),
(26, '1727036240591_17.jpg', 'sheena@email.test', '$2y$10$nCUgkOx7fGyyEFNIvb6SwOTncYbzxrWWZiJuPwlwX9Gcaj.SdO1IS', 'Sheena', 'Bini', 'customer', 'active', '2024-09-22 20:55:17'),
(27, '1727036240591_17.jpg', 'paul@email.test', '$2y$10$fop3FA/zAR6BrMcQrBiT2uErbflRdTc3/L7eiE4Ib0RfAbkgzGuKG', 'Paul', 'Wasabi', 'customer', 'active', '2024-09-22 20:55:52'),
(28, '1727036240591_17.jpg', 'david@email.com', '$2y$10$K.xzAArl9daVAnJzqHgUEOyGnHeEcMWKP2jGsxRDVuf0/VlbLbCge', 'David', 'Bowie', 'customer', 'active', '2024-09-22 20:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_cart`
--

CREATE TABLE `user_cart` (
  `ID` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `ordered_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_cart`
--

INSERT INTO `user_cart` (`ID`, `user_id`, `product_id`, `quantity`, `ordered_at`) VALUES
(1, 24, 14, 8, '2024-09-24 21:34:29');

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
-- Indexes for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_fkey` (`user_id`),
  ADD KEY `product_fkey` (`product_id`);

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
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_cart`
--
ALTER TABLE `user_cart`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD CONSTRAINT `product_fkey` FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
