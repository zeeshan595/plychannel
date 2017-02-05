-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2013 at 11:48 AM
-- Server version: 5.5.34-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Plychannel`
--
CREATE DATABASE IF NOT EXISTS `Plychannel` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `Plychannel`;

-- --------------------------------------------------------

--
-- Table structure for table `Adds`
--

CREATE TABLE IF NOT EXISTS `Adds` (
  `transactionID` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(25) NOT NULL,
  `imageUrl` varchar(200) NOT NULL,
  `time` int(11) NOT NULL,
  `addLevel` int(11) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Link` varchar(200) NOT NULL,
  UNIQUE KEY `transactionID` (`transactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `channelcomments`
--

CREATE TABLE IF NOT EXISTS `channelcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel` varchar(50) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `author` varchar(50) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `commentlikes`
--

CREATE TABLE IF NOT EXISTS `commentlikes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `commentID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `liked` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `videoID` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `time` int(11) NOT NULL,
  `author` varchar(50) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=202 ;

-- --------------------------------------------------------

--
-- Table structure for table `defaults`
--

CREATE TABLE IF NOT EXISTS `defaults` (
  `title` varchar(50) NOT NULL,
  `Privacy` varchar(1) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Tags` longtext NOT NULL,
  `Category` varchar(50) NOT NULL,
  `allowComs` tinyint(1) NOT NULL,
  `author` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `VideoID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Liked` tinyint(1) NOT NULL,
  `Time` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=978 ;

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE IF NOT EXISTS `playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `discription` varchar(500) NOT NULL,
  `owner` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `playlist_videos`
--

CREATE TABLE IF NOT EXISTS `playlist_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `videoNumber` int(11) NOT NULL,
  `playlistID` int(11) NOT NULL,
  `videoID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `Time` int(11) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Subscribed` varchar(50) NOT NULL,
  `Email` tinyint(1) NOT NULL,
  `Order` int(11) NOT NULL,
  `Videos` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `Username` (`Username`,`Subscribed`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `userhistory`
--

CREATE TABLE IF NOT EXISTS `userhistory` (
  `username` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  `videoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Blocked` tinyint(1) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `ChannelName` varchar(50) NOT NULL,
  `About` longtext NOT NULL,
  `Background` varchar(200) NOT NULL,
  `Image` blob NOT NULL,
  `Channelvideo` varchar(50) NOT NULL,
  `Code` int(30) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `Time` int(11) NOT NULL,
  `Session` varchar(50) NOT NULL,
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `VideoRportings`
--

CREATE TABLE IF NOT EXISTS `VideoRportings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) NOT NULL,
  `videoID` int(11) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(80) NOT NULL,
  `Discription` longtext NOT NULL,
  `Views` int(11) NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Time` int(11) NOT NULL,
  `Privacy` varchar(1) NOT NULL,
  `Tags` longtext NOT NULL,
  `Category` varchar(20) NOT NULL,
  `Likes` int(11) NOT NULL,
  `Dislikes` int(11) NOT NULL,
  `Comments` tinyint(1) NOT NULL,
  `Uploaded` tinyint(1) NOT NULL,
  `ViewsAllow` longtext NOT NULL,
  `URL` varchar(200) NOT NULL,
  `reports` int(50) NOT NULL,
  `Length` varchar(11) NOT NULL,
  UNIQUE KEY `id` (`ID`),
  FULLTEXT KEY `Title` (`Title`,`Author`,`Tags`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2745 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
