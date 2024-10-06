-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Oct 06, 2024 at 11:13 PM
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
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int NOT NULL,
  `user_id` int NOT NULL,
  `address_line1` varchar(255) DEFAULT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `user_id`, `address_line1`, `address_line2`, `city`, `postal_code`, `country`, `created_at`, `updated_at`) VALUES
(5, 24, '21 Dinar', '21 dinar st. camella 3-1, Las Pinas , Philippines', 'Las Pinas', '1744', 'Philippines', '2024-10-02 20:54:14', '2024-10-02 20:54:14');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_status_lu`
--

CREATE TABLE `delivery_status_lu` (
  `delivery_status_id` int NOT NULL,
  `delivery_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `delivery_status_lu`
--

INSERT INTO `delivery_status_lu` (`delivery_status_id`, `delivery_status`) VALUES
(1, 'pending'),
(2, 'shipped'),
(3, 'returned'),
(4, 'canceled');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_status` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `order_status`, `created_at`, `updated_at`) VALUES
(21, 24, 150.00, 2, '2024-10-06 03:56:21', '2024-10-06 22:47:39'),
(22, 24, 160.00, 2, '2024-10-06 03:56:26', '2024-10-06 22:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `product_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `product_price`) VALUES
(20, 21, 7, 3, 50.00),
(21, 22, 19, 4, 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_status_lu`
--

CREATE TABLE `order_status_lu` (
  `order_status_id` int NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_status_lu`
--

INSERT INTO `order_status_lu` (`order_status_id`, `order_status`) VALUES
(1, 'pending'),
(2, 'placed'),
(3, 'shipped'),
(4, 'paid'),
(5, 'completed'),
(6, 'canceled');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int NOT NULL,
  `order_id` int NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` int DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `payment_status`, `transaction_id`, `payment_date`) VALUES
(5, 21, 'on', 1, 'LSTRANS67020a7520a87172818699765248', NULL),
(6, 22, 'on', 1, 'LSTRANS67020a7530d93172818699775559', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_status_lu`
--

CREATE TABLE `payment_status_lu` (
  `payment_status_id` int NOT NULL,
  `payment_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment_status_lu`
--

INSERT INTO `payment_status_lu` (`payment_status_id`, `payment_status`) VALUES
(1, 'pending'),
(2, 'completed'),
(3, 'failed');

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
  `shipping_address` varchar(255) NOT NULL,
  `tracking_number` varchar(100) NOT NULL,
  `delivery_status` int NOT NULL,
  `shipped_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shipping_details`
--

INSERT INTO `shipping_details` (`shipping_id`, `order_id`, `shipping_address`, `tracking_number`, `delivery_status`, `shipped_at`, `delivered_at`) VALUES
(1, 21, '21 dinar st. camella 3-1, Las Pinas , Philippines', 'LSTRACKING67020a7522484172818699744848', 1, NULL, NULL),
(2, 22, '21 dinar st. camella 3-1, Las Pinas , Philippines', 'LSTRACKING67020a7535641172818699717621', 1, NULL, NULL);

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
  `mobile_number` varchar(11) DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_image`, `email`, `password`, `first_name`, `last_name`, `mobile_number`, `role`, `status`, `created_at`) VALUES
(17, '1727036240591_17.jpg', 'gambino@email.test', '$2y$10$s9OSY8YFNX.QEaIppuS4eOmaHPLuvFOr/7F6YRLzcLV3PMhayaSJK', 'Childish', 'Gambino', NULL, 'customer', 'inactive', '2024-09-22 01:54:58'),
(20, '1727036277926_20.jpg', 'admin@email.test', '$2y$10$FtXQYkNL6jc8DhilcwpAT.BV2Oobbm0nS09UuXGBcR2g9fpsPUY3C', 'admin', 'admin', NULL, 'administrator', 'active', '2024-09-22 02:05:19'),
(21, '1727036240591_17.jpg', 'roger@email.test', '$2y$10$zpwIFFAQNGEWUu3eEVIwc.hodej4q0Hx/cWUlKLRtDD7ASMKpwtiW', 'Roger', 'Baker', NULL, 'customer', 'active', '2024-09-22 20:41:19'),
(22, '1727036240591_17.jpg', 'paulo@email.test', '$2y$10$jIDD4Xw7v23K6/r0beQYB.37O5I3DhRbV3oenIt5ov..5IvZynkzu', 'Paulo', 'Banchero', NULL, 'customer', 'active', '2024-09-22 20:41:42'),
(24, '1727036240591_17.jpg', 'ej@email.test', '$2y$10$/n72EBflqbOFhabdH7/MQujlXytNdAXGDQiwA4pouEUvvDL5OiSnq', 'Ej', 'Santos', NULL, 'customer', 'active', '2024-09-22 20:51:46'),
(25, '1727036240591_17.jpg', 'lisa@email.test', '$2y$10$Vy.EbR1h3uEJp0IeS27RVeDXBua0Of7XXS6urVEfQ4/a460ZCaBiO', 'Lisa', 'Manoban', NULL, 'customer', 'active', '2024-09-22 20:54:01'),
(26, '1727036240591_17.jpg', 'sheena@email.test', '$2y$10$nCUgkOx7fGyyEFNIvb6SwOTncYbzxrWWZiJuPwlwX9Gcaj.SdO1IS', 'Sheena', 'Bini', NULL, 'customer', 'active', '2024-09-22 20:55:17'),
(27, '1727036240591_17.jpg', 'paul@email.test', '$2y$10$fop3FA/zAR6BrMcQrBiT2uErbflRdTc3/L7eiE4Ib0RfAbkgzGuKG', 'Paul', 'Wasabi', NULL, 'customer', 'active', '2024-09-22 20:55:52'),
(28, '1727036240591_17.jpg', 'david@email.com', '$2y$10$K.xzAArl9daVAnJzqHgUEOyGnHeEcMWKP2jGsxRDVuf0/VlbLbCge', 'David', 'Bowie', NULL, 'customer', 'active', '2024-09-22 20:56:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `delivery_status_lu`
--
ALTER TABLE `delivery_status_lu`
  ADD PRIMARY KEY (`delivery_status_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_status_fkey` (`order_status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_status_lu`
--
ALTER TABLE `order_status_lu`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `payment_status_fkey` (`payment_status`);

--
-- Indexes for table `payment_status_lu`
--
ALTER TABLE `payment_status_lu`
  ADD PRIMARY KEY (`payment_status_id`);

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
  ADD KEY `order_id_fkey` (`order_id`),
  ADD KEY `shipping_details_fkey` (`delivery_status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_status_lu`
--
ALTER TABLE `delivery_status_lu`
  MODIFY `delivery_status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_status_lu`
--
ALTER TABLE `order_status_lu`
  MODIFY `order_status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_status_lu`
--
ALTER TABLE `payment_status_lu`
  MODIFY `payment_status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `shipping_details`
--
ALTER TABLE `shipping_details`
  MODIFY `shipping_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_status_fkey` FOREIGN KEY (`order_status`) REFERENCES `order_status_lu` (`order_status_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payment_status_fkey` FOREIGN KEY (`payment_status`) REFERENCES `payment_status_lu` (`payment_status_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD CONSTRAINT `order_id_fkey` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shipping_details_fkey` FOREIGN KEY (`delivery_status`) REFERENCES `delivery_status_lu` (`delivery_status_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
