SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `Conversions` (
  `station` varchar(32) NOT NULL,
  `mesure` varchar(16) NOT NULL,
  `a` float NOT NULL,
  `b` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Fonction affine de conversion';

INSERT INTO `Conversions` (`station`, `mesure`, `a`, `b`) VALUES
('Alboussière', 'pressure', 0.585938, 450),
('Alboussière', 'temp1', 0.078125, -30),
('Alboussière', 'temp2', 0.078125, -30),
('Montélimar', 'pressure', 0.585938, 500),
('Montélimar', 'temp1', 0.078125, -30),
('Montélimar', 'temp2', 0.078125, -30);

CREATE TABLE `Mesures` (
  `station` varchar(32) NOT NULL,
  `quand` datetime NOT NULL,
  `temp1` float DEFAULT NULL,
  `temp2` float DEFAULT NULL,
  `pressure` smallint(6) DEFAULT NULL,
  `lux` int(11) DEFAULT NULL,
  `hygro` smallint(6) DEFAULT NULL,
  `windSpeed` float DEFAULT NULL,
  `windDir` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Mesures d''une station donnée à un instant donné';

INSERT INTO `Mesures` (`station`, `quand`, `temp1`, `temp2`, `pressure`, `lux`, `hygro`, `windSpeed`, `windDir`) VALUES
('Alboussière', '2015-10-25 10:00:00', 5.5, 4, 1008, NULL, NULL, NULL, NULL),
('Alboussière', '2015-10-25 10:30:00', 6, 5, 1008, NULL, NULL, NULL, NULL),
('Alboussière', '2015-10-25 11:00:00', 6.5, 6.5, 1008, NULL, NULL, NULL, NULL),
('Alboussière', '2015-10-25 11:30:00', 7, 7.5, 1008, NULL, NULL, NULL, NULL),
('Alboussière', '2015-10-25 12:00:00', 8.5, 8, 1007, NULL, NULL, NULL, NULL),
('Alboussière', '2015-10-25 12:30:00', 9, 8, 1007, NULL, NULL, NULL, NULL),
('Montélimar', '2015-10-25 10:00:00', 7.5, 6, 1010, NULL, NULL, NULL, NULL),
('Montélimar', '2015-10-25 10:30:00', 8, 8, 1010, NULL, NULL, NULL, NULL),
('Montélimar', '2015-10-25 11:00:00', 8.5, 9, 1009, NULL, NULL, NULL, NULL),
('Montélimar', '2015-10-25 11:30:00', 9, 10, 1009, NULL, NULL, NULL, NULL),
('Montélimar', '2015-10-25 12:00:00', 9.5, 11, 1009, NULL, NULL, NULL, NULL),
('Montélimar', '2015-10-25 12:30:00', 10, 12, 1009, NULL, NULL, NULL, NULL);

CREATE TABLE `Stations` (
  `id` varchar(32) NOT NULL,
  `libelle` varchar(128) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `altitude` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Description d''une station';

INSERT INTO `Stations` (`id`, `libelle`, `latitude`, `longitude`, `altitude`) VALUES
('Alboussière', 'Station d''altitude du pays de Crussol', 44.9434, 4.72924, 547),
('Montélimar', 'Station du vrai début du Sud', 44.5569, 4.7495, 86);


ALTER TABLE `Conversions`
  ADD PRIMARY KEY (`station`,`mesure`);

ALTER TABLE `Mesures`
  ADD PRIMARY KEY (`station`,`quand`);

ALTER TABLE `Stations`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
