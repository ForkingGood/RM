-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2013 at 08:50 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rm_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE IF NOT EXISTS `announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `dateCreated`, `title`, `description`) VALUES
(1, '2013-11-15 02:25:24', 'Announcement #1', 'testing some stuff in here so you dont'' really need to read this but if you want to i''m not going to stop you either, you can read this over and over for all i care.. really, do it.'),
(2, '2013-11-15 02:25:24', 'Announcement #2', 'Sup dawg'),
(6, '2013-11-16 03:28:38', 't2', 'd2'),
(7, '2013-11-16 03:32:06', 't3', 'd3'),
(15, '2013-11-16 04:18:29', 't4', 'd4'),
(16, '2013-11-16 04:20:20', 't5', 'd5');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `summonerName` varchar(50) NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `dateCreated`, `type`, `title`, `description`, `summonerName`, `viewed`) VALUES
(1, '2013-11-06 23:57:19', 'Idea', 'tee', 'dee', 'see', 0);

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
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `tshirt`
--

INSERT INTO `tshirt` (`id`, `dateCreated`, `summonerName`, `description`, `imgPath`, `showTShirt`, `viewed`) VALUES
(25, '2013-11-13 18:29:19', 'adwefqw', 'asdafwawefwqf', 'codesbg.jpg', 1, 1),
(27, '2013-11-16 05:51:39', 'afaw', 'df', 'loading.gif', 1, 1),
(28, '2013-11-16 05:52:01', 'asf', 'asdfasdf', '8.jpg', 1, 1),
(29, '2013-11-16 20:55:23', 'summ1', 'fslakjd alkfja wl;fej wa;lkaj wlk', '1.jpg', 1, 1),
(30, '2013-11-16 20:55:23', 'asf', 'wafa', '2.jpg', 1, 1),
(31, '2013-11-16 20:55:57', 'lkjasl;j', 'aslkj aflk asdlk akl; sdal;k aslk;j l;k', '3.jpg', 1, 1),
(32, '2013-11-16 20:55:57', 'sadfa', 'asljalkj lka jslk ', '4.jpg', 1, 1),
(33, '2013-11-16 20:56:31', 'lakj ', 'lkjas', '6.jpg', 1, 1),
(34, '2013-11-16 20:56:31', 'asjl;', 'alkjsak sdlj asdlkf salfja oiaj oafjw cnxzknaw owi xzn', '7.jpg', 1, 1),
(35, '2013-11-16 20:56:39', 'lakj ', 'lkjas', '6.jpg', 1, 1),
(36, '2013-11-16 20:56:39', 'asjl;', 'alkjsak sdlj asdlkf salfja oiaj oafjw cnxzknaw owi xzn', '7.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin1', '0192023a7bbd73250516f069df18b500', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(200) NOT NULL,
  `series` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `summonerName` varchar(100) NOT NULL,
  `startTime` varchar(10) NOT NULL,
  `endTime` varchar(10) NOT NULL,
  `vidPath` varchar(100) NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
