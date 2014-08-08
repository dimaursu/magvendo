-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2014 at 02:38 PM
-- Server version: 5.5.38-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crystal`
--

-- --------------------------------------------------------

--
-- Table structure for table `mag_categories`
--

CREATE TABLE IF NOT EXISTS `mag_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Table structure for table `mag_fabricated`
--

CREATE TABLE IF NOT EXISTS `mag_fabricated` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `quantity` bigint(20) NOT NULL DEFAULT '1',
  `salary` float(20,2) NOT NULL DEFAULT '0.00',
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `magazine_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- Table structure for table `mag_magazines`
--

CREATE TABLE IF NOT EXISTS `mag_magazines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `mag_products`
--

CREATE TABLE IF NOT EXISTS `mag_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `quantity` bigint(10) NOT NULL DEFAULT '0',
  `price` bigint(10) NOT NULL DEFAULT '0',
  `discount` int(3) NOT NULL DEFAULT '0',
  `category_id` bigint(10) NOT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `registered_date` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1511 ;

-- --------------------------------------------------------

--
-- Table structure for table `mag_products_percents`
--

CREATE TABLE IF NOT EXISTS `mag_products_percents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(11) DEFAULT NULL,
  `sell_percent` float(10,2) DEFAULT NULL,
  `repare_percent` float(10,2) DEFAULT NULL,
  `fabricated_percent` float(3,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `mag_repared`
--

CREATE TABLE IF NOT EXISTS `mag_repared` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` bigint(20) NOT NULL DEFAULT '0',
  `quantity` bigint(20) NOT NULL DEFAULT '1',
  `salary_percent` bigint(20) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `magazine_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Table structure for table `mag_sales`
--

CREATE TABLE IF NOT EXISTS `mag_sales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` bigint(20) NOT NULL DEFAULT '0',
  `quantity` bigint(20) NOT NULL DEFAULT '1',
  `discount` bigint(20) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `magazine_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `salary_percent` bigint(20) NOT NULL DEFAULT '0',
  `product_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2784 ;

-- --------------------------------------------------------

--
-- Table structure for table `mag_settings`
--

CREATE TABLE IF NOT EXISTS `mag_settings` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `mag_users`
--

CREATE TABLE IF NOT EXISTS `mag_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `phone` varchar(60) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `address` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `role` tinyint(1) DEFAULT '0',
  `registered_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_login` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `mag_workers`
--

CREATE TABLE IF NOT EXISTS `mag_workers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `work_role` int(3) DEFAULT NULL,
  `magazine_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
