-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 10:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `citywatch`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(8) NOT NULL,
  `post_id` int(8) NOT NULL,
  `text` varchar(255) NOT NULL,
  `user_id` int(8) NOT NULL,
  `rating` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `text`, `user_id`, `rating`) VALUES
(39, 23, 'We are currently looking into this issue, thanks for the heads up!', 34, 1),
(40, 24, 'The trash was successfully collected yesterday by a team of volunteers! Thanks you for reporting!', 34, 3);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `username`, `email`, `message`) VALUES
(5, 'user', 'email@email', 'hello myadmin');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(8) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int(8) NOT NULL,
  `rating` int(10) NOT NULL DEFAULT 0,
  `status` varchar(150) NOT NULL DEFAULT 'Pending',
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `image`, `title`, `description`, `user_id`, `rating`, `status`, `date`) VALUES
(23, 'images/uploads/657b5659a01ca5.24995878.jpeg', 'Damaged Pavement - Impian 5 Park', 'The payment is being uprooted near the playground', 34, 3, 'Resolving', '2023-12-15 03:24:09'),
(24, 'images/uploads/657b571fabea70.41696706.jpeg', 'Polluted lake nearby Setia Prima/Impian 2', 'Trash is piling up near the west side of the lake.', 34, 7, 'Resolved', '2023-12-15 03:27:27'),
(27, 'images/uploads/657b74ddd82884.04645972.jpg', 'Pothole after flood', 'The recent flood around Setia Prima has caused several potholes to appear', 34, 0, 'Pending', '2023-12-15 05:34:21'),
(28, 'images/uploads/657b761e345969.62215484.jpeg', 'Clogged drains near Sri Melur', 'Drains clogged from the car wash due to inadequate drainage', 34, 0, 'Pending', '2023-12-15 05:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(8) NOT NULL,
  `username` varchar(150) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `isAdmin`) VALUES
(0, '[deleted user]', '[deleted user]', '[deleted user]', 'deleted@deleted', '[deleted user]', 0),
(26, 'seanT', 'Sean', 'Tan', 'seantan.gax@gmail.com', '$2y$10$azKQXvbebwHN511jUwim3uNMdIaVirAwDcAH1w8wBJ445rQMQQWyW', 0),
(34, 'administrator', 'Admin', 'admin', 'admin@email.com', '$2y$10$DrZ2YWrBucOZ2WSyxiSe4OGLG.dYFVUmgAgF2rW1LPt.6hAKhTm9.', 1),
(36, 'kaviV23', 'Kavi', 'V', 'kavi.vijayanthiran@gmail.com', '$2y$10$8W4rFAlFP3Nm7hX0/CaV3.nm8xEVAPteam2WrGWG/rUb3WpiWlVbW', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
