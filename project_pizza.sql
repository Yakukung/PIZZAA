-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 03, 2023 at 09:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_pizza`
--

-- --------------------------------------------------------

--
-- Table structure for table `Basket`
--

CREATE TABLE `Basket` (
  `basket_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pizza_id` int(11) NOT NULL,
  `order_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Crust`
--

CREATE TABLE `Crust` (
  `crust_id` int(11) NOT NULL,
  `crust_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Crust`
--

INSERT INTO `Crust` (`crust_id`, `crust_name`) VALUES
(1, 'บางกรอบ'),
(2, 'หนานุ่ม'),
(3, 'ขอบชีส');

-- --------------------------------------------------------

--
-- Table structure for table `Order`
--

CREATE TABLE `Order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `status_id` int(2) NOT NULL,
  `status_name` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_status_id` int(11) NOT NULL,
  `payment_status_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Order`
--

INSERT INTO `Order` (`order_id`, `user_id`, `order_date`, `status_id`, `status_name`, `total_price`, `payment_status_id`, `payment_status_name`) VALUES
(1, 1, '2023-10-04', 1, 'ยังไม่จัดส่ง', 299.00, 1, 'ยังไม่ชำระเงิน');

-- --------------------------------------------------------

--
-- Table structure for table `Pizza`
--

CREATE TABLE `Pizza` (
  `pizza_id` int(11) NOT NULL,
  `pizza_name` varchar(255) NOT NULL,
  `pizza_price` decimal(10,2) NOT NULL,
  `pizza_image` varchar(255) NOT NULL,
  `pizza_details` varchar(250) DEFAULT NULL,
  `crust_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Pizza`
--

INSERT INTO `Pizza` (`pizza_id`, `pizza_name`, `pizza_price`, `pizza_image`, `pizza_details`, `crust_id`, `size_id`) VALUES
(1, 'หมาล่าหมูสไลด์', 299.00, 'https://cdn.1112delivery.com/1112one/public/images/products/pizza/Aug23/102783.png', 'เนื้อหมูสไลซ์, น้ำมันฮวาเจียว, พริกแห้งอบ, ต้นหอม, ผักมิกซ์, มอสซาเรลล่าชีส และซอสหมาล่า', NULL, NULL),
(2, 'กริลล์ฮาวายเอี้ยน', 509.00, 'https://cdn.1112delivery.com/1112one/public/images/products/pizza/Nov2022/199446.png', 'แฮม, เบคอน, สับปะรด และซอสพิซซ่า', NULL, NULL),
(3, 'ดับเบิ้ลเปปเปอโรนี', 279.00, 'https://cdn.1112delivery.com/1112one/public/images/products/pizza/Topping/162217.png', 'เป๊ปเปอโรนี, มอสซาเรลล่าชีส และซอสพิซซ่า', NULL, NULL),
(4, 'สไปซี่ ซุปเปอร์ซีฟู๊ด', 439.00, 'https://cdn.1112delivery.com/1112one/public/images/products/pizza/Topping/102734.png', 'ปลาหมึก, กุ้งกระเทียม, พริกแดง พริกเขียว, พริกหวาน, หอมใหญ่, อิตาเลี่ยน เบซิล, มอส', NULL, NULL),
(5, 'ไก่สามรส', 379.00, 'https://cdn.1112delivery.com/1112one/public/images/products/pizza/Topping/102203.png', 'ไก่บาร์บีคิว, ไก่เนยกระเทียม, ไก่อบซอส, เห็ด, พริกแดง พริกเขียว, มอสซาเรลล่าชีส และซอส', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Position`
--

CREATE TABLE `Position` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Position`
--

INSERT INTO `Position` (`position_id`, `position_name`) VALUES
(1, 'เจ้าของร้าน'),
(2, 'ลูกค้า');

-- --------------------------------------------------------

--
-- Table structure for table `Size`
--

CREATE TABLE `Size` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Size`
--

INSERT INTO `Size` (`size_id`, `size_name`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `position_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `user_name`, `email`, `password`, `address`, `position_id`) VALUES
(1, 'อัษฎาวุธ', 'kungkup1423@gmail.com', '1234', 'อินเตอร์แมนชั่น', 2),
(2, 'Aj\'M', 'ajm@gmail.com', '1234', 'มหาสารคาม', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Basket`
--
ALTER TABLE `Basket`
  ADD PRIMARY KEY (`basket_id`),
  ADD KEY `pizza_id` (`pizza_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `Crust`
--
ALTER TABLE `Crust`
  ADD PRIMARY KEY (`crust_id`);

--
-- Indexes for table `Order`
--
ALTER TABLE `Order`
  ADD PRIMARY KEY (`order_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Pizza`
--
ALTER TABLE `Pizza`
  ADD PRIMARY KEY (`pizza_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `crust_id` (`crust_id`);

--
-- Indexes for table `Position`
--
ALTER TABLE `Position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `Size`
--
ALTER TABLE `Size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `position_id` (`position_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Basket`
--
ALTER TABLE `Basket`
  MODIFY `basket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Crust`
--
ALTER TABLE `Crust`
  MODIFY `crust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Order`
--
ALTER TABLE `Order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Pizza`
--
ALTER TABLE `Pizza`
  MODIFY `pizza_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Position`
--
ALTER TABLE `Position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Size`
--
ALTER TABLE `Size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Basket`
--
ALTER TABLE `Basket`
  ADD CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`pizza_id`) REFERENCES `Pizza` (`pizza_id`),
  ADD CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `Order` (`order_id`);

--
-- Constraints for table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

--
-- Constraints for table `Pizza`
--
ALTER TABLE `Pizza`
  ADD CONSTRAINT `pizza_ibfk_1` FOREIGN KEY (`size_id`) REFERENCES `Size` (`size_id`),
  ADD CONSTRAINT `pizza_ibfk_2` FOREIGN KEY (`crust_id`) REFERENCES `Crust` (`crust_id`);

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `Position` (`position_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
