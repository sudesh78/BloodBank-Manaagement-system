-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2021 at 06:25 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_donate`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` char(7) NOT NULL,
  `photo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `username`, `password`, `type`, `photo`) VALUES
(1, 'Ankit', '', 'admin', 'admin123', 'Admin', 'images/81bde0fe-d779-4877-8500-8670e9ad2849.jpg'),
(6, 'Govind', 'rfdrtds134@gmail.com', 'pankaj', '12', 'Staff', 'images/fca8f688-86b1-4806-a16b-77af623d5dca.png');

-- --------------------------------------------------------

--
-- Table structure for table `bloodbank`
--

CREATE TABLE `bloodbank` (
  `id` int(11) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `volume` int(11) NOT NULL DEFAULT 0 COMMENT 'mL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bloodbank`
--

INSERT INTO `bloodbank` (`id`, `blood_group`, `volume`) VALUES
(1, 'A+', 213),
(2, 'A-', 0),
(3, 'B+', 0),
(4, 'B-', 0),
(5, 'O+', 0),
(6, 'O-', 0),
(7, 'AB+', 0),
(8, 'AB-', 541);

-- --------------------------------------------------------

--
-- Table structure for table `blood_inventory`
--

CREATE TABLE `blood_inventory` (
  `id` int(11) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `volume` float NOT NULL,
  `d_id` int(20) NOT NULL,
  `f_Name` char(20) NOT NULL,
  `l_Name` char(20) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1,
  `request_id` int(11) DEFAULT NULL,
  `date_created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blood_inventory`
--

INSERT INTO `blood_inventory` (`id`, `blood_group`, `volume`, `d_id`, `f_Name`, `l_Name`, `status`, `request_id`, `date_created`) VALUES
(2, 'AB-', 541, 2, '', '', 1, NULL, '2021-04-13'),
(4, 'A+', 213, 17, '', '', 1, NULL, '2021-01-04');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `d_id` int(20) NOT NULL,
  `f_Name` char(20) DEFAULT NULL,
  `l_Name` char(20) DEFAULT NULL,
  `father_name` char(25) DEFAULT NULL,
  `gender` char(8) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `b_group` varchar(10) DEFAULT NULL,
  `weight` int(5) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `street` varchar(15) DEFAULT NULL,
  `area` varchar(20) DEFAULT NULL,
  `city` char(20) DEFAULT NULL,
  `state` char(15) DEFAULT NULL,
  `pincode` int(8) DEFAULT NULL,
  `country` char(20) DEFAULT NULL,
  `Contact1` varchar(15) DEFAULT NULL,
  `Contact2` varchar(15) DEFAULT NULL,
  `photo` longblob DEFAULT NULL,
  `last_d_date` date DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`d_id`, `f_Name`, `l_Name`, `father_name`, `gender`, `dob`, `b_group`, `weight`, `email`, `street`, `area`, `city`, `state`, `pincode`, `country`, `Contact1`, `Contact2`, `photo`, `last_d_date`, `status`) VALUES
(2, 'Pankaj', 'Kumar', 'Ajit', 'Male', '2000-12-04', 'AB-', 60, 'tjdrtgrs123@gmail.com', '41 Arvind', 'Gandhi Nagar', 'Ambala', 'haryana', 133001, 'india', '5122441241123', '1231231231313', 0x646f6e6f72737069632f66636138663638382d383662312d343830362d613136622d3737616636323364356463612e706e67, '1970-01-01', 0),
(17, 'Ankit', 'Khana', 'Ajit', 'Male', '2021-04-21', 'A+', 67, 'Ashik123@gmail.com', '12', 'Rohai', 'Ambala', 'haryana', 133001, 'india', '123123', '', 0x646f6e6f72737069632f38316264653066652d643737392d343837372d383530302d3836373065396164323834392e6a7067, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `handedover_request`
--

CREATE TABLE `handedover_request` (
  `id` int(30) NOT NULL,
  `request_id` int(30) NOT NULL,
  `picked_up_by` varchar(17) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `handedover_request`
--

INSERT INTO `handedover_request` (`id`, `request_id`, `picked_up_by`, `date_created`) VALUES
(1, 2, 'Akir', '2021-04-11 14:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `r_id` int(30) NOT NULL,
  `name` char(30) NOT NULL,
  `gender` char(12) NOT NULL,
  `blood` varchar(13) NOT NULL,
  `bunit` int(10) NOT NULL,
  `hosp` varchar(100) NOT NULL,
  `city` char(20) NOT NULL,
  `pincode` int(10) NOT NULL,
  `doc_name` char(20) NOT NULL,
  `rdate` date NOT NULL,
  `c_name` char(30) NOT NULL,
  `c_address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` int(15) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `pic` longblob DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `ref_code` varchar(20) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `cdate` date DEFAULT NULL,
  `d_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`r_id`, `name`, `gender`, `blood`, `bunit`, `hosp`, `city`, `pincode`, `doc_name`, `rdate`, `c_name`, `c_address`, `email`, `contact`, `reason`, `pic`, `status`, `ref_code`, `date_created`, `cdate`, `d_id`) VALUES
(1, 'dsas', 'Female', 'AB+', 634, 'asda adsa', 'ambala', 133001, 'adas', '2021-03-24', 'asdad', 'aadsd', 'addasdads123asda@gmail.com', 1323, 'adsd', 0x726571756573746f722f56616973686e61762d54656a2d506963732d322e6a706567, 1, 'Zfpshiky', '2021-03-26 21:50:51', NULL, NULL),
(2, 'Rohiuni', 'Male', 'AB+', 12, 'asdads haryana', 'ambala', 133006, 'Arvind', '2002-04-10', 'asd', 'adsad', 'addasdads21312123asda@gmail.com', 12321, 'asda', 0x726571756573746f722f4453435f303436335f312e4a5047, 2, 'NsYh3c5M', '2021-04-10 17:30:45', NULL, NULL),
(3, 'sad', 'Male', 'AB+', 1243, 'adsasd', 'asd', 133001, 'asd', '2021-04-10', 'adsas', 'asda', 'asnkit21@gmail.com', 21312, 'sada', 0x726571756573746f722f56616973686e61762d54656a2d506963732d322e6a706567, 2, 'XdsVYGKB', '2021-04-10 19:24:06', NULL, NULL),
(5, 'asda', 'Female', 'O-', 213, 'zdcsd', 'adsad', 1231, 'asda', '2020-04-21', 'adsd', 'adsads', 'addasdads123asda@gmail.com', 313123, 'as', 0x726571756573746f722f4453435f303538375f312e4a5047, 0, 'QUnIr1yM', '2021-04-10 19:37:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `uploading`
--

CREATE TABLE `uploading` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `uploading`
--

INSERT INTO `uploading` (`id`, `name`, `email`, `file_name`) VALUES
(1, 'sdaa', 'asdasdasdads@gmail.com', 'uploads/833656122.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bloodbank`
--
ALTER TABLE `bloodbank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`d_id`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `handedover_request`
--
ALTER TABLE `handedover_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `uploading`
--
ALTER TABLE `uploading`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bloodbank`
--
ALTER TABLE `bloodbank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `d_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `handedover_request`
--
ALTER TABLE `handedover_request`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `r_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uploading`
--
ALTER TABLE `uploading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  ADD CONSTRAINT `Foreign` FOREIGN KEY (`d_id`) REFERENCES `donors` (`d_id`) ON DELETE CASCADE;

--
-- Constraints for table `handedover_request`
--
ALTER TABLE `handedover_request`
  ADD CONSTRAINT `handedover_request_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `request` (`r_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
