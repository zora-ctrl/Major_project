-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 05:57 PM
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
-- Database: `av`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `sub` varchar(50) NOT NULL,
  `msg` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `mail`, `sub`, `msg`) VALUES
(1, 'Jora Singh', 'gy@gmail.com', 'appreciation', 'Good Work');

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id` int(3) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `uclass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `uname`, `uclass`) VALUES
(20, 'zora', 'bca'),
(21, '', ''),
(22, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `product` varchar(500) NOT NULL,
  `pdprice` int(5) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `total_amount` int(4) NOT NULL,
  `order_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `product`, `pdprice`, `created_at`, `total_amount`, `order_date`, `status`, `quantity`) VALUES
(1, 'Data Cables ', 249, '2025-04-20 10:32:22.215799', 249, '2025-04-20 10:32:22.215799', 'Delivered', 1),
(2, 'Data Cables ', 249, '2025-04-20 10:33:20.626273', 249, '2025-04-20 10:33:20.626273', 'Pending', 1),
(4, 'Bluetooth Earbuds (x1)', 1299, '2025-04-20 10:32:41.443640', 1299, '2025-04-20 10:32:41.443640', 'Shipped', 1),
(5, 'Wireless Charger (x1)', 1499, '2025-04-20 10:33:22.829260', 1499, '2025-04-20 10:33:22.829260', 'Pending', 1),
(6, 'Bluetooth Earbuds (x1)', 1299, '2025-04-20 12:26:47.562486', 1299, '2025-04-19 18:30:00.000000', '', 0),
(7, 'Back Cover (x1)', 149, '2025-05-21 15:41:24.726434', 149, '2025-05-21 15:41:24.726434', 'Shipped', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_customers`
--

CREATE TABLE `order_customers` (
  `order_id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_customers`
--

INSERT INTO `order_customers` (`order_id`, `name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'Zora Singh', 'dff@mail.com', '8544468712', 'Jalandhar', '2025-04-20 07:56:14.713516'),
(2, 'Mohit Chopra', 'mohit@mail.com', '7585548444', 'Maqsudan', '2025-04-20 09:09:06.038600'),
(4, 'Jora', 'gy@gmail.com', '8544468712', 'Ludhiana', '2025-04-20 10:03:15.258236'),
(5, 'Love', 'love@mail.com', '9230845808', 'Patiala', '2025-04-20 10:30:24.705081'),
(6, 'Jora Singh', 'dff@mail.com', '9230845808', 'Jalandhar', '2025-04-20 12:26:02.181276'),
(7, 'Jora Singh', 'gy@gmail.com', '8544468712', 'Village Semi', '2025-05-13 06:58:23.230019');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 1, 1, 149.00, 1),
(2, 2, 3, 1299.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(3) NOT NULL,
  `product_id` int(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(5) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` enum('Phone Cases','Cables','Chargers','Audio Accessories') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_id`, `name`, `price`, `image_url`, `description`, `stock`, `created_at`, `category`) VALUES
(1, 1, 'Back Cover', 149, 'http://localhost/mobile_cart/js/images/cover.jpg', 'stylish back cover for Iphones', 10, '2025-04-05 11:12:30', 'Phone Cases'),
(2, 2, 'Wireless Charger', 1499, 'http://localhost/mobile_cart/js/images/wireless_charger.jpeg', 'wireless charger is a type of wireless power transfer. It uses electromagnetic induction to provide electricity to portable devices.', 10, '2025-04-05 11:12:30', 'Chargers'),
(3, 3, 'Bluetooth Earbuds', 1299, 'http://localhost/mobile_cart/js/images/bt.jpeg', 'Bluetooth Earbuds are portable speakers that fit inside people\'s ears.', 10, '2025-04-05 11:12:30', 'Audio Accessories'),
(4, 4, 'Data Cables', 249, '\r\nhttp://localhost/mobile_cart/js/images/cable.jpeg', 'Multi-purposes data cables for various ports.', 10, '2025-04-05 11:12:30', 'Cables');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_customers`
--
ALTER TABLE `order_customers`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_customers`
--
ALTER TABLE `order_customers`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
