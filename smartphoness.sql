-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql-sleazyjohan.alwaysdata.net
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
-- Table structure for table `le_c`
--

CREATE TABLE `le_c` (
  `Id` int(11) NOT NULL,
  `Marque` text NOT NULL,
  `modèle` varchar(128) NOT NULL,
  `couleur` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stockage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `le_c`
--

INSERT INTO `le_c` (`Id`, `Marque`, `modèle`, `couleur`, `photo`, `prix`, `stockage`) VALUES
(1, 'Iphone', '16 Simple', 'Noir', 'iPhone 16 noir.jpg', 1500.00, 512),
(2, 'Iphone', '17 Pro Max', 'Orange', 'iphone 17 pro max.webp', 1750.00, 512),
(3, 'Samsung', 'S26', 'Noir', 'S26 noir.jpg', 1199.00, 256),
(4, 'Samsung', 'Flip 7', 'Corail', 'flip 7.jpg', 1319.00, 256),
(5, 'Google Pixel', '10 Pro', 'Blanc', 'pixel 10 pro.jpg', 849.00, 128),
(6, 'Huawei', 'Pura 80 Pro', 'Rouge', 'p80 pro.png', 899.00, 256),
(7, 'Huawei', 'Pura 50 Pro', 'Or', 'P50 Pro Gold.jpg', 519.00, 128),
(8, 'Huawei', 'Mate X7', 'Rouge nébuleux', 'Mate X7.png', 1849.00, 512),
(9, 'Xiaomi', '17 Ultra', 'Starlit Green', 'Xiaomi 17 Ultra.webp', 1499.00, 512),
(10, 'Google Pixel', '9 Pro XL', 'Rose', 'pink 9 pro pixel.jpg', 808.00, 128),
(11, 'Iphone', 'Air', 'Bleu Ciel', 'Air Bleu-ciel.jpg', 1229.00, 256),
(12, 'Samsung', 'Fold 6', 'Silver Shadow', 'Fold 6 Silver Shadow.png', 1949.00, 512),
(13, 'Xiaomi', '17', 'Ice Blue', 'Ice Blue.webp', 999.00, 256);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `le_c`
--
ALTER TABLE `le_c`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `le_c`
--
ALTER TABLE `le_c`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
