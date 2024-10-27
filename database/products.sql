-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Oct 27, 2024 at 01:11 AM
-- Server version: 9.1.0
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
  `payment_method` int DEFAULT NULL,
  `payment_status` int DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods_lu`
--

CREATE TABLE `payment_methods_lu` (
  `payment_methods_id` int NOT NULL,
  `payment_method` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment_methods_lu`
--

INSERT INTO `payment_methods_lu` (`payment_methods_id`, `payment_method`) VALUES
(1, 'Credit Card'),
(2, 'Debit Card'),
(3, 'Cash on Delivery'),
(4, 'Mobile Payment'),
(5, 'E-Wallet'),
(6, 'Direct Debit');

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
  `product_category` int NOT NULL,
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
(1, 'tv_50inch.jpg', '50-inch 4K Smart TV', 'High-definition 50-inch 4K TV with smart features', 1, 599.9900, 50, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(2, 'home_theater.jpg', 'Home Theater System', '5.1 surround sound system with Bluetooth', 1, 299.9900, 30, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(3, 'gaming_console.jpg', 'Gaming Console', 'Latest gaming console with 1TB storage', 1, 399.9900, 20, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(4, 'bluetooth_speaker.jpg', 'Bluetooth Speaker', 'Portable Bluetooth speaker with powerful bass', 1, 49.9900, 100, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(5, 'soundbar.jpg', 'Soundbar', 'High-quality soundbar for TVs and music', 1, 149.9900, 40, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(6, 'vr_headset.jpg', 'VR Headset', 'Virtual reality headset compatible with gaming consoles', 1, 199.9900, 15, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(7, 'dvd_player.jpg', 'DVD Player', 'High-definition DVD player with HDMI output', 1, 39.9900, 80, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(8, 'smart_projector.jpg', 'Smart Projector', 'Portable projector with built-in streaming apps', 1, 299.9900, 10, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(9, 'karaoke_machine.jpg', 'Karaoke Machine', 'Karaoke system with two microphones', 1, 99.9900, 25, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(10, 'noise_cancelling_headphones.jpg', 'Noise Cancelling Headphones', 'Over-ear headphones with active noise cancellation', 1, 129.9900, 60, 'admin', 'admin', '2024-10-26 00:37:34', '2024-10-26 00:37:34'),
(11, 'dslr_camera.jpg', 'Digital SLR Camera', 'High-resolution DSLR camera with 24MP sensor', 2, 799.9900, 30, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(12, 'compact_camera.jpg', 'Compact Camera', 'Pocket-sized digital camera with 16MP sensor', 2, 199.9900, 50, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(13, 'action_camera.jpg', 'Action Camera', 'Waterproof action camera with 4K recording', 2, 299.9900, 40, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(14, 'mirrorless_camera.jpg', 'Mirrorless Camera', 'Lightweight mirrorless camera with interchangeable lenses', 2, 599.9900, 20, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(15, 'camera_lens.jpg', 'Camera Lens 50mm f/1.8', 'Standard prime lens for DSLR and mirrorless cameras', 2, 99.9900, 70, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(16, 'camera_tripod.jpg', 'Camera Tripod', 'Adjustable tripod for cameras and smartphones', 2, 49.9900, 80, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(17, 'camera_bag.jpg', 'Camera Bag', 'Weather-resistant camera bag with multiple compartments', 2, 79.9900, 60, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(18, 'drone_camera.jpg', 'Drone with Camera', 'Quadcopter drone with HD camera and live streaming', 2, 399.9900, 15, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(19, 'camera_stabilizer.jpg', 'Camera Stabilizer', 'Handheld gimbal stabilizer for smooth video recording', 2, 149.9900, 35, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(20, 'camera_flash.jpg', 'External Camera Flash', 'External flash unit compatible with DSLR cameras', 2, 59.9900, 50, 'admin', 'admin', '2024-10-26 00:37:46', '2024-10-26 00:37:46'),
(21, 'sketching_set.jpg', 'Artistic Sketching Set', 'Complete set of pencils, charcoal, and erasers', 3, 19.9900, 100, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(22, 'calligraphy_kit.jpg', 'Calligraphy Kit', 'Calligraphy pen set with different nibs and inks', 3, 29.9900, 80, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(23, 'model_kit.jpg', 'Model Building Kit', 'Plastic model kit for building airplanes and cars', 3, 49.9900, 60, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(24, 'puzzle.jpg', '1000-piece Puzzle', 'Challenging jigsaw puzzle for hobbyists', 3, 15.9900, 150, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(25, 'scrapbooking_supplies.jpg', 'Scrapbooking Supplies', 'Set of stickers, paper, and embellishments for scrapbooking', 3, 24.9900, 70, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(26, 'board_game.jpg', 'Board Game', 'Strategy board game for 2-6 players', 3, 39.9900, 50, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(27, 'painting_set.jpg', 'Watercolor Painting Set', 'Watercolor paints with brushes and paper', 3, 34.9900, 80, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(28, 'origami_paper.jpg', 'Origami Paper Pack', '100 sheets of colored origami paper', 3, 9.9900, 200, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(29, 'knitting_kit.jpg', 'Knitting Starter Kit', 'Yarn, needles, and patterns for beginners', 3, 29.9900, 40, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(30, 'notebook_set.jpg', 'Notebook Set', 'Pack of 3 spiral-bound notebooks', 3, 12.9900, 90, 'admin', 'admin', '2024-10-26 00:37:54', '2024-10-26 00:37:54'),
(31, 'air_fryer.jpg', 'Air Fryer', 'Healthier way to fry food using air instead of oil', 4, 89.9900, 40, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(32, 'vacuum_cleaner.jpg', 'Vacuum Cleaner', 'Bagless vacuum cleaner with HEPA filter', 4, 129.9900, 35, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(33, 'microwave.jpg', 'Microwave Oven', '1000W microwave with convection features', 4, 99.9900, 25, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(34, 'blender.jpg', 'High-Power Blender', 'Blender with multiple speed settings and pulse function', 4, 59.9900, 50, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(35, 'rice_cooker.jpg', 'Electric Rice Cooker', 'Rice cooker with keep-warm function', 4, 39.9900, 60, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(36, 'dishwasher.jpg', 'Dishwasher', 'Energy-efficient dishwasher with multiple cleaning modes', 4, 299.9900, 20, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(37, 'coffee_maker.jpg', 'Coffee Maker', 'Programmable coffee maker with built-in grinder', 4, 49.9900, 45, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(38, 'electric_kettle.jpg', 'Electric Kettle', 'Fast-boil kettle with auto shut-off', 4, 19.9900, 80, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(39, 'dehumidifier.jpg', 'Dehumidifier', 'Portable dehumidifier for controlling room humidity', 4, 89.9900, 30, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(40, 'induction_cooktop.jpg', 'Induction Cooktop', 'Portable induction cooktop with multiple heat settings', 4, 79.9900, 25, 'admin', 'admin', '2024-10-26 00:38:01', '2024-10-26 00:38:01'),
(41, 'gaming_laptop.jpg', 'Gaming Laptop', 'High-performance laptop with 16GB RAM and 1TB SSD', 5, 1299.9900, 20, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(42, 'desktop_computer.jpg', 'Desktop Computer', 'All-in-one desktop with 27-inch screen', 5, 999.9900, 15, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(43, 'ultrabook.jpg', 'Ultrabook', 'Lightweight laptop with 8GB RAM and 512GB SSD', 5, 799.9900, 30, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(44, '2_in_1_laptop.jpg', '2-in-1 Convertible Laptop', 'Laptop with touchscreen and detachable keyboard', 5, 699.9900, 25, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(45, 'computer_monitor.jpg', 'Computer Monitor', '24-inch Full HD monitor with adjustable stand', 5, 149.9900, 50, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(46, 'wireless_keyboard.jpg', 'Wireless Keyboard and Mouse Combo', 'Wireless keyboard and mouse set', 5, 29.9900, 100, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(47, 'ssd_drive.jpg', '1TB SSD Drive', 'High-speed solid-state drive for computers', 5, 99.9900, 60, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(48, 'external_hard_drive.jpg', 'External Hard Drive', '2TB external hard drive with USB 3.0', 5, 59.9900, 70, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(49, 'gaming_mouse.jpg', 'Gaming Mouse', 'High-precision gaming mouse with customizable buttons', 5, 39.9900, 80, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(50, 'cooling_pad.jpg', 'Laptop Cooling Pad', 'Cooling pad with adjustable fan speed', 5, 19.9900, 90, 'admin', 'admin', '2024-10-26 00:38:07', '2024-10-26 00:38:07'),
(51, 'mens_tshirt.jpg', 'Men\'s T-Shirt', '100% cotton T-shirt with round neck', 6, 9.9900, 150, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(52, 'mens_jeans.jpg', 'Men\'s Jeans', 'Slim fit jeans with stretchable fabric', 6, 29.9900, 60, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(53, 'mens_jacket.jpg', 'Men\'s Jacket', 'Waterproof jacket with hoodie', 6, 59.9900, 40, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(54, 'mens_sneakers.jpg', 'Men\'s Sneakers', 'Comfortable sneakers for casual wear', 6, 39.9900, 80, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(55, 'mens_watch.jpg', 'Men\'s Wristwatch', 'Classic wristwatch with leather strap', 6, 49.9900, 50, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(56, 'mens_belt.jpg', 'Men\'s Leather Belt', 'Durable leather belt with metal buckle', 6, 19.9900, 100, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(57, 'mens_sunglasses.jpg', 'Men\'s Sunglasses', 'Polarized sunglasses with UV protection', 6, 29.9900, 90, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(58, 'mens_hat.jpg', 'Men\'s Hat', 'Stylish hat for casual or formal wear', 6, 14.9900, 70, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(59, 'mens_socks.jpg', 'Men\'s Socks Pack', 'Pack of 5 cotton blend socks', 6, 9.9900, 200, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(60, 'mens_gloves.jpg', 'Men\'s Gloves', 'Winter gloves with touchscreen capability', 6, 14.9900, 60, 'admin', 'admin', '2024-10-26 00:38:14', '2024-10-26 00:38:14'),
(61, 'womens_dress.jpg', 'Women\'s Casual Dress', 'Floral print casual dress for summer', 7, 24.9900, 70, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(62, 'womens_handbag.jpg', 'Women\'s Handbag', 'Leather handbag with adjustable strap', 7, 39.9900, 50, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(63, 'womens_jeans.jpg', 'Women\'s Skinny Jeans', 'Stretchable skinny jeans for women', 7, 29.9900, 60, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(64, 'womens_jacket.jpg', 'Women\'s Denim Jacket', 'Classic denim jacket for casual wear', 7, 49.9900, 30, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(65, 'womens_sneakers.jpg', 'Women\'s Sneakers', 'Comfortable and stylish sneakers', 7, 34.9900, 40, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(66, 'womens_scarf.jpg', 'Women\'s Scarf', 'Soft and cozy scarf for winter', 7, 14.9900, 80, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(67, 'womens_watch.jpg', 'Women\'s Wristwatch', 'Stylish wristwatch with metal band', 7, 59.9900, 30, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(68, 'womens_hat.jpg', 'Women\'s Hat', 'Stylish hat for sunny days', 7, 19.9900, 100, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(69, 'womens_sunglasses.jpg', 'Women\'s Sunglasses', 'Trendy sunglasses with UV protection', 7, 24.9900, 70, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(70, 'womens_boots.jpg', 'Women\'s Boots', 'Fashionable boots with a comfortable fit', 7, 69.9900, 40, 'admin', 'admin', '2024-10-26 00:38:22', '2024-10-26 00:38:22'),
(71, 'motorcycle_helmet.jpg', 'Motorcycle Helmet', 'Full-face motorcycle helmet with visor', 8, 89.9900, 25, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35'),
(72, 'motorcycle_gloves.jpg', 'Motorcycle Gloves', 'Protective gloves with reinforced padding', 8, 19.9900, 80, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35'),
(73, 'motorcycle_jacket.jpg', 'Motorcycle Jacket', 'Leather jacket with protective padding', 8, 129.9900, 20, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35'),
(74, 'motorcycle_boots.jpg', 'Motorcycle Boots', 'Durable boots for motorcycling', 8, 69.9900, 30, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35'),
(75, 'motorcycle_pants.jpg', 'Motorcycle Pants', 'Protective pants with reinforced areas', 8, 79.9900, 40, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35'),
(76, 'motorcycle_backpack.jpg', 'Motorcycle Backpack', 'Compact backpack designed for riders', 8, 49.9900, 60, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35'),
(77, 'motorcycle_knee_pads.jpg', 'Motorcycle Knee Pads', 'Protective knee pads for motorcyclists', 8, 19.9900, 90, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35'),
(78, 'motorcycle_handle_grips.jpg', 'Motorcycle Handle Grips', 'Comfortable grips for motorcycle handlebars', 8, 14.9900, 70, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35'),
(79, 'motorcycle_cover.jpg', 'Motorcycle Cover', 'Waterproof cover for motorcycles', 8, 24.9900, 100, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35'),
(80, 'motorcycle_saddlebags.jpg', 'Motorcycle Saddlebags', 'Durable saddlebags for extra storage', 8, 59.9900, 30, 'admin', 'admin', '2024-10-26 00:38:35', '2024-10-26 00:38:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_category_lu`
--

CREATE TABLE `product_category_lu` (
  `product_category_id` int NOT NULL,
  `product_category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_category_lu`
--

INSERT INTO `product_category_lu` (`product_category_id`, `product_category`) VALUES
(1, 'entertainment'),
(2, 'cameras'),
(3, 'hobbies & stationery'),
(4, 'home appliances'),
(5, 'laptops and computers'),
(6, 'men\'s apprarel'),
(7, 'women\'s apprarel'),
(8, 'motor gears');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `review_id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `review_status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `promotion_id` int NOT NULL,
  `product_id` int NOT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `promotion_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_type_lu`
--

CREATE TABLE `promotion_type_lu` (
  `promotion_type_id` int NOT NULL,
  `promotion_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `promotion_type_lu`
--

INSERT INTO `promotion_type_lu` (`promotion_type_id`, `promotion_type`) VALUES
(1, 'Flash Sale'),
(2, 'New Customer Discount'),
(3, '50% off'),
(4, 'Summer Sale'),
(5, 'Christmas Sale'),
(6, 'Free Shipping');

-- --------------------------------------------------------

--
-- Table structure for table `review_status_lu`
--

CREATE TABLE `review_status_lu` (
  `review_status_id` int NOT NULL,
  `review_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `review_status_lu`
--

INSERT INTO `review_status_lu` (`review_status_id`, `review_status`) VALUES
(1, 'pending'),
(2, 'approved'),
(3, 'rejected');

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
  ADD KEY `payment_status_fkey` (`payment_status`),
  ADD KEY `payment_method_fkey` (`payment_method`);

--
-- Indexes for table `payment_methods_lu`
--
ALTER TABLE `payment_methods_lu`
  ADD PRIMARY KEY (`payment_methods_id`);

--
-- Indexes for table `payment_status_lu`
--
ALTER TABLE `payment_status_lu`
  ADD PRIMARY KEY (`payment_status_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category_fkey` (`product_category`);

--
-- Indexes for table `product_category_lu`
--
ALTER TABLE `product_category_lu`
  ADD PRIMARY KEY (`product_category_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `prod_rev_prod_id_fkey` (`product_id`),
  ADD KEY `prod_rev_user_id_fkey` (`user_id`),
  ADD KEY `prod_rev_prod_rev_fkey` (`review_status`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`promotion_id`),
  ADD KEY `promotion_type_fkey` (`promotion_type`),
  ADD KEY `product_id_fkey` (`product_id`);

--
-- Indexes for table `promotion_type_lu`
--
ALTER TABLE `promotion_type_lu`
  ADD PRIMARY KEY (`promotion_type_id`);

--
-- Indexes for table `review_status_lu`
--
ALTER TABLE `review_status_lu`
  ADD PRIMARY KEY (`review_status_id`);

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
-- AUTO_INCREMENT for table `payment_methods_lu`
--
ALTER TABLE `payment_methods_lu`
  MODIFY `payment_methods_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_status_lu`
--
ALTER TABLE `payment_status_lu`
  MODIFY `payment_status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `product_category_lu`
--
ALTER TABLE `product_category_lu`
  MODIFY `product_category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `promotion_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promotion_type_lu`
--
ALTER TABLE `promotion_type_lu`
  MODIFY `promotion_type_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `review_status_lu`
--
ALTER TABLE `review_status_lu`
  MODIFY `review_status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `payment_method_fkey` FOREIGN KEY (`payment_method`) REFERENCES `payment_methods_lu` (`payment_methods_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_status_fkey` FOREIGN KEY (`payment_status`) REFERENCES `payment_status_lu` (`payment_status_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_category_fkey` FOREIGN KEY (`product_category`) REFERENCES `product_category_lu` (`product_category_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `prod_rev_prod_id_fkey` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `prod_rev_prod_rev_fkey` FOREIGN KEY (`review_status`) REFERENCES `review_status_lu` (`review_status_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `prod_rev_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `promotion`
--
ALTER TABLE `promotion`
  ADD CONSTRAINT `product_id_fkey` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `promotion_type_fkey` FOREIGN KEY (`promotion_type`) REFERENCES `promotion_type_lu` (`promotion_type_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

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
