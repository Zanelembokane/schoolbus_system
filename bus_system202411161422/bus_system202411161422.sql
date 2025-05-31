-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 01:22 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus_system`
--
CREATE DATABASE IF NOT EXISTS `bus_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bus_system`;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE IF NOT EXISTS `administrator` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Learner_ID` int(11) NOT NULL,
  `AdminInitialSurname` varchar(30) NOT NULL,
  `CellPhoneNumber` varchar(10) NOT NULL,
  `Password` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`Admin_ID`),
  KEY `Learner_ID` (`Learner_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`Admin_ID`, `Learner_ID`, `AdminInitialSurname`, `CellPhoneNumber`, `Password`, `email`) VALUES
(1, 1, 'D Nkosi', '0126452258', 'DNkosi123@', 'dnkosi@impumelolo.high.school.co.za');

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE IF NOT EXISTS `bus` (
  `busRoute_ID` int(11) NOT NULL,
  `Learner_ID` int(11) DEFAULT NULL,
  `bus_Number` varchar(10) DEFAULT NULL,
  `Pickup_Number` varchar(10) DEFAULT NULL,
  `Dropoff_Number` varchar(10) DEFAULT NULL,
  `Application_Status` varchar(50) DEFAULT 'Unknown',
  `WaitingList_Number` int(11) DEFAULT 0,
  KEY `Learner_ID` (`Learner_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`busRoute_ID`, `Learner_ID`, `bus_Number`, `Pickup_Number`, `Dropoff_Number`, `Application_Status`, `WaitingList_Number`) VALUES
(1, 1, 'Bus 1', '1A', '1A', 'Approved', 0),
(2, 2, 'Bus 2', '2B', '2B', 'Approved', 0),
(1, 4, 'Bus 1', '1B', '1B', 'Approved', 0),
(3, 5, 'Bus 3', '3A', '3A', 'Approved', 0),
(3, 3, 'Bus 3', '3A', '3A', 'Approved', 0),
(2, 6, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 12, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 13, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 14, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 15, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 16, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 26, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 25, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 24, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 23, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 22, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 21, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 19, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 18, 'Bus 2', '2B', '2B', 'Approved', 0),
(2, 17, 'Bus 2', '2B', '2B', 'Approved', 0),
(3, 28, 'Bus 3', '3A', '3A', 'Approved', 0),
(3, 31, 'Bus 3', '3A', '3A', 'Approved', 0),
(2, 29, 'Bus 2', '2B', '2B', 'Waiting list', 2),
(2, 32, 'Bus 2', '2B', '2B', 'Waiting list', 3),
(3, 35, 'Bus 3', '3A', '3A', 'Unknown', 0),
(1, 36, 'Bus 1', '1B', '1B', 'Unknown', 0),
(2, 37, 'Bus 2', '2B', '2B', 'Unknown', 0),
(2, 38, 'Bus 2', '2B', '2B', 'Unknown', 0),
(1, 39, 'Bus 1', '1A', '1A', 'Unknown', 0),
(2, 40, 'Bus 2', '2B', '2B', 'Unknown', 0),
(2, 41, 'Bus 2', '2B', '2B', 'Unknown', 0),
(2, 42, 'Bus 2', '2B', '2B', 'Waiting list', 3),
(2, 43, 'Bus 2', '2B', '2B', 'Waiting list', 4),
(1, 44, 'Bus 1', '1A', '1A', 'Unknown', 0);

-- --------------------------------------------------------

--
-- Table structure for table `busroute`
--

CREATE TABLE IF NOT EXISTS `busroute` (
  `busRoute_ID` int(11) NOT NULL AUTO_INCREMENT,
  `busRoute` varchar(100) NOT NULL,
  `busLimit` int(11) DEFAULT NULL,
  PRIMARY KEY (`busRoute_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `busroute`
--

INSERT INTO `busroute` (`busRoute_ID`, `busRoute`, `busLimit`) VALUES
(1, 'Rooihuiskraal/The Reeds', 35),
(2, 'Wierdapark/Amberfield', 15),
(3, 'Centurion', 15);

-- --------------------------------------------------------

--
-- Table structure for table `learner`
--

CREATE TABLE IF NOT EXISTS `learner` (
  `Learner_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Parent_ID` int(11) DEFAULT NULL,
  `LearnerFullNames` varchar(30) DEFAULT NULL,
  `CellPhoneNumber` varchar(10) DEFAULT NULL,
  `Grade` varchar(15) DEFAULT NULL,
  `registrationDate` date DEFAULT curdate(),
  PRIMARY KEY (`Learner_ID`),
  KEY `Parent_ID` (`Parent_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learner`
--

INSERT INTO `learner` (`Learner_ID`, `Parent_ID`, `LearnerFullNames`, `CellPhoneNumber`, `Grade`, `registrationDate`) VALUES
(1, 1, 'Carel Smit', '0766558210', 'Grade 10', '2023-11-02'),
(2, 2, 'Jacob Evans', '0733447222', 'Grade 12', '2023-11-06'),
(3, 3, 'Sydwell Adams', '0814753325', 'Grade 9', '2023-11-07'),
(4, 4, 'Walter Moodley', '0814753325', 'Grade 10', '2023-11-08'),
(5, 5, 'Daniel Maake', '0821455236', 'Grade 12', '2023-11-09'),
(6, 5, 'Edward Maake', '0618952231', 'Grade 12', '2023-11-10'),
(12, 6, 'Mike Nkuna', '0716585521', 'Grade 10', '2023-11-10'),
(13, 7, 'Jane Nghwenya', '0792471510', 'Grade 11', '2023-11-13'),
(14, 8, 'Angie Sebopetsa', '0725102247', 'Grade 12', '2023-11-14'),
(15, 9, 'Lebo Mnguni', '0602103655', 'Grade 11', '2023-11-14'),
(16, 10, 'Sipho khumalo', '0834105233', 'Grade 10', '2023-11-14'),
(17, 3, 'Jollen Adams', '0652885634', 'Grade 11', '2023-11-15'),
(18, 2, 'Glen Evans', '0652510442', 'Grade 8', '2023-11-15'),
(19, 4, 'John Moodley', '0665102337', 'Grade 8', '2023-11-15'),
(20, 10, 'Nina Khumalo', '0745663213', 'Grade 8', '2023-11-16'),
(21, 9, 'Eleck Mnguni', '0844882033', 'Grade 8', '2023-11-16'),
(22, 8, 'Norman Sebopetsa', '0728631475', 'Grade 8', '2023-11-21'),
(23, 7, 'Phumzile Nghwenya', '0765446321', 'Grade 9', '2023-11-21'),
(24, 6, 'Marry Nkuna', '0711020551', 'Grade 9', '2023-11-21'),
(25, 5, 'Sylvia Maake', '0812105566', 'Grade 8', '2023-11-21'),
(26, 2, 'Collen Evans', '0715588452', 'Grade 8', '2023-11-21'),
(27, 6, 'Issac Nkuna', '0745996322', 'Grade 11', '2023-11-21'),
(28, 10, 'Donald Khumalo', '0614522589', 'Grade 10', '2023-11-21'),
(29, 6, 'Thabo Nkuna', '0605102588', 'Grade 9', '2023-11-21'),
(30, 8, 'Marvin Sebopetsa', '0647785456', 'Grade 12', '2023-11-21'),
(31, 7, 'Sibusiso Nghwenya', '0784996561', 'Grade 9', '2023-11-21'),
(32, 5, 'Trust Maake', '0714586632', 'Grade 12', '2023-11-21'),
(33, 5, 'Silver Maake', '0615895526', 'Grade 9', '2023-11-21'),
(34, 5, 'Evaluate Maake', '0856545585', 'Grade 11', '2023-11-21'),
(35, 7, 'Simon Nghwenya', '0856545585', 'Grade 11', '2023-11-21'),
(36, 7, 'Coolman Nghwenya', '0836548584', 'Grade 9', '2023-11-21'),
(37, 7, 'Khekhe Nghwenya', '0745886532', 'Grade 8', '2023-11-21'),
(38, 6, 'Nkiyasi Nkuna', '0714528871', 'Grade 8', '2023-11-22'),
(39, 6, 'Masingita Nkuna', '0745289963', 'Grade 11', '2023-11-22'),
(40, 5, 'Pamela Maake', '0745289963', 'Grade 11', '2023-11-22'),
(41, 5, 'Solly Maake', '0745289963', 'Grade 11', '2023-11-22'),
(42, 6, 'Senzo Nkuna', '0745289963', 'Grade 11', '2023-11-22'),
(43, 6, 'Bright Nkuna', '0745289963', 'Grade 11', '2023-11-22'),
(44, 6, 'Try Nkuna', '0745289963', 'Grade 11', '2023-11-22');

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE IF NOT EXISTS `parent` (
  `Parent_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Learner_ID` int(11) NOT NULL,
  `ParentFullNames` varchar(30) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `CellPhoneNumber` varchar(10) NOT NULL,
  `ParentEmail` varchar(30) NOT NULL,
  PRIMARY KEY (`Parent_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`Parent_ID`, `Learner_ID`, `ParentFullNames`, `Password`, `CellPhoneNumber`, `ParentEmail`) VALUES
(1, 1, 'Johan Smit', 'JohanSmit123@', '0833780166', 'Johan.Smit@gmail.com'),
(2, 2, 'Angel Evans', 'AngelEvans123@', '0726549865', 'Angel.Evans@gmail.com'),
(3, 3, 'Nick Adams', 'NickAdams123@', '0645128896', 'Nick.Adams@gmail.com'),
(4, 4, 'Jacob Moodley', 'JacobMoodley123@', '0745986321', 'Jacob.Moodley@gmail.com'),
(5, 5, 'Sarah Maake', 'SarahMaake123@', '0652105877', 'Sarah.Maake@gmail.com'),
(6, 6, 'George Nkuna', 'GeorgeNkuna123@', '0748810554', 'George.Nkuna@gmail.com'),
(7, 7, 'Terrance Nghwenya', 'TerrenceNghwenya123@', '0735442530', 'Terrence.Nghwenya@gmail.com'),
(8, 8, 'Olivia Sebopetsa', 'OliviaSebopetsa123@', '0621549931', 'Olivia.Sebopetsa@gmail.com'),
(9, 9, 'Mavis Mnguni', 'Mavis.Mguni123@', '0765510856', 'Mavis.Mnguni@gmail.com'),
(10, 10, 'Lista Khumalo', 'ListaKhumalo123@', '0837441012', 'Lista.Khumalo@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `waitinglist`
--

CREATE TABLE IF NOT EXISTS `waitinglist` (
  `waitingListID` int(11) NOT NULL AUTO_INCREMENT,
  `learner_ID` int(11) NOT NULL,
  `waitingDate` date NOT NULL DEFAULT curdate(),
  PRIMARY KEY (`waitingListID`),
  KEY `learner_ID` (`learner_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waitinglist`
--

INSERT INTO `waitinglist` (`waitingListID`, `learner_ID`, `waitingDate`) VALUES
(1, 30, '0000-00-00'),
(2, 29, '2023-11-21'),
(3, 42, '2023-11-22'),
(4, 43, '2023-11-22');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `admin_learner_FK` FOREIGN KEY (`Learner_ID`) REFERENCES `learner` (`Learner_ID`);

--
-- Constraints for table `bus`
--
ALTER TABLE `bus`
  ADD CONSTRAINT `bus_learner_FK` FOREIGN KEY (`Learner_ID`) REFERENCES `learner` (`Learner_ID`);

--
-- Constraints for table `learner`
--
ALTER TABLE `learner`
  ADD CONSTRAINT `learner_parent_FK` FOREIGN KEY (`Parent_ID`) REFERENCES `parent` (`Parent_ID`);

--
-- Constraints for table `waitinglist`
--
ALTER TABLE `waitinglist`
  ADD CONSTRAINT `waitingList_FK` FOREIGN KEY (`learner_ID`) REFERENCES `learner` (`Learner_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
