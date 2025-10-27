-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 27, 2025 at 07:46 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sanp`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

DROP TABLE IF EXISTS `batches`;
CREATE TABLE IF NOT EXISTS `batches` (
  `batch_id` int NOT NULL,
  `batch_name` varchar(64) DEFAULT NULL,
  `logo` varchar(256) DEFAULT NULL,
  `session` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`batch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`batch_id`, `batch_name`, `logo`, `session`) VALUES
(1, 'Prohor', NULL, '2021-22'),
(2, 'Sompurok', NULL, '2022-23');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `post_id` char(32) NOT NULL,
  `sid` varchar(12) NOT NULL,
  `comment` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`post_id`, `sid`, `comment`, `timestamp`) VALUES
('bc64648295940050a4ac66e2491fe93a', '202223104018', 'first comment', '2025-10-26 22:14:57'),
('fabf4cd46a7d09a3e008219063f04f01', '202223104018', 'First comment', '2025-10-26 22:05:58'),
('53503a9d5aebc250a9be70acb4d74eac', '202223104018', 'First comment', '2025-10-26 22:05:51'),
('8035c6d9bf013fe685b22551f8e9c85d', '202223104018', 'Very beautiful flowers.', '2025-10-24 09:20:39'),
('482c5af6e2db7f878adb824abfa70960', '202223104020', 'I have to get there soon!!!!', '2025-10-24 21:57:29'),
('482c5af6e2db7f878adb824abfa70960', '202223104020', 'Is there any way so that I can reach there?', '2025-10-24 21:57:57'),
('8035c6d9bf013fe685b22551f8e9c85d', '202223104020', 'You cracked it dude', '2025-10-24 22:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` char(32) NOT NULL,
  `type` varchar(8) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(256) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `image` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `approve_status` tinyint(1) DEFAULT '0',
  `approved_by` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `posted_by` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `type`, `timestamp`, `title`, `start_date`, `end_date`, `description`, `image`, `approve_status`, `approved_by`, `posted_by`) VALUES
('7d5cc8cd8291ac39af00e4494280f2e1', 'student', '2025-10-27 13:20:03', 'CSE Fest 2024', '2025-10-08', '2025-10-10', 'This was totally a crazy event. Like seriouly!!!!!!', 'uploads/img_68ffc3437f0555.09820084.png', 1, NULL, '202223104020'),
('3d3929e61f75e92ca97c291ff46fa696', 'student', '2025-10-27 13:20:51', 'Tech Innovation 2025', '2025-10-09', '2025-10-14', 'Nothing to say', NULL, 1, NULL, '202223104020'),
('80d8bb7186cafa0eebfdd6ebf72aa3d8', 'alumni', '2025-10-27 19:38:41', 'Alumni Reunion Program (2022-23)', '2025-10-30', '2025-10-31', 'This is going to be the first alumni reunion ever in the history of Kishoreganj University.', 'uploads/img_68ffca413334d2.30737185.jpg', 1, NULL, '202223104018');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `post_id` char(32) NOT NULL,
  `sid` varchar(12) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`post_id`, `sid`, `timestamp`) VALUES
('53503a9d5aebc250a9be70acb4d74eac', '202223104018', '2025-10-26 22:05:44'),
('482c5af6e2db7f878adb824abfa70960', '202223104018', '2025-10-23 17:55:53'),
('482c5af6e2db7f878adb824abfa70960', '202223104023', '2025-10-22 19:07:26'),
('bc64648295940050a4ac66e2491fe93a', '202223104018', '2025-10-26 22:15:09'),
('8035c6d9bf013fe685b22551f8e9c85d', '202223104023', '2025-10-22 19:07:00'),
('8035c6d9bf013fe685b22551f8e9c85d', '202223104020', '2025-10-24 01:34:50'),
('eae40d4f5afbbce4c6d86e6c58d850b9', '202223104020', '2025-10-24 01:33:26'),
('482c5af6e2db7f878adb824abfa70960', '202223104024', '2025-10-22 19:08:13'),
('eae40d4f5afbbce4c6d86e6c58d850b9', '202223104024', '2025-10-22 19:08:16'),
('8035c6d9bf013fe685b22551f8e9c85d', '202223104024', '2025-10-22 19:08:22'),
('482c5af6e2db7f878adb824abfa70960', '202223104020', '2025-10-24 21:58:10'),
('5df04623325ed09da1b25313fede0cdc', '202223104020', '2025-10-24 22:09:12'),
('5df04623325ed09da1b25313fede0cdc', '202223104024', '2025-10-24 22:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` char(32) NOT NULL,
  `sid` varchar(12) DEFAULT NULL,
  `type` varchar(16) DEFAULT NULL,
  `batch_id` int DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  `image` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `sid`, `type`, `batch_id`, `timestamp`, `description`, `image`) VALUES
('eae40d4f5afbbce4c6d86e6c58d850b9', '202223104024', 'student-general', NULL, '2025-10-22 15:16:34', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic repudiandae consequuntur sequi nihil, voluptas exercitationem, quod, cupiditate itaque commodi veniam voluptatem esse id earum at perferendis quia! Minima, doloremque dignissimos! Similique culpa eaque ab voluptates repudiandae, perspiciatis pariatur deleniti veritatis dolorem in fuga, dolore quidem ullam, aut vel laboriosam. Dolor? Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, voluptatem dignissimos incidunt et ipsam veritatis dolore possimus! Mollitia at libero sed! Commodi error nam esse eius vel corrupti non ipsam aut a in possimus est quasi aliquam, consequuntur rerum ut dolorum fuga facilis inventore quia asperiores numquam qui? Distinctio error in temporibus, corrupti, unde optio voluptatem repellat rerum, recusandae autem labore.', NULL),
('482c5af6e2db7f878adb824abfa70960', '202223104020', 'student-general', NULL, '2025-10-22 06:49:13', 'Let\'s update this post NOW!', 'uploads/img_68f87e691cd997.64826071.png'),
('8035c6d9bf013fe685b22551f8e9c85d', '202223104020', 'student-general', NULL, '2025-10-22 06:15:53', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic repudiandae consequuntur sequi nihil, voluptas exercitationem, quod, cupiditate itaque commodi veniam voluptatem esse id earum at perferendis quia! Minima, doloremque dignissimos! Similique culpa eaque ab voluptates repudiandae, perspiciatis pariatur deleniti veritatis dolorem in fuga, dolore quidem ullam, aut vel laboriosam. Dolor? Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, voluptatem dignissimos incidunt et ipsam veritatis dolore possimus! Mollitia at libero sed! Commodi error nam esse eius vel corrupti non ipsam aut a in possimus est quasi aliquam, consequuntur rerum ut dolorum fuga facilis inventore quia asperiores numquam qui? Distinctio error in temporibus, corrupti, unde optio voluptatem repellat rerum, recusandae autem labore.', 'uploads/img_68f876999fa535.59369629.jpg'),
('5df04623325ed09da1b25313fede0cdc', '202223104020', 'student-general', NULL, '2025-10-24 22:04:36', 'This is my latest post and it is updated! Final check (for Batch)!!! ', 'uploads/img_68fe86aaf06e37.99286390.png'),
('e4cf11b8a6d5e83ddda06d49e7ca3cf3', '202223104020', 'student-batch', 2, '2025-10-26 21:52:49', 'This is the first batch based post', NULL),
('fabf4cd46a7d09a3e008219063f04f01', '202223104024', 'alumni-general', NULL, '2025-10-26 22:03:24', 'First post in the alumni general section', NULL),
('76333546e51853a6e666f4620f9b8a6c', '202223104024', 'student-general', NULL, '2025-10-26 21:55:44', 'Here we go', NULL),
('53503a9d5aebc250a9be70acb4d74eac', '202223104018', 'alumni-general', NULL, '2025-10-26 22:05:41', 'I am Jashim, an Alumni', NULL),
('c06098f5cc90179af7f9d63ad389264c', '202223104024', 'alumni-batch', 1, '2025-10-26 22:14:23', 'First alumni post of prohor', NULL),
('bc64648295940050a4ac66e2491fe93a', '202223104018', 'alumni-batch', 2, '2025-10-26 22:14:48', 'First alumni post of sompurok.. bla bla bla', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports_feedbacks`
--

DROP TABLE IF EXISTS `reports_feedbacks`;
CREATE TABLE IF NOT EXISTS `reports_feedbacks` (
  `report_id` char(32) NOT NULL,
  `reporter_id` varchar(12) DEFAULT NULL,
  `target_type` varchar(8) DEFAULT NULL,
  `target_id` varchar(32) DEFAULT NULL,
  `report_description` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reports_feedbacks`
--

INSERT INTO `reports_feedbacks` (`report_id`, `reporter_id`, `target_type`, `target_id`, `report_description`, `timestamp`) VALUES
('4e7f7a7159b4649f212019b9d1fa6440', '202223104020', 'post', 'eae40d4f5afbbce4c6d86e6c58d850b9', 'This post looks suspicious!!!', '2025-10-26 21:09:59'),
('13d386f8a1afbe3a700a64c47ffaf070', '202223104020', 'post', 'eae40d4f5afbbce4c6d86e6c58d850b9', 'Another test report', '2025-10-26 21:34:38'),
('438e5f93e8a5609b2c91f1851680e75a', '202223104018', 'post', 'fabf4cd46a7d09a3e008219063f04f01', 'Nothing serious!', '2025-10-26 22:06:20'),
('c295133e9692815feebec0d2a66cb995', '202223104018', 'event', 'd8b2a85408bf42b5cfb46e142ec367e2', 'This event has no poster', '2025-10-27 19:21:26'),
('f9513092b52a3a9115643266aff19280', '202223104018', 'event', '7d5cc8cd8291ac39af00e4494280f2e1', 'The des is so short', '2025-10-27 19:21:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `sid` varchar(12) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `role` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'student',
  `batch_id` int DEFAULT NULL,
  `company` varchar(64) DEFAULT NULL,
  `designation` varchar(64) DEFAULT NULL,
  `blood_group` varchar(4) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(8) DEFAULT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `site` varchar(64) DEFAULT NULL,
  `skills` varchar(256) DEFAULT NULL,
  `achievements` varchar(256) DEFAULT NULL,
  `mentorship_availability` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`sid`, `email`, `password`, `name`, `role`, `batch_id`, `company`, `designation`, `blood_group`, `dob`, `gender`, `avatar`, `phone`, `address`, `site`, `skills`, `achievements`, `mentorship_availability`) VALUES
('202223104018', 'badhon.kiu@gmail.com', '$2y$10$P129g1LijcssdQ7dYyQpsePOUlZOUUJF5zTWb9cf41wABDn2SDDCe', 'Jashim', 'alumni', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('202223104020', 'badhon.kiu@gmail.com', '$2y$10$Ok/P6KUYm3E0PP99ssmHGO8q1n7n93dbSUdu7xJCP4lpPhznkeXeW', 'Rubayet Ashib Badhon', 'admin', 2, NULL, NULL, NULL, NULL, NULL, 'https://images.pexels.com/photos/771742/pexels-photo-771742.jpeg', NULL, NULL, NULL, NULL, NULL, NULL),
('202223104022', 'badhon.kiu@gmail.com', '$2y$10$UooAxDgYHrXwSBjW9HX.munBhfxVAyLMiKFDPFCh13ug9yzz7QaQy', 'Ovi', 'student', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('202223104023', 'badhon.kiu@gmail.com', '$2y$10$j9gFuwQTYyNUTz15Wgvld.EPFCmUnJ55128Nc5Qod2yO6msqpjrlS', 'Labib', 'admin', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('202223104024', 'badhon.kiu@gmail.com', '$2y$10$NcCqLFrn.cfNFBnbdhF/6.Ufbr/0sK83w9JPzo5RGAq1nbWyVWc3m', 'Ashraful', 'alumni', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
