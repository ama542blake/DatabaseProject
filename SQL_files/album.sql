-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 04, 2019 at 05:16 AM
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
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `album_id` smallint(5) UNSIGNED NOT NULL,
  `album_name` varchar(75) NOT NULL,
  `album_released_year` year(4) DEFAULT NULL,
  `album_artwork_artist` smallint(5) UNSIGNED DEFAULT NULL,
  `album_producer` smallint(5) UNSIGNED DEFAULT NULL,
  `album_update_user` smallint(5) UNSIGNED DEFAULT NULL,
  `album_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`album_id`, `album_name`, `album_released_year`, `album_artwork_artist`, `album_producer`, `album_update_user`, `album_update_time`) VALUES
(1, 'Polygondwanaland', 2017, 1, 1, 1, '2019-04-04 02:01:59'),
(3, 'Sketches of Brunswick East', 2017, 1, 1, NULL, '2019-04-04 02:15:49'),
(4, 'All Things Must Pass', 1970, 2, 2, 2, '2019-04-04 02:23:49'),
(5, 'Abbey Road', 1969, 3, 3, 2, '2019-04-04 02:37:15'),
(6, 'Acoustic Tracks From the Arch', 2017, NULL, NULL, 2, '2019-04-04 02:46:18'),
(7, 'So Long Forever', 2016, NULL, NULL, 2, '2019-04-04 02:48:41'),
(8, 'Palace', NULL, NULL, NULL, 2, '2019-04-04 02:58:29'),
(9, '15 Big Ones', 1976, NULL, 4, 2, '2019-04-04 03:01:04'),
(10, 'Veins - Single', 2014, NULL, NULL, 1, '2019-04-04 03:03:40'),
(11, 'Thirty Three & 1/3', 1976, NULL, NULL, 1, '2019-04-04 03:10:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `album_artwork_artist` (`album_artwork_artist`),
  ADD KEY `album_update_user` (`album_update_user`),
  ADD KEY `album_producer` (`album_producer`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `album_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`album_artwork_artist`) REFERENCES `artwork_artist` (`artwork_artist_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`album_update_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `album_ibfk_3` FOREIGN KEY (`album_producer`) REFERENCES `producer` (`producer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
