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
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `artist_id` smallint(5) UNSIGNED NOT NULL,
  `artist_name` varchar(75) NOT NULL,
  `artist_is_band` tinyint(1) DEFAULT NULL,
  `artist_update_user` smallint(5) UNSIGNED DEFAULT NULL,
  `artist_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`artist_id`, `artist_name`, `artist_is_band`, `artist_update_user`, `artist_update_time`) VALUES
(1, 'King Gizzard and the Lizard Wizard', 1, 1, '2019-04-04 01:53:32'),
(2, 'Stu MacKenzie', 0, 1, '2019-04-04 01:53:32'),
(3, 'Eric Moore', 0, 1, '2019-04-04 01:53:32'),
(4, 'Ambrose Kenny Smith', 0, 1, '2019-04-04 01:53:32'),
(5, 'Cook Craig', 0, 1, '2019-04-04 01:53:32'),
(6, 'Joey Walker', 0, 1, '2019-04-04 01:53:32'),
(7, 'Lucas Skinner', 0, 1, '2019-04-04 01:53:32'),
(8, 'Michael Cavanaugh', 0, 1, '2019-04-04 01:53:32'),
(9, 'Mild High Club', 1, 1, '2019-04-04 02:06:27'),
(10, 'Alex Brettin', 0, 1, '2019-04-04 02:06:27'),
(11, 'George Harrison', 0, 2, '2019-04-04 02:19:25'),
(12, 'The Beatles', 1, 2, '2019-04-04 02:20:35'),
(13, 'Paul McCartney', 0, 2, '2019-04-04 02:20:06'),
(14, 'Ringo Starr', 0, 2, '2019-04-04 02:20:35'),
(15, 'John Lennon', 0, 2, '2019-04-04 02:20:35'),
(16, 'Palace', 1, 2, '2019-04-04 02:44:44'),
(17, '', 0, 2, '2019-04-04 02:44:44'),
(18, 'Chapel Club', 1, 2, '2019-04-04 02:57:37'),
(19, 'The Beach Boys', 1, 2, '2019-04-04 03:00:28'),
(20, 'Brian Wilson', 0, 2, '2019-04-04 03:00:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`artist_id`),
  ADD KEY `artist_update_user` (`artist_update_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `artist_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artist`
--
ALTER TABLE `artist`
  ADD CONSTRAINT `artist_ibfk_1` FOREIGN KEY (`artist_update_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
