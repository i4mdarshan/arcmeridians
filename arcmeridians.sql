-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2020 at 08:27 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arcmeridians`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatroom`
--

CREATE TABLE `chatroom` (
  `room_id` int(11) DEFAULT NULL,
  `chat_name` varchar(128) NOT NULL,
  `chat_messages` text DEFAULT NULL,
  `chat_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `chat_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chatroom`
--

INSERT INTO `chatroom` (`room_id`, `chat_name`, `chat_messages`, `chat_time`, `chat_id`, `member_id`) VALUES
(30, 'Riyansh Shah', 'check', '2020-07-24 05:14:59', 36, NULL),
(30, 'Riyansh Shah', 'check 2', '2020-07-24 06:26:03', 37, NULL),
(30, 'Riyansh Shah', 'cvvc', '2020-07-24 08:35:48', 38, NULL),
(30, 'Riyansh Shah', 'check', '2020-07-24 08:49:58', 39, NULL),
(30, 'Riyansh Shah', 'check1', '2020-07-24 08:50:41', 40, NULL),
(30, 'Riyansh Shah', 'check 2', '2020-07-24 12:47:25', 41, NULL),
(30, 'Riyansh Shah', 'check', '2020-07-24 14:59:37', 42, NULL),
(30, 'Riyansh Shah', 'check', '2020-08-03 03:28:14', 43, NULL),
(30, 'Riyansh Shah', '1st', '2020-08-23 13:41:46', 44, NULL),
(30, 'Riyansh Shah', '2nd', '2020-08-23 13:59:45', 45, NULL),
(30, 'Riyansh Shah', '3rd', '2020-08-23 13:59:59', 46, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `post_id` int(11) NOT NULL,
  `design_images` varchar(255) DEFAULT NULL,
  `design_title` varchar(128) DEFAULT NULL,
  `design_description` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `is_final` tinyint(1) NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`post_id`, `design_images`, `design_title`, `design_description`, `comments`, `room_id`, `project_id`, `is_final`, `post_time`) VALUES
(6, 'IMG_20190227_212750.jpg', 'ghgfg', 'hfghfghgfh', NULL, 30, 1, 0, '2020-08-09 13:08:05'),
(7, 'IMG_20190227_212908.jpg', 'gjgfgsdfh', 'yjgdyjgejgjwgef', NULL, 30, 1, 1, '2020-08-09 13:08:05'),
(8, 'ER DIAGRAM.png', 'fytftyfytf', 'gdxfgxcgfchg', NULL, 34, 5, 0, '2020-08-09 13:08:05'),
(13, 'IMG_20190227_211312.jpg', 'qwwe', 'wqewe', NULL, 30, 1, 0, '2020-08-09 13:08:05'),
(19, 'Annotation 2020-08-12 161012.png', 'lorem', 'qwertyuiop;lkjhgfds', NULL, 31, 1, 0, '2020-08-16 06:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `designs_comments`
--

CREATE TABLE `designs_comments` (
  `post_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `comment_sender_name` varchar(128) NOT NULL,
  `comment` varchar(150) NOT NULL,
  `comment_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dimensions`
--

CREATE TABLE `dimensions` (
  `room_id` int(11) DEFAULT NULL,
  `dimensions_images` varchar(255) DEFAULT NULL,
  `dimension_title` varchar(255) DEFAULT NULL,
  `dimension_description` text DEFAULT NULL,
  `dimension_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dimensions`
--

INSERT INTO `dimensions` (`room_id`, `dimensions_images`, `dimension_title`, `dimension_description`, `dimension_id`) VALUES
(34, 'FINAL ER DIAGRAM.png', 'vghvjhv', 'jyjhybhjbj', 3),
(30, 'Annotation 2020-08-09 205918.png', 'ihiuihuh', 'sdzfghmj,k,hmjghfg', 23);

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `project_id` int(11) DEFAULT NULL,
  `forum_messages` text DEFAULT NULL,
  `forum_images` varchar(255) DEFAULT NULL,
  `forum_chat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `admin_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`admin_id`, `username`, `pass`, `admin_name`) VALUES
(1, 'riyansh', '1234', 'Riyansh Shah');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `project_id` int(11) DEFAULT NULL,
  `member_name` varchar(128) NOT NULL,
  `member_maiL` varchar(128) NOT NULL,
  `contact` int(11) DEFAULT NULL,
  `member_id` int(11) NOT NULL,
  `member_pass` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`project_id`, `member_name`, `member_maiL`, `contact`, `member_id`, `member_pass`) VALUES
(1, 'Darshan Mahajan', 'xyz@gmail.com', 35454564, 1, '1234'),
(2, 'sdss', 'qws@gmail.com', 567576657, 2, '1234'),
(1, 'werwr', 'abc@gmail.com', 54646456, 15, '5892'),
(3, 'kjsfjsf', 'lkkglkr@gmail.com', 897987, 16, '7085'),
(5, 'rreg', 'erggr@gmail.com', 567575675, 17, '6832');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `admin_id` int(11) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `startdate` varchar(255) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `delete_project` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`admin_id`, `project_name`, `location`, `startdate`, `project_id`, `delete_project`) VALUES
(1, 'Rodas Enclave', 'Thane', '2020-06-15', 1, 0),
(1, 'Pentahouse', 'Hiranandani Estate', '2020-06-17', 2, 0),
(1, 'pearls', 'bandra', '2020-06-11', 3, 1),
(1, 'wewdd', 'jhgjh', '2020-06-04', 4, 0),
(1, 'dfxfdxfd', 'dsfsfsd', '2020-07-09', 5, 0),
(1, 'hfghfhf', 'ggfggfg', '2020-07-10', 10, 0),
(1, 'abc', 'fdgs', '2020-07-09', 11, 0),
(1, 'last', 'last', '2020-08-24', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_name` varchar(128) NOT NULL,
  `room_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_name`, `room_id`, `project_id`) VALUES
('reger', 5, 2),
('iuyi', 7, 2),
('uhu', 8, 3),
('jgjhg', 9, 3),
('sdfsd', 10, 4),
('Rohits room', 30, 1),
('khbdkdsf', 31, 1),
('dsfds', 32, 3),
('kbkjbkjkkj', 34, 5),
('kiojoijoi', 35, 5),
('abxc', 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `technical_drawings`
--

CREATE TABLE `technical_drawings` (
  `img_id` int(11) NOT NULL,
  `technical_images` varchar(255) DEFAULT NULL,
  `technical_title` varchar(128) DEFAULT NULL,
  `technical_description` text DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `technical_drawings`
--

INSERT INTO `technical_drawings` (`img_id`, `technical_images`, `technical_title`, `technical_description`, `project_id`) VALUES
(9, 'Annotation 2020-07-18 130055.png', 'lorem', 'qwertyujhgbvcxzx', 1),
(12, 'Assignment 4 solved.pdf', 'asdfghj', 'ASDFGH', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatroom`
--
ALTER TABLE `chatroom`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `designs_comments`
--
ALTER TABLE `designs_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `dimensions`
--
ALTER TABLE `dimensions`
  ADD PRIMARY KEY (`dimension_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`forum_chat_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `technical_drawings`
--
ALTER TABLE `technical_drawings`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `project_id` (`project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatroom`
--
ALTER TABLE `chatroom`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `designs_comments`
--
ALTER TABLE `designs_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `dimensions`
--
ALTER TABLE `dimensions`
  MODIFY `dimension_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `forum_chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `technical_drawings`
--
ALTER TABLE `technical_drawings`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chatroom`
--
ALTER TABLE `chatroom`
  ADD CONSTRAINT `chatroom_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `chatroom_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `designs`
--
ALTER TABLE `designs`
  ADD CONSTRAINT `designs_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `designs_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `designs_comments`
--
ALTER TABLE `designs_comments`
  ADD CONSTRAINT `designs_comments_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `designs_comments_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `designs` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `dimensions`
--
ALTER TABLE `dimensions`
  ADD CONSTRAINT `dimensions_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `login` (`admin_id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `technical_drawings`
--
ALTER TABLE `technical_drawings`
  ADD CONSTRAINT `technical_drawings_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
