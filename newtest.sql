-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 10:31 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `emp_info`
--

CREATE TABLE `emp_info` (
  `id` int(11) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emp_info`
--

INSERT INTO `emp_info` (`id`, `emp_name`, `mobile_no`, `email`, `created_at`) VALUES
(1, 'ddfgd', '12', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(2, 'fdhbd', '1234', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(3, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(4, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(5, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(6, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(7, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(8, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(9, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(10, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(11, 'erer', '123456890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(12, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(13, 'erer', '125', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(14, 'erer', '1234567890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43'),
(15, 'erer', '123456890', 'pawarnana2000@gmail.com', '2024-09-26 08:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `pdf`
--

CREATE TABLE `pdf` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `PdfPath` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pdf`
--

INSERT INTO `pdf` (`id`, `Name`, `PdfPath`, `created_at`) VALUES
(1, 'Suyash ravan Kore', 'uploads/PHP Developer MTP2-3.pdf', '2024-09-26 04:44:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emp_info`
--
ALTER TABLE `emp_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdf`
--
ALTER TABLE `pdf`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emp_info`
--
ALTER TABLE `emp_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pdf`
--
ALTER TABLE `pdf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
