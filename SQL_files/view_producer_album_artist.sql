-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 04, 2019 at 05:20 AM
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
-- Structure for view `view_producer_album_artist`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_producer_album_artist`  AS  select `producer`.`producer_id` AS `producer_id`,`producer`.`producer_name` AS `producer_name`,`album`.`album_id` AS `album_id`,`album`.`album_name` AS `album_name`,`artist`.`artist_id` AS `artist_id`,`artist`.`artist_name` AS `artist_name` from (((`producer` join `album` on((`producer`.`producer_id` = `album`.`album_producer`))) join `artist_album` on((`album`.`album_id` = `artist_album`.`album_id`))) join `artist` on((`artist_album`.`artist_id` = `artist`.`artist_id`))) ;

--
-- VIEW  `view_producer_album_artist`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
