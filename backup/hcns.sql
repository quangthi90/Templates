-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2014 at 07:25 AM
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
-- Table structure for table `birthplace`
--

CREATE TABLE IF NOT EXISTS `birthplace` (
  `birthplace_id` int(11) NOT NULL AUTO_INCREMENT,
  `birthplace_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort_order` int(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`birthplace_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `birthplace`
--

INSERT INTO `birthplace` (`birthplace_id`, `birthplace_name`, `sort_order`, `deleted`) VALUES
(1, 'Hà Nội', 0, 0),
(2, 'Tp. HCM', 0, 0),
(3, 'Hải Phòng', 1, 0),
(4, 'Điện Biên', 1, 0),
(5, 'Vũng Tàu', 0, 0),
(6, 'Đà Nẵng', 0, 0),
(7, 'Huế', 1, 0),
(8, 'Bến Tre', 1, 0);

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
-- Table structure for table `folk`
--

CREATE TABLE IF NOT EXISTS `folk` (
  `folk_id` int(11) NOT NULL AUTO_INCREMENT,
  `folk_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort_order` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`folk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `folk`
--

INSERT INTO `folk` (`folk_id`, `folk_name`, `sort_order`, `deleted`) VALUES
(1, 'Kinh', 0, 0),
(2, 'Nùng', 1, 0),
(3, 'Mường', 0, 0),
(4, 'Tày', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE IF NOT EXISTS `religion` (
  `religion_id` int(11) NOT NULL AUTO_INCREMENT,
  `religion_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort_order` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`religion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `religion`
--

INSERT INTO `religion` (`religion_id`, `religion_name`, `sort_order`, `deleted`) VALUES
(1, 'Phật', 0, 0),
(2, 'Cao Đài', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `salary_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `salary_type_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`salary_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salary_id`, `staff_id`, `salary_type_id`, `value`, `deleted`) VALUES
(1, 1, 1, 480000, 0),
(2, 1, 2, 840000, 0),
(3, 1, 3, 1080000, 0),
(4, 7, 1, 1000000, 0),
(5, 7, 2, 3500000, 0),
(6, 7, 3, 4500000, 0),
(7, 2, 1, 400000, 0),
(8, 2, 2, 1400000, 0),
(9, 2, 3, 1800000, 0),
(10, 4, 1, 720000, 0),
(11, 4, 2, 2520000, 0),
(12, 4, 3, 3240000, 0);

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
(1, 'Salary 1', 10, 1, 0),
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
  `birthplace_id` int(11) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `salary` float NOT NULL,
  `salary_trial` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `folk_id` int(11) NOT NULL,
  `religion_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `staff_code` (`staff_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_code`, `firstname`, `middlename`, `lastname`, `birthday`, `birthplace_id`, `sex`, `address`, `salary`, `salary_trial`, `image`, `folk_id`, `religion_id`, `department_id`, `part_id`, `position_id`, `deleted`) VALUES
(1, '0002', 'Nguyễn', 'Thị', 'A', '1990-08-13', 0, 0, '', 3000000, 2400000, '', 0, 0, 1, 0, 0, 0),
(2, '0001', 'Huỳnh', 'Tuấn', 'B', '1990-07-15', 0, 1, 'abc xyz xxx', 5000000, 4000000, '', 0, 0, 2, 0, 0, 0),
(3, '0003', 'Trần', 'Văn', 'C', '1990-08-15', 0, 0, '', 7000000, 5600000, 'data/07-150x150h.jpg', 0, 0, 3, 0, 0, 0),
(4, '0004', 'Lưu', 'Quang', 'Thi', '1990-08-13', 2, 0, '129/6/5 Lê Văn Thọ, F11, Gò Vấp, HCM', 9000000, 7200000, '', 1, 1, 6, 0, 0, 0),
(5, '0005', 'Ngô', 'Văn', 'D', '1990-06-23', 0, 0, '', 8000000, 6400000, '', 0, 0, 6, 0, 0, 0),
(7, '0006', 'Trần', 'Quốc', 'E', '1977-08-12', 0, 0, '', 10000000, 8000000, '', 0, 0, 3, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
