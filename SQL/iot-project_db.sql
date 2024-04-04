-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 04, 2024 at 02:43 PM
-- Server version: 8.0.36-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot-project`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert-center`
--

CREATE TABLE `alert-center` (
  `id` int NOT NULL,
  `alert_type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `alert_text` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `alert_date` text COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sensor-data`
--

CREATE TABLE `sensor-data` (
  `id` int NOT NULL,
  `sensor` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `temp` float NOT NULL,
  `humidity` float NOT NULL,
  `pressure` float NOT NULL,
  `altitude` float NOT NULL,
  `time` text COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL COMMENT 'ไอดี',
  `data_rate` int NOT NULL COMMENT 'อัตราการส่งข้อมูล (วินาที)',
  `line_token` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `condition_notify` int NOT NULL DEFAULT '0',
  `modify_notify` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `line_notify_message` text COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alert-center`
--
ALTER TABLE `alert-center`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sensor-data`
--
ALTER TABLE `sensor-data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alert-center`
--
ALTER TABLE `alert-center`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensor-data`
--
ALTER TABLE `sensor-data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
