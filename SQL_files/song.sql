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
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `song_id` smallint(5) UNSIGNED NOT NULL,
  `song_name` varchar(75) NOT NULL,
  `song_genre` varchar(75) DEFAULT NULL,
  `song_update_user` smallint(5) UNSIGNED DEFAULT NULL,
  `song_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`song_id`, `song_name`, `song_genre`, `song_update_user`, `song_update_time`) VALUES
(1, 'Crumbling Castle', 'Progressive Rock', 1, '2019-04-04 02:02:50'),
(2, 'Polygondwanaland', 'Progressive Rock', 1, '2019-04-04 02:03:07'),
(3, 'The Castle in the Air', 'Progressive Rock', 1, '2019-04-04 02:03:17'),
(4, 'Deserted Dunes Welcome Weary Feet', 'Progressive Rock', 1, '2019-04-04 02:03:33'),
(5, 'Inner Cell', 'Progressive Rock', 1, '2019-04-04 02:05:22'),
(6, 'Loyalty', 'Progressive Rock', 1, '2019-04-04 02:05:13'),
(7, 'Horology', 'Progressive Rock', 1, '2019-04-04 02:04:21'),
(8, 'Tetrachromacy', 'Progressive Rock', 1, '2019-04-04 02:04:35'),
(9, 'Searching...', 'Progressive Rock', 1, '2019-04-04 02:04:50'),
(10, 'The Fourth Color', 'Progressive Rock', 1, '2019-04-04 02:05:34'),
(11, 'Sketches of Brunswick East I', 'Psychedelic Jazz', 2, '2019-04-04 02:16:13'),
(12, 'Countdown', 'Psychedelic Jazz', 2, '2019-04-04 02:16:22'),
(13, 'D-Day', 'Psychedelic Jazz', 2, '2019-04-04 02:16:31'),
(14, 'Tezeta', 'Psychedelic Jazz', 2, '2019-04-04 02:16:45'),
(15, 'Cranes, Planes, Migraines', 'Psychedelic Jazz', 2, '2019-04-04 02:16:56'),
(16, 'The Spider and Me', 'Psychedelic Jazz', 2, '2019-04-04 02:17:07'),
(17, 'Sketches of Brunswick East II', 'Psychedelic Jazz', 2, '2019-04-04 02:17:21'),
(18, 'Dusk To Dawn on Lygon Street', 'Psychedelic Jazz', 2, '2019-04-04 02:17:42'),
(19, 'The Book', 'Psychedelic Jazz', 2, '2019-04-04 02:17:52'),
(20, 'A Journey to (S)hell', 'Psychedelic Jazz', 2, '2019-04-04 02:18:09'),
(21, 'Rolling Stoned', 'Psychedelic Jazz', 2, '2019-04-04 02:18:19'),
(22, 'You Can Be Your Silhouette', 'Psychedelic Jazz', 2, '2019-04-04 02:18:32'),
(23, 'Sketches of Brunswick East III', 'Psychedelic Jazz', 2, '2019-04-04 02:18:43'),
(24, 'I\'d Have You Anytime', 'Classic Rock', 2, '2019-04-04 02:24:37'),
(25, 'My Sweet Lord', 'Classic Rock', 2, '2019-04-04 02:24:45'),
(26, 'Wah-Wah', 'Classic Rock', 2, '2019-04-04 02:24:58'),
(27, 'Isn\'t It A Pity (Version One)', 'Classic Rock', 2, '2019-04-04 02:25:14'),
(28, 'What Is Life', 'Classic Rock', 2, '2019-04-04 02:27:23'),
(29, 'If Not for You', 'Classic Rock', 2, '2019-04-04 02:27:31'),
(30, 'Behind That Locked Door', 'Classic Rock', 2, '2019-04-04 02:27:41'),
(31, 'Let It Down', 'Classic Rock', 2, '2019-04-04 02:27:49'),
(32, 'Run of the Mill', 'Classic Rock', 2, '2019-04-04 02:27:59'),
(33, 'Beware Of Darkness', 'Classic Rock', 2, '2019-04-04 02:28:55'),
(34, 'Apple Scruffs', 'Classic Rock', 2, '2019-04-04 02:29:13'),
(35, 'Ballad of Sir Frankie Crisp (Let It Roll)', 'Classic Rock', 2, '2019-04-04 02:29:34'),
(36, 'Awaiting on You All', 'Classic Rock', 2, '2019-04-04 02:29:50'),
(37, 'All Things Must Pass', 'Classic Rock', 2, '2019-04-04 02:31:13'),
(38, 'I Dig Love', 'Classic Rock', 2, '2019-04-04 02:31:25'),
(39, 'Art Of Dying', 'Classic Rock', 2, '2019-04-04 02:32:23'),
(40, 'Isn\'t It a Pity (Version Two)', 'Classic Rock', 2, '2019-04-04 02:34:29'),
(41, 'Hear Me Lord', 'Classic Rock', 2, '2019-04-04 02:34:38'),
(42, 'Come Together', 'Classic Rock', 2, '2019-04-04 02:39:05'),
(43, 'Something', 'Classic Rock', 2, '2019-04-04 02:39:15'),
(44, 'Maxwell\'s Silver Hammer', 'Classic Rock', 2, '2019-04-04 02:39:26'),
(45, 'Oh! Darling', 'Classic Rock', 2, '2019-04-04 02:39:35'),
(46, 'Octopus\'s Garden', 'Classic Rock', 2, '2019-04-04 02:39:47'),
(47, 'I Want You (She\'s So Heavy)', 'Classic Rock', 2, '2019-04-04 02:40:01'),
(48, 'Here Comes the Sun', 'Classic Rock', 2, '2019-04-04 02:40:10'),
(49, 'Because', 'Classic Rock', 2, '2019-04-04 02:40:17'),
(50, 'You Never Give Me Your Money', 'Classic Rock', 2, '2019-04-04 02:40:27'),
(51, 'Sun King', 'Classic Rock', 2, '2019-04-04 02:40:35'),
(52, 'Mean Mr. Mustard', 'Classic Rock', 2, '2019-04-04 02:40:45'),
(53, 'Polythene Pam', 'Classic Rock', 2, '2019-04-04 02:40:58'),
(54, 'She Came In Through the Bathroom Window', 'Classic Rock', 2, '2019-04-04 02:41:13'),
(55, 'Golden Slumbers', 'Classic Rock', 2, '2019-04-04 02:41:29'),
(56, 'Carry That Weight', 'Classic Rock', 2, '2019-04-04 02:41:39'),
(57, 'The End', 'Classic Rock', 2, '2019-04-04 02:41:57'),
(58, 'Her Majesty', 'Classic Rock', 2, '2019-04-04 02:42:05'),
(59, 'Bitter - Acoustic', 'Acoustic Rock', 2, '2019-04-04 02:46:48'),
(60, 'So Long Forever - Acoustic', 'Acoustic Rock', 2, '2019-04-04 02:47:27'),
(61, 'Break the Silence - Acoustic', 'Acoustic Rock', 2, '2019-04-04 02:47:40'),
(62, 'Holy Smoke - Acoustic', 'Acoustic Rock', 2, '2019-04-04 02:47:53'),
(63, 'It\'s Over - Acoustic', 'Acoustic Rock', 2, '2019-04-04 02:48:07'),
(64, 'Break The Silence', 'Rock', 2, '2019-04-04 02:49:21'),
(65, 'Bitter', 'Rock', 2, '2019-04-04 02:49:33'),
(66, 'Live Well', 'Rock', 2, '2019-04-04 02:49:44'),
(67, 'Chapel of Love', NULL, 2, '2019-04-04 03:01:47'),
(68, 'Veins', 'Blues Rock', 1, '2019-04-04 03:04:16'),
(69, 'Crackerbox Palace', 'Classic Rock', 1, '2019-04-04 03:11:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `song_update_user` (`song_update_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `song_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_ibfk_1` FOREIGN KEY (`song_update_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
