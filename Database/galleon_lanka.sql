-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 31, 2020 at 11:07 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `galleon_lanka`
--

-- --------------------------------------------------------

--
-- Table structure for table `bom`
--

DROP TABLE IF EXISTS `bom`;
CREATE TABLE IF NOT EXISTS `bom` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `bom_id` int(11) NOT NULL,
  `mName` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `state` varchar(10) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cash_receipts`
--

DROP TABLE IF EXISTS `cash_receipts`;
CREATE TABLE IF NOT EXISTS `cash_receipts` (
  `cr_no` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` int(11) NOT NULL,
  `cno` int(11) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `amout` float NOT NULL,
  `prepared_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`cr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `creditors`
--

DROP TABLE IF EXISTS `creditors`;
CREATE TABLE IF NOT EXISTS `creditors` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `cno` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `tpno` varchar(20) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  PRIMARY KEY (`cno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `debtors`
--

DROP TABLE IF EXISTS `debtors`;
CREATE TABLE IF NOT EXISTS `debtors` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `cno` int(11) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `eno` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Designation` varchar(20) NOT NULL,
  `Dept` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`eno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `finished_products`
--

DROP TABLE IF EXISTS `finished_products`;
CREATE TABLE IF NOT EXISTS `finished_products` (
  `fp_id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `bom_id` varchar(20) NOT NULL,
  `value` float NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`fp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grn`
--

DROP TABLE IF EXISTS `grn`;
CREATE TABLE IF NOT EXISTS `grn` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `grn_no` int(11) NOT NULL,
  `po_no` int(11) DEFAULT NULL,
  `sid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` float NOT NULL,
  `prepared_by_(eno)` int(11) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `approvedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gtn`
--

DROP TABLE IF EXISTS `gtn`;
CREATE TABLE IF NOT EXISTS `gtn` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `gtn_no` int(11) NOT NULL,
  `item_no` int(11) NOT NULL,
  `item_type` varchar(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `dept` varchar(20) NOT NULL,
  `prepared_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` int(11) NOT NULL,
  `cno` int(11) NOT NULL,
  `item_no` int(11) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `value` float NOT NULL,
  `prepared_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `po_no` int(11) DEFAULT NULL,
  `vehicle_no` int(11) DEFAULT NULL,
  `total` float NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
CREATE TABLE IF NOT EXISTS `materials` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `sid` int(11) NOT NULL,
  `value` float NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_voucher`
--

DROP TABLE IF EXISTS `payment_voucher`;
CREATE TABLE IF NOT EXISTS `payment_voucher` (
  `pv_no` int(11) NOT NULL,
  `grn_no` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` float NOT NULL,
  `prepared_by_(eno)` int(11) NOT NULL,
  `approvedBy` int(11) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pv_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

DROP TABLE IF EXISTS `purchase_orders`;
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `po_no` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `prep_date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `prepared_by_(eno)` int(11) NOT NULL,
  `approvedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
CREATE TABLE IF NOT EXISTS `stocks` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `item_no` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `dept` varchar(20) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `tpno` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
