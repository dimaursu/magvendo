-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2015 at 07:13 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mag`
--

-- --------------------------------------------------------

--
-- Table structure for table `mag_categories`
--

CREATE TABLE IF NOT EXISTS `mag_categories` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_customers`
--

CREATE TABLE IF NOT EXISTS `mag_customers` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `card` int(11) DEFAULT NULL,
  `card_discount` tinyint(4) NOT NULL DEFAULT '0',
  `registered_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `birthday` date DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_fabricated`
--

CREATE TABLE IF NOT EXISTS `mag_fabricated` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` bigint(20) NOT NULL DEFAULT '1',
  `salary` float(20,2) NOT NULL DEFAULT '0.00',
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `magazine_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_magazines`
--

CREATE TABLE IF NOT EXISTS `mag_magazines` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_products`
--

CREATE TABLE IF NOT EXISTS `mag_products` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `quantity` bigint(10) NOT NULL DEFAULT '0',
  `price` bigint(10) NOT NULL DEFAULT '0',
  `discount` int(3) NOT NULL DEFAULT '0',
  `category_id` bigint(10) NOT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `registered_date` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM AUTO_INCREMENT=1511 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_products_percents`
--

CREATE TABLE IF NOT EXISTS `mag_products_percents` (
`id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(11) DEFAULT NULL,
  `sell_percent` float(10,2) DEFAULT NULL,
  `repare_percent` float(10,2) DEFAULT NULL,
  `fabricated_percent` float(3,2) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_repared`
--

CREATE TABLE IF NOT EXISTS `mag_repared` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` bigint(20) NOT NULL DEFAULT '0',
  `quantity` bigint(20) NOT NULL DEFAULT '1',
  `salary_percent` bigint(20) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `magazine_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_sales`
--

CREATE TABLE IF NOT EXISTS `mag_sales` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` bigint(20) NOT NULL DEFAULT '0',
  `quantity` bigint(20) NOT NULL DEFAULT '1',
  `discount` bigint(20) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `magazine_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `salary_percent` bigint(20) NOT NULL DEFAULT '0',
  `product_id` bigint(20) DEFAULT NULL,
  `card_number` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2854 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_settings`
--

CREATE TABLE IF NOT EXISTS `mag_settings` (
`id` bigint(10) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_users`
--

CREATE TABLE IF NOT EXISTS `mag_users` (
`id` bigint(20) unsigned NOT NULL,
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
  `last_login` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mag_workers`
--

CREATE TABLE IF NOT EXISTS `mag_workers` (
`id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `work_role` int(3) DEFAULT NULL,
  `magazine_id` int(10) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mag_categories`
--
ALTER TABLE `mag_categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_customers`
--
ALTER TABLE `mag_customers`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `card` (`card`);

--
-- Indexes for table `mag_fabricated`
--
ALTER TABLE `mag_fabricated`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_magazines`
--
ALTER TABLE `mag_magazines`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_products`
--
ALTER TABLE `mag_products`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_products_percents`
--
ALTER TABLE `mag_products_percents`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_repared`
--
ALTER TABLE `mag_repared`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_sales`
--
ALTER TABLE `mag_sales`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_settings`
--
ALTER TABLE `mag_settings`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `mag_users`
--
ALTER TABLE `mag_users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_workers`
--
ALTER TABLE `mag_workers`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mag_categories`
--
ALTER TABLE `mag_categories`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `mag_customers`
--
ALTER TABLE `mag_customers`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `mag_fabricated`
--
ALTER TABLE `mag_fabricated`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `mag_magazines`
--
ALTER TABLE `mag_magazines`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mag_products`
--
ALTER TABLE `mag_products`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1511;
--
-- AUTO_INCREMENT for table `mag_products_percents`
--
ALTER TABLE `mag_products_percents`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `mag_repared`
--
ALTER TABLE `mag_repared`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `mag_sales`
--
ALTER TABLE `mag_sales`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2854;
--
-- AUTO_INCREMENT for table `mag_settings`
--
ALTER TABLE `mag_settings`
MODIFY `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `mag_users`
--
ALTER TABLE `mag_users`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `mag_workers`
--
ALTER TABLE `mag_workers`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
