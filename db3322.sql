-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mydb:3306
-- Generation Time: Apr 03, 2024 at 02:31 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db3322`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` smallint NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `email`, `password`) VALUES
(1, '12334a3@connect.hku.hk', '$2y$10$1B9JlscocUlohXOWtlVC1.vxXsMaHkyqPp.ERUlG5P07AUrtfRbt6'),
(4, '33333@connect.hku.hk', '$2y$10$lPHK1PGwmocNqpnTv5mTvOfBgPGfcT4ff5ju2/6Njs/VjRoGSuARG'),
(5, 'peter@connect.hku.hk', '$2y$10$1Br7bdP/Zp6h/p9177sE3O.j1CUL4.LoFoPmVHx9eKE9r3rLs9Acq');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msgid` int NOT NULL,
  `time` bigint NOT NULL,
  `message` varchar(250) NOT NULL,
  `person` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msgid`, `time`, `message`, `person`) VALUES
(92, 1712110852, 'Hello', 'peter'),
(93, 1712110852, 'How are you', '12334a3'),
(94, 1712110862, 'Yo', '3036085654'),
(95, 1712110870, 'Nice to meet you all', '12334a3'),
(96, 1712110871, '55', '12334a3'),
(97, 1712110872, '5', '12334a3'),
(98, 1712110872, '5', '12334a3'),
(99, 1712110872, '5', '12334a3'),
(100, 1712110986, 'hey', '12334a3'),
(101, 1712110991, 'hey', '12334a3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msgid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msgid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
