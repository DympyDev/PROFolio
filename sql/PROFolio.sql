CREATE DATABASE IF NOT EXISTS profolio`;

USE `profolio`;

DROP TABLE IF EXISTS `projects`;
DROP TABLE IF EXISTS `studenten`;

CREATE TABLE `studenten` (
  `id` INT(9) NOT NULL,     /*LLNR van de HvA*/
  `username` VARCHAR(25) NOT NULL,
  `firstname` VARCHAR(25) NOT NULL,
  `insertion` VARCHAR(10) DEFAULT NULL,
  `lastname` VARCHAR(25) NOT NULL,
  `password` VARCHAR(25) NOT NULL,
  `email` VARCHAR(25) NOT NULL,
  `year` YEAR(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

CREATE TABLE `projects` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `studentid` INT(9) NOT NULL,
  `name` VARCHAR(20) NOT NULL,
  `description` VARCHAR(250) DEFAULT NULL,
  `year` YEAR(4) DEFAULT NULL,
  PRIMARY KEY (`id`,`studentid`),
  FOREIGN KEY (`studentid`) REFERENCES `studenten`(`id`),
  KEY `id` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;