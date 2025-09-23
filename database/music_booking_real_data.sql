-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2025 at 08:02 AM
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
-- Database: `music_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `user_id`, `role`, `action_type`, `details`, `created_at`) VALUES
(1, 2, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [ไวโอลิน] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-22 08:57:09'),
(2, 2, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [กลองชุด]', '2025-09-22 08:57:18'),
(3, 2, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [กีตาร์ไฟฟ้า]', '2025-09-22 08:57:35'),
(4, 2, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [เบส]', '2025-09-22 08:57:39'),
(5, 2, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [ไมโครโฟนร้อง]', '2025-09-22 08:57:49'),
(6, 2, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [เครื่องเสริม]', '2025-09-22 08:58:00'),
(7, 2, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [กีตาร์] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-22 08:58:06'),
(8, 2, 'admin', 'create_room', 'เพิ่มห้องใหม่', '2025-09-22 11:27:51'),
(9, 2, 'admin', 'update_room', 'แก้ไขห้อง [ID: 20] จาก [ชื่อ: RM01, ราคา/ชม.: 180.00, ความจุ: 4] → [ชื่อ: RM01, ราคา/ชม.: 180.00, ความจุ: 4]', '2025-09-22 11:29:01'),
(10, 2, 'admin', 'create_room', 'เพิ่มห้องใหม่', '2025-09-22 11:29:39'),
(11, 2, 'admin', 'create_room', 'เพิ่มห้องใหม่', '2025-09-22 11:30:10'),
(12, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [กลองชุดมาตรฐาน] รหัส: D01', '2025-09-22 11:31:12'),
(13, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [กลองชุดไฟฟ้า] รหัส: D02', '2025-09-22 11:31:31'),
(14, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [กลองชุดอะคูสติก] รหัส: D03', '2025-09-22 11:32:05'),
(15, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [กลองชุดไฟฟ้า] → [กลองชุดไฟฟ้า]', '2025-09-22 11:32:16'),
(16, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [กลองชุดอะคูสติก] → [กลองชุดอะคูสติก]', '2025-09-22 11:32:21'),
(17, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [กลองชุดมาตรฐาน] รหัส: DR1', '2025-09-22 11:33:10'),
(18, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [กลองชุดมาตรฐาน] → [กลองชุดมาตรฐาน]', '2025-09-22 11:33:17'),
(19, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [กลองชุดมาตรฐาน] รหัส: กลองชุดมาตรฐาน', '2025-09-22 11:33:37'),
(20, 2, 'admin', 'delete_instrument', 'ลบเครื่องดนตรี [กลองชุดมาตรฐาน] รหัส: กลองชุดมาตรฐาน', '2025-09-22 11:33:49'),
(21, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [กลองชุดมาตรฐาน] รหัส: DR2', '2025-09-22 11:34:01'),
(22, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [กลองชุดมาตรฐาน] → [กลองชุดมาตรฐาน]', '2025-09-22 11:34:10'),
(23, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [กลองชุดมาตรฐาน] รหัส: DR3', '2025-09-22 11:34:29'),
(24, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [กลองชุดมาตรฐาน] → [กลองชุดมาตรฐาน]', '2025-09-22 11:34:34'),
(25, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM01] ให้เครื่องดนตรี [กลองชุดมาตรฐาน] จำนวน 1', '2025-09-22 11:34:38'),
(26, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM02] ให้เครื่องดนตรี [กลองชุดมาตรฐาน] จำนวน 1', '2025-09-22 11:34:45'),
(27, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM03] ให้เครื่องดนตรี [กลองชุดมาตรฐาน] จำนวน 1', '2025-09-22 11:34:50'),
(28, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Yamaha PSR-SX600] รหัส: KR1', '2025-09-22 11:37:03'),
(29, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Yamaha PSR-SX600] รหัส: KR2', '2025-09-22 11:37:23'),
(30, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Yamaha PSR-SX600] รหัส: KR3', '2025-09-22 11:37:40'),
(31, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Yamaha PSR-SX600] รหัส: KB01', '2025-09-22 11:37:57'),
(32, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Roland FP-30] รหัส: KB02', '2025-09-22 11:38:23'),
(33, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Korg Kross] รหัส: KR03', '2025-09-22 11:38:38'),
(34, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Yamaha PSR-SX600] → [Yamaha PSR-SX600]', '2025-09-22 11:38:44'),
(35, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Korg Kross] → [Korg Kross]', '2025-09-22 11:38:49'),
(36, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM01] ให้เครื่องดนตรี [Yamaha PSR-SX600] จำนวน 1', '2025-09-22 11:39:08'),
(37, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM02] ให้เครื่องดนตรี [Yamaha PSR-SX600] จำนวน 1', '2025-09-22 11:39:15'),
(38, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM03] ให้เครื่องดนตรี [Yamaha PSR-SX600] จำนวน 1', '2025-09-22 11:39:21'),
(39, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Fender Stratocaster] รหัส: RGR1', '2025-09-22 11:42:14'),
(40, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Fender Stratocaster] รหัส: EGR2', '2025-09-22 11:42:40'),
(41, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Fender Stratocaster] รหัส: EGR3', '2025-09-22 11:42:59'),
(42, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM01] ให้เครื่องดนตรี [Fender Stratocaster] จำนวน 1', '2025-09-22 11:43:10'),
(43, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM02] ให้เครื่องดนตรี [Fender Stratocaster] จำนวน 1', '2025-09-22 11:43:13'),
(44, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM03] ให้เครื่องดนตรี [Fender Stratocaster] จำนวน 1', '2025-09-22 11:43:15'),
(45, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Fender Stratocaster] รหัส: EG01', '2025-09-22 11:43:39'),
(46, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Gibson Les Paul] รหัส: EG02', '2025-09-22 11:44:09'),
(47, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Ibanez RG Series] รหัส: EG03', '2025-09-22 11:44:28'),
(48, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Jazz Bass] รหัส: BR1', '2025-09-22 11:45:26'),
(49, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Jazz Bass] รหัส: BR2', '2025-09-22 11:46:49'),
(50, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Jazz Bass] → [Jazz Bass]', '2025-09-22 11:46:54'),
(51, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Jazz Bass] รหัส: BR3', '2025-09-22 11:47:10'),
(52, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Jazz Bass] → [Jazz Bass]', '2025-09-22 11:47:16'),
(53, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Jazz Bass] รหัส: B01', '2025-09-22 11:47:42'),
(54, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Precision Bass] รหัส: B02', '2025-09-22 11:48:01'),
(55, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Yamaha TRBX] รหัส: E03', '2025-09-22 11:48:14'),
(56, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Shure SM58] รหัส: MR1', '2025-09-22 11:49:00'),
(57, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Shure SM58] รหัส: MR2', '2025-09-22 11:49:17'),
(58, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Shure SM58] รหัส: MR3', '2025-09-22 11:49:36'),
(59, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Shure SM58] → [Shure SM58]', '2025-09-22 11:49:40'),
(60, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Shure SM58] รหัส: M01', '2025-09-22 11:49:58'),
(61, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [AKG D5] รหัส: M02', '2025-09-22 11:50:13'),
(62, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Sennheiser e835] รหัส: M03', '2025-09-22 11:50:28'),
(63, 2, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [AKG D5] → [AKG D5]', '2025-09-22 11:50:33'),
(64, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Tambourine] รหัส: P01', '2025-09-22 11:51:04'),
(65, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Conga] รหัส: P02', '2025-09-22 11:51:17'),
(66, 2, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Snare Drum] รหัส: P03', '2025-09-22 11:51:33'),
(67, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM01] ให้เครื่องดนตรี [Jazz Bass] จำนวน 1', '2025-09-22 11:51:40'),
(68, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM02] ให้เครื่องดนตรี [Jazz Bass] จำนวน 1', '2025-09-22 11:51:43'),
(69, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM03] ให้เครื่องดนตรี [Jazz Bass] จำนวน 1', '2025-09-22 11:51:47'),
(70, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM01] ให้เครื่องดนตรี [Shure SM58] จำนวน 1', '2025-09-22 11:51:51'),
(71, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM02] ให้เครื่องดนตรี [Shure SM58] จำนวน 1', '2025-09-22 11:51:54'),
(72, 2, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [RM03] ให้เครื่องดนตรี [Shure SM58] จำนวน 1', '2025-09-22 11:51:57'),
(73, 2, 'admin', 'create_promotion', 'สร้างโปรโมชั่น [สนุกวันหยุด] (ประเภท: percent, ส่วนลด: 20)', '2025-09-22 11:56:44'),
(74, 2, 'admin', 'update_promotion', 'แก้ไขโปรโมชั่น [สนุกวันหยุด] → [สนุกวันหยุด], \n                        ส่วนลด: 20.00 → 20.00, \n                        สถานะ: Active → Active', '2025-09-22 11:57:15'),
(75, 2, 'admin', 'update_promotion', 'แก้ไขโปรโมชั่น [สนุกวันหยุด] → [สนุกวันหยุด], \n                        ส่วนลด: 20.00 → 20.00, \n                        สถานะ: Active → Active', '2025-09-22 11:57:25'),
(76, 2, 'admin', 'toggle_promotion', 'สลับสถานะโปรโมชั่น [สนุกวันหยุด] เป็น Inactive', '2025-09-22 11:57:38'),
(77, 2, 'admin', 'toggle_promotion', 'สลับสถานะโปรโมชั่น [สนุกวันหยุด] เป็น Active', '2025-09-22 11:57:40'),
(78, 1, 'user', 'confirm_payment', 'Booking #00103 confirmed via QR Code', '2025-09-22 12:00:00'),
(79, 2, 'admin', 'create_promotion', 'สร้างโปรโมชั่น [สัปดาห์หรรศา] (ประเภท: percent, ส่วนลด: 10)', '2025-09-22 12:02:45'),
(80, 2, 'admin', 'create_promotion', 'สร้างโปรโมชั่น [เวลาเล่น] (ประเภท: fixed, ส่วนลด: 50)', '2025-09-22 12:04:05'),
(81, 1, 'user', 'confirm_payment', 'Booking #00104 confirmed via QR Code', '2025-09-22 12:06:12'),
(82, 2, 'admin', 'Update Booking Status', 'Booking ID  status changed from confirmed to pending', '2025-09-22 12:07:08'),
(83, 2, 'admin', 'Update Booking Status', 'Booking ID  status changed from pending to complete', '2025-09-22 12:50:26'),
(84, 2, 'admin', 'Update Booking Status', 'Booking ID  status changed from confirmed to complete', '2025-09-22 12:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `promo_id` int(11) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `deposit_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled','complete') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `promo_id`, `start_time`, `end_time`, `total_price`, `deposit_price`, `status`, `created_at`, `updated_at`) VALUES
(103, 1, 20, NULL, '2025-09-22 19:00:00', '2025-09-22 20:00:00', 180.00, 90.00, 'complete', '2025-09-22 12:00:00', '2025-09-22 12:50:26'),
(104, 1, 21, NULL, '2025-09-22 21:00:00', '2025-09-22 22:00:00', 770.00, 385.00, 'complete', '2025-09-22 12:06:12', '2025-09-22 12:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `booking_addons`
--

CREATE TABLE `booking_addons` (
  `booking_id` int(11) NOT NULL,
  `instrument_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_addons`
--

INSERT INTO `booking_addons` (`booking_id`, `instrument_id`, `quantity`, `price`) VALUES
(104, 24, 1, 150.00),
(104, 31, 1, 120.00),
(104, 37, 1, 100.00),
(104, 43, 1, 100.00),
(104, 49, 1, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `instruments`
--

CREATE TABLE `instruments` (
  `instrument_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `picture_url` varchar(255) DEFAULT NULL,
  `status` enum('available','unavailable','maintenance') DEFAULT 'available',
  `price_per_unit` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instruments`
--

INSERT INTO `instruments` (`instrument_id`, `category_id`, `code`, `name`, `brand`, `picture_url`, `status`, `price_per_unit`) VALUES
(24, 3, 'D01', 'กลองชุดมาตรฐาน', 'Pearl', 'instruments/sJ1HwJxXfgAer2AjRza3yvlFBwZaEzGIhVdDhbMn.jpg', 'available', 150.00),
(25, 3, 'D02', 'กลองชุดไฟฟ้า', 'Yamaha', 'instruments/DDIDXGTImVf7fz2sXueUSbNrhXGuZNQVTTU0rQg2.jpg', 'available', 200.00),
(26, 3, 'D03', 'กลองชุดอะคูสติก', 'Gretsch', 'instruments/vAwOcbFdcCRPU2OmiaKeFI47hBYNhkAXmtsPCkrx.jpg', 'maintenance', 180.00),
(27, 3, 'DR1', 'กลองชุดมาตรฐาน', 'Tama', 'instruments/yTEQpLBmKdE5yNhh1wmv3GHinIp0ZSm5TOUfq6rP.jpg', 'available', 150.00),
(29, 3, 'DR2', 'กลองชุดมาตรฐาน', 'yamaha', 'instruments/ssld2jezqBb8XmFzlsSpD51czr7DGEqrnToW3MEz.jpg', 'available', 150.00),
(30, 3, 'DR3', 'กลองชุดมาตรฐาน', 'Pearl', 'instruments/r57zime2a6ddhhYVDJVVari0BlRT9ehlcaWZQ49u.jpg', 'available', 150.00),
(31, 24, 'KR1', 'Yamaha PSR-SX600', 'Yamaha', 'instruments/s9eZpK2lGhhzFwEtcVQsuurGPfGSeL9UABtXsLiB.jpg', 'available', 120.00),
(32, 24, 'KR2', 'Yamaha PSR-SX600', 'Yamaha', 'instruments/0OD1TTIOxd8QLXQMYDSkxYYgiekltL45mBFNLIk6.jpg', 'available', 120.00),
(33, 24, 'KR3', 'Yamaha PSR-SX600', 'Yamaha', 'instruments/J2OIMbDozlXumdqBEBfo7nmxvhm89V4Yk489sYmg.jpg', 'available', 120.00),
(34, 24, 'KB01', 'Yamaha PSR-SX600', 'Yamaha', 'instruments/XOmNoqVDmRvpP7sgGtak5E9YYpV8PMFBf0vCGLpW.jpg', 'available', 120.00),
(35, 24, 'KB02', 'Roland FP-30', 'Roland', 'instruments/BjrGI10oJI364ElmciHTvUH6ey2CfPlvI9RyAaU4.jpg', 'available', 150.00),
(36, 24, 'KR03', 'Korg Kross', 'Korg', 'instruments/KAgr2ckhbN3xUC5Ycpui26c3avg9xoH9myZTPgC0.jpg', 'available', 140.00),
(37, 25, 'RGR1', 'Fender Stratocaster', 'Fender', 'instruments/OAnoYuIXp5yEukxcqfZgZYWsQQ7NdNIPUN3D96mi.jpg', 'available', 100.00),
(38, 25, 'EGR2', 'Fender Stratocaster', 'Fender', 'instruments/4hgN801FIENhh2mJTqlgxyuiXg1BEgYYYppJEsSe.jpg', 'available', 100.00),
(39, 25, 'EGR3', 'Fender Stratocaster', 'Fender', 'instruments/RmUPBXWLTylbmk8aHpcM7xKeDRVUH5fVgTZXBnXj.jpg', 'available', 100.00),
(40, 25, 'EG01', 'Fender Stratocaster', 'Fender', 'instruments/5Domx1THMUbNTnxkT5VwII9BSHknYCebfNqBbTKE.jpg', 'available', 100.00),
(41, 25, 'EG02', 'Gibson Les Paul', 'Gibson', 'instruments/yjiSPXoKuiRAsquB1fqGDm8EllZ0rxjZtsznLYBT.jpg', 'available', 120.00),
(42, 25, 'EG03', 'Ibanez RG Series', 'Ibanez', 'instruments/hBtlJae8XEwilDrUIK6aDs0jABkebSML0SASS9at.jpg', 'available', 90.00),
(43, 26, 'BR1', 'Jazz Bass', 'Fender', 'instruments/voBYGeJMDnOWe22RNWThHZP7nvRCgzfV7wboWkVh.jpg', 'available', 100.00),
(44, 26, 'BR2', 'Jazz Bass', 'Ibanez', 'instruments/lwLxbqhr448GIdCCKJHUiCZnlgyTnza8mZaim78r.jpg', 'available', 100.00),
(45, 26, 'BR3', 'Jazz Bass', 'Fender', 'instruments/em5GZ3toN9o8qw7IoOcoZe3v0GjfCFi0gwEpiiM5.jpg', 'available', 100.00),
(46, 26, 'B01', 'Jazz Bass', 'Fender', 'instruments/YcMDKs5yf2kKZHDbJHgI9a2FJIwAOQEE0NsvR19h.jpg', 'available', 100.00),
(47, 26, 'B02', 'Precision Bass', 'Musicman', 'instruments/HK4MGqFxm1l7qY1umGySxUeFbDcjYvUD7lDBDFDc.jpg', 'available', 120.00),
(48, 26, 'E03', 'Yamaha TRBX', 'Yamaha', 'instruments/NtWawyNSJme7If0YopG4rhdvSOCXszdRMicAaVKY.jpg', 'available', 90.00),
(49, 27, 'MR1', 'Shure SM58', 'Shure', 'instruments/xjk8tSPmyf6L2t0NBNBKjQxKoQwsAu6lO0hja8eE.png', 'available', 50.00),
(50, 27, 'MR2', 'Shure SM58', 'Shure', 'instruments/gFQNlxrUrkX783DQCgYDzuxYUN4KMS5vhjTaRcpo.png', 'available', 50.00),
(51, 27, 'MR3', 'Shure SM58', 'Shure', 'instruments/o1X6SqU4ioATvUuJ33vu7vwfHHo5HPES1AGvGIvo.png', 'available', 50.00),
(52, 27, 'M01', 'Shure SM58', 'Shure', 'instruments/CylDznn8NQYfiUj3mQzR2VWuhRDmqXXSPo1JWNq1.png', 'available', 50.00),
(53, 27, 'M02', 'AKG D5', 'AKG', 'instruments/dLmFsRVH0WvbuaP1dDUQDxieRYTf5sfhqvMvwwKU.png', 'available', 60.00),
(54, 27, 'M03', 'Sennheiser e835', 'Sennheiser', 'instruments/i0OKb69P5OgIrJsoWuy7qqJFCsitrf11qGRT0jLg.png', 'available', 55.00),
(55, 28, 'P01', 'Tambourine', 'Remo', NULL, 'available', 40.00),
(56, 28, 'P02', 'Conga', 'LP', NULL, 'available', 80.00),
(57, 28, 'P03', 'Snare Drum', 'Pearl', NULL, 'available', 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `instrument_categories`
--

CREATE TABLE `instrument_categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instrument_categories`
--

INSERT INTO `instrument_categories` (`category_id`, `name`) VALUES
(3, 'กลองชุด'),
(24, 'คีย์บอร์ด'),
(25, 'กีตาร์ไฟฟ้า'),
(26, 'เบส'),
(27, 'ไมโครโฟนร้อง'),
(28, 'เครื่องเสริม');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `reset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`reset_id`, `user_id`, `reset_token`, `expires_at`, `used`, `created_at`) VALUES
(1, 1, 'sWx3Vbhm8M7IWZ4BGbDbBXSrlmqlbXZZSJxTr2Z6B8P727ngs8heI38SyE1t9uuT', '2025-08-28 16:54:34', 0, '2025-08-28 08:54:34'),
(2, 1, '4yqXk02ctgffWh3HnjD0rvus0HVwJ4GA7qLPcUcLBJ9as2rV3zVlc79Fs33Sgv6j', '2025-08-28 16:57:03', 1, '2025-08-28 08:57:03'),
(3, 1, 'Hkhu3O0hKCmy4U7nfbjgjPhxSnttIuGz5YNyqljrlezSk2SkZvXQbye5RJxOume2', '2025-08-28 17:01:20', 1, '2025-08-28 09:01:20'),
(4, 6, 'yzKJoNMk6pXuzmwNChO0Nn0jscTyCGecdkFV02MVHHH0Vn8KD865cVAM9ptcZY4F', '2025-09-09 14:36:18', 1, '2025-09-09 06:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('qr_code','manual') DEFAULT 'qr_code',
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `amount`, `payment_method`, `payment_status`, `transaction_id`, `paid_at`, `created_at`) VALUES
(36, 103, 90.00, 'qr_code', 'paid', 'TXN1758542400', '2025-09-22 19:00:00', '2025-09-22 12:00:00'),
(37, 104, 385.00, 'qr_code', 'paid', 'TXN1758542772', '2025-09-22 19:06:12', '2025-09-22 12:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `promo_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('percent','fixed') NOT NULL DEFAULT 'percent',
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`promo_id`, `name`, `description`, `discount_type`, `discount_value`, `start_date`, `end_date`, `is_active`) VALUES
(10, 'สนุกวันหยุด', 'ส่วนลด 20 % สำหรับการจองวันหยุดสุดสัปดาห์', 'percent', 20.00, '2025-09-27', '2025-09-28', 1),
(11, 'สัปดาห์หรรศา', 'ส่วนลด 10 % ในสัปดาห์นี้', 'percent', 10.00, '2025-09-22', '2025-09-26', 1),
(12, 'เวลาเล่น', 'ส่วนลด 50 บาท', 'fixed', 50.00, '2025-09-22', '2025-09-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `receipt_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `receipt_number` varchar(50) NOT NULL,
  `full_amount` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`receipt_id`, `booking_id`, `receipt_number`, `full_amount`, `deposit_amount`, `discount_amount`, `created_at`) VALUES
(36, 103, '00103', 180.00, 90.00, 0.00, '2025-09-22 12:00:00'),
(37, 104, '00104', 770.00, 385.00, 0.00, '2025-09-22 12:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price_per_hour` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `name`, `price_per_hour`, `capacity`, `description`, `image_url`, `created_at`) VALUES
(20, 'RM01', 180.00, 4, 'ห้องขนาดเล็ก', 'rooms/NwZyxwFjsWRiNdH3dkx7M2lEvVXJ1khT12pUAuvs.jpg', '2025-09-22 11:27:51'),
(21, 'RM02', 300.00, 6, 'ห้องขนาดกลาง', 'rooms/8Ic5TYpHsunRDl49AmnrHlFaUTwGhdSLorxkOy9v.jpg', '2025-09-22 11:29:39'),
(22, 'RM03', 500.00, 10, 'ห้องขนาดใหญ่', 'rooms/hUCTW4F52isufErwErOFaotKOQeAorQfLNjJmMGh.jpg', '2025-09-22 11:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `room_instruments`
--

CREATE TABLE `room_instruments` (
  `room_id` int(11) NOT NULL,
  `instrument_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_instruments`
--

INSERT INTO `room_instruments` (`room_id`, `instrument_id`, `quantity`) VALUES
(20, 27, 1),
(20, 31, 1),
(20, 37, 1),
(20, 43, 1),
(20, 49, 1),
(21, 29, 1),
(21, 32, 1),
(21, 38, 1),
(21, 44, 1),
(21, 50, 1),
(22, 30, 1),
(22, 33, 1),
(22, 39, 1),
(22, 45, 1),
(22, 51, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `email`, `password_hash`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'ssdUpdated', 'RazorUpdated', 'ssd', 'ssd@gmail.com', '$2y$12$bnXDEifKPXZ8.9GeOF2Rqe2WslKMPSawgViqmqPREHHfIB/7aY6vm', '0000000000', 'user', '2025-08-28 08:15:50', '2025-09-16 16:10:34'),
(2, 'AdminUpdated', 'AdminnaUpdated', 'admin', 'admin@gmail.com', '$2y$12$z/sNkz6p2yXidTUD9H1zae/iLUigd8CYIZdawJsIypVvzcavmD392', '0123456789', 'admin', '2025-08-28 09:22:19', '2025-09-16 16:59:36'),
(3, 'test2Logg', 'test2Logg', 'test2', 'test2@gmail.com', '$2y$12$u0Tc4T6MzHLfLJamNqcepu84ex2PImFPr/vzxujZ9t9yqIwD/kMoK', '0234445551', 'admin', '2025-08-28 09:23:38', '2025-09-10 17:58:33'),
(4, 'Testingnew', 'Testingnew', 'Testing123new', 'Testing123@gmail.com', '$2y$12$LLP1NEDU3aScsyyiTiQEo.nkhxvXTY5ZqULn9upgdtkTdQSLaOp5e', '0111111111', 'user', '2025-09-05 16:58:24', '2025-09-11 06:31:35'),
(5, 'Testingg', 'Testingg', 'Testing333444', 'Testing333@gmail.com', '$2y$12$dUd9BlUtBaJYiV9Yog2VAuVPJs209CxHz.w4NmerNM/jA4ZjukK86', '0123456789', 'user', '2025-09-05 16:59:11', '2025-09-10 18:06:18'),
(6, 'News', 'Looks', 'Newlookauth3', 'Newlookauth3@gmail.com', '$2y$12$UUwnROXyy9ydejCsTnc7pecOf6nzDsCD16/lrT3LfLOBmvYTkayQ6', '0812345678', 'user', '2025-09-09 06:35:11', '2025-09-10 17:40:33'),
(7, 'Tester1', 'Tester1', 'TesterLast', 'Tester@gmail.com', '$2y$12$xU4VdVkGBCEn04/f24ndcu2lVVWoNmf5wQIsAds/N4/dgIgo3rr7a', '033333333', 'admin', '2025-09-16 12:45:30', '2025-09-16 13:19:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `promo_id` (`promo_id`);

--
-- Indexes for table `booking_addons`
--
ALTER TABLE `booking_addons`
  ADD PRIMARY KEY (`booking_id`,`instrument_id`),
  ADD KEY `instrument_id` (`instrument_id`);

--
-- Indexes for table `instruments`
--
ALTER TABLE `instruments`
  ADD PRIMARY KEY (`instrument_id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `instrument_categories`
--
ALTER TABLE `instrument_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`reset_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promo_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`receipt_id`),
  ADD UNIQUE KEY `receipt_number` (`receipt_number`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `room_instruments`
--
ALTER TABLE `room_instruments`
  ADD PRIMARY KEY (`room_id`,`instrument_id`),
  ADD KEY `instrument_id` (`instrument_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `instruments`
--
ALTER TABLE `instruments`
  MODIFY `instrument_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `instrument_categories`
--
ALTER TABLE `instrument_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`promo_id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_addons`
--
ALTER TABLE `booking_addons`
  ADD CONSTRAINT `booking_addons_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_addons_ibfk_2` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`instrument_id`) ON DELETE CASCADE;

--
-- Constraints for table `instruments`
--
ALTER TABLE `instruments`
  ADD CONSTRAINT `instruments_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `instrument_categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `room_instruments`
--
ALTER TABLE `room_instruments`
  ADD CONSTRAINT `room_instruments_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_instruments_ibfk_2` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`instrument_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
