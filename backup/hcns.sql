-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2014 at 09:42 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `templates`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_code` varchar(50) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort_order` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_code`, `name`, `sort_order`, `deleted`) VALUES
(1, 'NS', 'Nhân sự', 2, 0),
(2, 'KT', 'Kế toán', 1, 0),
(3, 'BH', 'Bán hàng', 3, 0),
(4, 'TK', 'Thư ký', 4, 0),
(5, 'SX', 'Sản xuất', 5, 0),
(6, 'IT', 'Kỹ Thuật', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `salary_type`
--

CREATE TABLE IF NOT EXISTS `salary_type` (
  `salary_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `percent_of_salary` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`salary_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `salary_type`
--

INSERT INTO `salary_type` (`salary_type_id`, `name`, `percent_of_salary`, `sort_order`, `deleted`) VALUES
(1, 'Salary 1', 20, 1, 0),
(2, 'Salary 2', 35, 2, 0),
(3, 'Salary 3', 45, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_code` varchar(30) NOT NULL,
  `firstname` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `middlename` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lastname` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `birthday` date NOT NULL,
  `salary` float NOT NULL,
  `salary_trial` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `staff_code` (`staff_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_code`, `firstname`, `middlename`, `lastname`, `birthday`, `salary`, `salary_trial`, `image`, `department_id`, `part_id`, `position_id`, `deleted`) VALUES
(1, '0002', 'Nguyễn', 'Thị', 'A', '1990-08-13', 3000000, 2400000, '', 1, 0, 0, 0),
(2, '0001', 'Huỳnh', 'Tuấn', 'B', '1990-07-15', 5000000, 4000000, '', 2, 0, 0, 0),
(3, '0003', 'Trần', 'Văn', 'C', '1990-08-15', 7000000, 5600000, 'data/07-150x150h.jpg', 3, 0, 0, 0),
(4, '0004', 'Lưu', 'Quang', 'Thi', '1990-08-13', 9000000, 7200000, '', 6, 0, 0, 0),
(5, '0005', 'Ngô', 'Văn', 'D', '1990-06-23', 8000000, 6400000, '', 6, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
