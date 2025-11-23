-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2023 at 06:24 AM
-- Server version: 5.6.20
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spamenu`
--

-- --------------------------------------------------------

--
-- Table structure for table `ref_sijil_universiti`
--

CREATE TABLE `ref_sijil_universiti` (
  `sijil_kod` varchar(4) NOT NULL,
  `sijil_nama` varchar(32) NOT NULL,
  `sijil_YT` varchar(2) NOT NULL,
  `sijil_susun` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ref_sijil_universiti`
--

INSERT INTO `ref_sijil_universiti` (`sijil_kod`, `sijil_nama`, `sijil_YT`, `sijil_susun`) VALUES
('DBP', 'Diploma Bukan Pendidikan', 'Y', 2),
('DP', 'Diploma Pendidikan', 'Y', 1),
('IBP', 'Ijazah Bukan Pendidikan', 'Y', 4),
('IP', 'Ijazah Pendidikan', 'Y', 3),
('MBP', 'Master Bukan Pendidikan', 'Y', 6),
('MPU', 'Master Pendidikan (UTHM sahaja)', 'Y', 5),
('PHD', 'PHD Bukan Pendidikan', 'Y', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ref_sijil_universiti`
--
ALTER TABLE `ref_sijil_universiti`
  ADD PRIMARY KEY (`sijil_kod`,`sijil_nama`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
