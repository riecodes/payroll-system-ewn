-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2025 at 06:31 AM
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
-- Database: `payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `access_role_1` int(11) NOT NULL,
  `created_on` date NOT NULL,
  `sec_1` text NOT NULL,
  `ans_1` text NOT NULL,
  `sec_2` text NOT NULL,
  `ans_2` text NOT NULL,
  `sec_3` text NOT NULL,
  `ans_3` text NOT NULL,
  `activation` varchar(10) NOT NULL DEFAULT 'Active',
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `access_role_1`, `created_on`, `sec_1`, `ans_1`, `sec_2`, `ans_2`, `sec_3`, `ans_3`, `activation`, `status`) VALUES
(2, 'admin', 'admin123', 'Rona', 'Espeso', '', 3, '2024-04-04', 'secq1a', 'a', 'secq1b', 'a', 'secq1c', 'a', 'Active', 0),
(3, 'staff', 'staff123', 'Pat', 'Patin', '', 2, '2024-05-11', 'secq4a', 'football', 'secq1b', 'nenita', 'secq1c', 'cavite', 'Active', 0),
(4, 'hr', 'hr123', 'Sarang', 'Hae', '', 2, '2024-05-23', '', '', '', '', '', '', 'Active', 0),
(5, 'as', 'as', 'as', 'as', '', 2, '2024-05-27', 'secq1a', 'as', 'secq1b', 'as', 'secq1c', 'as', 'Active', 0),
(6, 'a', 'a', 'a', 'a', '', 1, '2024-06-26', '', '', '', '', '', '', 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE `approval` (
  `id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approval`
--

INSERT INTO `approval` (`id`, `status`) VALUES
(1, 'pending'),
(2, 'approve'),
(3, 're-check');

-- --------------------------------------------------------

--
-- Table structure for table `ass_sched_fin`
--

CREATE TABLE `ass_sched_fin` (
  `id` int(11) NOT NULL,
  `ass_employee_id` varchar(50) NOT NULL,
  `ass_employee_id_sc` varchar(20) NOT NULL,
  `ass_name` varchar(50) NOT NULL,
  `ass_position` varchar(50) NOT NULL,
  `ass_meal_allowance` varchar(50) NOT NULL,
  `ass_adjustments` varchar(50) NOT NULL,
  `ass_transpo` varchar(50) NOT NULL,
  `ass_location` varchar(50) NOT NULL,
  `ass_schedule` varchar(50) NOT NULL,
  `computed` int(11) NOT NULL DEFAULT 0,
  `salary_calculation_status` int(11) NOT NULL DEFAULT 0,
  `date_created` varchar(50) NOT NULL,
  `time` varchar(20) NOT NULL,
  `day` varchar(20) NOT NULL,
  `pullout_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ass_sched_fin`
--

INSERT INTO `ass_sched_fin` (`id`, `ass_employee_id`, `ass_employee_id_sc`, `ass_name`, `ass_position`, `ass_meal_allowance`, `ass_adjustments`, `ass_transpo`, `ass_location`, `ass_schedule`, `computed`, `salary_calculation_status`, `date_created`, `time`, `day`, `pullout_status`) VALUES
(31, '1', 'VC:2024-001', '', '12', '', '', '', '1', '2025-08-16', 0, 0, '09-10-2025', '06:09', 'Wed', '0');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `status` int(1) NOT NULL,
  `time_out` time NOT NULL,
  `num_hr` double NOT NULL,
  `adjustments` varchar(50) NOT NULL,
  `meal_allowance` varchar(50) NOT NULL,
  `transportation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `status`, `time_out`, `num_hr`, `adjustments`, `meal_allowance`, `transportation`) VALUES
(10, 'VC:2024-001', '2025-08-17', '04:52:00', 0, '00:00:00', 0, '', '', ''),
(11, 'VC:2024-001', '2025-09-08', '04:55:00', 0, '00:00:00', 0, '', '', ''),
(12, 'VC:2024-001', '2025-08-16', '06:10:00', 0, '00:00:00', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `date_and_time` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `date_and_time`, `user`, `description`) VALUES
(1, '2024-05-02 12:40:56', 'admin', 'Employee added by: admin. Name: Sandara th. ID: 5'),
(2, '2024-05-02 13:08:32', 'admin', 'Deduction edited by user: admin. Description: Pagibig. employeer: 200. employee: 200.'),
(3, '2024-05-03 12:09:24', 'admin', 'Employee membership edited by: admin. Employee id: 2'),
(4, '2024-05-03 16:02:06', 'admin', 'Employee archive by: admin. Employee id: 1'),
(5, '2024-05-03 16:03:07', 'admin', 'Employee archive by: admin. Employee id: 2'),
(6, '2024-05-03 16:04:50', 'admin', 'Employee archive by: admin. Employee id: 1'),
(7, '2024-05-03 16:25:59', 'admin', 'Employee restored by: admin. Employee id: 1'),
(8, '2024-05-03 16:26:05', 'admin', 'Employee archive by: admin. Employee id: 1'),
(9, '2024-05-03 16:26:13', 'admin', 'Employee restored by: admin. Employee id: 1'),
(10, '2024-05-03 16:27:29', 'admin', 'Employee archive by: admin. Employee id: 1'),
(11, '2024-05-03 18:20:18', 'admin', 'User logged out: admin'),
(12, '2024-05-03 18:46:05', 'staff', 'Password updated by: staff. Name: staff staff'),
(13, '2024-05-03 18:46:11', 'staff', 'User logged out: staff'),
(14, '2024-05-03 18:46:30', 'staff', 'User logged out: staff'),
(15, '2024-05-03 22:15:38', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: 4'),
(16, '2024-05-03 22:52:41', 'admin', 'Wage edited by user: admin. id: 1  Wage: 700'),
(17, '2024-05-03 22:52:50', 'admin', 'Wage edited by user: admin. id: 1  Wage: 800'),
(18, '2024-05-03 22:52:56', 'admin', 'Wage edited by user: admin. id: 1  Wage: 600'),
(19, '2024-05-03 22:53:05', 'admin', 'Wage edited by user: admin. id: 1  Wage: 500'),
(20, '2024-05-04 01:16:49', 'admin', 'Row in employee financial list variable deleted by: admin. Row in employee financial list: . Salary:'),
(21, '2024-05-04 14:46:44', 'admin', 'Employee restored by: admin. Employee id: 1'),
(22, '2024-05-04 15:11:03', 'admin', 'Employee added by: admin. Name: Sandara th. ID: 5'),
(23, '2024-05-05 12:00:25', 'admin', 'Employee archive by: admin. Employee id: 5'),
(24, '2024-05-05 12:07:27', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(25, '2024-05-05 12:07:30', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(26, '2024-05-05 12:07:31', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(27, '2024-05-05 12:07:33', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(28, '2024-05-05 23:10:34', 'admin', 'Row in employee financial list variable deleted by: admin. Row in employee financial list: . Salary:'),
(29, '2024-05-05 23:10:37', 'admin', 'Row in employee financial list variable deleted by: admin. Row in employee financial list: . Salary:'),
(30, '2024-05-05 23:10:39', 'admin', 'Row in employee financial list variable deleted by: admin. Row in employee financial list: . Salary:'),
(31, '2024-05-05 23:35:59', 'admin', 'Deduction edited by user: admin. Description: PhilHealth. employeer: 0.095. employee: .04.'),
(32, '2024-05-05 23:37:55', 'admin', 'Deduction edited by user: admin. Description: TIN. employeer: 0.095. employee: .40.'),
(33, '2024-05-05 23:39:41', 'admin', 'Row in employee financial list variable deleted by: admin. Row in employee financial list: . Salary:'),
(34, '2024-05-05 23:39:43', 'admin', 'Row in employee financial list variable deleted by: admin. Row in employee financial list: . Salary:'),
(35, '2024-05-05 23:39:45', 'admin', 'Row in employee financial list variable deleted by: admin. Row in employee financial list: . Salary:'),
(36, '2024-05-05 23:40:48', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(37, '2024-05-05 23:40:50', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(38, '2024-05-05 23:40:52', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(39, '2024-05-05 23:57:01', 'admin', 'User logged out: admin'),
(40, '2024-05-05 23:58:54', 'staff', 'User logged out: staff'),
(41, '2024-05-06 00:01:23', 'admin', 'User logged out: admin'),
(42, '2024-05-06 00:01:46', 'staff', 'User logged out: staff'),
(43, '2024-05-06 00:05:51', 'staff', 'User logged out: staff'),
(44, '2024-05-06 00:06:05', 'admin', 'User logged out: admin'),
(45, '2024-05-06 00:06:24', 'staff', 'User logged out: staff'),
(46, '2024-05-06 00:12:33', 'staff', 'Password updated by: staff. Name: staff staff'),
(47, '2024-05-06 00:12:38', 'staff', 'User logged out: staff'),
(48, '2024-05-06 00:17:43', 'staff', 'User logged out: staff'),
(49, '2024-05-06 00:18:05', 'staff', 'Password updated by: staff. Name: staff staff'),
(50, '2024-05-06 00:18:53', 'staff', 'User logged out: staff'),
(51, '2024-05-06 00:20:44', 'staff', 'Password updated by: staff. Name: staff staff'),
(52, '2024-05-06 00:20:49', 'staff', 'User logged out: staff'),
(53, '2024-05-06 00:21:04', 'staff', 'User logged out: staff'),
(54, '2024-05-06 01:27:14', 'admin', 'Employee added by: admin. Employee id: VC:2024-004. Employee name: Juan Delacruz'),
(55, '2024-05-06 01:28:19', 'admin', 'Employee membership edited by: admin. Employee id: 6'),
(56, '2024-05-06 02:09:01', 'admin', 'Employee added by: admin. Name: Dommaraju  Gukesh. ID: 4'),
(57, '2024-05-06 02:09:20', 'admin', 'Employee added by: admin. Name: Garry Casparov. ID: 2'),
(58, '2024-05-06 02:09:37', 'admin', 'Employee added by: admin. Name: Welsy So. ID: 1'),
(59, '2024-05-06 04:05:56', 'admin', 'Employee added by: admin. Employee id: VC:2024-005. Employee name: dfsd fsdf'),
(60, '2024-05-06 11:27:43', 'admin', 'Employee added by: admin. Employee id: VC:2024-006. Employee name: zdgh ghrtht'),
(61, '2024-05-06 11:44:56', 'admin', 'Employee added by: admin. Employee id: VC:2024-005. Employee name: rthrthrt hrthr'),
(62, '2024-05-06 12:36:47', 'admin', 'Employee archive by: admin. Employee id: 6'),
(63, '2024-05-06 12:37:04', 'admin', 'Employee restored by: admin. Employee id: 6'),
(64, '2024-05-06 12:53:31', 'admin', 'User logged out: admin'),
(65, '2024-05-06 12:54:52', 'staff', 'User logged out: staff'),
(66, '2024-05-06 12:55:11', 'staff', 'User logged out: staff'),
(67, '2024-05-06 12:55:52', 'admin', 'User logged out: admin'),
(68, '2024-05-06 12:56:40', 'staff', 'Password updated by: staff. Name: staff staff'),
(69, '2024-05-06 12:56:45', 'staff', 'User logged out: staff'),
(70, '2024-05-06 12:57:15', 'staff', 'User logged out: staff'),
(71, '2024-05-06 13:13:36', 'admin', 'Employee added by: admin. Name: Garry Casparov. ID: 2'),
(72, '2024-05-06 13:13:41', 'admin', 'Employee added by: admin. Name: Dommaraju  Gukesh. ID: 4'),
(73, '2024-05-06 13:13:50', 'admin', 'Employee added by: admin. Name: rthrthrt hrthr. ID: 9'),
(74, '2024-05-06 14:31:01', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(75, '2024-05-06 16:56:58', 'admin', 'Employee archive by: admin. Employee id: 9'),
(76, '2024-05-06 16:57:05', 'admin', 'Employee archive by: admin. Employee id: 6'),
(77, '2024-05-06 22:05:13', '', 'User logged out: '),
(78, '2024-05-07 02:27:15', '', 'User logged out: '),
(79, '2024-05-07 15:05:53', 'admin', 'Employee added by: admin. Name: Dommaraju  Gukesh. ID: 4'),
(80, '2024-05-07 15:06:01', 'admin', 'Employee added by: admin. Name: Dommaraju  Gukesh. ID: 4'),
(81, '2024-05-07 15:25:06', 'admin', 'Position variable added by: admin. Position: tecgg. Salary: 100'),
(82, '2024-05-07 15:25:09', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: 6'),
(83, '2024-05-08 12:36:03', 'admin', 'Position variable added by: admin. Position: technician. Salary: 600'),
(84, '2024-05-08 12:36:16', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: 7'),
(85, '2024-05-08 12:57:48', '', 'User logged out: '),
(86, '2024-05-08 13:00:35', 'staff', 'User logged out: staff'),
(87, '2024-05-08 13:49:28', '', 'User logged out: '),
(88, '2024-05-08 13:49:40', 'staff', 'User logged out: staff'),
(89, '2024-05-08 14:48:04', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(90, '2024-05-08 16:20:17', 'admin', 'Password updated by: admin. Name: Rona Espeso'),
(91, '2024-05-08 16:20:38', 'admin', 'User logged out: admin'),
(92, '2024-05-08 21:04:49', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(93, '2024-05-08 21:07:44', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(94, '2024-05-09 00:05:40', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(95, '2024-05-09 00:05:42', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(96, '2024-05-09 20:15:53', 'admin', 'Position variable edited by: admin. Position: . Salary: '),
(97, '2024-05-09 20:18:05', 'admin', 'Payslip variable edited by: admin. Payslip: . Salary: '),
(98, '2024-05-09 20:18:11', 'admin', 'Payslip variable edited by: admin. Payslip: . Salary: '),
(99, '2024-05-09 20:18:26', 'admin', 'Payslip variable edited by: admin. Payslip: . Salary: '),
(100, '2024-05-09 20:18:36', 'admin', 'Payslip variable edited by: admin. Payslip: . Salary: '),
(101, '2024-05-09 21:01:31', 'admin', 'Payslip variable edited by: admin. Payslip: . Salary: '),
(102, '2024-05-09 21:22:52', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(103, '2024-05-09 21:38:13', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(104, '2024-05-09 21:57:00', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(105, '2024-05-09 21:57:32', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(106, '2024-05-09 21:57:38', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(107, '2024-05-09 21:57:43', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(108, '2024-05-09 21:58:53', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(109, '2024-05-09 21:58:54', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(110, '2024-05-09 21:58:55', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(111, '2024-05-09 21:58:55', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(112, '2024-05-09 21:58:59', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(113, '2024-05-09 22:03:38', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(114, '2024-05-09 22:03:39', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(115, '2024-05-09 22:03:39', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(116, '2024-05-09 22:03:40', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(117, '2024-05-09 22:03:45', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(118, '2024-05-09 22:05:53', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(119, '2024-05-09 22:06:05', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(120, '2024-05-09 22:06:06', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(121, '2024-05-09 22:06:07', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(122, '2024-05-09 22:06:07', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(123, '2024-05-09 23:00:47', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(124, '2024-05-09 23:00:59', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(125, '2024-05-09 23:01:09', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(126, '2024-05-09 23:46:48', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(127, '2024-05-09 23:46:49', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(128, '2024-05-09 23:46:50', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(129, '2024-05-09 23:46:51', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(130, '2024-05-09 23:46:51', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(131, '2024-05-09 23:47:04', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(132, '2024-05-09 23:48:08', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(133, '2024-05-10 00:01:37', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(134, '2024-05-11 12:40:11', 'admin', 'User logged out: admin'),
(135, '2024-05-11 13:57:23', 'admin', 'User logged out: admin'),
(136, '2024-05-11 14:33:06', 'admin', 'User logged out: admin'),
(137, '2024-05-11 16:02:55', 'admin', 'User logged out: admin'),
(138, '2024-05-11 16:08:11', 'admin', 'User logged out: admin'),
(139, '2024-05-11 16:38:43', 'staff', 'User logged out: staff'),
(140, '2024-05-11 16:39:26', 'staff', 'User logged out: staff'),
(141, '2024-05-11 16:39:39', 'admin', 'User logged out: admin'),
(142, '2024-05-11 17:08:09', 'staff', 'User logged out: staff'),
(143, '2024-05-11 17:08:57', 'admin', 'User logged out: admin'),
(144, '2024-05-11 17:15:53', 'staff', 'User logged out: staff'),
(145, '2024-05-11 17:16:52', 'admin', 'User logged out: admin'),
(146, '2024-05-11 17:33:22', 'admin', 'User logged out: admin'),
(147, '2024-05-11 17:39:07', 'staff', 'User logged out: staff'),
(148, '2024-05-11 17:40:06', 'admin', 'User logged out: admin'),
(149, '2024-05-11 17:43:59', 'admin', 'User logged out: admin'),
(150, '2024-05-11 17:45:10', 'staff', 'User logged out: staff'),
(151, '2024-05-11 17:54:49', 'staff', 'User logged out: staff'),
(152, '2024-05-11 17:55:31', 'admin', 'User logged out: admin'),
(153, '2024-05-11 17:57:50', 'staff', 'User logged out: staff'),
(154, '2024-05-11 18:02:00', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(155, '2024-05-11 18:02:22', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(156, '2024-05-11 18:02:26', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(157, '2024-05-12 15:07:15', 'admin', 'User logged out: admin'),
(158, '2024-05-12 15:23:53', 'staff', 'User logged out: staff'),
(159, '2024-05-12 22:13:08', 'admin', 'Position variable edited by: admin. Position: Technician. Salary: 312.50'),
(160, '2024-05-12 22:13:14', 'admin', 'Position variable edited by: admin. Position: Vaccinator. Salary: 312.50'),
(161, '2024-05-12 23:11:53', 'admin', 'base_pay variable added by: admin. Basepay: 3750'),
(162, '2024-05-12 23:12:16', 'admin', 'base_pay variable added by: admin. Basepay: 6500'),
(163, '2024-05-12 23:12:28', 'admin', 'base_pay variable added by: admin. Basepay: 7500'),
(164, '2024-05-12 23:12:39', 'admin', 'base_pay variable added by: admin. Basepay: 8500'),
(165, '2024-05-12 23:24:52', 'admin', 'base_pay variable edited by: admin. base_pay: . Salary: '),
(166, '2024-05-12 23:25:01', 'admin', 'base_pay variable edited by: admin. base_pay: . Salary: '),
(167, '2024-05-12 23:25:03', 'admin', 'base_pay variable edited by: admin. base_pay: . Salary: '),
(168, '2024-05-12 23:26:54', 'admin', 'base_pay variable edited by: admin. base_pay: 4573865756. id: 1'),
(169, '2024-05-12 23:27:00', 'admin', 'base_pay variable edited by: admin. base_pay: 3750. id: 1'),
(170, '2024-05-12 23:32:17', 'admin', 'base_pay variable deleted by: admin.  base_pay id: 4'),
(171, '2024-05-12 23:33:39', 'admin', 'base_pay variable deleted by: admin.  base_pay id: 4'),
(172, '2024-05-12 23:33:46', 'admin', 'base_pay variable added by: admin. Basepay: 8500'),
(173, '2024-05-13 00:58:06', 'admin', 'Position variable added by: admin. Position: technician. Salary: 312.50'),
(174, '2024-05-13 00:58:13', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: '),
(175, '2024-05-13 00:58:15', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: '),
(176, '2024-05-13 01:02:48', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: '),
(177, '2024-05-13 01:07:37', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: 3'),
(178, '2024-05-13 01:07:40', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: 1'),
(179, '2024-05-13 01:08:52', 'admin', 'Position variable added by: admin. Position: vaccinator. Salary: 312.50'),
(180, '2024-05-13 01:09:08', 'admin', 'Position variable edited by: admin. Position: Technician. Salary: 312.5'),
(181, '2024-05-13 01:58:43', 'admin', 'base_pay variable edited by: admin. base_pay: . id: 1'),
(182, '2024-05-13 02:00:25', 'admin', 'base_pay variable edited by: admin. base_pay: . id: 1'),
(183, '2024-05-13 02:03:33', 'admin', 'base_pay variable edited by: admin. base_pay: 312.50. id: '),
(184, '2024-05-13 02:04:14', 'admin', 'base_pay variable edited by: admin. base_pay: . id: 1'),
(185, '2024-05-13 02:05:17', 'admin', 'base_pay variable edited by: admin. base_pay: 312.50. id: '),
(186, '2024-05-13 02:05:20', 'admin', 'base_pay variable edited by: admin. base_pay: . id: 1'),
(187, '2024-05-13 02:09:25', 'admin', 'base_pay variable edited by: admin. base_pay: 312.50. id: '),
(188, '2024-05-13 02:14:01', 'admin', 'base_pay variable edited by: admin. base_pay: 3750. id: '),
(189, '2024-05-13 02:33:04', 'admin', 'Employee added by: admin. Name: Dommaraju  Gukesh. ID: 4'),
(190, '2024-05-13 02:33:13', 'admin', 'Employee added by: admin. Name: Garry Casparov. ID: 2'),
(191, '2024-05-13 02:33:17', 'admin', 'Employee added by: admin. Name: Welsy So. ID: 1'),
(192, '2024-05-13 03:26:03', 'admin', 'User logged out: admin'),
(193, '2024-05-13 09:35:43', 'admin', 'Position variable added by: admin. Position: tech. Salary: 791.6666666666666'),
(194, '2024-05-13 09:47:40', 'admin', 'Position variable edited by: admin. Position: vaccinator. Salary: 708.33'),
(195, '2024-05-13 09:47:56', 'admin', 'Position variable edited by: admin. Position: Technician. Salary: 312.50'),
(196, '2024-05-13 10:05:32', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(197, '2024-05-13 10:09:02', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(198, '2024-05-13 10:09:51', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(199, '2024-05-13 10:10:02', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(200, '2024-05-13 10:10:36', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(201, '2024-05-13 10:10:43', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(202, '2024-05-13 12:51:33', 'admin', 'Position variable added by: admin. Position: fdgdfg. Salary: 4713.75'),
(203, '2024-05-13 12:53:26', 'admin', 'Position variable edited by: admin. Position: tech. Salary: 791.67'),
(204, '2024-05-13 12:53:30', 'admin', 'Position variable edited by: admin. Position: vaccinator. Salary: 708.33'),
(205, '2024-05-13 12:53:33', 'admin', 'Position variable edited by: admin. Position: Technician. Salary: 312.5'),
(206, '2024-05-13 12:53:36', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: 11'),
(207, '2024-05-13 14:23:51', 'admin', 'User logged out: admin'),
(208, '2024-05-13 14:24:40', 'admin', 'User logged out: admin'),
(209, '2024-05-13 14:29:39', 'staff', 'User logged out: staff'),
(210, '2024-05-13 14:30:57', 'admin', 'User logged out: admin'),
(211, '2024-05-13 14:32:28', 'staff', 'User logged out: staff'),
(212, '2024-05-13 14:32:48', 'admin', 'User logged out: admin'),
(213, '2024-05-13 14:33:15', 'admin', 'User logged out: admin'),
(214, '2024-05-13 20:31:02', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(215, '2024-05-13 20:31:12', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(216, '2024-05-14 00:32:17', 'admin', 'User logged out: admin'),
(217, '2024-05-14 01:06:44', 'admin', 'User logged out: admin'),
(218, '2024-05-14 16:30:59', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(219, '2024-05-14 16:33:50', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(220, '2024-05-14 18:29:20', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(221, '2024-05-14 18:29:22', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(222, '2024-05-14 18:29:24', 'admin', 'Deduction added by user: admin. Description: . Amount: .'),
(223, '2024-05-14 19:43:15', 'admin', 'Employee added by: admin. Name: Jhen Bacho. ID: 4'),
(224, '2024-05-14 19:44:37', 'admin', 'Employee added by: admin. Name: Genielyn Gonzales. ID: 2'),
(225, '2024-05-23 20:07:39', 'admin', 'User logged out: admin'),
(226, '2024-05-23 20:08:34', 'admin', 'User logged out: admin'),
(227, '2024-05-23 20:16:17', 'staff', 'User logged out: staff'),
(228, '2024-05-23 20:16:25', 'admin', 'User logged out: admin'),
(229, '2024-05-23 20:18:58', 'staff', 'User logged out: staff'),
(230, '2024-05-23 20:19:09', 'admin', 'User logged out: admin'),
(231, '2024-05-23 20:20:40', 'admin', 'User logged out: admin'),
(232, '2024-05-23 20:26:34', 'admin', 'User logged out: admin'),
(233, '2024-05-23 20:46:31', 'hr', 'User logged out: hr'),
(234, '2024-05-23 20:46:59', 'admin', 'User logged out: admin'),
(235, '2024-05-23 20:48:33', 'staff', 'User logged out: staff'),
(236, '2024-05-23 20:50:09', 'hr', 'User logged out: hr'),
(237, '2024-05-23 20:50:47', 'admin', 'User logged out: admin'),
(238, '2024-05-23 20:50:59', 'staff', 'User logged out: staff'),
(239, '2024-05-23 23:23:55', 'admin', 'User logged out: admin'),
(240, '2024-05-23 23:24:09', 'staff', 'User logged out: staff'),
(241, '2024-05-24 00:18:13', 'admin', 'User logged out: admin'),
(242, '2024-05-24 00:18:35', 'staff', 'User logged out: staff'),
(243, '2024-05-25 21:49:16', 'admin', 'Position variable edited by: admin. Position: Technician. Salary: 308.33'),
(244, '2024-05-25 21:58:51', 'admin', 'Wage edited by user: admin. id: 1  Wage: 500'),
(245, '2024-05-25 22:03:35', 'admin', 'Deduction edited by user: admin. Description: PhilHealth. employeer: 0.095. employee: .025.'),
(246, '2024-05-25 22:03:43', 'admin', 'Deduction edited by user: admin. Description: PhilHealth. employeer: 0.025. employee: .025.'),
(247, '2024-05-25 22:42:18', 'admin', 'Position variable edited by: admin. Position: Technician. Salary: 625.00'),
(248, '2024-05-25 22:46:52', 'admin', 'Position variable deleted by: admin. Position: . Salary: . Position id: 10'),
(249, '2024-05-26 02:23:35', 'admin', 'Employee added by: admin. Name: Jhen Bacho. ID: 1'),
(250, '2024-05-26 02:44:27', 'admin', 'Employee added by: admin. Name: Genielyn Gonzales. ID: 2'),
(251, '2024-05-26 02:44:36', 'admin', 'Employee added by: admin. Name: Jhen Bacho. ID: 1'),
(252, '2024-05-26 02:53:34', 'admin', 'Employee added by: admin. Employee id: VC:2024-003. Employee name: Juan Delacruz'),
(253, '2024-05-26 02:54:41', 'admin', 'Employee photo edited by: admin. Photo: profile.jpg'),
(254, '2024-05-26 02:54:50', 'admin', 'Employee photo edited by: admin. Photo: profile.jpg'),
(255, '2024-05-26 02:55:00', 'admin', 'Employee photo edited by: admin. Photo: profile.jpg'),
(256, '2024-05-26 03:16:53', 'admin', 'Employee added by: admin. Employee id: VC:2024-004. Employee name: Pedro Penduko'),
(257, '2024-05-26 04:01:54', 'admin', 'Employee archive by: admin. Employee id: 10'),
(258, '2024-05-26 04:43:14', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(259, '2024-05-26 04:43:36', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(260, '2024-05-26 04:43:39', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(261, '2024-05-26 04:43:40', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(262, '2024-05-26 04:43:41', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(263, '2024-05-26 04:43:43', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(264, '2024-05-26 04:43:45', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(265, '2024-05-26 04:44:25', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(266, '2024-05-26 04:45:53', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(267, '2024-05-26 04:47:23', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(268, '2024-05-26 04:47:25', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(269, '2024-05-26 04:47:26', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(270, '2024-05-26 04:52:10', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(271, '2024-05-26 04:52:32', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(272, '2024-05-26 05:25:59', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(273, '2024-05-26 05:26:00', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(274, '2024-05-26 13:34:22', 'admin', 'Position variable added by: admin. Province: . Municipality: dfgdf'),
(275, '2024-05-26 13:56:55', 'admin', 'User logged out: admin'),
(276, '2024-05-26 14:26:08', 'staff', 'User logged out: staff'),
(277, '2024-05-26 14:36:56', 'hr', 'User logged out: hr'),
(278, '2024-05-26 14:38:03', 'admin', 'User logged out: admin'),
(279, '2024-05-26 14:40:50', 'hr', 'User logged out: hr'),
(280, '2024-05-26 14:47:05', 'admin', 'User logged out: admin'),
(281, '2024-05-26 14:54:08', 'hr', 'User logged out: hr'),
(282, '2024-05-26 14:54:24', 'admin', 'User logged out: admin'),
(283, '2024-05-26 14:54:36', 'staff', 'User logged out: staff'),
(284, '2024-05-26 15:00:59', 'hr', 'User logged out: hr'),
(285, '2024-05-26 15:01:08', 'admin', 'User logged out: admin'),
(286, '2024-05-26 15:01:20', 'staff', 'User logged out: staff'),
(287, '2024-05-26 15:02:11', 'hr', 'User logged out: hr'),
(288, '2024-05-26 15:02:37', 'admin', 'User logged out: admin'),
(289, '2024-05-26 18:14:10', 'admin', 'User logged out: admin'),
(290, '2024-05-26 18:18:28', 'hr', 'User logged out: hr'),
(291, '2024-05-27 20:41:24', 'admin', 'User logged out: admin'),
(292, '2024-05-27 20:43:22', 'staff', 'User logged out: staff'),
(293, '2024-05-27 22:16:12', 'admin', 'Employee archive by: admin. Employee id: 11'),
(294, '2024-05-27 23:53:50', 'admin', 'Employee added by: admin. Employee id: VC:2024-005. Employee name: erge erg'),
(295, '2024-05-27 23:54:41', 'admin', 'Employee archive by: admin. Employee id: 12'),
(296, '2024-05-27 23:54:47', 'admin', 'Employee restored by: admin. Employee id: 12'),
(297, '2024-05-28 00:05:38', 'admin', 'Employee added by: admin. Name: Jhen Bacho. ID: 1'),
(298, '2024-05-28 00:05:51', 'admin', 'Employee added by: admin. Name: Genielyn Gonzales. ID: 2'),
(299, '2024-05-28 00:08:03', 'admin', 'Employee added by: admin. Name: Jhen Bacho. ID: 1'),
(300, '2024-05-28 00:08:09', 'admin', 'Employee added by: admin. Name: erge erg. ID: 12'),
(301, '2024-05-28 00:08:14', 'admin', 'Employee added by: admin. Name: Genielyn Gonzales. ID: 2'),
(302, '2024-05-28 00:08:19', 'admin', 'Employee added by: admin. Name: Jhen Bacho. ID: 1'),
(303, '2024-05-27 10:06:18', 'admin', 'User logged out: admin'),
(304, '2024-05-27 10:16:32', 'admin', 'User logged out: admin'),
(305, '2024-05-27 10:17:22', 'as', 'User logged out: as'),
(306, '2024-05-29 11:05:39', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(307, '2024-05-29 11:06:29', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(308, '2024-05-29 11:06:35', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(309, '2024-05-29 11:13:04', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(310, '2024-05-29 11:27:12', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(311, '2024-05-29 11:27:57', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(312, '2024-05-29 11:35:20', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(313, '2024-05-29 11:35:22', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(314, '2024-05-29 11:37:44', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(315, '2024-05-29 11:37:48', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(316, '2024-05-29 11:37:52', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(317, '2024-05-29 11:45:10', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(318, '2024-05-29 11:45:19', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(319, '2024-05-29 11:49:35', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(320, '2024-05-29 11:49:42', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(321, '2024-05-29 12:10:27', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-001.'),
(322, '2024-05-29 19:23:00', 'admin', 'User logged out: admin'),
(323, '2024-05-30 19:20:58', 'admin', 'User logged out: admin'),
(324, '2024-05-30 19:40:13', 'admin', 'Deduction edited by user: admin. Description: SSS. employeer: 0.095. employee: 0.045.'),
(325, '2024-05-30 23:21:48', 'admin', 'User logged out: admin'),
(326, '2024-05-31 11:30:49', 'admin', 'Employee archive by: admin. Employee id: 12'),
(327, '2024-05-31 12:47:04', 'admin', 'User logged out: admin'),
(328, '2024-05-31 13:52:13', 'admin', 'User logged out: admin'),
(329, '2024-05-31 13:54:13', 'hr', 'User logged out: hr'),
(330, '2024-06-24 10:09:46', 'admin', 'Employee added by: admin. Name: Genielyn Gonzales. ID: 2'),
(331, '2024-06-24 10:14:32', 'admin', 'Employee added by: admin. Name: Genielyn Gonzales. ID: 2'),
(332, '2024-06-24 10:38:01', 'admin', 'Employee added by: admin. Employee id: VC:2024-006. Employee name: rg erg'),
(333, '2024-06-24 10:38:36', 'admin', 'Employee added by: admin. Name: rg erg. ID: 13'),
(334, '2024-06-24 20:40:32', 'admin', 'Position variable added by: admin. Province: 0128. Municipality: 012802'),
(335, '2024-06-24 20:42:04', 'admin', 'Position variable added by: admin. Province: 0128. Municipality: 012802'),
(336, '2024-06-24 20:42:43', 'admin', 'Position variable added by: admin. Province: 0209. Municipality: 020906'),
(337, '2024-06-24 20:49:53', 'admin', 'Position variable added by: admin. Province: 0133. Municipality: 013302'),
(338, '2024-06-24 20:53:38', 'admin', 'Position variable added by: admin. Province: 0129. Municipality: 012911'),
(339, '2024-06-24 20:56:13', 'admin', 'Position variable added by: admin. Province: 0209. Municipality: SABTANG'),
(340, '2024-06-24 21:04:30', 'admin', 'Position variable added by: admin. Province: PANGASINAN. Municipality: BALUNGAO'),
(341, '2024-06-24 21:07:11', 'admin', 'Position variable added by: admin. Province: LA UNION. Municipality: Bauang'),
(342, '2024-06-24 21:07:23', 'admin', 'Position variable added by: admin. Province: TARLAC. Municipality: La Paz'),
(343, '2024-06-24 21:12:51', 'admin', 'Position variable added by: admin. Province: BATAAN. Municipality: Mariveles'),
(344, '2024-06-24 21:13:13', 'admin', 'Position variable added by: admin. Province: PANGASINAN. Municipality: SUAL'),
(345, '2024-06-24 21:15:02', 'admin', 'Position variable added by: admin. Province: Pangasinan. Municipality: Balungao'),
(346, '2024-06-24 21:32:37', 'admin', 'Position variable added by: admin. Province: Batanes. Municipality: Itbayat'),
(347, '2024-06-24 21:34:29', 'admin', 'Position variable added by: admin. Province: Dinagat Islands. Municipality: Loreto'),
(348, '2024-06-25 14:56:52', 'admin', 'Position variable added by: admin. Province: . Municipality: '),
(349, '2024-06-25 14:57:14', 'admin', 'Position variable added by: admin. Province: La Union. Municipality: Bacnotan'),
(350, '2024-06-25 15:29:45', 'admin', 'Position variable added by: admin. Province: Cagayan. Municipality: Aparri'),
(351, '2024-06-25 18:34:00', 'admin', 'Employee added by: admin. Name: rg erg. ID: 13'),
(352, '2024-06-25 21:50:21', 'admin', 'User logged out: admin'),
(353, '2024-06-26 12:58:04', 'admin', 'User logged out: admin'),
(354, '2024-06-26 16:12:26', 'admin', 'Employee photo edited by: admin. Photo: 13999067.jpg'),
(355, '2024-06-26 16:22:59', 'admin', 'Employee photo edited by: admin. Photo: 13999067.jpg'),
(356, '2024-06-26 16:23:09', 'admin', 'Employee photo edited by: admin. Photo: top-10-the-most-beautiful-japanese-actresses.jpg'),
(357, '2024-06-26 16:28:16', 'admin', 'Employee photo edited by: admin. Photo: Cyclic-RedunDancy-Check-1.png'),
(358, '2024-06-26 22:34:40', 'admin', 'User logged out: admin'),
(359, '2024-06-26 23:00:14', 'a', 'User logged out: a'),
(360, '2024-06-26 23:02:41', 'admin', 'User logged out: admin'),
(361, '2024-06-26 23:04:16', 'a', 'User logged out: a'),
(362, '2024-06-27 13:08:49', 'admin', 'User logged out: admin'),
(363, '2024-06-27 13:09:14', 'staff', 'User logged out: staff'),
(364, '2024-06-27 14:04:02', 'admin', 'Reimbursement edited by: admin. id: 122. Meal allowance: 108 adjustment: 36 Transportation: 95 '),
(365, '2024-06-27 14:11:14', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(366, '2024-06-29 00:56:52', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(367, '2024-06-29 01:01:19', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(368, '2024-06-29 13:44:49', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(369, '2024-06-29 13:53:05', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(370, '2024-06-29 14:08:42', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(371, '2024-06-29 14:13:01', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(372, '2024-06-29 14:32:34', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(373, '2024-06-29 14:33:00', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(374, '2024-06-29 14:36:49', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(375, '2024-06-29 14:36:57', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(376, '2024-06-29 14:37:07', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(377, '2024-06-29 14:42:21', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(378, '2024-06-29 14:42:34', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(379, '2024-06-29 14:43:11', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(380, '2024-06-29 14:45:34', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(381, '2024-06-29 14:45:39', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(382, '2024-06-29 14:45:45', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(383, '2024-06-29 14:45:52', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(384, '2024-06-29 14:45:59', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(385, '2024-06-29 14:48:48', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(386, '2024-06-29 14:49:01', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(387, '2024-06-29 14:49:09', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(388, '2024-06-29 14:49:13', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(389, '2024-06-29 14:51:45', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(390, '2024-06-29 14:54:05', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(391, '2024-06-29 14:54:18', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(392, '2024-06-29 14:55:57', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(393, '2024-06-29 14:56:06', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(394, '2024-06-29 14:58:13', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(395, '2024-06-29 14:58:40', 'admin', 'Payslip variable edited by: admin. Employee: VC:2024-002.'),
(396, '2024-07-02 11:02:22', 'admin', 'Reimbursement edited by: admin. id: 122. Meal allowance: 108 adjustment: 36 Transportation: 95 '),
(397, '2024-07-02 11:02:29', 'admin', 'Reimbursement edited by: admin. id: 122. Meal allowance: 141 adjustment: 36 Transportation: 128 '),
(398, '2024-07-02 11:02:56', 'admin', 'Employee photo edited by: admin. Photo: 10.png'),
(399, '2024-07-02 11:03:23', 'admin', 'Employee photo edited by: admin. Photo: Grey Modern Cute Cats and Quote Bookmark .png'),
(400, '2024-07-02 11:54:01', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-05-01] - [2024-05-15]'),
(401, '2024-07-02 12:05:09', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-07-01] - [2024-07-15]'),
(402, '2024-07-02 12:36:23', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-07-01] - [2024-07-15]'),
(403, '2024-07-02 12:46:06', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-07-01] - [2024-07-15]'),
(404, '2024-07-02 15:30:03', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2024-07-01] - [2024-07-15]'),
(405, '2024-07-02 15:36:37', 'admin', 'Wage edited by user: admin. id: 1  Wage: 500'),
(406, '2024-07-02 15:47:00', 'admin', 'Wage edited by user: admin. id: 1  Wage: 500'),
(407, '2024-07-02 16:00:15', 'admin', 'Wage edited by user: admin. id: 1 Wage: 500'),
(408, '2024-07-02 16:00:20', 'admin', 'Wage edited by user: admin. id: 1 Wage: 600'),
(409, '2024-07-02 16:00:25', 'admin', 'Wage edited by user: admin. id: 1 Wage: 500'),
(410, '2024-07-02 16:04:54', 'admin', 'Wage edited by user: admin. id: 1 Wage: 600'),
(411, '2024-07-02 16:07:17', 'admin', 'Wage edited by user: admin. id: 1 Wage: 600'),
(412, '2024-07-02 16:07:50', 'admin', 'Wage edited by user: admin. id: 1 Wage: 500'),
(413, '2025-07-14 16:47:26', 'admin', 'User logged out: admin'),
(414, '2025-07-15 20:09:55', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2025-07-01] - [2025-07-15]'),
(415, '2025-07-15 20:34:05', 'admin', 'User logged out: admin'),
(416, '2025-07-15 20:38:01', 'staff', 'User logged out: staff'),
(417, '2025-07-15 20:52:33', 'admin', 'Position variable added by: admin. Position: manager. Salary: 833.33'),
(418, '2025-07-15 20:54:54', 'admin', 'Employee edited by: admin. Name: rg erg. ID: 13'),
(419, '2025-07-15 20:55:05', 'admin', 'Employee edited by: admin. Name: rg erg. ID: 13'),
(420, '2025-07-15 20:55:24', 'admin', 'Employee edited by: admin. Name: Jhen Bacho. ID: 1'),
(421, '2025-07-15 20:55:55', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2025-07-01] - [2025-07-15]'),
(422, '2025-07-15 21:08:07', 'admin', 'User logged out: admin'),
(423, '2025-07-15 21:28:45', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2025-07-01] - [2025-07-15]'),
(424, '2025-07-17 17:50:55', 'admin', 'Deduction edited by user: admin. Description: PhilHealth. employeer: 0.025. employee: 0.025.'),
(425, '2025-07-20 13:26:09', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2025-07-01] - [2025-07-15]'),
(426, '2025-08-13 17:29:55', 'admin', 'Payroll created by: admin. Cutoff: 2. Date range: [2025-07-16] - [2025-07-31]'),
(427, '2025-09-03 14:33:22', 'Rona Espeso', 'SSS contribution schedule updated by: Rona Espeso. ID: 2'),
(428, '2025-09-03 14:33:41', 'Rona Espeso', 'SSS contribution schedule updated by: Rona Espeso. ID: 2'),
(429, '2025-09-03 14:33:47', 'Rona Espeso', 'SSS contribution schedule updated by: Rona Espeso. ID: 2'),
(430, '2025-09-05 14:29:18', 'admin', 'User logged out: admin'),
(431, '2025-09-08 21:34:17', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2025-09-01] - [2025-09-15]'),
(432, '2025-09-08 21:49:24', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2025-08-01] - [2025-08-15]'),
(433, '2025-09-08 21:49:50', 'admin', 'Payroll created by: admin. Cutoff: 2. Date range: [2025-08-16] - [2025-08-31]'),
(434, '2025-09-09 07:51:00', 'admin', 'Payroll created by: admin. Cutoff: 2. Date range: [2025-08-16] - [2025-08-31]'),
(435, '2025-09-09 07:53:28', 'admin', 'Payroll created by: admin. Cutoff: 2. Date range: [2025-08-16] - [2025-08-31]'),
(436, '2025-09-10 10:53:21', 'admin', 'Payroll created by: admin. Cutoff: 2. Date range: [2025-08-16] - [2025-08-31]'),
(437, '2025-09-10 10:55:23', 'admin', 'Payroll created by: admin. Cutoff: 1. Date range: [2025-09-01] - [2025-09-15]'),
(438, '2025-09-10 12:11:09', 'admin', 'Payroll created by: admin. Cutoff: 2. Date range: [2025-08-16] - [2025-08-31]');

-- --------------------------------------------------------

--
-- Table structure for table `base_pay`
--

CREATE TABLE `base_pay` (
  `id` int(11) NOT NULL,
  `base_pay` varchar(11) NOT NULL,
  `active` varchar(5) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `base_pay`
--

INSERT INTO `base_pay` (`id`, `base_pay`, `active`) VALUES
(1, '3750', 'yes'),
(2, '6500', 'no'),
(3, '7500', 'no'),
(5, '8500', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `amount` varchar(11) NOT NULL,
  `pay_per_cut_off` varchar(11) NOT NULL,
  `number_of_cutoffs` varchar(11) NOT NULL,
  `balance` varchar(11) NOT NULL,
  `empid` varchar(11) NOT NULL,
  `employee_id` varchar(11) NOT NULL,
  `date_advance` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashadvance_history`
--

CREATE TABLE `cashadvance_history` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(100) NOT NULL,
  `loan` varchar(100) NOT NULL,
  `paid` varchar(100) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `employeer_contribution` varchar(20) NOT NULL,
  `employee_contribution` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `description`, `employeer_contribution`, `employee_contribution`) VALUES
(1, 'SSS', '0.095', '0.045'),
(2, 'Pagibig', '200', '200'),
(3, 'PhilHealth', '0.025', '0.025');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `bloodtype` varchar(5) NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `position_id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `fb` varchar(50) NOT NULL,
  `civil_status` varchar(50) NOT NULL,
  `sss` varchar(50) NOT NULL,
  `sss_deduction` varchar(11) DEFAULT NULL,
  `tin_deduction` varchar(11) DEFAULT NULL,
  `philhealth_deduction` varchar(11) DEFAULT NULL,
  `pagibig_deduction` varchar(11) DEFAULT NULL,
  `tin` varchar(50) NOT NULL,
  `pagibig` varchar(50) NOT NULL,
  `philhealth` varchar(50) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `contact_person_address` varchar(100) NOT NULL,
  `contact_person_number` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `bank_services` varchar(50) NOT NULL,
  `bank_account` varchar(50) NOT NULL,
  `gcash` varchar(50) NOT NULL,
  `archive` varchar(20) NOT NULL DEFAULT 'no',
  `assigned_status` varchar(2) NOT NULL DEFAULT '0',
  `reg_rel_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `firstname`, `lastname`, `nickname`, `address`, `birthdate`, `bloodtype`, `contact_info`, `gender`, `position_id`, `photo`, `created_on`, `email`, `fb`, `civil_status`, `sss`, `sss_deduction`, `tin_deduction`, `philhealth_deduction`, `pagibig_deduction`, `tin`, `pagibig`, `philhealth`, `contact_person`, `contact_person_address`, `contact_person_number`, `bank_name`, `bank_services`, `bank_account`, `gcash`, `archive`, `assigned_status`, `reg_rel_id`) VALUES
(1, 'VC:2024-001', 'Jhen', 'Bacho', 'Wes', 'USA', '2024-04-19', 'AB+', '09648569565', 'Male', 12, 'profile.jpg', '2024-04-20', 'wesley@gmail.com', 'wesley_wes', 'Single', '9875485748458', '1', '', '3', '2', '', '', '659856526365', 'Fabiano Caruana', 'USA', '09864587586', 'UnionBank', 'Savings', '369875468523', '09658425625', 'no', '0', 1),
(2, 'VC:2024-002', 'Genielyn', 'Gonzales', 'Genielyn', 'Russia', '2024-04-10', 'AB+', '09658462535', 'Male', 9, 'profile.jpg', '2024-04-20', 'garry@gmail.com', 'garry', 'Married', '6859756845111', '1', '', '3', '2', '546875486111', '365245857111', '655874512111', 'Hansmoke Niemann', 'Ambot', '09874565854', 'Maybank Philippines', 'Checking', '987546213584', '09854875154', 'no', '0', 2),
(10, 'VC:2024-003', 'Juan', 'Delacruz', 'juan', 'Kawit', '1999-06-16', 'B+', '03695855566', 'Male', 9, 'profile.jpg', '2024-05-26', 'juan@gmail.com', 'juan', 'Married', '', '', '', '', '', '', '', '', 'Alice', 'Cavite City', '09856558545', 'RCBC', 'Savings', '326566565999', '06598889956', 'yes', '0', 0),
(11, 'VC:2024-004', 'Pedro', 'Penduko', 'Pedro', 'Tejero', '1999-06-16', 'B', '09656565626', 'Female', 8, 'profile.jpg', '2024-05-26', 'pedro@gmail.com', 'peterpan', 'Married', '', '', '', '', '', '', '', '', 'Paul ', 'Kawit', '09865656566', 'China Bank', 'Checking', '656565659965', '09865656266', 'yes', '0', 0),
(12, 'VC:2024-005', 'erge', 'erg', 'erg', 'ergerg', '2024-05-22', 'B', '45345454545', 'Male', 8, '', '2024-05-27', 'dfg@gmail.com', 'ergerg', 'Single', '', '', '', '', '', '', '', '', '456456456', 'hrthrthrth', '54665465644', 'RCBC', 'Checking', '456456456666', '54645654666', 'yes', '0', 2),
(13, 'VC:2024-006', 'rg', 'erg', 'erg', 'egferwg', '2024-06-14', 'A+', '45454555555', 'Male', 12, 'top-10-the-most-beautiful-japanese-actresses.jpg', '2024-06-24', 'er@gmail.com', 'reg', 'Single', '4565656546', '1', '', '3', '2', '411111111111', '111111111111', '111111111111', 'rdfgjgj', 'tyjrj', '56456453454', 'RCBC', 'Savings', '453454545455', '43534545447', 'no', '0', 2);

-- --------------------------------------------------------

--
-- Table structure for table `employee_financial_list`
--

CREATE TABLE `employee_financial_list` (
  `id` int(11) NOT NULL,
  `reimbursement_proof` text NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `base_pay` varchar(11) NOT NULL,
  `salary` varchar(20) NOT NULL,
  `leave_credits` varchar(11) NOT NULL,
  `meal_allowance` varchar(20) NOT NULL,
  `meal_allowance_additional` varchar(12) NOT NULL,
  `incentives_value` varchar(20) NOT NULL,
  `adjustments` varchar(20) NOT NULL,
  `adjustments_additional` varchar(12) NOT NULL,
  `transportation` varchar(20) NOT NULL,
  `transportation_additional` varchar(12) NOT NULL,
  `sss_employeer` varchar(20) NOT NULL,
  `sss_emp` varchar(20) NOT NULL,
  `philhealth_employeer` varchar(20) NOT NULL,
  `philhealth_emp` varchar(20) NOT NULL,
  `pagibig_employeer` varchar(20) NOT NULL,
  `pagibig_emp` varchar(20) NOT NULL,
  `tin_employeer` varchar(20) NOT NULL,
  `tin_emp` varchar(20) NOT NULL,
  `location_id` varchar(50) NOT NULL,
  `ass_sched_fin_date` varchar(20) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_financial_list`
--

INSERT INTO `employee_financial_list` (`id`, `reimbursement_proof`, `employee_id`, `date`, `base_pay`, `salary`, `leave_credits`, `meal_allowance`, `meal_allowance_additional`, `incentives_value`, `adjustments`, `adjustments_additional`, `transportation`, `transportation_additional`, `sss_employeer`, `sss_emp`, `philhealth_employeer`, `philhealth_emp`, `pagibig_employeer`, `pagibig_emp`, `tin_employeer`, `tin_emp`, `location_id`, `ass_sched_fin_date`, `status`) VALUES
(1, '', 'VC:2024-001', '2025-07-15', '7500', '625', '5', '0', '', '600.02', '0', '', '0', '', '0.095', '0.045', '0.025', '.025', '200', '200', '', '', '1', '07-15-2025', 0),
(2, '', 'VC:2024-002', '2025-07-15', '8500', '708.33', '5', '0', '', '684.68', '0', '', '0', '', '0.095', '0.045', '0.025', '.025', '200', '200', '', '', '2', '07-15-2025', 0),
(3, '', 'VC:2024-002', '2025-07-20', '8500', '708.33', '5', '0', '', '197.94', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '5', '07-20-2025', 0),
(4, '', 'VC:2024-006', '2025-08-13', '10000', '833.33', '5', '0', '', '600.02', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '1', '08-13-2025', 0),
(5, '', 'VC:2024-006', '2025-07-16', '10000', '833.33', '5', '0', '', '600.02', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '1', '08-13-2025', 0),
(6, '', 'VC:2024-001', '2025-09-08', '10000', '833.33', '5', '0', '', '600.02', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '1', '09-08-2025', 0),
(7, '', 'VC:2024-001', '2025-08-17', '10000', '833.33', '5', '0', '', '600.02', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '1', '09-08-2025', 0),
(8, '', 'VC:2024-001', '2025-08-18', '10000', '833.33', '5', '0', '', '684.68', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '2', '09-09-2025', 0),
(9, '', 'VC:2024-001', '2025-08-19', '10000', '833.33', '5', '0', '', '630', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '3', '09-09-2025', 0),
(10, '', 'VC:2024-001', '2025-08-17', '10000', '833.33', '5', '0', '', '600.02', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '1', '09-10-2025', 0),
(11, '', 'VC:2024-001', '2025-09-08', '10000', '833.33', '5', '0', '', '600.02', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '1', '09-10-2025', 0),
(12, '', 'VC:2024-001', '2025-08-16', '10000', '833.33', '5', '0', '', '600.02', '0', '', '0', '', '0.095', '0.045', '0.025', '0.025', '200', '200', '', '', '1', '09-10-2025', 0);

-- --------------------------------------------------------

--
-- Table structure for table `income_tax`
--

CREATE TABLE `income_tax` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `first_bracket` varchar(15) NOT NULL,
  `second_bracket` varchar(15) NOT NULL,
  `tax_rate` varchar(5) DEFAULT NULL,
  `gross-income` varchar(11) NOT NULL,
  `tax-rate` varchar(11) NOT NULL,
  `income-tax` varchar(11) NOT NULL,
  `calculation_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income_tax`
--

INSERT INTO `income_tax` (`id`, `employee_id`, `first_bracket`, `second_bracket`, `tax_rate`, `gross-income`, `tax-rate`, `income-tax`, `calculation_date`) VALUES
(1, '', '0', '250000', '0', '', '', '', ''),
(2, '', '250000', '400000', '.15', '', '', '', ''),
(4, '', '400000', '800000', '.20', '', '', '', ''),
(5, '', '800000', '2000000', '.25', '', '', '', ''),
(6, '', '2000000', '8000000', '.30', '', '', '', ''),
(7, '', '8000000', 'Above', '.35', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `province` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `incentives` varchar(11) NOT NULL,
  `doc` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `location_archive` varchar(3) NOT NULL DEFAULT 'no',
  `date` varchar(50) NOT NULL DEFAULT '2024-04-19'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `province`, `municipality`, `incentives`, `doc`, `status`, `location_archive`, `date`) VALUES
(1, 'Cavite', 'Kawit', '.02', '30001', 1, 'no', '2025-07-15'),
(2, 'Indang', 'Cavite', '.02', '34234', 1, 'no', '2025-07-15'),
(3, 'Cavite', 'Wealth core', '.03', '21000', 1, 'no', '2025-07-15'),
(4, 'Manila', 'Bulacan', '.02', '23423', 1, 'no', '2025-07-15'),
(5, 'Cavite', 'Danson', '.02', '9897', 1, 'no', '2025-07-15'),
(6, 'Antipolo', 'Rizal', '.02', '32000', 1, 'no', '2025-07-15'),
(7, 'Cabiao', 'Laguna', '.02', '31123', 1, 'no', '2025-07-15'),
(48, 'Cagayan', 'Aparri', '345', '345', 1, 'yes', '2025-07-15');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_employee`
--

CREATE TABLE `payroll_employee` (
  `id` int(11) NOT NULL,
  `payroll_number` varchar(100) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `date_range` varchar(50) NOT NULL,
  `salary` varchar(50) NOT NULL,
  `meal_allowance` varchar(50) NOT NULL,
  `incentives` varchar(50) NOT NULL,
  `adjustments` varchar(50) NOT NULL,
  `transportation` varchar(50) NOT NULL,
  `sss` varchar(20) NOT NULL,
  `sss_employeer` varchar(11) NOT NULL,
  `pagibig` varchar(20) NOT NULL,
  `pagibig_employeer` varchar(11) NOT NULL,
  `tin` varchar(20) NOT NULL,
  `tin_employeer` varchar(11) NOT NULL,
  `philhealth` varchar(20) NOT NULL,
  `philhealth_employeer` varchar(11) NOT NULL,
  `cashadvance` varchar(11) NOT NULL,
  `pay_per_cut_off` varchar(11) NOT NULL,
  `cashadvance_balance` varchar(11) NOT NULL,
  `total_deduction` varchar(20) NOT NULL,
  `_13th` varchar(11) NOT NULL,
  `bonus` varchar(11) NOT NULL,
  `gross` varchar(20) NOT NULL,
  `net_salary` varchar(20) NOT NULL,
  `net_salary_after` varchar(20) NOT NULL,
  `num_days_work` varchar(20) NOT NULL,
  `workdays_total` varchar(11) NOT NULL,
  `num_of_absent` varchar(11) NOT NULL,
  `remaining_credits` varchar(11) NOT NULL,
  `created_on` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll_employee`
--

INSERT INTO `payroll_employee` (`id`, `payroll_number`, `employee_id`, `date_range`, `salary`, `meal_allowance`, `incentives`, `adjustments`, `transportation`, `sss`, `sss_employeer`, `pagibig`, `pagibig_employeer`, `tin`, `tin_employeer`, `philhealth`, `philhealth_employeer`, `cashadvance`, `pay_per_cut_off`, `cashadvance_balance`, `total_deduction`, `_13th`, `bonus`, `gross`, `net_salary`, `net_salary_after`, `num_days_work`, `workdays_total`, `num_of_absent`, `remaining_credits`, `created_on`, `status`) VALUES
(16, '', 'VC:2024-001', '[2025-08-16] - [2025-08-31]', '3333.32', '0', '3114.74', '0', '0', '500', '1010', '0', '200', '0', '', '250', '250', '0', '0', '0', '750', '', '', '6448.06', '5698.06', '', '4', '1', '0', '5', '2025-09-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_summary`
--

CREATE TABLE `payroll_summary` (
  `id` int(11) NOT NULL,
  `date_range` varchar(100) NOT NULL,
  `num_work_days` varchar(11) NOT NULL,
  `total_deduction` varchar(15) NOT NULL,
  `gross` varchar(15) NOT NULL,
  `net_salary` varchar(15) NOT NULL,
  `created_on` varchar(100) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `base_pay` varchar(11) NOT NULL,
  `leave_credits` varchar(11) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `description`, `base_pay`, `leave_credits`, `rate`) VALUES
(8, 'Technician', '7500', '5', 625),
(9, 'vaccinator', '8500', '5', 708.33),
(12, 'manager', '10000', '5', 833.33);

-- --------------------------------------------------------

--
-- Table structure for table `reg_rel`
--

CREATE TABLE `reg_rel` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reg_rel`
--

INSERT INTO `reg_rel` (`id`, `title`) VALUES
(1, 'Regular'),
(2, 'Reliever');

-- --------------------------------------------------------

--
-- Table structure for table `salary_calculation`
--

CREATE TABLE `salary_calculation` (
  `id` int(11) NOT NULL,
  `date_hatch` varchar(20) NOT NULL,
  `total_doc` varchar(50) NOT NULL,
  `incentives` varchar(50) NOT NULL,
  `incentives_value` varchar(20) NOT NULL,
  `xtmeal_allowance` varchar(20) NOT NULL,
  `meal_allowance` varchar(20) NOT NULL,
  `crew` varchar(20) NOT NULL,
  `total_cost` varchar(20) NOT NULL,
  `location_id` int(11) NOT NULL,
  `salary_calculation_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_computed`
--

CREATE TABLE `salary_computed` (
  `id` int(11) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `date_from` varchar(20) NOT NULL,
  `date_to` varchar(20) NOT NULL,
  `com_doc` varchar(20) NOT NULL,
  `com_incentives` varchar(20) NOT NULL,
  `com_incentives_value` varchar(20) NOT NULL,
  `com_xtmeal_allowance` varchar(20) NOT NULL,
  `com_meal_allowance` varchar(20) NOT NULL,
  `com_crew` varchar(20) NOT NULL,
  `com_total_cost` varchar(20) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `day` varchar(20) NOT NULL,
  `day_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `time_in`, `time_out`, `day`, `day_value`) VALUES
(1, '16:00:00', '16:00:00', 'monday', 1),
(2, '16:00:00', '16:00:00', 'tuesday', 2),
(3, '16:00:00', '16:00:00', 'thursday', 3),
(4, '16:00:00', '16:00:00', 'wednesday', 4),
(5, '16:00:00', '16:00:00', 'friday', 5),
(6, '16:00:00', '16:00:00', 'saturday', 6);

-- --------------------------------------------------------

--
-- Table structure for table `sss_contribution_schedule`
--

CREATE TABLE `sss_contribution_schedule` (
  `id` int(11) NOT NULL,
  `min_compensation` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_compensation` decimal(10,2) NOT NULL DEFAULT 0.00,
  `regular_ss_employer` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mpf_employer` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ec_employer` decimal(10,2) NOT NULL DEFAULT 0.00,
  `regular_ss_employee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mpf_employee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sss_contribution_schedule`
--

INSERT INTO `sss_contribution_schedule` (`id`, `min_compensation`, `max_compensation`, `regular_ss_employer`, `mpf_employer`, `ec_employer`, `regular_ss_employee`, `mpf_employee`, `active`, `created_on`, `updated_on`) VALUES
(1, 0.00, 5249.99, 500.00, 0.00, 10.00, 250.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(2, 5250.00, 5749.99, 550.00, 0.00, 10.00, 275.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:33:47'),
(3, 5750.00, 6249.99, 600.00, 0.00, 10.00, 300.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(4, 6250.00, 6749.99, 650.00, 0.00, 10.00, 325.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(5, 6750.00, 7249.99, 700.00, 0.00, 10.00, 350.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(6, 7250.00, 7749.99, 750.00, 0.00, 10.00, 375.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(7, 7750.00, 8249.99, 800.00, 0.00, 10.00, 400.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(8, 8250.00, 8749.99, 850.00, 0.00, 10.00, 425.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(9, 8750.00, 9249.99, 900.00, 0.00, 10.00, 450.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(10, 9250.00, 9749.99, 950.00, 0.00, 10.00, 475.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(11, 9750.00, 10249.99, 1000.00, 0.00, 10.00, 500.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(12, 10250.00, 10749.99, 1050.00, 0.00, 10.00, 525.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(13, 10750.00, 11249.99, 1100.00, 0.00, 10.00, 550.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(14, 11250.00, 11749.99, 1150.00, 0.00, 10.00, 575.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(15, 11750.00, 12249.99, 1200.00, 0.00, 10.00, 600.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(16, 12250.00, 12749.99, 1250.00, 0.00, 10.00, 625.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(17, 12750.00, 13249.99, 1300.00, 0.00, 10.00, 650.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(18, 13250.00, 13749.99, 1350.00, 0.00, 10.00, 675.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(19, 13750.00, 14249.99, 1400.00, 0.00, 10.00, 700.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(20, 14250.00, 14749.99, 1450.00, 0.00, 10.00, 725.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(21, 14750.00, 15249.99, 1500.00, 0.00, 30.00, 750.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(22, 15250.00, 15749.99, 1550.00, 0.00, 30.00, 775.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(23, 15750.00, 16249.99, 1600.00, 0.00, 30.00, 800.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(24, 16250.00, 16749.99, 1650.00, 0.00, 30.00, 825.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(25, 16750.00, 17249.99, 1700.00, 0.00, 30.00, 850.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(26, 17250.00, 17749.99, 1750.00, 0.00, 30.00, 875.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(27, 17750.00, 18249.99, 1800.00, 0.00, 30.00, 900.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(28, 18250.00, 18749.99, 1850.00, 0.00, 30.00, 925.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(29, 18750.00, 19249.99, 1900.00, 0.00, 30.00, 950.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(30, 19250.00, 19749.99, 1950.00, 0.00, 30.00, 975.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(31, 19750.00, 20249.99, 2000.00, 0.00, 30.00, 1000.00, 0.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(32, 20250.00, 20749.99, 2000.00, 50.00, 30.00, 1000.00, 25.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(33, 20750.00, 21249.99, 2000.00, 100.00, 30.00, 1000.00, 50.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(34, 21250.00, 21749.99, 2000.00, 150.00, 30.00, 1000.00, 75.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(35, 21750.00, 22249.99, 2000.00, 200.00, 30.00, 1000.00, 100.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(36, 22250.00, 22749.99, 2000.00, 250.00, 30.00, 1000.00, 125.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(37, 22750.00, 23249.99, 2000.00, 300.00, 30.00, 1000.00, 150.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(38, 23250.00, 23749.99, 2000.00, 350.00, 30.00, 1000.00, 175.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(39, 23750.00, 24249.99, 2000.00, 400.00, 30.00, 1000.00, 200.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(40, 24250.00, 24749.99, 2000.00, 450.00, 30.00, 1000.00, 225.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(41, 24750.00, 25249.99, 2000.00, 500.00, 30.00, 1000.00, 250.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(42, 25250.00, 25749.99, 2000.00, 550.00, 30.00, 1000.00, 275.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(43, 25750.00, 26249.99, 2000.00, 600.00, 30.00, 1000.00, 300.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(44, 26250.00, 26749.99, 2000.00, 650.00, 30.00, 1000.00, 325.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(45, 26750.00, 27249.99, 2000.00, 700.00, 30.00, 1000.00, 350.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(46, 27250.00, 27749.99, 2000.00, 750.00, 30.00, 1000.00, 375.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(47, 27750.00, 28249.99, 2000.00, 800.00, 30.00, 1000.00, 400.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(48, 28250.00, 28749.99, 2000.00, 850.00, 30.00, 1000.00, 425.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(49, 28750.00, 29249.99, 2000.00, 900.00, 30.00, 1000.00, 450.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(50, 29250.00, 29749.99, 2000.00, 950.00, 30.00, 1000.00, 475.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(51, 29750.00, 30249.99, 2000.00, 1000.00, 30.00, 1000.00, 500.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(52, 30250.00, 30749.99, 2000.00, 1050.00, 30.00, 1000.00, 525.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(53, 30750.00, 31249.99, 2000.00, 1100.00, 30.00, 1000.00, 550.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(54, 31250.00, 31749.99, 2000.00, 1150.00, 30.00, 1000.00, 575.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(55, 31750.00, 32249.99, 2000.00, 1200.00, 30.00, 1000.00, 600.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(56, 32250.00, 32749.99, 2000.00, 1250.00, 30.00, 1000.00, 625.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(57, 32750.00, 33249.99, 2000.00, 1300.00, 30.00, 1000.00, 650.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(58, 33250.00, 33749.99, 2000.00, 1350.00, 30.00, 1000.00, 675.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(59, 33750.00, 34249.99, 2000.00, 1400.00, 30.00, 1000.00, 700.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(60, 34250.00, 34749.99, 2000.00, 1450.00, 30.00, 1000.00, 725.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57'),
(61, 34750.00, 999999.99, 2000.00, 1500.00, 30.00, 1000.00, 750.00, 'yes', '2025-09-03 06:09:57', '2025-09-03 06:09:57');

-- --------------------------------------------------------

--
-- Stand-in structure for view `sss_contribution_view`
-- (See below for the actual view)
--
CREATE TABLE `sss_contribution_view` (
`id` int(11)
,`min_compensation` decimal(10,2)
,`max_compensation` decimal(10,2)
,`regular_ss_employer` decimal(10,2)
,`mpf_employer` decimal(10,2)
,`ec_employer` decimal(10,2)
,`employer_total` decimal(12,2)
,`regular_ss_employee` decimal(10,2)
,`mpf_employee` decimal(10,2)
,`employee_total` decimal(11,2)
,`grand_total` decimal(14,2)
,`active` enum('yes','no')
,`created_on` timestamp
,`updated_on` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_role_id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_on` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `firstname`, `lastname`, `username`, `password`, `access_role_id`, `photo`, `created_on`) VALUES
(1, 'staff', 'staff', 'staff', '1111', 2, '8190c5ae-738d-4a5a-bb23-9298ec066a76(1).jpg', '2024-04-03');

-- --------------------------------------------------------

--
-- Table structure for table `system_lock`
--

CREATE TABLE `system_lock` (
  `id` int(11) NOT NULL,
  `status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_lock`
--

INSERT INTO `system_lock` (`id`, `status`) VALUES
(12345, 'off');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `access_role` varchar(20) NOT NULL,
  `sec_1` varchar(100) NOT NULL,
  `ans_1` varchar(100) NOT NULL,
  `sec_2` varchar(100) NOT NULL,
  `ans_2` varchar(100) NOT NULL,
  `sec_3` varchar(100) NOT NULL,
  `ans_3` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `access_role`, `sec_1`, `ans_1`, `sec_2`, `ans_2`, `sec_3`, `ans_3`) VALUES
(1, 'admin', 'secq1a', 'whitey', 'secq1b', 'nenita', 'secq3c', '8'),
(2, 'staff', '', '', '', '', '', ''),
(3, 'super admin', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `wage`
--

CREATE TABLE `wage` (
  `id` int(11) NOT NULL,
  `current_wage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wage`
--

INSERT INTO `wage` (`id`, `current_wage`) VALUES
(1, '500');

-- --------------------------------------------------------

--
-- Table structure for table `_13th_pay`
--

CREATE TABLE `_13th_pay` (
  `id` int(11) NOT NULL,
  `date_range` varchar(20) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `net_salary` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `_13th_pay`
--

INSERT INTO `_13th_pay` (`id`, `date_range`, `employee_id`, `net_salary`, `date`) VALUES
(3, '[2024-05-01] - [2024', 'VC:2024-001', '7004.68', '2024-05-29'),
(4, '[2024-05-01] - [2024', 'VC:2024-002', '46926.16', '2024-05-29');

-- --------------------------------------------------------

--
-- Table structure for table `_session`
--

CREATE TABLE `_session` (
  `id` int(11) NOT NULL,
  `sesh` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `_session`
--

INSERT INTO `_session` (`id`, `sesh`) VALUES
(1, 3600);

-- --------------------------------------------------------

--
-- Structure for view `sss_contribution_view`
--
DROP TABLE IF EXISTS `sss_contribution_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sss_contribution_view`  AS SELECT `sss_contribution_schedule`.`id` AS `id`, `sss_contribution_schedule`.`min_compensation` AS `min_compensation`, `sss_contribution_schedule`.`max_compensation` AS `max_compensation`, `sss_contribution_schedule`.`regular_ss_employer` AS `regular_ss_employer`, `sss_contribution_schedule`.`mpf_employer` AS `mpf_employer`, `sss_contribution_schedule`.`ec_employer` AS `ec_employer`, `sss_contribution_schedule`.`regular_ss_employer`+ `sss_contribution_schedule`.`mpf_employer` + `sss_contribution_schedule`.`ec_employer` AS `employer_total`, `sss_contribution_schedule`.`regular_ss_employee` AS `regular_ss_employee`, `sss_contribution_schedule`.`mpf_employee` AS `mpf_employee`, `sss_contribution_schedule`.`regular_ss_employee`+ `sss_contribution_schedule`.`mpf_employee` AS `employee_total`, `sss_contribution_schedule`.`regular_ss_employer`+ `sss_contribution_schedule`.`mpf_employer` + `sss_contribution_schedule`.`ec_employer` + `sss_contribution_schedule`.`regular_ss_employee` + `sss_contribution_schedule`.`mpf_employee` AS `grand_total`, `sss_contribution_schedule`.`active` AS `active`, `sss_contribution_schedule`.`created_on` AS `created_on`, `sss_contribution_schedule`.`updated_on` AS `updated_on` FROM `sss_contribution_schedule` WHERE `sss_contribution_schedule`.`active` = 'yes' ORDER BY `sss_contribution_schedule`.`min_compensation` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approval`
--
ALTER TABLE `approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ass_sched_fin`
--
ALTER TABLE `ass_sched_fin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `base_pay`
--
ALTER TABLE `base_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashadvance_history`
--
ALTER TABLE `cashadvance_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_financial_list`
--
ALTER TABLE `employee_financial_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_tax`
--
ALTER TABLE `income_tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_employee`
--
ALTER TABLE `payroll_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_summary`
--
ALTER TABLE `payroll_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reg_rel`
--
ALTER TABLE `reg_rel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_calculation`
--
ALTER TABLE `salary_calculation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_computed`
--
ALTER TABLE `salary_computed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sss_contribution_schedule`
--
ALTER TABLE `sss_contribution_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_compensation_range` (`min_compensation`,`max_compensation`),
  ADD KEY `idx_active` (`active`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_lock`
--
ALTER TABLE `system_lock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wage`
--
ALTER TABLE `wage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_13th_pay`
--
ALTER TABLE `_13th_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_session`
--
ALTER TABLE `_session`
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
-- AUTO_INCREMENT for table `approval`
--
ALTER TABLE `approval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ass_sched_fin`
--
ALTER TABLE `ass_sched_fin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;

--
-- AUTO_INCREMENT for table `base_pay`
--
ALTER TABLE `base_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cashadvance_history`
--
ALTER TABLE `cashadvance_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee_financial_list`
--
ALTER TABLE `employee_financial_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `income_tax`
--
ALTER TABLE `income_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `payroll_employee`
--
ALTER TABLE `payroll_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payroll_summary`
--
ALTER TABLE `payroll_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reg_rel`
--
ALTER TABLE `reg_rel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `salary_calculation`
--
ALTER TABLE `salary_calculation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `salary_computed`
--
ALTER TABLE `salary_computed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sss_contribution_schedule`
--
ALTER TABLE `sss_contribution_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_lock`
--
ALTER TABLE `system_lock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12347;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wage`
--
ALTER TABLE `wage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `_13th_pay`
--
ALTER TABLE `_13th_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `_session`
--
ALTER TABLE `_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
