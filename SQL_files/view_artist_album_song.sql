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
-- Structure for view `view_artist_album_song`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_artist_album_song`  AS  select `artist_album`.`artist_id` AS `artist_id`,`artist`.`artist_name` AS `artist_name`,`artist_album`.`album_id` AS `album_id`,`album`.`album_name` AS `album_name`,`album`.`album_producer` AS `album_producer`,`album_song`.`song_id` AS `song_id`,`song`.`song_name` AS `song_name`,`song`.`song_genre` AS `song_genre`,`album_song`.`song_track_number` AS `song_track_number` from ((((`artist_album` join `album_song` on((`artist_album`.`album_id` = `album_song`.`album_id`))) join `artist` on((`artist_album`.`artist_id` = `artist`.`artist_id`))) join `album` on((`artist_album`.`album_id` = `album`.`album_id`))) join `song` on((`album_song`.`song_id` = `song`.`song_id`))) order by `album_song`.`song_track_number` ;

--
-- VIEW  `view_artist_album_song`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
