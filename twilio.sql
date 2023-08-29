-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2023 at 05:03 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twilio`
--

-- --------------------------------------------------------

--
-- Table structure for table `session_participants`
--

DROP TABLE IF EXISTS `session_participants`;
CREATE TABLE IF NOT EXISTS `session_participants` (
  `sessionid` int DEFAULT NULL,
  `userid` int DEFAULT NULL,
  KEY `sessionid` (`sessionid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `email`, `password_hash`) VALUES
(1, 'shubham', 'a@a.com', '$2y$10$VtHyYjsEUGpDteef6qPop.aVCsoR8jWmc7JYbK948/FqkYURi5wnm'),
(2, 'admin', 'admin@a.com', '$2y$10$sj/a4rn7BmaeqojD9KKE.OcIGO6D/9riplvQ6NTbFy6JBS3qw5mxu');

-- --------------------------------------------------------

--
-- Table structure for table `video_call_sessions`
--

DROP TABLE IF EXISTS `video_call_sessions`;
CREATE TABLE IF NOT EXISTS `video_call_sessions` (
  `sessionid` int NOT NULL AUTO_INCREMENT,
  `starttime` datetime NOT NULL,
  `endtime` datetime DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `callerid` int DEFAULT NULL,
  `receiverid` int DEFAULT NULL,
  PRIMARY KEY (`sessionid`),
  KEY `callerid` (`callerid`),
  KEY `receiverid` (`receiverid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
