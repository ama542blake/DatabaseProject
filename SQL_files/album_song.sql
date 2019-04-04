-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 04, 2019 at 05:18 AM
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
-- Table structure for table `album_song`
--

CREATE TABLE `album_song` (
  `album_id` smallint(5) UNSIGNED NOT NULL,
  `song_id` smallint(5) UNSIGNED NOT NULL,
  `song_track_number` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `album_song`
--

INSERT INTO `album_song` (`album_id`, `song_id`, `song_track_number`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 5, 5),
(1, 6, 6),
(1, 7, 7),
(1, 8, 8),
(1, 9, 9),
(1, 10, 10),
(3, 11, 1),
(3, 12, 2),
(3, 13, 3),
(3, 14, 4),
(3, 15, 5),
(3, 16, 6),
(3, 17, 7),
(3, 18, 8),
(3, 19, 9),
(3, 20, 10),
(3, 21, 11),
(3, 22, 12),
(3, 23, 13),
(4, 24, 1),
(4, 25, 2),
(4, 26, 3),
(4, 27, 4),
(4, 28, 5),
(4, 29, 6),
(4, 30, 7),
(4, 31, 8),
(4, 32, 9),
(4, 33, 10),
(4, 34, 11),
(4, 35, 12),
(4, 36, 13),
(4, 37, 14),
(4, 38, 15),
(4, 39, 16),
(4, 40, 17),
(4, 41, 18),
(5, 42, 1),
(5, 43, 2),
(5, 44, 3),
(5, 45, 4),
(5, 46, 5),
(5, 47, 6),
(5, 48, 7),
(5, 49, 8),
(5, 50, 9),
(5, 51, 10),
(5, 52, 11),
(5, 53, 12),
(5, 54, 13),
(5, 55, 14),
(5, 56, 15),
(5, 57, 16),
(5, 58, 17),
(6, 59, 1),
(6, 60, 2),
(6, 61, 3),
(6, 62, 4),
(6, 63, 5),
(7, 64, 1),
(7, 65, 2),
(7, 66, 3),
(9, 67, 4),
(10, 68, 1),
(11, 69, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album_song`
--
ALTER TABLE `album_song`
  ADD PRIMARY KEY (`album_id`,`song_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album_song`
--
ALTER TABLE `album_song`
  ADD CONSTRAINT `album_song_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `album_song_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `song` (`song_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
