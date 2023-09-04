-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 04, 2023 at 06:37 AM
-- Server version: 10.6.14-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u313289538_arena`
--

-- --------------------------------------------------------

--
-- Table structure for table `session_participants`
--

CREATE TABLE `session_participants` (
  `sessionid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `email`, `password_hash`) VALUES
(1, 'shubham', 's@a.com', '$2y$10$JQn4ORVJC2ow8yU.Osf8sOEj8NlP4dF7IbHVw04pR1zZeUBKQxXuW'),
(2, 'arena', 'a@a.com', '$2y$10$uex7aQxlp9AnSyix2nzGQuCAKWJEeuHb0kzx43M5f.CZW3Hqmqw8O');

-- --------------------------------------------------------

--
-- Table structure for table `video_call_sessions`
--

CREATE TABLE `video_call_sessions` (
  `sessionid` int(11) NOT NULL,
  `starttime` datetime NOT NULL,
  `receivetime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `callerid` int(11) DEFAULT NULL,
  `receiverid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video_call_sessions`
--

INSERT INTO `video_call_sessions` (`sessionid`, `starttime`, `receivetime`, `endtime`, `duration`, `callerid`, `receiverid`) VALUES
(1, '2023-09-03 10:25:16', '2023-09-03 10:25:28', NULL, NULL, 1, 2),
(2, '2023-09-03 10:36:57', '2023-09-03 10:37:01', NULL, NULL, 1, 2),
(3, '2023-09-03 10:38:58', '2023-09-03 10:39:03', '2023-09-03 10:39:20', 17, 2, 1),
(4, '2023-09-03 10:44:56', '2023-09-03 10:45:00', '2023-09-03 10:46:06', 66, 1, 2),
(5, '2023-09-04 06:24:57', '2023-09-04 06:25:04', NULL, NULL, 2, 1),
(6, '2023-09-04 06:27:18', NULL, NULL, NULL, 2, 1),
(7, '2023-09-04 06:29:35', '2023-09-04 06:29:40', '2023-09-04 06:30:41', 61, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `session_participants`
--
ALTER TABLE `session_participants`
  ADD KEY `sessionid` (`sessionid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `video_call_sessions`
--
ALTER TABLE `video_call_sessions`
  ADD PRIMARY KEY (`sessionid`),
  ADD KEY `callerid` (`callerid`),
  ADD KEY `receiverid` (`receiverid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `video_call_sessions`
--
ALTER TABLE `video_call_sessions`
  MODIFY `sessionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
