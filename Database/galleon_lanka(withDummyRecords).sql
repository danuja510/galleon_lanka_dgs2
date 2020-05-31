-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 31, 2020 at 03:06 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bom`
--

INSERT INTO `bom` (`no`, `bom_id`, `mName`, `qty`, `state`) VALUES
(1, 1, 'Material A', 10, 'active'),
(2, 1, 'Material B', 5, 'active'),
(3, 1, 'Material BB', 4, 'active'),
(4, 2, 'Material C', 6, 'active'),
(5, 2, 'Material BB', 2, 'active'),
(6, 2, 'Material B', 4, 'active'),
(7, 3, 'Material A', 8, 'active'),
(9, 3, 'Material B', 4, 'active'),
(10, 3, 'Material BB', 6, 'active');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_receipts`
--

INSERT INTO `cash_receipts` (`cr_no`, `invoice_no`, `cno`, `remarks`, `amout`, `prepared_by`, `approved_by`, `date`) VALUES
(1, 1, 1, NULL, 5499.99, 1, 1, '2020-05-31');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `creditors`
--

INSERT INTO `creditors` (`no`, `sid`, `amount`, `date`) VALUES
(1, 1, 6199.38, '2020-05-31'),
(2, 2, 1499.7, '2020-05-31'),
(3, 3, 2819.62, '2020-05-31'),
(4, 4, 799.9, '2020-05-31'),
(5, 4, 399.95, '2020-05-31'),
(6, 5, 399.9, '2020-05-31'),
(7, 2, -1499.7, '2020-05-31');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cno`, `Name`, `Address`, `tpno`, `type`, `state`) VALUES
(1, 'Gandalf', 'Middle-Earth', '1234567890', 'distributor', 'active'),
(2, 'Aragorn', 'Gondor', '1234567891', 'dealer', 'active'),
(3, 'Goku', '439 East District', '1234567892', 'customer', 'active'),
(4, 'Batman', 'Gotham', '0987654321', 'other', 'active'),
(5, 'Rick Sanchez', 'Washington', '1234567891', 'distributor', 'active');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `debtors`
--

INSERT INTO `debtors` (`no`, `cno`, `amount`, `date`) VALUES
(1, 1, 7499.99, '2020-05-31'),
(2, 1, -5499.99, '2020-05-31');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`eno`, `Name`, `Designation`, `Dept`, `password`, `email`, `status`) VALUES
(1, 'Vito Corleone', 'Manager', 'Manager', '1d0258c2440a8d19e716292b231e3190', 'email@email.com', 'active'),
(2, 'Michael Corleone', 'Employee', 'store', '8cd892b7b97ef9489ae4479d3f4ef0fc', 'mail@mail.com', 'active'),
(3, 'Gus Fring', 'Employee', 'pFloor', '9ec811b5bf4dbea12deea16997085dac', 'email@email.com', 'active'),
(4, 'Tony Soprano', 'Employee', 'fGoods', 'a8c42c59e7f1c9473efef644bddf6765', 'email@email.com', 'active');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finished_products`
--

INSERT INTO `finished_products` (`fp_id`, `Name`, `bom_id`, `value`, `status`) VALUES
(1, 'Mattress', '3', 7499.99, 'active'),
(2, 'Cushion Small', '2', 1499.99, 'active'),
(3, 'Cushion Medium', '1', 4999.99, 'active');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grn`
--

INSERT INTO `grn` (`no`, `grn_no`, `po_no`, `sid`, `mid`, `qty`, `date`, `amount`, `prepared_by_(eno)`, `remarks`, `approvedBy`) VALUES
(1, 1, 1, 1, 3, 62, '2020-05-31', 6199.38, 1, NULL, 1),
(2, 2, 2, 2, 1, 30, '2020-05-31', 1499.7, 1, NULL, 1),
(3, 3, 3, 3, 2, 20, '2020-05-31', 1199.8, 1, NULL, 1),
(4, 3, 3, 3, 4, 18, '2020-05-31', 1619.82, 1, NULL, 1),
(5, 4, 4, 4, 5, 10, '2020-05-31', 799.9, 1, NULL, 1),
(6, 5, 5, 4, 5, 5, '2020-05-31', 399.95, 1, NULL, 1),
(7, 6, 6, 5, 6, 10, '2020-05-31', 399.9, 1, NULL, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gtn`
--

INSERT INTO `gtn` (`no`, `gtn_no`, `item_no`, `item_type`, `qty`, `type`, `remarks`, `dept`, `prepared_by`, `approved_by`, `date`) VALUES
(1, 1, 1, 'material', 20, 'out', NULL, 'store', 1, 1, '2020-05-31'),
(2, 1, 2, 'material', 10, 'out', NULL, 'store', 1, 1, '2020-05-31'),
(3, 1, 3, 'material', 30, 'out', NULL, 'store', 1, 1, '2020-05-31'),
(4, 2, 1, 'material', 20, 'in', NULL, 'pFloor', 1, 1, '2020-05-31'),
(5, 2, 2, 'material', 10, 'in', NULL, 'pFloor', 1, 1, '2020-05-31'),
(6, 2, 3, 'material', 30, 'in', NULL, 'pFloor', 1, 1, '2020-05-31'),
(7, 3, 4, 'material', 8, 'out', NULL, 'store', 1, 1, '2020-05-31'),
(8, 3, 5, 'material', 10, 'out', NULL, 'store', 1, 1, '2020-05-31'),
(9, 3, 6, 'material', 10, 'out', NULL, 'store', 1, 1, '2020-05-31'),
(10, 4, 4, 'material', 8, 'in', NULL, 'pFloor', 1, 1, '2020-05-31'),
(11, 4, 5, 'material', 10, 'in', NULL, 'pFloor', 1, 1, '2020-05-31'),
(12, 4, 6, 'material', 10, 'in', NULL, 'pFloor', 1, 1, '2020-05-31'),
(13, 5, 4, 'material', 8, 'return_out', NULL, 'pFloor', 1, 1, '2020-05-31'),
(14, 6, 4, 'material', 8, 'return_in', NULL, 'store', 1, 1, '2020-05-31'),
(15, 7, 1, 'finished_product', 3, 'out', NULL, 'pFloor', 1, 1, '2020-05-31'),
(16, 8, 1, 'finished_product', 3, 'in', NULL, 'fGoods', 1, 1, '2020-05-31'),
(17, 9, 1, 'finished_product', 1, 'return_out', NULL, 'fGoods', 1, 1, '2020-05-31'),
(18, 10, 1, 'finished_product', 1, 'return_in', 'return from fgoods', 'pFloor', 1, 1, '2020-05-31');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`no`, `invoice_no`, `cno`, `item_no`, `remarks`, `qty`, `value`, `prepared_by`, `approved_by`, `date`, `po_no`, `vehicle_no`, `total`) VALUES
(1, 1, 1, 1, NULL, 1, 7499.99, 1, 1, '2020-05-31', NULL, NULL, 7499.99);

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`mid`, `Name`, `Type`, `sid`, `value`, `status`) VALUES
(1, 'Material A', 'Raw', 2, 49.99, 'active'),
(2, 'Material B', 'Packing', 3, 59.99, 'active'),
(3, 'Material BB', 'Chemical', 1, 99.99, 'active'),
(4, 'Material BB', 'Chemical', 3, 89.99, 'active'),
(5, 'Material A', 'Raw', 4, 79.99, 'active'),
(6, 'Material B', 'Packing', 5, 39.99, 'active'),
(7, 'Material C', 'Raw', 2, 29.99, 'inactive');

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

--
-- Dumping data for table `payment_voucher`
--

INSERT INTO `payment_voucher` (`pv_no`, `grn_no`, `sid`, `date`, `amount`, `prepared_by_(eno)`, `approvedBy`, `remarks`) VALUES
(1, 2, 2, '2020-05-30', 1499.7, 1, 1, '');

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
  `amount` float NOT NULL,
  `delivery_date` date NOT NULL,
  `prepared_by_(eno)` int(11) NOT NULL,
  `approvedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`no`, `po_no`, `sid`, `mid`, `qty`, `prep_date`, `amount`, `delivery_date`, `prepared_by_(eno)`, `approvedBy`) VALUES
(2, 1, 1, 3, 62, '2020-05-31', 6199.38, '2020-06-04', 1, 1),
(3, 2, 2, 1, 30, '2020-05-31', 1499.7, '2020-06-05', 1, 1),
(4, 3, 3, 2, 20, '2020-05-31', 1199.8, '2020-06-06', 1, 1),
(5, 3, 3, 4, 18, '2020-05-31', 1619.82, '2020-06-06', 1, 1),
(6, 4, 4, 5, 10, '2020-05-31', 799.9, '2020-06-02', 1, 1),
(7, 5, 4, 5, 5, '2020-05-31', 399.95, '2020-06-03', 1, 1),
(8, 6, 5, 6, 10, '2020-05-31', 399.9, '2020-06-04', 1, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`no`, `item_no`, `qty`, `type`, `date`, `dept`) VALUES
(1, 3, 62, 'material', '2020-05-31', 'store'),
(2, 1, 30, 'material', '2020-05-31', 'store'),
(3, 2, 20, 'material', '2020-05-31', 'store'),
(4, 4, 18, 'material', '2020-05-31', 'store'),
(5, 5, 10, 'material', '2020-05-31', 'store'),
(6, 5, 5, 'material', '2020-05-31', 'store'),
(7, 6, 10, 'material', '2020-05-31', 'store'),
(8, 1, -20, 'material', '2020-05-31', 'store'),
(9, 2, -10, 'material', '2020-05-31', 'store'),
(10, 3, -30, 'material', '2020-05-31', 'store'),
(11, 1, 20, 'material', '2020-05-31', 'pFloor'),
(12, 2, 10, 'material', '2020-05-31', 'pFloor'),
(13, 3, 30, 'material', '2020-05-31', 'pFloor'),
(14, 4, -8, 'material', '2020-05-31', 'store'),
(15, 5, -10, 'material', '2020-05-31', 'store'),
(16, 6, -10, 'material', '2020-05-31', 'store'),
(17, 4, 8, 'material', '2020-05-31', 'pFloor'),
(18, 5, 10, 'material', '2020-05-31', 'pFloor'),
(19, 6, 10, 'material', '2020-05-31', 'pFloor'),
(20, 4, -8, 'material', '2020-05-31', 'pFloor'),
(21, 4, 8, 'material', '2020-05-31', 'store'),
(22, 1, 3, 'finished_product', '2020-05-31', 'pfloor'),
(23, 1, 3, 'finished_product', '2020-05-31', 'pfloor'),
(24, 1, -6, 'finished_product', '2020-05-31', 'pfloor'),
(25, 1, 3, 'finished_product', '2020-05-31', 'pfloor'),
(26, 1, -14, 'material', '2020-05-31', 'pfloor'),
(27, 2, -4, 'material', '2020-05-31', 'pfloor'),
(28, 3, -18, 'material', '2020-05-31', 'pfloor'),
(29, 4, 0, 'material', '2020-05-31', 'pfloor'),
(30, 5, -10, 'material', '2020-05-31', 'pfloor'),
(31, 6, -4, 'material', '2020-05-31', 'pfloor'),
(32, 2, -2, 'material', '2020-05-31', 'pFloor'),
(33, 6, -2, 'material', '2020-05-31', 'pFloor'),
(34, 1, -3, 'finished_product', '2020-05-31', 'pFloor'),
(35, 1, 3, 'finished_product', '2020-05-31', 'fGoods'),
(36, 1, -1, 'finished_product', '2020-05-31', 'fGoods'),
(37, 1, 1, 'finished_product', '2020-05-31', 'pFloor'),
(38, 1, -1, 'finished_product', '2020-05-31', 'fGoods');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`sid`, `Name`, `Address`, `tpno`, `state`) VALUES
(1, 'Walter White', 'Albuquerque', '1234567890', 'active'),
(2, 'Darth Vader', 'Mustafar', '0987654321', 'active'),
(3, 'Jesse Pinkman', 'Albuquerque', '1234567890', 'active'),
(4, 'Night King', 'Beyond The Wall', '0987654321', 'active'),
(5, 'The Joker', 'Gotham', '1234567890', 'active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
