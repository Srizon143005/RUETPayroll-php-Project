-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 27, 2018 at 05:29 PM
-- Server version: 10.2.8-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ruet_payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `addition`
--

DROP TABLE IF EXISTS `addition`;
CREATE TABLE IF NOT EXISTS `addition` (
  `add_no` int(10) NOT NULL,
  `add_name` varchar(50) NOT NULL,
  `add_amount` int(10) NOT NULL,
  `add_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`add_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cat_no` int(10) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `cat_basic` int(10) NOT NULL,
  PRIMARY KEY (`cat_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_no`, `cat_name`, `cat_basic`) VALUES
(1, 'Developer', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `deduction`
--

DROP TABLE IF EXISTS `deduction`;
CREATE TABLE IF NOT EXISTS `deduction` (
  `ded_no` int(10) NOT NULL,
  `ded_name` varchar(50) NOT NULL,
  `ded_amount` int(10) NOT NULL,
  `ded_type` varchar(50) NOT NULL,
  PRIMARY KEY (`ded_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `emp_no` int(10) NOT NULL,
  `emp_name` varchar(50) NOT NULL,
  `emp_desig` int(10) NOT NULL,
  `emp_role` varchar(50) NOT NULL,
  `emp_road` varchar(50) NOT NULL,
  `emp_thana` varchar(50) NOT NULL,
  `emp_city` varchar(50) NOT NULL,
  `emp_district` varchar(50) NOT NULL,
  `emp_division` varchar(50) NOT NULL,
  `emp_zip` varchar(50) NOT NULL,
  `emp_phone` varchar(50) NOT NULL,
  `emp_email` varchar(50) NOT NULL,
  `emp_join_day` int(10) NOT NULL,
  `emp_join_month` varchar(50) NOT NULL,
  `emp_join_year` int(10) NOT NULL,
  `emp_password` varchar(50) NOT NULL,
  `emp_image` varchar(50) NOT NULL,
  PRIMARY KEY (`emp_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_no`, `emp_name`, `emp_desig`, `emp_role`, `emp_road`, `emp_thana`, `emp_city`, `emp_district`, `emp_division`, `emp_zip`, `emp_phone`, `emp_email`, `emp_join_day`, `emp_join_month`, `emp_join_year`, `emp_password`, `emp_image`) VALUES
(2, 'Azmain Yakin Srizon', 1, 'Admin', 'Natore Road', 'Matihar', 'Rajshahi', 'Rajshahi', 'Rajshahi', '6612', '01790-187189', 'azmainsrizon@gmail.com', 1, 'October', 2016, '143005', '-1479746884.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary`
--

DROP TABLE IF EXISTS `emp_salary`;
CREATE TABLE IF NOT EXISTS `emp_salary` (
  `emp_no` int(10) NOT NULL,
  `emp_salary` int(10) NOT NULL,
  PRIMARY KEY (`emp_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_salary`
--

INSERT INTO `emp_salary` (`emp_no`, `emp_salary`) VALUES
(2, 30000);

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary_add`
--

DROP TABLE IF EXISTS `emp_salary_add`;
CREATE TABLE IF NOT EXISTS `emp_salary_add` (
  `emp_no` int(10) NOT NULL,
  `add_no` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary_ded`
--

DROP TABLE IF EXISTS `emp_salary_ded`;
CREATE TABLE IF NOT EXISTS `emp_salary_ded` (
  `emp_no` int(10) NOT NULL,
  `ded_no` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

DROP TABLE IF EXISTS `loan`;
CREATE TABLE IF NOT EXISTS `loan` (
  `loan_no` int(10) NOT NULL,
  `emp_no` int(10) NOT NULL,
  `loan_name` varchar(50) NOT NULL,
  `loan_amount` int(10) NOT NULL,
  `loan_time` int(10) NOT NULL,
  `loan_due` int(10) NOT NULL,
  PRIMARY KEY (`loan_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`loan_no`, `emp_no`, `loan_name`, `loan_amount`, `loan_time`, `loan_due`) VALUES
(1, 2, 'LOAN-1', 1240, 10, 1240);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `emp_no` int(10) NOT NULL,
  `for_month` varchar(50) NOT NULL,
  `for_year` int(10) NOT NULL,
  `basic` int(10) NOT NULL,
  `salary_paid` int(10) NOT NULL,
  `paid_or_not` varchar(50) NOT NULL,
  `loan_paid` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
