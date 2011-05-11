CREATE DATABASE IF NOT EXISTS `profolio` DEFAULT CHARACTER SET latin1;

USE `profolio`;

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `teamnr` int(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`,`teamnr`),
  KEY `id` (`id`),
  KEY `FK_projects` (`teamnr`),
  CONSTRAINT `FK_projects` FOREIGN KEY (`teamnr`) REFERENCES `teams` (`teamnr`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `studenten`;

CREATE TABLE `studenten` (
  `id` int(9) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `insertion` varchar(10) DEFAULT NULL,
  `lastname` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `year` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `teamnr` int(5) NOT NULL,
  `teamnaam` varchar(50) NOT NULL,
  `leerlingnr` int(9) NOT NULL,
  PRIMARY KEY (`teamnr`,`leerlingnr`),
  KEY `FK_teams` (`leerlingnr`),
  CONSTRAINT `FK_teams` FOREIGN KEY (`leerlingnr`) REFERENCES `studenten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;