
-- SBHS Database script

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `sbhs`
--
CREATE DATABASE `sbhs` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sbhs`;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`acc_id`, `rollno`, `password`, `emailid`, `name`, `mid`, `regdate`, `approved`) VALUES
(1, 'demo', 'vlabs123', 'sushanth@ee.iitb.ac.in', 'Demo User', 1, '30.07.2010', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `Srno` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`Srno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Srno`, `username`, `password`) VALUES
(1, 'admin', 'b2ecb14033cee7cb719ea052ca47b03b');

-- --------------------------------------------------------

--
-- Table structure for table `slot`
--

CREATE TABLE IF NOT EXISTS `slot` (
  `Srno` int(10) NOT NULL AUTO_INCREMENT,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  PRIMARY KEY (`Srno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `slot`
--

INSERT INTO `slot` (`Srno`, `start_time`, `end_time`) VALUES
(1, '0.00', '1.00'),
(2, '1.00', '2.00'),
(4, '2.00', '3.00'),
(5, '3.00', '4.00'),
(6, '4.00', '5.00'),
(7, '5.00', '6.00'),
(8, '6.00', '7.00'),
(9, '7.00', '8.00'),
(10, '8.00', '9.00'),
(11, '9.00', '10.00'),
(12, '10.00', '11.00'),
(13, '11.00', '12.00'),
(14, '12.00', '13.00'),
(15, '13.00', '14.00'),
(16, '14.00', '15.00'),
(17, '15.00', '16.00'),
(18, '16.00', '17.00'),
(19, '17.00', '18.00'),
(20, '18.00', '19.00'),
(21, '19.00', '20.00'),
(22, '20.00', '21.00'),
(23, '21.00', '22.00'),
(24, '22.00', '23.00'),
(25, '23.00', '0.00');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `slot_booking`
--


-- --------------------------------------------------------
--
-- Table structure for table `curr_bookings`
--
CREATE TABLE `sbhs`.`curr_bookings` (
`slot_id` INT( 11 ) NULL DEFAULT NULL
) ENGINE = MYISAM ;

-- --------------------------------------------------------
--
-- Table structure for table `feedback`
--
CREATE TABLE `sbhs`.`feedback` (
`id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 30 ) NOT NULL ,
`email` VARCHAR( 30 ) NOT NULL ,
`subject` VARCHAR( 60 ) NOT NULL ,
`message` TEXT NOT NULL
) ENGINE = MYISAM ;

-- --------------------------------------------------------
