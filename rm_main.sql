-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2013 at 10:10 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rm_main`
--
CREATE DATABASE IF NOT EXISTS `rm_main` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `rm_main`;

-- --------------------------------------------------------

--
-- Table structure for table `tshirt`
--

CREATE TABLE IF NOT EXISTS `tshirt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `summonerName` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `imgPath` varchar(100) NOT NULL,
  `showTShirt` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tshirt`
--

INSERT INTO `tshirt` (`id`, `dateCreated`, `summonerName`, `description`, `imgPath`, `showTShirt`) VALUES
(1, '2013-11-01 20:17:40', 'summ1', 'description summ1 for ppooo pooo', '1.jpg', 0),
(2, '2013-11-01 20:17:40', 'summ2', 'description me me me', '2.jpg', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
