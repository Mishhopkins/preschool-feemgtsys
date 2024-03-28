-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2024 at 04:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolfeesys`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(15) NOT NULL,
  `level` int(15) NOT NULL,
  `type` varchar(15) NOT NULL,
  `class_name` varchar(15) NOT NULL,
  `delete_status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `level`, `type`, `class_name`, `delete_status`) VALUES
(6, 1, 'Pre-Primary', 'Pre-Primary.1', '0'),
(7, 2, 'Pre-Primary', 'Pre-Primary.2', '0'),
(8, 0, 'Day Care', 'Day Care.0', '0'),
(9, 0, 'PlayGroup', 'PlayGroup.0', '0'),
(10, 1, 'Grade', 'Grade.1', '0'),
(11, 1, 'Grade', 'Grade.1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `transport` varchar(255) NOT NULL,
  `admission` varchar(255) NOT NULL,
  `academic` varchar(255) NOT NULL,
  `lunch_fee` varchar(255) NOT NULL,
  `boarding_fee` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `class_id`, `session_id`, `transport`, `admission`, `academic`, `lunch_fee`, `boarding_fee`) VALUES
(7, 10, 2, '', '2000', '4000', '1000', '6000');

-- --------------------------------------------------------

--
-- Table structure for table `fees_transaction`
--

CREATE TABLE `fees_transaction` (
  `id` int(255) NOT NULL,
  `stdid` varchar(255) NOT NULL,
  `paid` int(255) NOT NULL,
  `submitdate` datetime NOT NULL,
  `transcation_remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `fees_transaction`
--

INSERT INTO `fees_transaction` (`id`, `stdid`, `paid`, `submitdate`, `transcation_remark`) VALUES
(6, '5', 1500, '2018-06-02 00:00:00', 'DEMO'),
(11, '10', 2500, '2021-01-14 00:00:00', 'advance payment received'),
(12, '11', 2100, '2021-03-26 00:00:00', 'Advance payment done!'),
(13, '12', 3000, '2019-10-11 00:00:00', 'advance received'),
(14, '13', 1000, '2021-04-01 00:00:00', 'advance received'),
(15, '14', 2500, '2021-04-01 00:00:00', 'advance fee received first of month'),
(16, '15', 2100, '2018-04-01 00:00:00', 'advance fee received march'),
(17, '16', 2900, '2019-04-06 00:00:00', 'received during enrollment'),
(18, '17', 3500, '2021-04-18 00:00:00', 'received on apr 18'),
(19, '18', 500, '2021-01-03 00:00:00', 'none'),
(20, '19', 4900, '2015-02-20 00:00:00', 'none'),
(21, '20', 0, '2021-04-01 00:00:00', 'none'),
(22, '21', 2000, '2021-04-04 00:00:00', 'none'),
(23, '22', 0, '2021-02-21 00:00:00', 'none'),
(24, '23', 5000, '2021-04-04 00:00:00', 'none'),
(25, '24', 3900, '2021-03-29 00:00:00', 'advance payment received on march'),
(26, '24', 3100, '2021-04-21 00:00:00', 'fees cleared up!'),
(27, '22', 4900, '2021-04-23 00:00:00', 'all clear'),
(28, '24', 900, '2021-04-23 00:00:00', 'cleared up remainings');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `id` int(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `grade`, `detail`, `delete_status`) VALUES
(1, '1st Grade', 'This is a demo text', '0'),
(2, '2nd Grade', 'This is a demo text', '0'),
(3, '3rd Grade', 'This is a demo text', '0'),
(4, '4th Grade', 'This is a demo text', '0'),
(5, '5th Grade', 'This is a demo text', '0'),
(6, '6th Grade', 'This is a demo text', '0'),
(7, '7th Grade', 'This is a demo text', '0'),
(8, '8th Grade', 'This is a demo text', '0'),
(9, 'Freshman/9th Grade', 'This is a demo text', '0'),
(10, 'Sophomore/10th Grade', 'This is a demo text', '0'),
(11, 'Junior/11th Grade', 'This is a demo text', '0'),
(12, 'Senior/12th Grade', 'This is a demo text', '0');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `term` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `term`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(2, 'term1', '2024-01-01', '2024-03-31', '2024-01-26 04:18:53', '2024-01-26 04:18:53'),
(3, 'term2', '2024-05-05', '2024-08-30', '2024-01-29 09:43:48', '2024-01-29 09:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(255) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `joindate` datetime NOT NULL,
  `about` text NOT NULL,
  `contact` varchar(255) NOT NULL,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0',
  `class` int(11) DEFAULT NULL,
  `session` int(11) DEFAULT NULL,
  `pname` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `pcontact` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `sname`, `joindate`, `about`, `contact`, `delete_status`, `class`, `session`, `pname`, `location`, `pcontact`, `created_at`, `updated_at`) VALUES
(25, 'Mishael Momanyi', '2024-01-01 00:00:00', 'newly joined', '0718045860', '0', 6, 2, 'eudia moraa', 'Chepilat', '0750496190', '2024-01-26 18:20:21', '2024-01-26 18:20:21'),
(26, 'Mishael Momanyi', '2024-01-01 00:00:00', '', '0718045860', '0', 9, 2, 'eudia moraa', 'Chepilat', '0750496190', '2024-01-27 17:35:27', '2024-01-29 15:36:13'),
(27, 'Laurel Castillo', '2024-01-01 00:00:00', 'Above Average, Displine', '0718909038', '0', 8, 2, 'Conor Walsh', 'Alps', '0720146570', '2024-01-29 09:41:54', '2024-01-29 09:41:54');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `lastlogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `emailid`, `lastlogin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'admin@gmail.com', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `fees_transaction`
--
ALTER TABLE `fees_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fees_transaction`
--
ALTER TABLE `fees_transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `fees_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
