-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 08, 2023 at 06:44 PM
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
-- Database: `contact_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `first_name`, `last_name`, `email`, `phone_number`, `user_id`) VALUES
(21, 'abc5555', 'ddd', '222@222.gjf', '666-666-6666', 2),
(23, 'yyy', 'iii', 'dvdf@dfsd.ght', '555-555-5555', 1),
(24, '111', '111', '111@111.111', '111-111-1111', 1),
(25, 'fdf', 'dfd', 'df@dfd.dfd', '444-444-4444', 3),
(26, 'kkk', 'kkk', 'kkk@kkk.kkk', '000-000-0099', 3),
(27, 'sss', 'sss', 'sss@sss.sss', '555-555-5555', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `email`) VALUES
(1, '11', '11', ''),
(2, '22', '22', ''),
(3, '33', '33', '22@22.kk'),
(4, '111', '$2y$10$UG5dzSImPerRzOtolSUHTOQOtCM3D7Yf8gL6iL.Dtvpbe.awmVsfW', '111@111.111'),
(5, 'zzz', '$2y$10$p3pIC9mn/z7FamMxvjUuzuJQc8Uav2cnVCtb29NCm94v.CQTvEIJ2', 'zzz@zzz.zzz'),
(6, 'ccc', '$2y$10$PeelAyaVtks/hFViyS4Vi.QKw0o5.us1Tl47mGnevvNjCzrmX6xK6', 'ccc@ccc.ccc'),
(7, 'iii', '$2y$10$IWQkgO./7.mI8xBoBvU1aOvOo23vIF8SwM5nGA/yI99SeXr5C2XIa', 'iii@iii.iii');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
