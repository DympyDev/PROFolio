ALTER TABLE `projects` DROP FOREIGN KEY `studentid`;
ALTER TABLE `projects` CHANGE `studentid` `teamnr` int(5) NOT NULL;

CREATE TABLE `teams` (
  `teamnr` int(5) NOT NULL,
  `teamnaam` varchar(50) NOT NULL,
  `leerlingnr` int(9) NOT NULL,
  PRIMARY KEY (`teamnr`,`leerlingnr`),
  KEY `FK_teams` (`leerlingnr`),
  CONSTRAINT `Student` FOREIGN KEY (`leerlingnr`) REFERENCES `studenten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `projects` ADD CONSTRAINT `Team` FOREIGN KEY (`teamnr`) REFERENCES `teams` (`teamnr`) ON DELETE CASCADE ON UPDATE CASCADE;