-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 04, 2019 at 05:19 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `band_membership`
--

CREATE TABLE `band_membership` (
  `band_id` smallint(5) UNSIGNED NOT NULL,
  `solo_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `band_membership`
--

INSERT INTO `band_membership` (`band_id`, `solo_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(9, 10),
(12, 11),
(12, 13),
(12, 14),
(12, 15),
(16, 17),
(18, 17),
(19, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `band_membership`
--
ALTER TABLE `band_membership`
  ADD PRIMARY KEY (`band_id`,`solo_id`),
  ADD KEY `solo_id` (`solo_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `band_membership`
--
ALTER TABLE `band_membership`
  ADD CONSTRAINT `band_membership_ibfk_1` FOREIGN KEY (`band_id`) REFERENCES `artist` (`artist_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `band_membership_ibfk_2` FOREIGN KEY (`solo_id`) REFERENCES `artist` (`artist_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
