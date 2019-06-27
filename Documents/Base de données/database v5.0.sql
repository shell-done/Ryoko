SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `Ryoko`
--

DROP database IF EXISTS Ryoko;
CREATE database Ryoko;
USE Ryoko;


--
-- Structure de la table `Booking`
--

CREATE TABLE `Booking` (
  `id_travel` int(11) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `departure_date` date NOT NULL,
  `return_date` date NOT NULL,
  `total_cost` float NOT NULL,
  `validation_status` varchar(8) NOT NULL DEFAULT 'WAITING',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Structure de la table `Country`
--

CREATE TABLE `Country` (
  `iso_code` varchar(3) NOT NULL,
  `name` varchar(64) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Structure de la table `Travel`
--

CREATE TABLE `Travel` (
  `id_travel` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `cost` float NOT NULL,
  `img_directory` varchar(128) NOT NULL,
  `country_code` varchar(3) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `email` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `city` varchar(64) NOT NULL,
  `zip_code` varchar(16) NOT NULL,
  `street` varchar(128) NOT NULL,
  `birth_date` date NOT NULL,
  `country_code` varchar(3) NOT NULL,
  `token` varchar(32) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Index pour les tables exportées
--

--
-- Index pour la table `Booking`
--
ALTER TABLE `Booking`
  ADD PRIMARY KEY (`id_travel`,`user_email`),
  ADD KEY `FK_BOOKING_USER` (`user_email`);

--
-- Index pour la table `Country`
--
ALTER TABLE `Country`
  ADD PRIMARY KEY (`iso_code`);

--
-- Index pour la table `Travel`
--
ALTER TABLE `Travel`
  ADD PRIMARY KEY (`id_travel`),
  ADD KEY `FK_TRAVEL_COUNTRY` (`country_code`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`email`),
  ADD KEY `FK_USER_COUNTRY` (`country_code`);

-- -----------------------------------------------------

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Travel`
--
ALTER TABLE `Travel`
  MODIFY `id_travel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
  
 
-- -----------------------------------------------------

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Booking`
--
ALTER TABLE `Booking`
  ADD CONSTRAINT `FK_BOOKING_TRAVEL` FOREIGN KEY (`id_travel`) REFERENCES `Travel` (`id_travel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_BOOKING_USER` FOREIGN KEY (`user_email`) REFERENCES `User` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Travel`
--
ALTER TABLE `Travel`
  ADD CONSTRAINT `FK_TRAVEL_COUNTRY` FOREIGN KEY (`country_code`) REFERENCES `Country` (`iso_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `FK_USER_COUNTRY` FOREIGN KEY (`country_code`) REFERENCES `Country` (`iso_code`) ON UPDATE CASCADE;


--
-- Création d'un utilisateur autorisé
--

DROP USER IF EXISTS 'Ryoko'@'localhost';
CREATE USER 'Ryoko'@'localhost' IDENTIFIED BY '#grp11@Ryoko!';
GRANT ALL PRIVILEGES ON Ryoko.* TO 'Ryoko'@'localhost';


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
