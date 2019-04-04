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
-- Table structure for table `artwork_artist`
--

CREATE TABLE `artwork_artist` (
  `artwork_artist_id` smallint(5) UNSIGNED NOT NULL,
  `artwork_artist_name` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artwork_artist`
--

INSERT INTO `artwork_artist` (`artwork_artist_id`, `artwork_artist_name`) VALUES
(2, 'Barry Feinstein'),
(3, 'Ian Macmillan'),
(1, 'Jason Galea');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artwork_artist`
--
ALTER TABLE `artwork_artist`
  ADD PRIMARY KEY (`artwork_artist_id`),
  ADD UNIQUE KEY `artwork_artist_name` (`artwork_artist_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artwork_artist`
--
ALTER TABLE `artwork_artist`
  MODIFY `artwork_artist_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
