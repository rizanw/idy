-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2019 at 10:45 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idy`
--

-- --------------------------------------------------------

--
-- Table structure for table `ideas`
--

CREATE TABLE `ideas` (
  `id` varchar(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_email` varchar(255) NOT NULL,
  `votes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ideas`
--

INSERT INTO `ideas` (`id`, `title`, `description`, `author_name`, `author_email`, `votes`) VALUES
('a2e4ab73-14db-43e4-a249-d943c87fc3ce', 'All creatives are created equal', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor i', 'Rizky Andre', 'rzkandre@email.com', 4),
('48540943-7069-4151-a082-e445baa04a07', 'Discourage sleep', 'In some ways Mr. Heyer and Mr. Rockwell\'s biggest idea is to transform hotels into big bars and meeting spaces that just happen to also have bedrooms. \"We have to give [guests] a reason to use their time in other ways. The last option is sleep,\" Mr. Heyer', 'Rizky Andre W', 'rzkandre@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `idea_id` varchar(36) NOT NULL,
  `user` varchar(255) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`idea_id`, `user`, `value`) VALUES
('a2e4ab73-14db-43e4-a249-d943c87fc3ce', 'andre', 4),
('a2e4ab73-14db-43e4-a249-d943c87fc3ce', 'enzo', 5),
('a2e4ab73-14db-43e4-a249-d943c87fc3ce', 'iko', 3),
('48540943-7069-4151-a082-e445baa04a07', 'Administrator', 4),
('48540943-7069-4151-a082-e445baa04a07', 'enzo', 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
