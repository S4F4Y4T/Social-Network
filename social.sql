-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 25, 2019 at 12:31 AM
-- Server version: 10.1.40-MariaDB-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `safayata_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `active`
--

CREATE TABLE `active` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `time` text NOT NULL,
  `active` tinyint(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `active`
--

INSERT INTO `active` (`id`, `userid`, `time`, `active`) VALUES
(1, 1, '1566714628', 1),
(2, 2, '1566711822', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `posted_at_com` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `user_id`, `post_id`, `comment`, `posted_at_com`) VALUES
(1, 2, 3, 'wow ', '2019-08-24 11:14:04'),
(2, 2, 3, 'nani ', '2019-08-24 11:14:22'),
(3, 1, 6, 'love you two ', '2019-08-24 11:49:54'),
(4, 2, 6, '<a href=\"profile.php?username=safayat\">@safayat</a> same here ', '2019-08-24 12:04:55'),
(5, 1, 6, 'nice ', '2019-08-24 12:42:22'),
(6, 2, 6, 'Thanks ', '2019-08-25 05:15:27'),
(7, 2, 6, 'yo tf ', '2019-08-25 05:15:38'),
(8, 2, 10, 'giorno giovana ', '2019-08-25 05:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `following_id`, `user_id`) VALUES
(5, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `post_id`) VALUES
(1, 2, 5),
(2, 2, 3),
(3, 2, 4),
(4, 1, 5),
(5, 1, 6),
(6, 1, 3),
(7, 2, 7),
(8, 2, 6),
(9, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `login_tokens`
--

CREATE TABLE `login_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_tokens`
--

INSERT INTO `login_tokens` (`id`, `token`, `user_id`) VALUES
(6, '37994d7ef491cbf3c053064f81b241cc443d8136', 1),
(7, '4d904b10a4d8f4185a6360cd1af5d3edac4943d9', 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `sender`, `receiver`, `seen`, `date`) VALUES
(1, 'hi bro', 2, 1, 1, '2019-08-24 11:39:09'),
(2, 'hey sup', 1, 2, 1, '2019-08-24 11:41:26'),
(3, 'hentai', 1, 2, 1, '2019-08-24 11:50:19'),
(4, 'jah dusto', 2, 1, 1, '2019-08-24 12:05:10'),
(5, 'hi', 1, 2, 1, '2019-08-24 12:40:16'),
(6, 'sup', 2, 1, 1, '2019-08-25 05:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) DEFAULT NULL,
  `post` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `type`, `sender`, `receiver`, `post`, `date`) VALUES
(1, 1, 2, 1, NULL, '2019-08-24 11:13:50'),
(2, 4, 2, 1, 5, '2019-08-24 11:13:56'),
(3, 5, 2, 1, 3, '2019-08-24 11:14:04'),
(4, 5, 2, 1, 3, '2019-08-24 11:14:22'),
(5, 2, 2, 1, NULL, '2019-08-24 11:38:23'),
(6, 4, 2, 1, 3, '2019-08-24 11:38:39'),
(7, 4, 2, 1, 4, '2019-08-24 11:38:45'),
(8, 1, 2, 1, NULL, '2019-08-24 11:39:50'),
(9, 1, 1, 2, NULL, '2019-08-24 11:48:38'),
(10, 4, 1, 2, 6, '2019-08-24 11:49:48'),
(11, 5, 1, 2, 6, '2019-08-24 11:49:54'),
(12, 3, 2, 1, 6, '2019-08-24 12:04:55'),
(13, 5, 1, 2, 6, '2019-08-24 12:42:22'),
(14, 1, 2, 1, NULL, '2019-08-25 05:32:43'),
(15, 1, 2, 1, NULL, '2019-08-25 05:33:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_token`
--

CREATE TABLE `password_token` (
  `id` int(11) NOT NULL,
  `verf_code` varchar(64) NOT NULL,
  `token` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exp_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text,
  `post_image` varchar(24) DEFAULT NULL,
  `posted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int(11) NOT NULL DEFAULT '0',
  `comments` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `body`, `post_image`, `posted_at`, `likes`, `comments`) VALUES
(1, 1, 'nice<br />\r\nthank you ', NULL, '2019-08-24 10:16:11', 0, 0),
(2, 1, NULL, '44cdc669bb.jpg', '2019-08-24 11:00:09', 0, 0),
(3, 1, 'loves ', '27e7c2e4f9.jpg', '2019-08-24 11:00:35', 2, 2),
(4, 1, '<span style=\"color:#337ab7\">@nanase</span> ', NULL, '2019-08-24 11:00:48', 1, 0),
(5, 1, '<span>@nanase</span> ', NULL, '2019-08-24 11:11:41', 2, 0),
(6, 2, '<a href=\"profile.php?username=safayat\">@safayat</a> sup bro ', NULL, '2019-08-24 11:38:23', 2, 5),
(7, 2, 'sup niggas <br />\r\num back ', NULL, '2019-08-25 05:14:17', 1, 0),
(10, 2, NULL, '00640fab01.jpg', '2019-08-25 05:36:03', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `image` varchar(24) NOT NULL DEFAULT 'profile.png',
  `cover` varchar(24) NOT NULL DEFAULT 'cover.png',
  `active` varchar(64) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '0',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `birthdate` varchar(32) NOT NULL DEFAULT '2000-01-01',
  `gender` varchar(12) NOT NULL,
  `job` varchar(32) NOT NULL,
  `address` varchar(64) NOT NULL,
  `about` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `image`, `cover`, `active`, `verified`, `creation_date`, `birthdate`, `gender`, `job`, `address`, `about`) VALUES
(1, 'Safayat Mahmud', 'safayat', 'safayatmahmud.99@gmail.com', '740b77d6e58c40ff1da9d9ff7a3af570d7432fc8', 'f59766f751.jpg', '8550a426cf.jpg', '1', 0, '2019-08-24 10:14:35', '2000-01-01', 'Male', 'programmer', 'dhaka,bangladesh', 'if you are bad then i am your dad'),
(2, 'Aswarjo Malik', 'aswarjo', 'aswarjo@gmail.com', '8d585466392ae3be346022e5b1cb2e58b174975a', '205ae9cb8e.jpg', 'a7a5e8c0ab.jpg', '1', 0, '2019-08-24 11:12:34', '2000-01-01', 'Female', 'student', 'khulna,bangladesh', 'nothing');

-- --------------------------------------------------------

--
-- Table structure for table `verf_token`
--

CREATE TABLE `verf_token` (
  `id` int(11) NOT NULL,
  `verf_code` varchar(64) NOT NULL,
  `token` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `exp_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active`
--
ALTER TABLE `active`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_token`
--
ALTER TABLE `password_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verf_token`
--
ALTER TABLE `verf_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active`
--
ALTER TABLE `active`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `password_token`
--
ALTER TABLE `password_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `verf_token`
--
ALTER TABLE `verf_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
