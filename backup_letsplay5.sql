-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. Jul 2012 um 10:23
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `letsplay5`
--

DROP DATABASE IF EXISTS `letsplay5`;
CREATE DATABASE IF NOT EXISTS `letsplay5` DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

USE letsplay5;

-- --------------------------------------------------------

/*
--
-- Tabellenstruktur für Tabelle `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_bin DEFAULT '',
  `foreign_key` int(10) unsigned DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_bin DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_bin DEFAULT '',
  `alias` varchar(255) COLLATE utf8_bin DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `foreign_key` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) unsigned,
  `aco_id` int(10) unsigned,
  `_create` char(2) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `_read` char(2) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `_update` char(2) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `_delete` char(2) COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_aros_acos_acos1` (`aro_id`),
  KEY `fk_aros_acos_aros1` (`aco_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
*/



--
-- Tabellenstruktur für Tabelle `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `challenger_id` int(11) DEFAULT '0',
  `opponent_id` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `terminated` tinyint(4) DEFAULT '0',
  `winner_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_games_users2` (`challenger_id`),
  KEY `fk_games_users3` (`opponent_id`),
  KEY `fk_games_users1` (`winner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `data` text COLLATE utf8_bin,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `turns`
--

CREATE TABLE IF NOT EXISTS `turns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `game_id` int(11) NOT NULL,
  `creator` int(11) DEFAULT NULL,
  `x` tinyint(4) NOT NULL,
  `y` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_turns_games1` (`game_id`),
  KEY `fk_turns_users1` (`creator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT 'Unknown',
  `password` varchar(40) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `isMale` tinyint(4) DEFAULT '1',
  `group_id` int(11) NOT NULL,
  `storePassword` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_users_groups` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `waitingforgames`
--

CREATE TABLE IF NOT EXISTS `waitingforgames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_waitingForGames_users1` (`user_id`),
  KEY `fk_waitingForGames_cake_sessions1` (`session_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `aros_acos`
--
/*
ALTER TABLE `aros_acos`
  ADD CONSTRAINT `fk_aros_acos_acos1` FOREIGN KEY (`aro_id`) REFERENCES `acos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_aros_acos_aros1` FOREIGN KEY (`aco_id`) REFERENCES `aros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
*/
--
-- Constraints der Tabelle `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `fk_games_users2` FOREIGN KEY (`challenger_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_games_users3` FOREIGN KEY (`opponent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_games_users1` FOREIGN KEY (`winner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `turns`
--
ALTER TABLE `turns`
  ADD CONSTRAINT `fk_turns_games1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_turns_users1` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

  
  
  
  
--
-- Inserts default values / group
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Administrator', '2012-07-07 18:16:04', '2012-07-07 18:16:26'),
(2, 'Moderator', '2012-07-07 18:16:09', '2012-07-07 18:16:09'),
(3, 'Registered', '2012-07-07 18:16:16', '2012-07-07 18:16:16'),
(4, 'Anonymous', '2012-07-07 23:06:53', '2012-07-07 23:06:53');


  
  
 
INSERT INTO `users` (`id`, `username`, `password`, `email`, `created`, `modified`, `score`, `isMale`, `group_id`, `storePassword`) VALUES
(1, 'user', '46df4a13034942d363c8c9be702380ecfc5adc9c', '', '2012-07-07 18:56:17', '2012-07-07 18:56:17', 0, 1, 3, NULL),
(2, 'admin', '39a06327c87c9e3563a4b6cc136db546cd723a62', '', '2012-07-07 20:29:39', '2012-07-07 20:29:39', 0, 1, 1, NULL),
(3, 'Moderator', '3abfe6335f246c0becb374b4b1a7a5f09df58bbe', 'moderator@moderator.mod', '2012-07-08 00:00:00', '2012-07-08 20:03:43', 0, 1, 2, NULL);

  
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
