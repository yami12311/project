-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 05:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employeemanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `role`, `contact_number`) VALUES
(1, 'admin', '$2y$10$VdokqSpY8gtZI6a23/ZUt.NHpT65FYczSFY9.C9u.UenJWn7LK/le', 'admin@example.com', '', '1234567890');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `work_hours` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `employee_id`, `attendance_date`, `check_in_time`, `check_out_time`, `status`, `work_hours`, `remarks`) VALUES
(1, 1, '2025-02-02', '10:30:00', '16:30:00', 'Present', NULL, NULL),
(2, 1, '2025-02-06', '10:30:00', '16:30:00', '0', '6', NULL),
(3, 1, '2025-02-06', '10:30:00', '16:30:00', '0', '6', NULL),
(4, 1, '2025-02-06', '10:30:00', '16:30:00', '0', '6', NULL),
(5, 1, '2025-02-06', '10:30:00', '16:30:00', '0', '6', ''),
(6, 1, '2025-02-06', '10:30:00', '16:30:00', '0', '6', ''),
(7, 1, '2025-02-06', '10:30:00', '16:30:00', '0', '6', ''),
(8, 1, '2025-02-06', '10:11:00', '16:30:00', '0', '6.3166666666667', 'today little bit late'),
(9, 1, '2025-02-06', '10:11:00', '16:30:00', '0', '6.3166666666667', 'today little bit late'),
(10, 1, '2025-02-06', '10:11:00', '16:30:00', '0', '6.3166666666667', 'today little bit late'),
(11, 1, '2025-02-06', '10:11:00', '16:30:00', '0', '6.3166666666667', 'today little bit late'),
(12, 1, '2025-02-06', '10:11:00', '16:30:00', '0', '6.3166666666667', 'today little bit late'),
(13, 1, '2025-02-06', '10:11:00', '16:30:00', '0', '6.3166666666667', 'today little bit late'),
(14, 1, '2025-02-06', '10:00:00', '22:30:00', '0', '12.5', 'hello'),
(15, 1, '2025-02-06', '10:00:00', '22:30:00', '0', '12.5', 'hello'),
(16, 1, '2025-02-06', '10:30:00', '12:20:00', '0', '1.8333333333333', 'need to go home its urgent so '),
(17, 1, '2025-02-06', '22:20:00', '17:30:00', '0', '4.8333333333333', 'help'),
(18, 1, '2025-02-06', '10:20:00', '22:12:00', '0', '11.866666666667', 'overtime'),
(19, 1, '2025-02-06', '10:20:00', '22:30:00', '0', '12.166666666667', ''),
(20, 2, '2025-02-06', '10:30:00', '23:33:00', '0', '13.05', 'project'),
(21, 2, '2025-02-06', '12:22:00', '23:35:00', '0', '11.216666666667', ''),
(22, 2, '2025-02-06', '00:01:00', '23:40:00', '0', '23.65', ''),
(23, 2, '2025-02-06', '10:20:00', '12:00:00', '0', '1.6666666666667', ''),
(24, 1, '2025-02-07', '10:30:00', '15:02:00', '0', '4.5333333333333', 'lit'),
(25, 2, '2025-02-09', '10:00:00', '16:30:00', '0', '6.5', 'aayush');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `salary` float NOT NULL,
  `join_date` date NOT NULL,
  `contact_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `username`, `password`, `email`, `department`, `position`, `salary`, `join_date`, `contact_number`) VALUES
(1, 'hi', '$2y$10$A2E5vncRWCuza3IVrDkdhenPnD5SbbdY2ZlZ5jLYiGI7.IRg.oluq', 'hi@gmail.com', 'IT', 'Manager', 100000, '2021-02-02', ''),
(2, 'sidash', '$2y$10$ICZf/y.fEvgOBWXsZUDa6ugtq7JHSTlIUynbiuq011pQmrXtxef5u', 'sidash@gmail.com', 'it', 'senior dev', 120000, '2022-02-20', ''),
(3, 'aayush', '$2y$10$oScXWioRa6kZMiMXrs4hMON6tb7boWyq45OBITYi7BNKAMWaVAqPy', 'ayush@gmail.com', 'it', 'Intern', 100000, '2025-02-20', '');

-- --------------------------------------------------------

--
-- Table structure for table `leave_request`
--

CREATE TABLE `leave_request` (
  `leave_request_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `task_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `employee_id`, `id`, `task_name`, `description`, `assigned_date`, `due_date`, `status`) VALUES
(1, 2, NULL, ' k xa', 'hello', '2025-02-06', '2025-02-12', 'Pending'),
(2, 1, NULL, 'hello', 'hi', '2025-02-06', '2025-02-20', 'Pending'),
(3, 2, NULL, 'nice', 'nice', '2025-02-02', '2025-02-25', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `profile_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `last_login` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `leave_request`
--
ALTER TABLE `leave_request`
  ADD PRIMARY KEY (`leave_request_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leave_request`
--
ALTER TABLE `leave_request`
  MODIFY `leave_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_request`
--
ALTER TABLE `leave_request`
  ADD CONSTRAINT `leave_request_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_request_ibfk_2` FOREIGN KEY (`id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_profile_ibfk_2` FOREIGN KEY (`id`) REFERENCES `admins` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
