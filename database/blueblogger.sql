-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2019 at 04:21 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blueblogger`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `commentor_post_author_username` varchar(255) NOT NULL,
  `comment_post_id` int(11) NOT NULL,
  `comment_content` longtext NOT NULL,
  `comment_commentor_username` varchar(255) NOT NULL,
  `comment_commentor_fullname` varchar(255) NOT NULL,
  `comment_post_author_username` varchar(255) NOT NULL,
  `comment_birthdate` datetime DEFAULT NULL,
  `comment_order` int(10) UNSIGNED DEFAULT NULL,
  `comment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `commentor_post_author_username`, `comment_post_id`, `comment_content`, `comment_commentor_username`, `comment_commentor_fullname`, `comment_post_author_username`, `comment_birthdate`, `comment_order`, `comment_date`) VALUES
(1, 'rakesh', 1, 'well said ', 'rakesh', 'Rakesh Roshan', 'rakesh', '2019-09-19 00:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_title` varchar(1000) NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `post_excerpt` varchar(2000) DEFAULT NULL,
  `post_content` longtext DEFAULT NULL,
  `post_author_username` varchar(255) NOT NULL,
  `post_visit_count` int(10) UNSIGNED DEFAULT 0,
  `post_comment_count` int(10) UNSIGNED DEFAULT 0,
  `post_publish_date` datetime DEFAULT NULL,
  `post_thumbnail` varchar(10000) DEFAULT 'post.png',
  `post_author_id` int(10) UNSIGNED NOT NULL,
  `post_birthdate` datetime DEFAULT NULL,
  `post_number` int(10) UNSIGNED DEFAULT 0,
  `post_status` varchar(50) DEFAULT 'public',
  `post_comment_allowed` varchar(10) DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_title`, `post_id`, `post_excerpt`, `post_content`, `post_author_username`, `post_visit_count`, `post_comment_count`, `post_publish_date`, `post_thumbnail`, `post_author_id`, `post_birthdate`, `post_number`, `post_status`, `post_comment_allowed`) VALUES
('Blue Is The Color Of Joy.', 1, 'People Say that the scene of ocean have the ability to remove all memory from the mind.', 'People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.People Say that the scene of ocean have the ability to remove all memory from the mind.', 'rakesh', 0, 0, '2019-09-19 03:09:52', 'post_1_thumpic.jpg', 1, '2019-09-19 03:09:52', 1, 'public', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_username` varchar(255) NOT NULL,
  `user_password` mediumtext NOT NULL,
  `user_email` varchar(1000) NOT NULL,
  `user_phone` int(15) NOT NULL,
  `user_fullname` varchar(250) NOT NULL,
  `user_age` int(10) UNSIGNED NOT NULL,
  `user_gender` varchar(50) NOT NULL,
  `user_bloodgroup` varchar(50) NOT NULL,
  `user_education` varchar(100) NOT NULL,
  `user_profession` varchar(1000) NOT NULL,
  `user_current_city` varchar(100) NOT NULL,
  `user_from` varchar(100) NOT NULL,
  `user_profile_picture_link` varchar(10000) DEFAULT 'avatar.png',
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_post_count` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_username`, `user_password`, `user_email`, `user_phone`, `user_fullname`, `user_age`, `user_gender`, `user_bloodgroup`, `user_education`, `user_profession`, `user_current_city`, `user_from`, `user_profile_picture_link`, `user_id`, `user_post_count`) VALUES
('rakesh', '$2y$10$MbHG/685RcK5h8eRXgjxD.s0jgjQJ8O3ZJTn.IRnLwmPnzysytNJa', 'rak321@gmail.com', 434343345, 'Rakesh Roshan', 72, 'Male', 'O-', 'Bcom', 'Film Maker', 'Mumbai', 'Mumbai', 'post_5_thumpic.jpg', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
