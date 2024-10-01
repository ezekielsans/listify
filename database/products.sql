-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Oct 01, 2024 at 10:29 AM
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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_status` enum('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `product_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
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

INSERT INTO `products` (`product_id`, `product_image`, `product_name`, `product_description`, `product_category`, `product_price`, `product_stocks`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, '1726414608225_14.jpg', 'Pandesal', 'this is a pandesal', 'Food', 50.0000, 10, '', 'admin@email.test', '2024-09-08 08:26:39', '2024-09-23 21:17:23'),
(9, '1726414608225_14.jpg', 'PineApple', 'this is a pineapple', 'fruits', 55.0000, 0, '', 'admin@email.test', '2024-09-08 11:07:51', '2024-09-23 21:22:52'),
(12, '1726414608225_14.jpg', 'Camera', 'this is  a camera', 'Tools', 16600.0000, 50, '', '', '2024-09-08 11:33:23', '2024-09-08 11:33:23'),
(13, '1726414608225_14.jpg', 'Mocha', 'Coffe flavored test', 'Coffee', 300.0000, 50, '', '', '2024-09-15 15:01:38', '2024-09-15 15:01:38'),
(14, '1726414608225_14.jpg', 'DJI Action 3', 'Action camera test 3,updated', 'Camera', 25500.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-15 15:25:18', '2024-09-15 15:36:48'),
(15, '1726414608225_14.jpg', 'Kiwi', 'This is a test', 'Fruits', 40.0000, 50, '', '', '2024-09-08 08:26:39', '2024-09-08 08:26:39'),
(16, '1726414608225_14.jpg', 'chia seeds', 'test 1', 'fruits', 50.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:27:34', '2024-09-16 13:27:34'),
(17, '1726414608225_14.jpg', 'colgate', 'test', 'Daily', 25.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:27:53', '2024-09-16 13:27:53'),
(18, '1726414608225_14.jpg', 'Internet', 'test 4', 'Tool', 30.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:28:27', '2024-09-16 13:28:27'),
(19, '1726414608225_14.jpg', 'Rambutan', 'test 5', 'Fruits', 40.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:28:40', '2024-09-16 13:28:40'),
(21, '1726414608225_14.jpg', 'Strawberry ', 'test', 'Fruits', 60.0000, 50, 'test4@email.com', 'test4@email.com', '2024-09-16 13:36:54', '2024-09-16 13:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_details`
--

CREATE TABLE `shipping_details` (
  `shipping_id` int NOT NULL,
  `order_id` int NOT NULL,
  `shipping_address` int NOT NULL,
  `tracking_number` varchar(100) NOT NULL,
  `delivery_status` varchar(50) NOT NULL,
  `shipped_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delivered_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
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

INSERT INTO `users` (`user_id`, `user_image`, `email`, `password`, `first_name`, `last_name`, `role`, `status`, `created_at`) VALUES
(17, '1727036240591_17.jpg', 'gambino@email.test', '$2y$10$s9OSY8YFNX.QEaIppuS4eOmaHPLuvFOr/7F6YRLzcLV3PMhayaSJK', 'Childish', 'Gambino', 'customer', 'inactive', '2024-09-22 01:54:58'),
(20, '1727036277926_20.jpg', 'admin@email.test', '$2y$10$FtXQYkNL6jc8DhilcwpAT.BV2Oobbm0nS09UuXGBcR2g9fpsPUY3C', 'admin', 'admin', 'administrator', 'active', '2024-09-22 02:05:19'),
(21, '1727036240591_17.jpg', 'roger@email.test', '$2y$10$zpwIFFAQNGEWUu3eEVIwc.hodej4q0Hx/cWUlKLRtDD7ASMKpwtiW', 'Roger', 'Baker', 'customer', 'active', '2024-09-22 20:41:19'),
(22, '1727036240591_17.jpg', 'paulo@email.test', '$2y$10$jIDD4Xw7v23K6/r0beQYB.37O5I3DhRbV3oenIt5ov..5IvZynkzu', 'Paulo', 'Banchero', 'customer', 'active', '2024-09-22 20:41:42'),
(24, '1727036240591_17.jpg', 'ej@email.test', '$2y$10$/n72EBflqbOFhabdH7/MQujlXytNdAXGDQiwA4pouEUvvDL5OiSnq', 'Ej', 'Santos', 'customer', 'active', '2024-09-22 20:51:46'),
(25, '1727036240591_17.jpg', 'lisa@email.test', '$2y$10$Vy.EbR1h3uEJp0IeS27RVeDXBua0Of7XXS6urVEfQ4/a460ZCaBiO', 'Lisa', 'Manoban', 'customer', 'active', '2024-09-22 20:54:01'),
(26, '1727036240591_17.jpg', 'sheena@email.test', '$2y$10$nCUgkOx7fGyyEFNIvb6SwOTncYbzxrWWZiJuPwlwX9Gcaj.SdO1IS', 'Sheena', 'Bini', 'customer', 'active', '2024-09-22 20:55:17'),
(27, '1727036240591_17.jpg', 'paul@email.test', '$2y$10$fop3FA/zAR6BrMcQrBiT2uErbflRdTc3/L7eiE4Ib0RfAbkgzGuKG', 'Paul', 'Wasabi', 'customer', 'active', '2024-09-22 20:55:52'),
(28, '1727036240591_17.jpg', 'david@email.com', '$2y$10$K.xzAArl9daVAnJzqHgUEOyGnHeEcMWKP2jGsxRDVuf0/VlbLbCge', 'David', 'Bowie', 'customer', 'active', '2024-09-22 20:56:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `order_id_fkey` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `shipping_details`
--
ALTER TABLE `shipping_details`
  MODIFY `shipping_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD CONSTRAINT `order_id_fkey` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
