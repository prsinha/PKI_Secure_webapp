-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 21, 2008 at 04:19 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `6120project`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `FID` varchar(50) NOT NULL,
  `FName` varchar(255) NOT NULL,
  `FDetails` varchar(255) default NULL,
  `FType` varchar(255) default NULL,
  `FSize` int(10) default NULL,
  `FContent` blob,
  `DateUploaded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`FID`, `FName`, `FDetails`, `FType`, `FSize`, `FContent`, `DateUploaded`) VALUES
('0000002', 'config.txt', 'test', 'text/plain', 136, 0x535349443a204265636b790d0a70776428574550293a202052656265636361476964656f6e0d0a61646d696e206775693a2075736572203d2061646d696e0d0a202020202020202020202070776420203d206265636b730d0a2020202020202020202020495020203d203139322e3136382e32392e312064656661756c7420676174657761790d0a, '2008-11-21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RID` tinyint(10) NOT NULL,
  `RName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RID`, `RName`) VALUES
(0, 'Admin'),
(1, 'Users');

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `UserID` varchar(50) NOT NULL,
  `FName` varchar(100) NOT NULL,
  `MName` varchar(100) default NULL,
  `LName` varchar(100) NOT NULL,
  `Telephone` varchar(100) default NULL,
  `Address` varchar(100) default NULL,
  `DOB` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Country` varchar(100) default NULL,
  `State` varchar(100) default NULL,
  `City` varchar(100) default NULL,
  `RID` tinyint(10) NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`UserID`, `FName`, `MName`, `LName`, `Telephone`, `Address`, `DOB`, `Email`, `Password`, `Country`, `State`, `City`, `RID`) VALUES
('0000001', 'Rebecca', 'N', 'Gideon', '21831234721', 'jadasjhdsha', '2008/11/18', 'rebecca_gideon@yahoo.com', 'e358bf645a205cf15efa983b5517d945', 'Kenya (Nairobi)', 'Nairobi', 'Nairobi', 0),
('0000002', 'Akram', 'Akram', 'Akram', NULL, NULL, '1900/1/1', 'test@test.com', '3248f28c2b5f704b8c214924b7218f11', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `userfilerights`
--

CREATE TABLE `userfilerights` (
  `UserID` varchar(50) NOT NULL,
  `FID` varchar(50) NOT NULL,
  `R` tinyint(1) NOT NULL default '0',
  `W` tinyint(1) NOT NULL default '0',
  `O` tinyint(1) NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userfilerights`
--

INSERT INTO `userfilerights` (`UserID`, `FID`, `R`, `W`, `O`) VALUES
('0000001', '0000002', 1, 1, 1);
