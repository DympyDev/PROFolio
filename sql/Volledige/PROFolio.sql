CREATE DATABASE IF NOT EXISTS `profolio` DEFAULT CHARACTER SET latin1;

USE `profolio`;

DROP TABLE IF EXISTS `studenten`;

CREATE TABLE `studenten` (
  `id` INT(9) NOT NULL,
  `firstname` VARCHAR(25) NOT NULL,
  `insertion` VARCHAR(10) DEFAULT NULL,
  `lastname` VARCHAR(25) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `email` VARCHAR(25) NOT NULL,
  `year` YEAR(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `teamnr` INT(5) NOT NULL,
  `teamnaam` VARCHAR(50) NOT NULL,
  `leerlingnr` INT(9) NOT NULL,
  PRIMARY KEY (`teamnr`,`leerlingnr`),
  KEY `FK_teams` (`leerlingnr`),
  CONSTRAINT `FK_teams` FOREIGN KEY (`leerlingnr`) REFERENCES `studenten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `teamnr` INT(5) NOT NULL,
  `name` VARCHAR(20) NOT NULL,
  `description` VARCHAR(250) DEFAULT NULL,
  `year` YEAR(4) DEFAULT NULL,
  PRIMARY KEY (`id`,`teamnr`),
  KEY `id` (`id`),
  KEY `FK_projects` (`teamnr`),
  CONSTRAINT `FK_projects` FOREIGN KEY (`teamnr`) REFERENCES `teams` (`teamnr`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=latin1;