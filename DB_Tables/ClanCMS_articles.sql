-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2012 at 07:30 PM
-- Server version: 5.1.58
-- PHP Version: 5.3.6-13ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xcel`
--

-- --------------------------------------------------------

--
-- Table structure for table `ClanCMS_articles`
--

CREATE TABLE IF NOT EXISTS `ClanCMS_articles` (
  `article_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `squad_id` bigint(20) NOT NULL DEFAULT '0',
  `article_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `article_slug` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `article_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `article_comments` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `article_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `article_status` tinyint(1) NOT NULL DEFAULT '0',
  `article_permission` tinyint(1) NOT NULL DEFAULT '1',
  `article_game` varchar(64) NOT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
