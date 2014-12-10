-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2014 at 03:55 PM
-- Server version: 5.1.73
-- PHP Version: 5.4.30-1+deb.sury.org~lucid+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `pwd` text NOT NULL,
  `mobile` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `user_name`, `pwd`, `mobile`) VALUES
('53df09483e902', 'gani tumbi', 'gani', '81dc9bdb52d04dc20036dbd8313ed055', '9879782615'),
('53e06039f2f7a', 'asdf', 'asdf', 'e10adc3949ba59abbe56e057f20f883e', '9879782615');
