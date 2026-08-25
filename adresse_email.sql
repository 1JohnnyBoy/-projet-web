-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql-sleazyjohan.alwaysdata.net
-- Generation Time: Aug 25, 2026 at 02:27 PM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sleazyjohan_smartphones`
--

-- --------------------------------------------------------

--
-- Table structure for table `adresse_email`
--

CREATE TABLE `adresse_email` (
  `Id` int(11) NOT NULL COMMENT 'Auto-incrément',
  `Username` varchar(128) NOT NULL,
  `Mail` varchar(128) NOT NULL,
  `MDP` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adresse_email`
--

INSERT INTO `adresse_email` (`Id`, `Username`, `Mail`, `MDP`, `is_admin`) VALUES
(4, 'youngboi', 'babiere@gmail.com', '$2y$10$4ywSvBBZJ6fduCqMHHO4t.XYkbCZuL75ZTaV.gyk0ev5vVpk1fzYK', NULL),
(5, 'youngboi2', 'ebordanyongo@gmail.com', '$2y$10$xaeGSCpnBam8vYU8SyYmxe2RCRbWQElhaDGkG0IJVzJiasBioZVXC', NULL),
(6, 'john', 'johankamgang44@gmail.com', '$2y$10$AsPMZsU7ke8zpVOd3XqjteQJu7Uejwm1nJ2FGZS6Wdayb9nA.9Vjm', NULL),
(7, 'sleazyjohan', 'carolnguemeni@gmail.com', '$2y$12$apQI/fENiVUBGsZ9NQ8yCui1VgVPZAYj4BPmWTdzeiobPhLtGC0iu', 1),
(8, 'youngboi', 'jj@gmail.com', '$2y$12$yzkyu.1YFFMzgP1FCCFeyOmzP3z3ckq.amOtq/gusbwf.M6GS07pS', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adresse_email`
--
ALTER TABLE `adresse_email`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresse_email`
--
ALTER TABLE `adresse_email`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto-incrément', AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
