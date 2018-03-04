-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `ZeusDb`;

DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FolderId` int(10) unsigned DEFAULT NULL,
  `Name` varchar(50) NOT NULL,
  `Extension` varchar(10) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FolderId` (`FolderId`),
  CONSTRAINT `file_ibfk_1` FOREIGN KEY (`FolderId`) REFERENCES `folder` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `folder`;
CREATE TABLE `folder` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ParentFolderId` int(10) unsigned zerofill DEFAULT NULL,
  `Name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `ParentFolderId` (`ParentFolderId`),
  CONSTRAINT `folder_ibfk_1` FOREIGN KEY (`ParentFolderId`) REFERENCES `folder` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MainFolderId` int(10) unsigned DEFAULT NULL,
  `Firstname` varchar(20) NOT NULL,
  `Surname` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(65) NOT NULL,
  `GuidForEmail` char(40) NOT NULL,
  `GuidForNewPW` char(40) NOT NULL,
  `EmailVerified` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `MainFolderId` (`MainFolderId`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`MainFolderId`) REFERENCES `folder` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `userFileRealease`;
CREATE TABLE `userFileRealease` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserId` int(10) unsigned DEFAULT NULL,
  `FileId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `UserId` (`UserId`),
  KEY `FileId` (`FileId`),
  CONSTRAINT `userFileRealease_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`),
  CONSTRAINT `userFileRealease_ibfk_2` FOREIGN KEY (`FileId`) REFERENCES `file` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `userFolderRealease`;
CREATE TABLE `userFolderRealease` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserId` int(10) unsigned DEFAULT NULL,
  `FolderId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `UserId` (`UserId`),
  KEY `FolderId` (`FolderId`),
  CONSTRAINT `userFolderRealease_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`),
  CONSTRAINT `userFolderRealease_ibfk_2` FOREIGN KEY (`FolderId`) REFERENCES `folder` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2017-06-24 11:28:15
