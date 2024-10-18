DROP DATABASE IF EXISTS proefexamen;
CREATE DATABASE proefexamen;
USE proefexamen;

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `gebruikersnaam` varchar(255) DEFAULT NULL,
  `wachtwoord` varchar(255) DEFAULT NULL,
  `registratiedatum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_verkiesbaar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `partijen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partijnaam` varchar(255) NOT NULL,
  `datum_oprichting` date NOT NULL,
  `is_actief` tinyint(1) DEFAULT '1',
  `leider_id` int(11),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`leider_id`) REFERENCES `gebruikers`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

COMMIT;
