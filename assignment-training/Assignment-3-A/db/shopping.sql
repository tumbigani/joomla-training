-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2014 at 03:54 PM
-- Server version: 5.1.73
-- PHP Version: 5.4.30-1+deb.sury.org~lucid+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `decs` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `decs`, `price`, `img`) VALUES
(1, 'Analog Watch', 1500, 'watches/1.jpeg'),
(2, 'Sonata Ocean', 3200, 'watches/2.jpeg'),
(3, 'Fastrack Basics ', 995, 'watches/3.jpeg'),
(4, 'Rado Watch', 3700, 'watches/4.jpeg'),
(5, 'Titen Watch', 5800, 'watches/5.jpeg'),
(6, 'Rolex Watch', 4700, 'watches/6.png');
