-- $Id$

-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 22 apr, 2011 at 08:54 PM
-- Versione MySQL: 5.1.49
-- Versione PHP: 5.3.3-1ubuntu9.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shauku`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `code` varchar(8) NOT NULL,
  `email` varchar(225) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '0',
  `date_added` bigint(20) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
