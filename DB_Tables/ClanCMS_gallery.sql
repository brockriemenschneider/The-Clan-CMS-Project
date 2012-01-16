-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 16, 2012 at 01:28 AM
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
-- Table structure for table `Clan_gallery`
--

CREATE TABLE IF NOT EXISTS `Clan_gallery` (
  `gallery_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `image_slug` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `uploader` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` bigint(20) NOT NULL,
  `comments` bigint(20) NOT NULL,
  `favors` bigint(20) NOT NULL,
  `downloads` bigint(20) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `height` int(4) NOT NULL,
  `width` int(4) NOT NULL,
  `size` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=69 ;

