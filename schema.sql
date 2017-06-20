-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `app` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `app`;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `category_Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category` (`category_Id`, `name`) VALUES
(1,	'Food'),
(2,	'Clothing'),
(3,	'Rent'),
(4,	'Car'),
(6,	'Hobby');

DROP TABLE IF EXISTS `configuration`;
CREATE TABLE `configuration` (
  `config_Id` int(11) NOT NULL AUTO_INCREMENT,
  `user_Id` int(11) NOT NULL,
  `monthlyBudget` double NOT NULL,
  `resetType` enum('endMonth','beginMonth','userDate') NOT NULL,
  `resetDate` int(11) DEFAULT NULL,
  PRIMARY KEY (`config_Id`),
  KEY `user_Id` (`user_Id`),
  CONSTRAINT `configuration_ibfk_1` FOREIGN KEY (`user_Id`) REFERENCES `user` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `entry`;
CREATE TABLE `entry` (
  `entry_Id` int(11) NOT NULL AUTO_INCREMENT,
  `category_Id` int(11) NOT NULL,
  `user_Id` int(11) NOT NULL,
  `amountOfMoney` double NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`entry_Id`),
  KEY `user_Id` (`user_Id`),
  KEY `category_Id` (`category_Id`),
  CONSTRAINT `entry_ibfk_1` FOREIGN KEY (`user_Id`) REFERENCES `user` (`Id`),
  CONSTRAINT `entry_ibfk_2` FOREIGN KEY (`category_Id`) REFERENCES `category` (`category_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Gender` enum('Male','Female') NOT NULL,
  `DateOfBirth` date NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `person_Id` int(11) NOT NULL,
  `config_Id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `resetPoint` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `person_Id` (`person_Id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`person_Id`) REFERENCES `person` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2017-06-20 20:19:24
