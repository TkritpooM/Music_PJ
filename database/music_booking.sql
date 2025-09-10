-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2025 at 07:37 AM
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
(1, 6, 'user', 'confirm_payment', 'Booking #00069 confirmed via QR Code', '2025-09-09 19:06:48'),
(2, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #66 คืนเงิน 50%', '2025-09-09 19:18:50'),
(3, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #68 คืนเงิน 50%', '2025-09-09 19:25:28'),
(4, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #67 คืนเงิน 50%', '2025-09-09 19:25:30'),
(5, 6, 'user', 'confirm_payment', 'Booking #00070 confirmed via QR Code', '2025-09-09 19:28:19'),
(6, 6, 'user', 'confirm_payment', 'Booking #00071 confirmed via QR Code', '2025-09-09 19:31:45'),
(7, 6, 'user', 'confirm_payment', 'Booking #00072 confirmed via QR Code', '2025-09-10 03:34:26'),
(8, 6, 'user', 'confirm_payment', 'Booking #00073 confirmed via QR Code', '2025-09-10 04:26:11'),
(9, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #70 คืนเงิน 50%', '2025-09-10 04:28:22'),
(10, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #71 คืนเงิน 50%', '2025-09-10 04:28:23'),
(11, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #72 คืนเงิน 50%', '2025-09-10 04:28:25'),
(12, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #69 คืนเงิน 50%', '2025-09-10 04:28:27'),
(13, 6, 'user', 'confirm_payment', 'Booking #00074 confirmed via QR Code', '2025-09-10 04:40:10'),
(14, 6, 'user', 'confirm_payment', 'Booking #00075 confirmed via QR Code', '2025-09-10 04:43:04'),
(15, 6, 'user', 'confirm_payment', 'Booking #00076 confirmed via QR Code', '2025-09-10 05:12:22'),
(16, 6, 'user', 'confirm_payment', 'Booking #00077 confirmed via QR Code', '2025-09-10 05:14:53'),
(17, 6, 'user', 'confirm_payment', 'Booking #00078 confirmed via QR Code', '2025-09-10 05:19:50'),
(18, 6, 'user', 'confirm_payment', 'Booking #00079 confirmed via QR Code', '2025-09-10 05:21:04'),
(19, 6, 'user', 'confirm_payment', 'Booking #00080 confirmed via QR Code', '2025-09-10 05:24:26'),
(20, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #79 คืนเงิน 50%', '2025-09-10 05:32:46'),
(21, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #78 คืนเงิน 50%', '2025-09-10 05:32:55'),
(22, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #76 คืนเงิน 50%', '2025-09-10 05:32:59'),
(23, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #73 คืนเงิน 50%', '2025-09-10 05:33:08'),
(24, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #75 คืนเงิน 50%', '2025-09-10 05:33:10'),
(25, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #74 คืนเงิน 50%', '2025-09-10 05:33:11');

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
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `promo_id`, `start_time`, `end_time`, `total_price`, `deposit_price`, `status`, `created_at`, `updated_at`) VALUES
(66, 6, 12, NULL, '2025-09-10 01:51:00', '2025-09-10 03:51:00', 10978.00, 5489.00, 'cancelled', '2025-09-09 18:59:22', '2025-09-09 19:18:50'),
(67, 6, 12, NULL, '2025-09-10 01:52:00', '2025-09-10 03:51:00', 10978.00, 5489.00, 'cancelled', '2025-09-09 19:03:36', '2025-09-09 19:25:30'),
(68, 6, 12, NULL, '2025-09-10 01:52:00', '2025-09-10 03:51:00', 10978.00, 5489.00, 'cancelled', '2025-09-09 19:05:24', '2025-09-09 19:25:28'),
(69, 6, 12, NULL, '2025-09-10 01:51:00', '2025-09-10 03:51:00', 10978.00, 5489.00, 'cancelled', '2025-09-09 19:06:48', '2025-09-10 04:28:27'),
(70, 6, 12, NULL, '2025-09-10 06:27:00', '2025-09-10 10:27:00', 25078.00, 12539.00, 'cancelled', '2025-09-09 19:28:19', '2025-09-10 04:28:21'),
(71, 6, 12, NULL, '2025-09-10 11:31:00', '2025-09-10 13:31:00', 12378.00, 6189.00, 'cancelled', '2025-09-09 19:31:45', '2025-09-10 04:28:23'),
(72, 6, 12, NULL, '2025-09-10 15:33:00', '2025-09-10 16:33:00', 7678.00, 3839.00, 'cancelled', '2025-09-10 03:34:26', '2025-09-10 04:28:25'),
(73, 6, 12, NULL, '2025-09-11 10:50:00', '2025-09-11 11:50:00', 6878.00, 3439.00, 'cancelled', '2025-09-10 04:26:11', '2025-09-10 05:33:08'),
(74, 6, 12, NULL, '2025-09-10 15:30:00', '2025-09-10 16:30:00', 6178.00, 3089.00, 'cancelled', '2025-09-10 04:40:10', '2025-09-10 05:33:11'),
(75, 6, 12, NULL, '2025-09-10 17:41:00', '2025-09-10 18:41:00', 15278.00, 7639.00, 'cancelled', '2025-09-10 04:43:04', '2025-09-10 05:33:10'),
(76, 6, 12, NULL, '2025-09-10 12:12:00', '2025-09-10 13:12:00', 7378.00, 3689.00, 'cancelled', '2025-09-10 05:12:22', '2025-09-10 05:32:59'),
(77, 6, 12, NULL, '2025-09-10 12:12:00', '2025-09-10 13:12:00', 7378.00, 3689.00, 'confirmed', '2025-09-10 05:14:53', '2025-09-10 05:14:53'),
(78, 6, 12, NULL, '2025-09-10 12:12:00', '2025-09-10 13:12:00', 7378.00, 3689.00, 'cancelled', '2025-09-10 05:19:50', '2025-09-10 05:32:55'),
(79, 6, 12, NULL, '2025-09-10 12:12:00', '2025-09-10 13:12:00', 7378.00, 3689.00, 'cancelled', '2025-09-10 05:21:04', '2025-09-10 05:32:46'),
(80, 6, 12, NULL, '2025-09-10 12:12:00', '2025-09-10 13:12:00', 7378.00, 3689.00, 'confirmed', '2025-09-10 05:24:26', '2025-09-10 05:24:26');

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
(73, 2, 3, 100.00),
(73, 7, 6, 300.00),
(74, 2, 2, 100.00),
(74, 7, 4, 300.00),
(75, 2, 12, 100.00),
(75, 7, 31, 300.00),
(76, 2, 5, 100.00),
(76, 7, 7, 300.00),
(77, 2, 5, 100.00),
(77, 7, 7, 300.00),
(78, 2, 5, 100.00),
(78, 7, 7, 300.00),
(79, 2, 5, 100.00),
(79, 7, 7, 300.00),
(80, 2, 5, 100.00),
(80, 7, 7, 300.00);

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
(2, 5, '22222', 'Dodge', 'D33', 'instruments/YNkHVTdaAdapPH6wiNWb3TTZEwDifzvZvMbU5HRD.jpg', 'available', 100.00),
(4, 6, '22233', 'Johnson - KutchUpdate', 'JW1122', 'instruments/0dYbMvBfFkfXSp510Lb7A7xl2vELzKPqrVa0dMKJ.png', 'unavailable', 200.00),
(7, 7, '12445', 'Johnson - Kutchhh', 'JW1122', 'instruments/sZvk9NdrIsnU1ERS4x5sAAjlC7M9NzPNYezZQd2a.jpg', 'available', 300.00);

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
(2, 'กีตาร์'),
(3, 'คีย์บอร์ด'),
(4, 'ไวโอลิน'),
(5, 'YippyCat'),
(6, 'Jewery'),
(7, 'CattyEIEI');

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
(1, 68, 5489.00, 'qr_code', 'paid', 'TXN1757444724', '2025-09-10 02:05:24', '2025-09-09 19:05:24'),
(2, 69, 5489.00, 'qr_code', 'paid', 'TXN1757444808', '2025-09-10 02:06:48', '2025-09-09 19:06:48'),
(3, 70, 12539.00, 'qr_code', 'paid', 'TXN1757446099', '2025-09-10 02:28:19', '2025-09-09 19:28:19'),
(4, 71, 6189.00, 'qr_code', 'paid', 'TXN1757446305', '2025-09-10 02:31:45', '2025-09-09 19:31:45'),
(5, 72, 3839.00, 'qr_code', 'paid', 'TXN1757475266', '2025-09-10 10:34:26', '2025-09-10 03:34:26'),
(6, 73, 3439.00, 'qr_code', 'paid', 'TXN1757478371', '2025-09-10 11:26:11', '2025-09-10 04:26:11'),
(7, 74, 3089.00, 'qr_code', 'paid', 'TXN1757479210', '2025-09-10 11:40:10', '2025-09-10 04:40:10'),
(8, 75, 7639.00, 'qr_code', 'paid', 'TXN1757479384', '2025-09-10 11:43:04', '2025-09-10 04:43:04'),
(9, 76, 3689.00, 'qr_code', 'paid', 'TXN1757481142', '2025-09-10 12:12:22', '2025-09-10 05:12:22'),
(10, 77, 3689.00, 'qr_code', 'paid', 'TXN1757481293', '2025-09-10 12:14:53', '2025-09-10 05:14:53'),
(11, 78, 3689.00, 'qr_code', 'paid', 'TXN1757481590', '2025-09-10 12:19:50', '2025-09-10 05:19:50'),
(12, 79, 3689.00, 'qr_code', 'paid', 'TXN1757481664', '2025-09-10 12:21:04', '2025-09-10 05:21:04'),
(13, 80, 3689.00, 'qr_code', 'paid', 'TXN1757481866', '2025-09-10 12:24:26', '2025-09-10 05:24:26');

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
(1, 'Holiday Discount', 'You can save up to 50 pounds per person !!!', 'fixed', 50.00, '2025-09-02', '2025-09-04', 1),
(2, '100% Discount', 'Perfect payment', 'percent', 100.00, '2025-08-31', '2025-09-01', 0),
(3, 'Holiday Discount Scoopy', 'test', 'percent', 99.99, '2025-09-02', '2025-09-06', 1),
(4, 'test222', 'test222', 'fixed', 222.00, '2025-09-02', '2025-09-18', 1);

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
(1, 68, '00068', 10978.00, 5489.00, 0.00, '2025-09-09 19:05:24'),
(2, 69, '00069', 10978.00, 5489.00, 0.00, '2025-09-09 19:06:48'),
(3, 70, '00070', 25078.00, 12539.00, 0.00, '2025-09-09 19:28:19'),
(4, 71, '00071', 12378.00, 6189.00, 0.00, '2025-09-09 19:31:45'),
(5, 72, '00072', 7678.00, 3839.00, 0.00, '2025-09-10 03:34:26'),
(6, 73, '00073', 6878.00, 3439.00, 0.00, '2025-09-10 04:26:11'),
(7, 74, '00074', 6178.00, 3089.00, 0.00, '2025-09-10 04:40:10'),
(8, 75, '00075', 15278.00, 7639.00, 0.00, '2025-09-10 04:43:04'),
(9, 76, '00076', 7378.00, 3689.00, 0.00, '2025-09-10 05:12:22'),
(10, 77, '00077', 7378.00, 3689.00, 0.00, '2025-09-10 05:14:53'),
(11, 78, '00078', 7378.00, 3689.00, 0.00, '2025-09-10 05:19:50'),
(12, 79, '00079', 7378.00, 3689.00, 0.00, '2025-09-10 05:21:04'),
(13, 80, '00080', 7378.00, 3689.00, 0.00, '2025-09-10 05:24:26');

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
(9, 'A13', 5.00, 5, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', 'rooms/Se5ry9aSnIdy64WESJb6RhcF910UtwiXcFSKwbpp.png', '2025-09-04 06:12:23'),
(11, 'A12', 12.00, 12121, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', 'rooms/vIJc6z9i18dt2RaCXrKvpZ9SqTSX8h1Ymc6RbW5L.jpg', '2025-09-05 16:50:34'),
(12, 'Studio A - Premium', 5000.00, 6, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', NULL, '2025-09-08 18:18:09');

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
(9, 2, 3),
(9, 4, 1111),
(9, 7, 6);

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
(1, 'ssdUpdated', 'RazorUpdated', 'ssd', 'ssd@gmail.com', '$2y$12$CC0qPkH/dXQyMJZXsy7.j.geXF/.eyZOSW.Mhi2xMiGLt6JufNS2K', '0000000000', 'user', '2025-08-28 08:15:50', '2025-08-30 18:42:45'),
(2, 'AdminUpdated', 'AdminnaUpdated', 'admin', 'admin@gmail.com', '$2y$12$qWLk1jgW9AmYTDegQLnTx.gF4LrmSp/J3LalWgd4oS.vqJuR061Qe', '0123456789', 'admin', '2025-08-28 09:22:19', '2025-08-30 18:43:28'),
(3, 'test2UpdateUser1', 'test2UpdateUser1', 'test2', 'test2@gmail.com', '$2y$12$u0Tc4T6MzHLfLJamNqcepu84ex2PImFPr/vzxujZ9t9yqIwD/kMoK', '0234445555', 'admin', '2025-08-28 09:23:38', '2025-09-02 11:03:42'),
(4, 'Testing', 'Testing', 'Testing123', 'Testing123@gmail.com', '$2y$12$ICZPZbpajdvYCQLTFbHkwufsU9jpPf56V6LfQRu50QXy3yEl.Rw.m', '0222222222', 'user', '2025-09-05 16:58:24', '2025-09-05 16:58:24'),
(5, 'Testingg', 'Testingg', 'Testing333', 'Testing333@gmail.com', '$2y$12$T9cUl0VeCwCIZmrS8gR6x.eWtfvHWqHBWn5iGZEVT0IeINR3akgI.', '0123456789', 'user', '2025-09-05 16:59:11', '2025-09-05 16:59:11'),
(6, 'New', 'Looks', 'Newlookauth3', 'Newlookauth3@gmail.com', '$2y$12$UUwnROXyy9ydejCsTnc7pecOf6nzDsCD16/lrT3LfLOBmvYTkayQ6', '0812345678', 'user', '2025-09-09 06:35:11', '2025-09-09 07:17:09');

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
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `instruments`
--
ALTER TABLE `instruments`
  MODIFY `instrument_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `instrument_categories`
--
ALTER TABLE `instrument_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
