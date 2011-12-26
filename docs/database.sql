-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 26, 2011 at 01:12 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sbhs`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `acc_id` int(5) NOT NULL AUTO_INCREMENT,
  `rollno` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `emailid` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mid` int(10) NOT NULL,
  `regdate` varchar(10) NOT NULL,
  `approved` varchar(15) NOT NULL,
  PRIMARY KEY (`acc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `Srno` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`Srno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Dumping data for table `admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `curr_bookings`
--

CREATE TABLE IF NOT EXISTS `curr_bookings` (
  `slot_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `django_session`
--

CREATE TABLE IF NOT EXISTS `django_session` (
  `session_key` varchar(40) NOT NULL,
  `session_data` longtext NOT NULL,
  `expire_date` datetime NOT NULL,
  PRIMARY KEY (`session_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `subject` varchar(60) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `slot`
--

CREATE TABLE IF NOT EXISTS `slot` (
  `Srno` int(10) NOT NULL AUTO_INCREMENT,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  PRIMARY KEY (`Srno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `slot_booking`
--

CREATE TABLE IF NOT EXISTS `slot_booking` (
  `slot_id` int(11) NOT NULL AUTO_INCREMENT,
  `rollno` varchar(10) NOT NULL,
  `slot_date` varchar(30) NOT NULL,
  `start_time` varchar(11) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `time` int(11) NOT NULL,
  `mid` varchar(10) NOT NULL,
  `rno` varchar(60) NOT NULL,
  `is_busy` int(11) NOT NULL,
  PRIMARY KEY (`slot_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

