-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2024 at 07:33 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u198372255_vm_cricket`
--

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `companyname` varchar(255) DEFAULT NULL,
  `linkedinurl` varchar(255) DEFAULT NULL,
  `contactperson` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `jobtitle` varchar(255) DEFAULT NULL,
  `captain` varchar(255) DEFAULT NULL,
  `vicecaptain` varchar(255) DEFAULT NULL,
  `player3` varchar(255) DEFAULT NULL,
  `player4` varchar(255) DEFAULT NULL,
  `player5` varchar(255) DEFAULT NULL,
  `player6` varchar(255) DEFAULT NULL,
  `player7` varchar(255) DEFAULT NULL,
  `player8` varchar(255) DEFAULT NULL,
  `player9` varchar(255) DEFAULT NULL,
  `player10` varchar(255) DEFAULT NULL,
  `player11` varchar(255) DEFAULT NULL,
  `lkcaptain` varchar(255) DEFAULT NULL,
  `lkvicecaptain` varchar(255) DEFAULT NULL,
  `lkplayer3` varchar(255) NOT NULL,
  `lkplayer4` varchar(255) NOT NULL,
  `lkplayer5` varchar(255) NOT NULL,
  `lkplayer6` varchar(255) NOT NULL,
  `lkplayer7` varchar(255) NOT NULL,
  `lkplayer8` varchar(255) NOT NULL,
  `lkplayer9` varchar(255) NOT NULL,
  `lkplayer10` varchar(255) NOT NULL,
  `lkplayer11` varchar(255) NOT NULL,
  `rulesaccepted` enum('0','1') DEFAULT '0',
  `token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `created_at`) VALUES
(1, 'admin', 'vidyadhar.sutar@vereigenmedia.com', '49fd2b485cdd4d25adbc31d87388391f', 'cff1555c02fc9dee9821eed56b2f8370', '2024-04-22 12:44:32');


ALTER TABLE `team`
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
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
