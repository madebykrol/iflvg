-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 17 okt 2016 kl 14:11
-- Serverversion: 5.7.9
-- PHP-version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `iflvg`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `file`
--

DROP TABLE IF EXISTS `file`;
CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(45) DEFAULT NULL,
  `path` longtext,
  `mime` varchar(45) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reference` (`reference`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `memberships`
--

DROP TABLE IF EXISTS `memberships`;
CREATE TABLE IF NOT EXISTS `memberships` (
  `ident` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `is_locked_out` tinyint(1) NOT NULL DEFAULT '0',
  `failed_password_attempts` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ident`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `memberships`
--

INSERT INTO `memberships` (`ident`, `email`, `password`, `create_date`, `is_approved`, `is_locked_out`, `failed_password_attempts`) VALUES
('ab5d17b7-2560-4263-ba25-dce5e44c89e0', 'kristoffer.two@gmail.com', '$2a$08$/m0hmirP5tcQH5Q0/ogsievGpJ5KbwNoizAlLhXTPCPcnC3RUr7ay', '2016-04-20 07:45:52', 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `application` varchar(100) NOT NULL,
  `role_id` varchar(100) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `application` varchar(100) NOT NULL,
  `ident` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `last_active_date` datetime DEFAULT NULL,
  PRIMARY KEY (`ident`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`application`, `ident`, `username`, `last_active_date`) VALUES
('#1', 'ab5d17b7-2560-4263-ba25-dce5e44c89e0', 'ksdkrol', '2016-04-20 07:45:52');

-- --------------------------------------------------------

--
-- Tabellstruktur `users_in_roles`
--

DROP TABLE IF EXISTS `users_in_roles`;
CREATE TABLE IF NOT EXISTS `users_in_roles` (
  `user_ident` varchar(100) NOT NULL,
  `role_id` varchar(100) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
