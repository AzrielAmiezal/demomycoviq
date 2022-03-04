-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2022 at 08:28 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mycoviq`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_username` varchar(30) NOT NULL,
  `admin_telNo` int(20) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_profileImg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_username`, `admin_telNo`, `admin_email`, `admin_password`, `admin_profileImg`) VALUES
(1, 'Admin', 'Admin', 1234567891, 'admin@email,com', '$2y$10$SyamR8w/lbegL7BjPZxtAeHEkjFDzA0P/MFdFGisckpowPJTeKDc.', 'sfsdfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `deklarasi_harian`
--

CREATE TABLE `deklarasi_harian` (
  `days_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `covidStage` varchar(255) NOT NULL,
  `tarikh_mula` date NOT NULL,
  `tarikh_tamat` date NOT NULL,
  `status_kuarantin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `health_status`
--

CREATE TABLE `health_status` (
  `healthStatus_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `spo2_id` int(11) NOT NULL,
  `temperature_id` int(11) NOT NULL,
  `sakit_tekak` varchar(20) NOT NULL,
  `selesema` varchar(20) NOT NULL,
  `batuk` varchar(20) NOT NULL,
  `demam` varchar(20) NOT NULL,
  `loya_muntah` varchar(20) NOT NULL,
  `kesukaran_bernafas` varchar(20) NOT NULL,
  `deria_rasa` varchar(20) NOT NULL,
  `deria_bau` varchar(20) NOT NULL,
  `tarikh_kemaskini` date NOT NULL,
  `hari_kemaskini` varchar(255) NOT NULL,
  `masa_kemaskini` time NOT NULL,
  `sesi_No` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `google_id` varchar(255) NOT NULL,
  `patientName` varchar(100) NOT NULL,
  `patient_icNo` varchar(255) NOT NULL,
  `patient_address` varchar(255) NOT NULL,
  `patient_telNo` int(20) NOT NULL,
  `patientEmail` varchar(100) NOT NULL,
  `patientPassword` varchar(100) NOT NULL,
  `verification_code` varchar(255) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `patient_profileImg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `google_id`, `patientName`, `patient_icNo`, `patient_address`, `patient_telNo`, `patientEmail`, `patientPassword`, `verification_code`, `is_verified`, `patient_profileImg`) VALUES
(1, '114855044859333761379', 'Azriel Amiezal Bin Azwary_', '991006145201', 'Jalan Bunga Raya 2', 176154374, 'kl2007006808@student.kuptm.edu.my', '', '0', 1, '6214ee367aa81.jpg'),
(2, '111534507314374444382', 'Nur Aziera Farieza Binti Azwary', '690902025553', 'Jalan Sungai Tua', 142635427, 'azierafarieza65@gmail.com', '', '0', 1, '62151ec74fc93.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sesi_kemaskini_kesihatan`
--

CREATE TABLE `sesi_kemaskini_kesihatan` (
  `sesi_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `sesi_No` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `spo2`
--

CREATE TABLE `spo2` (
  `spo2_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `spo2_level` int(11) NOT NULL,
  `tarikh_kemaskini` date NOT NULL,
  `masa_kemaskini` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `temperature`
--

CREATE TABLE `temperature` (
  `temperature_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `temperature_level` float NOT NULL,
  `tarikh_kemaskini` date NOT NULL,
  `masa_kemaskini` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `deklarasi_harian`
--
ALTER TABLE `deklarasi_harian`
  ADD PRIMARY KEY (`days_id`);

--
-- Indexes for table `health_status`
--
ALTER TABLE `health_status`
  ADD PRIMARY KEY (`healthStatus_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `sesi_kemaskini_kesihatan`
--
ALTER TABLE `sesi_kemaskini_kesihatan`
  ADD PRIMARY KEY (`sesi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deklarasi_harian`
--
ALTER TABLE `deklarasi_harian`
  MODIFY `days_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `health_status`
--
ALTER TABLE `health_status`
  MODIFY `healthStatus_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sesi_kemaskini_kesihatan`
--
ALTER TABLE `sesi_kemaskini_kesihatan`
  MODIFY `sesi_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
