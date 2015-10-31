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
-- Table structure for table `magv_categories`
--

CREATE TABLE IF NOT EXISTS `magv_categories` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `magv_customers`
--

CREATE TABLE IF NOT EXISTS `magv_customers` (
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
-- Table structure for table `magv_fabricated`
--

CREATE TABLE IF NOT EXISTS `magv_fabricated` (
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
-- Table structure for table `magv_magazines`
--

CREATE TABLE IF NOT EXISTS `magv_magazines` (
`id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `magv_products`
--

CREATE TABLE IF NOT EXISTS `magv_products` (
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
-- Table structure for table `magv_products_percents`
--

CREATE TABLE IF NOT EXISTS `magv_products_percents` (
`id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(11) DEFAULT NULL,
  `sell_percent` float(10,2) DEFAULT NULL,
  `repare_percent` float(10,2) DEFAULT NULL,
  `fabricated_percent` float(3,2) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `magv_repared`
--

CREATE TABLE IF NOT EXISTS `magv_repared` (
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
-- Table structure for table `magv_sales`
--

CREATE TABLE IF NOT EXISTS `magv_sales` (
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
-- Table structure for table `magv_settings`
--

CREATE TABLE IF NOT EXISTS `magv_settings` (
`id` bigint(10) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `magv_users`
--

CREATE TABLE IF NOT EXISTS `magv_users` (
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
-- Table structure for table `magv_workers`
--

CREATE TABLE IF NOT EXISTS `magv_workers` (
`id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `work_role` int(3) DEFAULT NULL,
  `magazine_id` int(10) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `magv_categories`
--
ALTER TABLE `magv_categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magv_customers`
--
ALTER TABLE `magv_customers`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `card` (`card`);

--
-- Indexes for table `magv_fabricated`
--
ALTER TABLE `magv_fabricated`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magv_magazines`
--
ALTER TABLE `magv_magazines`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magv_products`
--
ALTER TABLE `magv_products`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magv_products_percents`
--
ALTER TABLE `magv_products_percents`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magv_repared`
--
ALTER TABLE `magv_repared`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magv_sales`
--
ALTER TABLE `magv_sales`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magv_settings`
--
ALTER TABLE `magv_settings`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `magv_users`
--
ALTER TABLE `magv_users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magv_workers`
--
ALTER TABLE `magv_workers`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `magv_categories`
--
ALTER TABLE `magv_categories`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `magv_customers`
--
ALTER TABLE `magv_customers`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `magv_fabricated`
--
ALTER TABLE `magv_fabricated`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `magv_magazines`
--
ALTER TABLE `magv_magazines`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `magv_products`
--
ALTER TABLE `magv_products`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1511;
--
-- AUTO_INCREMENT for table `magv_products_percents`
--
ALTER TABLE `magv_products_percents`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `magv_repared`
--
ALTER TABLE `magv_repared`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `magv_sales`
--
ALTER TABLE `magv_sales`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2854;
--
-- AUTO_INCREMENT for table `magv_settings`
--
ALTER TABLE `magv_settings`
MODIFY `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `magv_users`
--
ALTER TABLE `magv_users`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `magv_workers`
--
ALTER TABLE `magv_workers`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
