-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2023 at 01:52 PM
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
-- Database: `user-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(55) NOT NULL,
  `email` varchar(211) NOT NULL,
  `password` varchar(211) NOT NULL,
  `user_type` varchar(55) NOT NULL COMMENT '1=admin,=user',
  `verify_token` varchar(255) NOT NULL,
  `verify_status` tinyint(11) NOT NULL,
  `active_status` tinyint(11) NOT NULL DEFAULT 1,
  `created_at` varchar(55) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `phone`, `email`, `password`, `user_type`, `verify_token`, `verify_status`, `active_status`, `created_at`) VALUES
(1, 'Rahul', '+917889126754', 'akhilranatramiet116030@gmail.com', '8d6fb517e4454d5abfe1e02c6dc64cda30acdc79', 'admin', '74ab71f3b82d121db30f2fdbc1900fafaefdcdb4', 1, 1, '2023-02-09 19:52:36'),
(2, 'Chetan', '+917889126754', 'akhilrana7874@gmail.com', '8d6fb517e4454d5abfe1e02c6dc64cda30acdc79', 'user', '469bc2b782fbf9a2c0e875fbe94f4e23ba4785dc', 1, 0, '2023-02-09 19:53:57'),
(3, 'Pankaj', '+917889126754', 'akhilrana2498@gmail.com', '8d6fb517e4454d5abfe1e02c6dc64cda30acdc79', 'user', '11fd933f1eb80537aadc5a4e3027c124', 1, 1, '2023-02-09 19:55:14'),
(17, 'Deepak', '+917889126754', 'akhilwebspace88@gmail.com', '8d6fb517e4454d5abfe1e02c6dc64cda30acdc79', 'user', '2bcf4af02d957f169b3153b0555008f7e6f98841', 1, 0, '2023-02-13 12:48:34'),
(24, 'Rahul', '+917889126754', 'akhilranatramiet116030@gmail.com', '8d6fb517e4454d5abfe1e02c6dc64cda30acdc79', 'user', 'e5e5acacf586b6f75e5ccc638d78945a4325cfbe', 1, 1, '2023-02-14 12:24:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
