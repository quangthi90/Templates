-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2014 at 12:05 PM
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

INSERT INTO `staff` (`staff_id`, `staff_code`, `firstname`, `middlename`, `lastname`, `birthday`, `birthplace_id`, `sex`, `address`, `salary`, `salary_trial`, `image`, `department_id`, `part_id`, `position_id`, `deleted`) VALUES
(1, '0002', 'Nguyễn', 'Thị', 'A', '1990-08-13', 0, 0, '', 3000000, 2400000, '', 1, 0, 0, 0),
(2, '0001', 'Huỳnh', 'Tuấn', 'B', '1990-07-15', 0, 1, 'abc xyz xxx', 5000000, 4000000, '', 2, 0, 0, 0),
(3, '0003', 'Trần', 'Văn', 'C', '1990-08-15', 0, 0, '', 7000000, 5600000, 'data/07-150x150h.jpg', 3, 0, 0, 0),
(4, '0004', 'Lưu', 'Quang', 'Thi', '1990-08-13', 2, 0, '129/6/5 Lê Văn Thọ, F11, Gò Vấp, HCM', 9000000, 7200000, '', 6, 0, 0, 0),
(5, '0005', 'Ngô', 'Văn', 'D', '1990-06-23', 0, 0, '', 8000000, 6400000, '', 6, 0, 0, 0),
(7, '0006', 'Trần', 'Quốc', 'E', '1977-08-12', 0, 0, '', 10000000, 8000000, '', 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`user_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`user_group_id`, `name`, `permission`) VALUES
(1, 'Top Administrator', 'a:2:{s:6:"access";a:161:{i:0;s:17:"catalog/attribute";i:1;s:23:"catalog/attribute_group";i:2;s:16:"catalog/category";i:3;s:16:"catalog/download";i:4;s:14:"catalog/filter";i:5;s:19:"catalog/information";i:6;s:20:"catalog/manufacturer";i:7;s:14:"catalog/option";i:8;s:15:"catalog/product";i:9;s:15:"catalog/profile";i:10;s:14:"catalog/review";i:11;s:18:"common/filemanager";i:12;s:17:"config/birthplace";i:13;s:11:"config/folk";i:14;s:21:"department/department";i:15;s:13:"design/banner";i:16;s:19:"design/custom_field";i:17;s:13:"design/layout";i:18;s:14:"extension/feed";i:19;s:17:"extension/manager";i:20;s:16:"extension/module";i:21;s:17:"extension/openbay";i:22;s:17:"extension/payment";i:23;s:18:"extension/shipping";i:24;s:15:"extension/total";i:25;s:16:"feed/google_base";i:26;s:19:"feed/google_sitemap";i:27;s:20:"localisation/country";i:28;s:21:"localisation/currency";i:29;s:21:"localisation/geo_zone";i:30;s:21:"localisation/language";i:31;s:25:"localisation/length_class";i:32;s:25:"localisation/order_status";i:33;s:26:"localisation/return_action";i:34;s:26:"localisation/return_reason";i:35;s:26:"localisation/return_status";i:36;s:25:"localisation/stock_status";i:37;s:22:"localisation/tax_class";i:38;s:21:"localisation/tax_rate";i:39;s:25:"localisation/weight_class";i:40;s:17:"localisation/zone";i:41;s:14:"module/account";i:42;s:16:"module/affiliate";i:43;s:29:"module/amazon_checkout_layout";i:44;s:13:"module/banner";i:45;s:17:"module/bestseller";i:46;s:15:"module/carousel";i:47;s:15:"module/category";i:48;s:18:"module/ebaydisplay";i:49;s:15:"module/featured";i:50;s:13:"module/filter";i:51;s:18:"module/google_talk";i:52;s:18:"module/information";i:53;s:13:"module/latest";i:54;s:17:"module/openbaypro";i:55;s:16:"module/pp_layout";i:56;s:19:"module/rgen_banners";i:57;s:25:"module/rgen_contentblocks";i:58;s:18:"module/rgen_custom";i:59;s:26:"module/rgen_customproducts";i:60;s:19:"module/rgen_gallery";i:61;s:23:"module/rgen_gridmanager";i:62;s:20:"module/rgen_megamenu";i:63;s:22:"module/rgen_revoslider";i:64;s:27:"module/rgen_simpleslideshow";i:65;s:17:"module/rgen_theme";i:66;s:16:"module/slideshow";i:67;s:14:"module/special";i:68;s:12:"module/store";i:69;s:14:"module/welcome";i:70;s:14:"openbay/amazon";i:71;s:22:"openbay/amazon_listing";i:72;s:22:"openbay/amazon_product";i:73;s:16:"openbay/amazonus";i:74;s:24:"openbay/amazonus_listing";i:75;s:24:"openbay/amazonus_product";i:76;s:20:"openbay/ebay_profile";i:77;s:21:"openbay/ebay_template";i:78;s:15:"openbay/openbay";i:79;s:23:"payment/amazon_checkout";i:80;s:24:"payment/authorizenet_aim";i:81;s:21:"payment/bank_transfer";i:82;s:14:"payment/cheque";i:83;s:11:"payment/cod";i:84;s:21:"payment/free_checkout";i:85;s:22:"payment/klarna_account";i:86;s:22:"payment/klarna_invoice";i:87;s:14:"payment/liqpay";i:88;s:20:"payment/moneybookers";i:89;s:14:"payment/nochex";i:90;s:15:"payment/paymate";i:91;s:16:"payment/paypoint";i:92;s:13:"payment/payza";i:93;s:26:"payment/perpetual_payments";i:94;s:18:"payment/pp_express";i:95;s:25:"payment/pp_payflow_iframe";i:96;s:14:"payment/pp_pro";i:97;s:21:"payment/pp_pro_iframe";i:98;s:17:"payment/pp_pro_pf";i:99;s:17:"payment/pp_pro_uk";i:100;s:19:"payment/pp_standard";i:101;s:15:"payment/sagepay";i:102;s:22:"payment/sagepay_direct";i:103;s:18:"payment/sagepay_us";i:104;s:19:"payment/twocheckout";i:105;s:28:"payment/web_payment_software";i:106;s:16:"payment/worldpay";i:107;s:27:"report/affiliate_commission";i:108;s:22:"report/customer_credit";i:109;s:22:"report/customer_online";i:110;s:21:"report/customer_order";i:111;s:22:"report/customer_reward";i:112;s:24:"report/product_purchased";i:113;s:21:"report/product_viewed";i:114;s:18:"report/sale_coupon";i:115;s:17:"report/sale_order";i:116;s:18:"report/sale_return";i:117;s:20:"report/sale_shipping";i:118;s:15:"report/sale_tax";i:119;s:11:"salary/type";i:120;s:14:"sale/affiliate";i:121;s:12:"sale/contact";i:122;s:11:"sale/coupon";i:123;s:13:"sale/customer";i:124;s:20:"sale/customer_ban_ip";i:125;s:19:"sale/customer_group";i:126;s:10:"sale/order";i:127;s:14:"sale/recurring";i:128;s:11:"sale/return";i:129;s:12:"sale/voucher";i:130;s:18:"sale/voucher_theme";i:131;s:15:"setting/setting";i:132;s:13:"setting/store";i:133;s:16:"shipping/auspost";i:134;s:17:"shipping/citylink";i:135;s:14:"shipping/fedex";i:136;s:13:"shipping/flat";i:137;s:13:"shipping/free";i:138;s:13:"shipping/item";i:139;s:23:"shipping/parcelforce_48";i:140;s:15:"shipping/pickup";i:141;s:19:"shipping/royal_mail";i:142;s:12:"shipping/ups";i:143;s:13:"shipping/usps";i:144;s:15:"shipping/weight";i:145;s:11:"staff/staff";i:146;s:11:"tool/backup";i:147;s:14:"tool/error_log";i:148;s:12:"total/coupon";i:149;s:12:"total/credit";i:150;s:14:"total/handling";i:151;s:16:"total/klarna_fee";i:152;s:19:"total/low_order_fee";i:153;s:12:"total/reward";i:154;s:14:"total/shipping";i:155;s:15:"total/sub_total";i:156;s:9:"total/tax";i:157;s:11:"total/total";i:158;s:13:"total/voucher";i:159;s:9:"user/user";i:160;s:20:"user/user_permission";}s:6:"modify";a:161:{i:0;s:17:"catalog/attribute";i:1;s:23:"catalog/attribute_group";i:2;s:16:"catalog/category";i:3;s:16:"catalog/download";i:4;s:14:"catalog/filter";i:5;s:19:"catalog/information";i:6;s:20:"catalog/manufacturer";i:7;s:14:"catalog/option";i:8;s:15:"catalog/product";i:9;s:15:"catalog/profile";i:10;s:14:"catalog/review";i:11;s:18:"common/filemanager";i:12;s:17:"config/birthplace";i:13;s:11:"config/folk";i:14;s:21:"department/department";i:15;s:13:"design/banner";i:16;s:19:"design/custom_field";i:17;s:13:"design/layout";i:18;s:14:"extension/feed";i:19;s:17:"extension/manager";i:20;s:16:"extension/module";i:21;s:17:"extension/openbay";i:22;s:17:"extension/payment";i:23;s:18:"extension/shipping";i:24;s:15:"extension/total";i:25;s:16:"feed/google_base";i:26;s:19:"feed/google_sitemap";i:27;s:20:"localisation/country";i:28;s:21:"localisation/currency";i:29;s:21:"localisation/geo_zone";i:30;s:21:"localisation/language";i:31;s:25:"localisation/length_class";i:32;s:25:"localisation/order_status";i:33;s:26:"localisation/return_action";i:34;s:26:"localisation/return_reason";i:35;s:26:"localisation/return_status";i:36;s:25:"localisation/stock_status";i:37;s:22:"localisation/tax_class";i:38;s:21:"localisation/tax_rate";i:39;s:25:"localisation/weight_class";i:40;s:17:"localisation/zone";i:41;s:14:"module/account";i:42;s:16:"module/affiliate";i:43;s:29:"module/amazon_checkout_layout";i:44;s:13:"module/banner";i:45;s:17:"module/bestseller";i:46;s:15:"module/carousel";i:47;s:15:"module/category";i:48;s:18:"module/ebaydisplay";i:49;s:15:"module/featured";i:50;s:13:"module/filter";i:51;s:18:"module/google_talk";i:52;s:18:"module/information";i:53;s:13:"module/latest";i:54;s:17:"module/openbaypro";i:55;s:16:"module/pp_layout";i:56;s:19:"module/rgen_banners";i:57;s:25:"module/rgen_contentblocks";i:58;s:18:"module/rgen_custom";i:59;s:26:"module/rgen_customproducts";i:60;s:19:"module/rgen_gallery";i:61;s:23:"module/rgen_gridmanager";i:62;s:20:"module/rgen_megamenu";i:63;s:22:"module/rgen_revoslider";i:64;s:27:"module/rgen_simpleslideshow";i:65;s:17:"module/rgen_theme";i:66;s:16:"module/slideshow";i:67;s:14:"module/special";i:68;s:12:"module/store";i:69;s:14:"module/welcome";i:70;s:14:"openbay/amazon";i:71;s:22:"openbay/amazon_listing";i:72;s:22:"openbay/amazon_product";i:73;s:16:"openbay/amazonus";i:74;s:24:"openbay/amazonus_listing";i:75;s:24:"openbay/amazonus_product";i:76;s:20:"openbay/ebay_profile";i:77;s:21:"openbay/ebay_template";i:78;s:15:"openbay/openbay";i:79;s:23:"payment/amazon_checkout";i:80;s:24:"payment/authorizenet_aim";i:81;s:21:"payment/bank_transfer";i:82;s:14:"payment/cheque";i:83;s:11:"payment/cod";i:84;s:21:"payment/free_checkout";i:85;s:22:"payment/klarna_account";i:86;s:22:"payment/klarna_invoice";i:87;s:14:"payment/liqpay";i:88;s:20:"payment/moneybookers";i:89;s:14:"payment/nochex";i:90;s:15:"payment/paymate";i:91;s:16:"payment/paypoint";i:92;s:13:"payment/payza";i:93;s:26:"payment/perpetual_payments";i:94;s:18:"payment/pp_express";i:95;s:25:"payment/pp_payflow_iframe";i:96;s:14:"payment/pp_pro";i:97;s:21:"payment/pp_pro_iframe";i:98;s:17:"payment/pp_pro_pf";i:99;s:17:"payment/pp_pro_uk";i:100;s:19:"payment/pp_standard";i:101;s:15:"payment/sagepay";i:102;s:22:"payment/sagepay_direct";i:103;s:18:"payment/sagepay_us";i:104;s:19:"payment/twocheckout";i:105;s:28:"payment/web_payment_software";i:106;s:16:"payment/worldpay";i:107;s:27:"report/affiliate_commission";i:108;s:22:"report/customer_credit";i:109;s:22:"report/customer_online";i:110;s:21:"report/customer_order";i:111;s:22:"report/customer_reward";i:112;s:24:"report/product_purchased";i:113;s:21:"report/product_viewed";i:114;s:18:"report/sale_coupon";i:115;s:17:"report/sale_order";i:116;s:18:"report/sale_return";i:117;s:20:"report/sale_shipping";i:118;s:15:"report/sale_tax";i:119;s:11:"salary/type";i:120;s:14:"sale/affiliate";i:121;s:12:"sale/contact";i:122;s:11:"sale/coupon";i:123;s:13:"sale/customer";i:124;s:20:"sale/customer_ban_ip";i:125;s:19:"sale/customer_group";i:126;s:10:"sale/order";i:127;s:14:"sale/recurring";i:128;s:11:"sale/return";i:129;s:12:"sale/voucher";i:130;s:18:"sale/voucher_theme";i:131;s:15:"setting/setting";i:132;s:13:"setting/store";i:133;s:16:"shipping/auspost";i:134;s:17:"shipping/citylink";i:135;s:14:"shipping/fedex";i:136;s:13:"shipping/flat";i:137;s:13:"shipping/free";i:138;s:13:"shipping/item";i:139;s:23:"shipping/parcelforce_48";i:140;s:15:"shipping/pickup";i:141;s:19:"shipping/royal_mail";i:142;s:12:"shipping/ups";i:143;s:13:"shipping/usps";i:144;s:15:"shipping/weight";i:145;s:11:"staff/staff";i:146;s:11:"tool/backup";i:147;s:14:"tool/error_log";i:148;s:12:"total/coupon";i:149;s:12:"total/credit";i:150;s:14:"total/handling";i:151;s:16:"total/klarna_fee";i:152;s:19:"total/low_order_fee";i:153;s:12:"total/reward";i:154;s:14:"total/shipping";i:155;s:15:"total/sub_total";i:156;s:9:"total/tax";i:157;s:11:"total/total";i:158;s:13:"total/voucher";i:159;s:9:"user/user";i:160;s:20:"user/user_permission";}}'),
(10, 'Demonstration', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
