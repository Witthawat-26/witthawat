-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2026 at 10:00 AM
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
-- Database: `9999db`
--

-- --------------------------------------------------------

--
-- Table structure for table `progamer_sales`
--

DROP TABLE IF EXISTS `progamer_sales`;
CREATE TABLE `progamer_sales` (
  `order_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `sale_date` date NOT NULL,
  `province` varchar(100) NOT NULL,
  `total_price` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progamer_sales`
--

INSERT INTO `progamer_sales` (`order_id`, `product_name`, `category`, `sale_date`, `province`, `total_price`) VALUES
(1, 'HyperX Cloud II', 'Headset', '2025-01-06', 'Bangkok', 4270),
(2, 'RTX 3060 12GB', 'Graphic Card', '2025-01-07', 'Chiang Mai', 8239),
(3, 'Logitech G Pro X', 'Mouse', '2025-01-08', 'Bangkok', 4617),
(4, 'Logitech G Pro X', 'Mouse', '2025-01-10', 'Khon Kaen', 3384),
(5, 'Razer BlackWidow', 'Keyboard', '2025-01-10', 'Chonburi', 2626),
(6, 'LG UltraGear 24', 'Monitor', '2025-01-11', 'Bangkok', 5610),
(7, 'RTX 3060 12GB', 'Graphic Card', '2025-01-11', 'Phuket', 9062),
(8, 'Logitech G Pro X', 'Mouse', '2025-01-16', 'Songkhla', 4906),
(9, 'Keychron K2 Pro', 'Keyboard', '2025-01-16', 'Nakhon Ratchasima', 5417),
(10, 'Keychron K2 Pro', 'Keyboard', '2025-01-16', 'Khon Kaen', 7431),
(11, 'Logitech G Pro X', 'Mouse', '2025-01-16', 'Chonburi', 4250),
(12, 'RTX 4060 Ti', 'Graphic Card', '2025-01-18', 'Bangkok', 12012),
(13, 'HyperX Cloud II', 'Headset', '2025-01-20', 'Chonburi', 2903),
(14, 'RTX 3060 12GB', 'Graphic Card', '2025-01-22', 'Khon Kaen', 8824),
(15, 'Keychron K2 Pro', 'Keyboard', '2025-01-24', 'Nakhon Ratchasima', 4946),
(16, 'Logitech G Pro X', 'Mouse', '2025-01-27', 'Chiang Mai', 2320),
(17, 'Logitech G Pro X', 'Mouse', '2025-01-28', 'Bangkok', 2116),
(18, 'Logitech G Pro X', 'Mouse', '2025-01-30', 'Chiang Mai', 3135),
(19, 'RTX 3060 12GB', 'Graphic Card', '2025-01-30', 'Chiang Mai', 9595),
(20, 'Keychron Q1 Max', 'Keyboard', '2025-02-02', 'Bangkok', 8161),
(21, 'LG UltraGear 24', 'Monitor', '2025-02-04', 'Nakhon Ratchasima', 5256),
(22, 'Logitech G Pro X', 'Mouse', '2025-02-11', 'Songkhla', 3004),
(23, 'Logitech G Pro X', 'Mouse', '2025-02-14', 'Khon Kaen', 3642),
(24, 'Logitech G Pro X', 'Mouse', '2025-02-17', 'Bangkok', 4582),
(25, 'Razer BlackWidow', 'Keyboard', '2025-02-17', 'Chiang Mai', 3559),
(26, 'HyperX Cloud II', 'Headset', '2025-02-17', 'Phuket', 5154),
(27, 'Secretlab Titan', 'Gaming Chair', '2025-02-18', 'Nakhon Ratchasima', 17388),
(28, 'Razer BlackWidow', 'Keyboard', '2025-02-18', 'Bangkok', 7163),
(29, 'Razer BlackWidow', 'Keyboard', '2025-02-20', 'Chonburi', 5101),
(30, 'Keychron K2 Pro', 'Keyboard', '2025-02-21', 'Nakhon Ratchasima', 7602),
(31, 'Secretlab Titan', 'Gaming Chair', '2025-02-22', 'Bangkok', 16410),
(32, 'Keychron K2 Pro', 'Keyboard', '2025-02-23', 'Phuket', 4892),
(33, 'Keychron K2 Pro', 'Keyboard', '2025-03-01', 'Nakhon Ratchasima', 4060),
(34, 'RTX 3060 12GB', 'Graphic Card', '2025-03-01', 'Chonburi', 9557),
(35, 'Keychron K2 Pro', 'Keyboard', '2025-03-01', 'Nakhon Ratchasima', 6509),
(36, 'Keychron K2 Pro', 'Keyboard', '2025-03-04', 'Phuket', 5718),
(37, 'Keychron K2 Pro', 'Keyboard', '2025-03-05', 'Bangkok', 7655),
(38, 'HyperX Cloud II', 'Headset', '2025-03-05', 'Chiang Mai', 3116),
(39, 'Logitech G Pro X', 'Mouse', '2025-03-15', 'Bangkok', 2795),
(40, 'Logitech G Pro X', 'Mouse', '2025-03-15', 'Bangkok', 5084),
(41, 'HyperX Cloud II', 'Headset', '2025-03-15', 'Chiang Mai', 3941),
(42, 'RTX 3060 12GB', 'Graphic Card', '2025-03-16', 'Nakhon Ratchasima', 9341),
(43, 'Logitech G Pro X', 'Mouse', '2025-03-19', 'Khon Kaen', 3135),
(44, 'Logitech G Pro X', 'Mouse', '2025-03-19', 'Phuket', 9400),
(45, 'Razer BlackWidow', 'Keyboard', '2025-03-21', 'Chonburi', 6045),
(46, 'Keychron K2 Pro', 'Keyboard', '2025-03-22', 'Songkhla', 5820),
(47, 'LG UltraGear 24', 'Monitor', '2025-03-23', 'Chonburi', 5887),
(48, 'LG UltraGear 24', 'Monitor', '2025-03-24', 'Bangkok', 6982),
(49, 'Logitech G Pro X', 'Mouse', '2025-03-26', 'Phuket', 4029),
(50, 'HyperX Cloud II', 'Headset', '2025-03-26', 'Chonburi', 3665),
(51, 'Logitech G Pro X', 'Mouse', '2025-03-29', 'Nakhon Ratchasima', 4781),
(52, 'Secretlab Titan', 'Gaming Chair', '2025-03-30', 'Phuket', 13663),
(53, 'Keychron K2 Pro', 'Keyboard', '2025-04-01', 'Nakhon Ratchasima', 6331),
(54, 'Keychron K2 Pro', 'Keyboard', '2025-04-01', 'Khon Kaen', 4364),
(55, 'HyperX Cloud II', 'Headset', '2025-04-03', 'Chiang Mai', 2607),
(56, 'Logitech G Pro X', 'Mouse', '2025-04-06', 'Songkhla', 3054),
(57, 'HyperX Cloud II', 'Headset', '2025-04-06', 'Bangkok', 3659),
(58, 'RTX 3060 12GB', 'Graphic Card', '2025-04-12', 'Chonburi', 9277),
(59, 'Logitech G Pro X', 'Mouse', '2025-04-17', 'Bangkok', 4235),
(60, 'LG UltraGear 24', 'Monitor', '2025-04-18', 'Phuket', 5113),
(61, 'Keychron K2 Pro', 'Keyboard', '2025-04-21', 'Bangkok', 4128),
(62, 'RTX 3060 12GB', 'Graphic Card', '2025-04-22', 'Khon Kaen', 9231),
(63, 'Logitech G Pro X', 'Mouse', '2025-04-23', 'Bangkok', 4387),
(64, 'Keychron K2 Pro', 'Keyboard', '2025-04-25', 'Khon Kaen', 2763),
(65, 'Logitech G Pro X', 'Mouse', '2025-04-27', 'Chiang Mai', 3898),
(66, 'Logitech G Pro X', 'Mouse', '2025-04-30', 'Nakhon Ratchasima', 2427),
(67, 'Logitech G Pro X', 'Mouse', '2025-05-01', 'Songkhla', 3663),
(68, 'HyperX Cloud II', 'Headset', '2025-05-01', 'Chonburi', 2789),
(69, 'Logitech G Pro X', 'Mouse', '2025-05-02', 'Bangkok', 4054),
(70, 'Secretlab Titan', 'Gaming Chair', '2025-05-02', 'Bangkok', 12262),
(71, 'Secretlab Titan', 'Gaming Chair', '2025-05-02', 'Chiang Mai', 15600),
(72, 'Logitech G Pro X', 'Mouse', '2025-05-03', 'Bangkok', 5787),
(73, 'LG UltraGear 24', 'Monitor', '2025-05-03', 'Khon Kaen', 6295),
(74, 'Logitech G Pro X', 'Mouse', '2025-05-05', 'Chonburi', 4474),
(75, 'Keychron K2 Pro', 'Keyboard', '2025-05-05', 'Nakhon Ratchasima', 4325),
(76, 'Logitech G Pro X', 'Mouse', '2025-05-06', 'Bangkok', 2592),
(77, 'LG UltraGear 24', 'Monitor', '2025-05-08', 'Bangkok', 4330),
(78, 'Logitech G Pro X', 'Mouse', '2025-05-08', 'Chiang Mai', 3405),
(79, 'Keychron K2 Pro', 'Keyboard', '2025-05-08', 'Nakhon Ratchasima', 7671),
(80, 'HyperX Cloud II', 'Headset', '2025-05-08', 'Chiang Mai', 5791),
(81, 'Logitech G Pro X', 'Mouse', '2025-05-12', 'Khon Kaen', 6007),
(82, 'Logitech G Pro X', 'Mouse', '2025-05-14', 'Chonburi', 5030);
-- (ตัดข้อมูลบางส่วนเพื่อให้โค้ดไม่ยาวเกินไป แต่คุณสามารถรันคำสั่งนี้เพื่อสร้างตารางและข้อมูลตัวอย่าง 80+ แถวแรกได้ทันที)

--
-- Indexes for table `progamer_sales`
--
ALTER TABLE `progamer_sales`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for table `progamer_sales`
--
ALTER TABLE `progamer_sales`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 03:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4