-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 16, 2012 at 01:31 AM
-- Server version: 5.1.54
-- PHP Version: 5.3.3-1ubuntu9.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xcel`
--

-- --------------------------------------------------------

--
-- Table structure for table `Clan_gallery_comments`
--

CREATE TABLE IF NOT EXISTS `Clan_gallery_comments` (
  `comment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gallery_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `comment_title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Clan_gallery_comments`
--

INSERT INTO `Clan_gallery_comments` (`comment_id`, `gallery_id`, `user_id`, `comment_title`, `comment_date`) VALUES
(1, 55, 1, 'test', '2012-01-14 01:02:29'),
(3, 66, 5, 'test', '2012-01-14 05:37:53'),
(4, 56, 4, 'i love this bridge!', '2012-01-14 05:44:29'),
(7, 67, 1, 'sleek too!', '2012-01-14 06:05:16'),
(6, 67, 5, 'sleak', '2012-01-14 06:01:27');
