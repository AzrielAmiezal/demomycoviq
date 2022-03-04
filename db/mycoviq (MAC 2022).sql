-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2022 at 05:02 AM
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
(1, 'Admin', 'admin', 123456789, 'admin@email.com', '$2y$10$xxlOCq9gtzATCiOltbyW7uJMHcrmS.Dw8IioWt4q7AhftSJj0IEHq', 'admin');

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

--
-- Dumping data for table `deklarasi_harian`
--

INSERT INTO `deklarasi_harian` (`days_id`, `patient_id`, `covidStage`, `tarikh_mula`, `tarikh_tamat`, `status_kuarantin`) VALUES
(1, 1, '2 - Bergejala ringan, tiada radang paru-paru', '2022-03-03', '2022-03-09', 'Sedang dalam pemantauan');

-- --------------------------------------------------------

--
-- Table structure for table `health_status`
--

CREATE TABLE `health_status` (
  `healthStatus_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `spo2_id` int(11) NOT NULL,
  `temperature_id` int(11) NOT NULL,
  `sesi_id` int(11) NOT NULL,
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
  `submission_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `health_status`
--

INSERT INTO `health_status` (`healthStatus_id`, `patient_id`, `spo2_id`, `temperature_id`, `sesi_id`, `sakit_tekak`, `selesema`, `batuk`, `demam`, `loya_muntah`, `kesukaran_bernafas`, `deria_rasa`, `deria_bau`, `tarikh_kemaskini`, `hari_kemaskini`, `masa_kemaskini`, `submission_status`) VALUES
(1, 1, 1, 1, 1, 'Ada', 'Ada', 'Tiada', 'Tiada', 'Tiada', 'Ada', 'Ada', 'Ada', '2022-03-03', 'Thu', '11:03:29', 1),
(2, 1, 2, 2, 2, 'Ada', 'Tiada', 'Tiada', 'Tiada', 'Tiada', 'Tiada', 'Tiada', 'Ada', '2022-03-03', 'Thu', '11:04:05', 1),
(3, 1, 3, 3, 3, 'Ada', 'Tiada', 'Tiada', 'Tiada', 'Ada', 'Tiada', 'Ada', 'Ada', '2022-03-04', 'Fri', '11:04:53', 1),
(4, 1, 4, 4, 4, 'Ada', 'Ada', 'Tiada', 'Tiada', 'Tiada', 'Tiada', 'Ada', 'Ada', '2022-03-04', 'Fri', '11:37:07', 1),
(5, 1, 5, 5, 5, 'Tiada', 'Ada', 'Ada', 'Tiada', 'Ada', 'Tiada', 'Ada', 'Ada', '2022-03-05', 'Sat', '11:39:21', 1),
(6, 1, 6, 6, 6, 'Tiada', 'Ada', 'Ada', 'Ada', 'Ada', 'Tiada', 'Ada', 'Ada', '2022-03-05', 'Sat', '11:40:02', 1);

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
(1, '114855044859333761379', 'Azriel Amiezal Bin Azwary_', '991006145201', 'Jalan Api 2', 176154374, 'kl2007006808@student.kuptm.edu.my', '', '0', 1, 'https://lh3.googleusercontent.com/a/AATXAJxN0uKVVhMaHNHPHCeMbNNy9bI4MJvBJry1eY5s=s96-c');

-- --------------------------------------------------------

--
-- Table structure for table `sesi_kemaskini_kesihatan`
--

CREATE TABLE `sesi_kemaskini_kesihatan` (
  `sesi_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `sesi_No` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sesi_kemaskini_kesihatan`
--

INSERT INTO `sesi_kemaskini_kesihatan` (`sesi_id`, `patient_id`, `sesi_No`) VALUES
(1, 1, '1'),
(2, 1, '2'),
(3, 1, '1'),
(4, 1, '2'),
(5, 1, '1'),
(6, 1, '2');

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

--
-- Dumping data for table `spo2`
--

INSERT INTO `spo2` (`spo2_id`, `patient_id`, `spo2_level`, `tarikh_kemaskini`, `masa_kemaskini`) VALUES
(1, 1, 90, '2022-03-03', '11:03:29'),
(2, 1, 90, '2022-03-03', '11:04:05'),
(3, 1, 90, '2022-03-04', '11:04:53'),
(4, 1, 90, '2022-03-04', '11:37:07'),
(5, 1, 96, '2022-03-05', '11:39:21'),
(6, 1, 90, '2022-03-05', '11:40:02');

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
-- Dumping data for table `temperature`
--

INSERT INTO `temperature` (`temperature_id`, `patient_id`, `temperature_level`, `tarikh_kemaskini`, `masa_kemaskini`) VALUES
(1, 1, 20, '2022-03-03', '11:03:29'),
(2, 1, 29, '2022-03-03', '11:04:05'),
(3, 1, 29, '2022-03-04', '11:04:53'),
(4, 1, 28, '2022-03-04', '11:37:07'),
(5, 1, 32, '2022-03-05', '11:39:21'),
(6, 1, 30, '2022-03-05', '11:40:02');

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
  MODIFY `days_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `health_status`
--
ALTER TABLE `health_status`
  MODIFY `healthStatus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sesi_kemaskini_kesihatan`
--
ALTER TABLE `sesi_kemaskini_kesihatan`
  MODIFY `sesi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
