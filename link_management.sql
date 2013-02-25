-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2013 at 10:58 AM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `link_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `Backlinks`
--

CREATE TABLE IF NOT EXISTS `Backlinks` (
  `backlinkId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE ucs2_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `visible` int(1) DEFAULT NULL,
  `anchor_text` varchar(1000) COLLATE ucs2_unicode_ci DEFAULT NULL,
  `anchor_status` int(1) DEFAULT NULL,
  `nofollow` int(1) DEFAULT NULL,
  `linkId` int(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`backlinkId`)
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Links`
--

CREATE TABLE IF NOT EXISTS `Links` (
  `linkId` int(255) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci,
  `url` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `webmasterId` int(255) NOT NULL,
  `keyword_notes` varchar(6000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(6000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `backlinks` varchar(6000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `anchor_text` text COLLATE utf8_unicode_ci,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` double(10,2) DEFAULT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`linkId`),
  KEY `FK_Links` (`webmasterId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `Links`
--

INSERT INTO `Links` (`linkId`, `title`, `url`, `webmasterId`, `keyword_notes`, `notes`, `expiration`, `backlinks`, `anchor_text`, `date_added`, `price`, `active`) VALUES
(15, 'Newlink', 'http://www.bangyoulater.com', 39, 'key', 'notes', '2012-01-01', '{"0":{"backlink":"http:\\/\\/backlink.com","name":"backlink1"},"1":{"backlink":"http:\\/\\/secondbacklink.com","name":"backlink2"}}', 'anchr', '2013-02-19 14:55:22', 9.99, 1),
(16, 'Youporn', 'http://www.youporn.com', 39, 'key', 'nots', '2012-01-01', '{"0":{"backlink":"http:\\/\\/www.pornhub.com","name":"backlink1"},"1":{"backlink":"http:\\/\\/www.bangyoulater.com","name":"backlink2"}}', 'anchr', '2013-02-19 14:56:42', 9.99, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Webmasters`
--

CREATE TABLE IF NOT EXISTS `Webmasters` (
  `webmasterId` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_method` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_details` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `webmasterId` (`webmasterId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46 ;

--
-- Dumping data for table `Webmasters`
--

INSERT INTO `Webmasters` (`webmasterId`, `name`, `email`, `phone`, `social`, `payment_method`, `payment_details`, `notes`, `date_added`) VALUES
(38, 'Test', 'test@test.com', '4151542354', 'akshaytwitter', 'paypal', 'paypalemail@gmail.com', 'guys a winner', '2013-02-12 21:10:26'),
(39, 'Test', 'test@test.com', '4151542354', 'akshaytwitter', 'paypal', NULL, 'guys a winner', '2013-02-12 21:59:40'),
(40, '12534534', 'test@test.com', '4151542354', 'akshaytwitter', 'paypal', NULL, 'guys a winner', '2013-02-13 14:33:25'),
(41, 'Akshay', 'test@test.com', '4151542354', 'akshaytwitter', 'paypal', NULL, 'guys a winner', '2013-02-13 14:02:22'),
(42, 'Nottestt', 'test@test.com', '4151542354', 'akshaytwitter', 'paypal', NULL, 'guys a winner', '2013-02-13 14:03:28'),
(43, 'Nottestt', 'test@test.com', '4151542354', 'akshaytwitter', 'paypal', NULL, 'guys a winner', '2013-02-13 14:04:28'),
(44, 'Nottestt', 'test@test.com', '4151542354', 'akshaytwitter', 'paypal', NULL, 'guys a winner', '2013-02-13 14:04:30'),
(45, 'testtersssts', 'test@test.com', '4151542354', 'akshaytwitter', 'paypal', NULL, 'guys a winner', '2013-02-13 14:04:43');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Links`
--
ALTER TABLE `Links`
  ADD CONSTRAINT `FK_Links` FOREIGN KEY (`webmasterId`) REFERENCES `Webmasters` (`webmasterId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
