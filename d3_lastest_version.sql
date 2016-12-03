-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2016 at 10:00 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `d3`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicationrequest`
--

CREATE TABLE IF NOT EXISTS `applicationrequest` (
  `LoginId` varchar(30) NOT NULL,
  `applicationNumber` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `conferenceDetails` varchar(1000) NOT NULL,
  `typeOfPresentation` varchar(100) NOT NULL,
  `presentationDetail` varchar(1000) NOT NULL,
  `registrationExpense` float NOT NULL,
  `transportationExpense` float NOT NULL,
  `accomendationExpense` float NOT NULL,
  `mealsExpense` float NOT NULL,
  `advancedFunds` float DEFAULT NULL,
  `applicationStatus` varchar(30) DEFAULT NULL,
  `supervisor` varchar(30) NOT NULL,
  PRIMARY KEY (`applicationNumber`),
  UNIQUE KEY `applicationNumber` (`applicationNumber`),
  KEY `LoginId` (`LoginId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `applicationrequest`
--

INSERT INTO `applicationrequest` (`LoginId`, `applicationNumber`, `conferenceDetails`, `typeOfPresentation`, `presentationDetail`, `registrationExpense`, `transportationExpense`, `accomendationExpense`, `mealsExpense`, `advancedFunds`, `applicationStatus`, `supervisor`) VALUES
('Pram', 1, 'This is a text', 'Biology', 'evolution is unique', 200.78, 200, 300, 100, NULL, 'Refused', 'niel111'),
('Parker01', 2, 'Test', 'Test', 'Test', 10, 20, 20, 10, 0, 'Pending Faculty Evaluation', 'niel111'),
('Parker01', 4, 'Another Test', 'Another Test', 'Another Test', 12.66, 40, 50, 39, 45, 'Pending Faculty Evaluation', 'niel111'),
('Parker01', 5, 'This is a test', 'Geography', 'Using ArcGIS', 20, 40, 60, 49, 0, 'Pending Supervisor Approval', 'niel111'),
('hannah', 6, 'Test', 'Test', 'Test', 10, 10, 10, 10, 0, 'Pending Supervisor Approval', 'shey'),
('hannah', 8, 'This conference is about all things awesome.', 'Music Theory', 'Music Genres affect on Learning', 100, 400, 340, 100, 0, 'Pending Faculty Evaluation', 'shey');

-- --------------------------------------------------------

--
-- Table structure for table `inboxitems`
--

CREATE TABLE IF NOT EXISTS `inboxitems` (
  `LoginId` varchar(30) NOT NULL,
  `itemId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender` varchar(30) NOT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`itemId`),
  UNIQUE KEY `itemId` (`itemId`),
  KEY `LoginId` (`LoginId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `inboxitems`
--

INSERT INTO `inboxitems` (`LoginId`, `itemId`, `sender`, `message`, `date`) VALUES
('Parker01', 1, 'Farrah101', 'Hello', '2016-11-30 23:17:22'),
('Parker01', 2, 'Farrah Dean', 'This is a very very very very very very very very very very very very very very very very very very very very very very very very very very very very very very very very very veryvery very long message', '2016-11-30 23:40:20'),
('Pram', 4, 'Michael James', 'Your application evolution is unique has been approved and is now pending falculty evaluation.', '2016-12-02 05:02:33'),
('Pram', 8, 'Michael James', 'Do these changes now. They''re very important.', '2016-12-02 05:10:37'),
('Pram', 9, 'Michael James', 'Your application evolution is unique has been refused.', '2016-12-02 05:10:59'),
('Parker01', 10, 'Michael James', 'Changes', '2016-12-02 05:23:48'),
('Parker01', 11, 'Michael James', 'Your application Another Test has been approved and is now pending falculty evaluation.', '2016-12-02 05:23:58'),
('Parker01', 12, 'Michael James', 'Your application Test has been approved and is now pending falculty evaluation.', '2016-12-02 05:48:37'),
('hannah', 13, 'Sasha Richardson', 'Your application Music Genres affect on Learning has been approved and is now pending falculty evaluation.', '2016-12-02 20:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `requester`
--

CREATE TABLE IF NOT EXISTS `requester` (
  `LoginId` varchar(30) NOT NULL,
  `studentNumber` int(11) DEFAULT NULL,
  `academicUnit` varchar(30) NOT NULL,
  `program` varchar(30) NOT NULL,
  `sessionNumber` int(11) NOT NULL,
  `Thesis_Topic` varchar(50) NOT NULL,
  `BankAccountNumber` int(11) NOT NULL,
  `RequestType` varchar(20) NOT NULL,
  `supervisor` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`LoginId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requester`
--

INSERT INTO `requester` (`LoginId`, `studentNumber`, `academicUnit`, `program`, `sessionNumber`, `Thesis_Topic`, `BankAccountNumber`, `RequestType`, `supervisor`) VALUES
('hannah', 123451, 'Science', 'Health Sciences', 2, 'Bio', 123492, 'Ph.D', 'shey'),
('Parker01', 12345678, 'Engineering', 'Computer Science', 2, 'The best one!!!', 123456789, 'Ph.D', 'niel111'),
('Pram', NULL, '', '', 0, '', 0, '', 'niel111');

-- --------------------------------------------------------

--
-- Table structure for table `supervisor`
--

CREATE TABLE IF NOT EXISTS `supervisor` (
  `LoginId` varchar(30) NOT NULL,
  `employeeNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`LoginId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supervisor`
--

INSERT INTO `supervisor` (`LoginId`, `employeeNumber`) VALUES
('niel111', 123213134),
('shey', 12332144);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `LoginId` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`LoginId`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`LoginId`, `password`, `last_name`, `first_name`, `email`, `status`) VALUES
('adi25', 'Roy1', 'Roy', 'Adity', 'Adity25@yahoo.ca', 'System Admin'),
('Farrah101', 'Dean101', 'Dean', 'Farrah', 'Farrah101@hotmail.com', 'Financial Office Staff'),
('farrahdean', 'Farrah', 'Dean', 'Farrah', 'fdean@live.ca', 'System Admin'),
('fdean043', 'fdean', 'Dean', 'Farrah', 'f.dean@live.ca', 'System Admin'),
('hannah', 'dean', 'Dean', 'Hannah', 'hannah@live.ca', 'Requester'),
('Mark101', 'MrozMark', 'Mroz', 'Mark', 'Mark101@hotmail.com', 'System Admin'),
('niel111', 'Parker101', 'James', 'Michael', 'Mark101@uottawa.ca', 'Supervisor'),
('Parker01', 'Sam', 'Parker', 'Samantha', 'sam23@yahoo.ca', 'Requester'),
('Pram', 'Pram', 'Roy', 'Pramity', 'Pram23@yahoo.ca', 'Requester'),
('Proy', 'Pram', 'Roy', 'Pramity', 'pramity150@yahoo.ca', 'System Admin'),
('Roy101', 'Cool', 'Roy', 'Pragya', 'proy061@uottawa.ca', 'Finacial Office Staff'),
('shey', 'sh', 'Richardson', 'Sasha', 'shey90@gmail.com', 'Supervisor');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicationrequest`
--
ALTER TABLE `applicationrequest`
  ADD CONSTRAINT `applicationrequest_ibfk_1` FOREIGN KEY (`LoginId`) REFERENCES `users` (`LoginId`);

--
-- Constraints for table `inboxitems`
--
ALTER TABLE `inboxitems`
  ADD CONSTRAINT `inboxitems_ibfk_1` FOREIGN KEY (`LoginId`) REFERENCES `users` (`LoginId`);

--
-- Constraints for table `requester`
--
ALTER TABLE `requester`
  ADD CONSTRAINT `requester_ibfk_1` FOREIGN KEY (`LoginId`) REFERENCES `users` (`LoginId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
