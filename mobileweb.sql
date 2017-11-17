-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 17, 2017 at 03:46 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobileweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `pay_api`
--

CREATE TABLE `pay_api` (
  `number` int(20) NOT NULL,
  `vendor` enum('Vodafone','MTN','Tigo','Airtel') NOT NULL,
  `uid` int(11) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `tp` varchar(200) NOT NULL,
  `cbk` varchar(200) NOT NULL,
  `amt` int(11) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `vou` varchar(200) NOT NULL,
  `pin` int(11) NOT NULL,
  `trans_type` enum('credit','debit','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessionmanager`
--

CREATE TABLE `sessionmanager` (
  `number` varchar(20) NOT NULL,
  `transaction_type` varchar(1000) DEFAULT NULL,
  `recipientcol` varchar(200) DEFAULT NULL,
  `amountcol` varchar(200) DEFAULT NULL,
  `confirmcol` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessionmanager`
--

INSERT INTO `sessionmanager` (`number`, `transaction_type`, `recipientcol`, `amountcol`, `confirmcol`) VALUES
('3333333333', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `sender` varchar(20) NOT NULL,
  `recipient` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transaction_status` enum('confirmed','cancelled','','') NOT NULL,
  `status_message` enum('sent','not sent','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `number` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `accountbalance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sessionmanager`
--
ALTER TABLE `sessionmanager`
  ADD PRIMARY KEY (`number`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
