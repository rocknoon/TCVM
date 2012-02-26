-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 02 月 26 日 11:37
-- 服务器版本: 5.0.92
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `tcvmcoma_tcvm`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_add` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `apply_etf`
--

DROP TABLE IF EXISTS `apply_etf`;
CREATE TABLE IF NOT EXISTS `apply_etf` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` varchar(50) NOT NULL,
  `info` text,
  `date_add` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `log_adaptive`
--

DROP TABLE IF EXISTS `log_adaptive`;
CREATE TABLE IF NOT EXISTS `log_adaptive` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `pay_key` varchar(255) NOT NULL,
  `date_add` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `log_payment_error`
--

DROP TABLE IF EXISTS `log_payment_error`;
CREATE TABLE IF NOT EXISTS `log_payment_error` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `payment` tinyint(1) NOT NULL,
  `error` text NOT NULL,
  `date_add` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `log_payment_success`
--

DROP TABLE IF EXISTS `log_payment_success`;
CREATE TABLE IF NOT EXISTS `log_payment_success` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `transaction_id` varchar(100) default NULL,
  `payment` tinyint(1) NOT NULL,
  `info` text,
  `date_add` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `status` int(5) NOT NULL,
  `cart_info` text NOT NULL,
  `total_price` float NOT NULL,
  `date_add` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `product_courses`
--

DROP TABLE IF EXISTS `product_courses`;
CREATE TABLE IF NOT EXISTS `product_courses` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) default NULL,
  `desc` text,
  `visible` tinyint(1) NOT NULL default '1',
  `paypal` varchar(10) NOT NULL,
  `time_start` int(11) NOT NULL,
  `time_end` int(11) NOT NULL,
  `before_price` float NOT NULL,
  `now_price` float NOT NULL,
  `date_add` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date_add` (`date_add`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) default NULL,
  `last_name` varchar(50) default NULL,
  `billing_address_1` varchar(255) default NULL,
  `billing_address_2` varchar(255) default NULL,
  `zip_code` varchar(100) default NULL,
  `city` varchar(50) default NULL,
  `state` varchar(60) default NULL,
  `telephone` varchar(100) default NULL,
  `mobile` varchar(100) default NULL,
  `registration_basic_defualt` text,
  `findpassword_code` varchar(255) default NULL,
  `findpassword_code_used` tinyint(4) default NULL,
  `date_add` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
