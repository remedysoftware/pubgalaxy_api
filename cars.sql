-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 09, 2021 at 05:45 PM
-- Server version: 10.3.22-MariaDB-log
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
-- Database: `santuco_pubgalaxy`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `manufacturer` varchar(150) NOT NULL,
  `model` varchar(100) NOT NULL,
  `model_year` smallint(10) NOT NULL,
  `engine` tinyint(10) NOT NULL,
  `fuel_type` int(5) NOT NULL,
  `hybrid` tinyint(1) NOT NULL,
  `four_by_four` tinyint(1) NOT NULL,
  `auto_gearbox` tinyint(1) NOT NULL,
  `deleted` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `manufacturer`, `model`, `model_year`, `engine`, `fuel_type`, `hybrid`, `four_by_four`, `auto_gearbox`, `deleted`) VALUES
(2, 'BMW', 'x6', 2010, 127, 2, 0, 0, 0, 0),
(3, 'Mercedess', 'S Class', 2015, 127, 1, 0, 1, 1, 0),
(4, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(5, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(6, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(7, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(8, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(9, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(10, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(11, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(12, '12', '12', 12, 12, 12, 12, 12, 12, 0),
(13, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(14, 'Mercedess', 'S class', 2020, 127, 1, 1, 1, 1, 0),
(15, 'Mercedess11111', 'S class', 2020, 127, 1, 1, 1, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
