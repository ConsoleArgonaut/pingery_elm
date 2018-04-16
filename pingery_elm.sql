-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2018 at 09:09 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pingery_elm`
--

-- --------------------------------------------------------

--
-- Table structure for table `elm_log`
--

CREATE TABLE `elm_log` (
  `logId` int(11) NOT NULL,
  `websitesFK` int(11) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Message` varchar(255) NOT NULL,
  `Success` BOOLEAN,
  `callerIP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elm_websites`
--

CREATE TABLE `elm_websites` (
  `websitesId` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `elm_log`
--
ALTER TABLE `elm_log`
  ADD PRIMARY KEY (`logId`),
  ADD KEY `websites_log_FK` (`websitesFK`);

--
-- Indexes for table `elm_websites`
--
ALTER TABLE `elm_websites`
  ADD PRIMARY KEY (`websitesId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `elm_log`
--
ALTER TABLE `elm_log`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `elm_websites`
--
ALTER TABLE `elm_websites`
  MODIFY `websitesId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `elm_log`
--
ALTER TABLE `elm_log`
  ADD CONSTRAINT `websites_log_FK` FOREIGN KEY (`websitesFK`) REFERENCES `elm_websites` (`websitesId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
