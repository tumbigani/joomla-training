-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2014 at 03:56 PM
-- Server version: 5.1.73
-- PHP Version: 5.4.30-1+deb.sury.org~lucid+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `employee_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `join_date` date NOT NULL,
  `salary` int(11) NOT NULL,
  `enddate` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `city`, `phone`, `join_date`, `salary`, `enddate`) VALUES
(21, 'Jamal Derdivala', 'Dhoraji', '123456', '2014-07-22', 500000, 'null'),
(20, 'Irshad Nagani', 'Dhoraji', '13456', '2014-07-21', 500000, 'null'),
(19, 'Gani Tumbi', 'Surat', '123456', '2014-07-21', 500000, 'null'),
(22, 'Ronak', 'Ahmedabad', '1234567', '2014-05-01', 58000, 'null'),
(23, 'Jay', 'Ahmadabad', '78456', '2014-07-22', 8000, 'null'),
(25, 'Ahemed', 'surat', '456132', '2014-05-22', 70000, 'null'),
(26, 'moin', 'surat', '1326546', '2014-02-21', 12000, 'null'),
(27, 'saad', 'Dhoraji', '32165465', '0000-00-00', 8004, '2014-08-05'),
(28, 'uuuo', 'ouuo', '13213', '0000-00-00', 20000, '2014-08-05'),
(29, 'sadf', 'saf', '456221', '2014-06-01', 20000, 'null');
