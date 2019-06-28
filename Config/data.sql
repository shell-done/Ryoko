-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Ryoko
-- ------------------------------------------------------
-- Server version	10.1.38-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP database IF EXISTS Ryoko;
CREATE database Ryoko;
USE Ryoko;

--
-- Table structure for table `Booking`
--

DROP TABLE IF EXISTS `Booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Booking` (
  `id_travel` int(11) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `departure_date` date NOT NULL,
  `return_date` date NOT NULL,
  `total_cost` float NOT NULL,
  `validation_status` varchar(8) NOT NULL DEFAULT 'WAITING',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_travel`,`user_email`),
  KEY `FK_BOOKING_USER` (`user_email`),
  CONSTRAINT `FK_BOOKING_TRAVEL` FOREIGN KEY (`id_travel`) REFERENCES `Travel` (`id_travel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_BOOKING_USER` FOREIGN KEY (`user_email`) REFERENCES `User` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Booking`
--

LOCK TABLES `Booking` WRITE;
/*!40000 ALTER TABLE `Booking` DISABLE KEYS */;
INSERT INTO `Booking` VALUES (16,'dupont.jean@mail.com','2019-06-28','2019-07-19',1310,'WAITING','2019-06-28 08:18:31','2019-06-28 08:18:31'),(18,'test@test.fr','2019-06-28','2019-07-06',1169,'WAITING','2019-06-28 08:19:52','2019-06-28 08:19:52'),(19,'dupont.jean@mail.com','2019-06-28','2019-07-14',399,'WAITING','2019-06-28 08:18:36','2019-06-28 08:18:36'),(21,'dupont.jean@mail.com','2019-06-28','2019-07-05',100,'WAITING','2019-06-28 08:18:33','2019-06-28 08:18:33'),(21,'test@test.fr','2019-06-28','2019-07-05',100,'WAITING','2019-06-28 08:19:55','2019-06-28 08:19:55');
/*!40000 ALTER TABLE `Booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Country`
--

DROP TABLE IF EXISTS `Country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Country` (
  `iso_code` varchar(3) NOT NULL,
  `name` varchar(64) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`iso_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Country`
--

LOCK TABLES `Country` WRITE;
/*!40000 ALTER TABLE `Country` DISABLE KEYS */;
INSERT INTO `Country` VALUES ('AU','Australie','2019-06-28 07:29:05','2019-06-28 07:29:05'),('BM','Bermuda','2019-06-28 07:29:40','2019-06-28 07:29:40'),('BR','Brésil','2019-06-28 07:30:00','2019-06-28 07:30:00'),('BS','Bahamas','2019-06-28 07:29:22','2019-06-28 07:29:22'),('CA','Canada','2019-06-28 07:30:21','2019-06-28 07:30:21'),('CN','Chine','2019-06-28 07:30:30','2019-06-28 07:30:30'),('CU','Cuba','2019-06-28 07:30:56','2019-06-28 07:30:56'),('CY','Chypre','2019-06-28 07:31:12','2019-06-28 07:31:12'),('DE','Allemagne','2019-06-28 07:32:07','2019-06-28 07:32:07'),('DZ','Algérie','2019-06-28 07:28:17','2019-06-28 07:28:17'),('EG','Egypte','2019-06-28 07:31:28','2019-06-28 07:31:28'),('FR','France','2019-06-28 07:31:42','2019-06-28 07:31:42'),('GB','Royaume-Uni','2019-06-28 07:36:56','2019-06-28 07:36:56'),('GP','Guadeloupe','2019-06-28 07:33:55','2019-06-28 07:33:55'),('GR','Grèce','2019-06-28 07:32:35','2019-06-28 07:32:35'),('HK','Hong Kong','2019-06-28 07:34:09','2019-06-28 07:34:09'),('IN','Inde','2019-06-28 07:34:18','2019-06-28 07:34:18'),('IT','Italie','2019-06-28 07:34:59','2019-06-28 07:34:59'),('TR','Turquie','2019-06-28 07:34:37','2019-06-28 07:34:37'),('US','Etats-Unis','2019-06-28 07:36:28','2019-06-28 07:36:28');
/*!40000 ALTER TABLE `Country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Travel`
--

DROP TABLE IF EXISTS `Travel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Travel` (
  `id_travel` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `cost` float NOT NULL,
  `img_directory` varchar(128) NOT NULL,
  `country_code` varchar(3) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_travel`),
  KEY `FK_TRAVEL_COUNTRY` (`country_code`),
  CONSTRAINT `FK_TRAVEL_COUNTRY` FOREIGN KEY (`country_code`) REFERENCES `Country` (`iso_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Travel`
--

LOCK TABLES `Travel` WRITE;
/*!40000 ALTER TABLE `Travel` DISABLE KEYS */;
INSERT INTO `Travel` VALUES (16,'CLUB FTI VOYAGES MUSKEBI - 4','Classé 4 étoiles par nos experts ! Face à la mer, avec un accès direct à une plage de 150m de long, appréciez le cadre fleuri...',21,1310,'travels/3182f3d1905232ce/','TR','2019-06-28 07:52:00','2019-06-28 08:16:53'),(18,'ILES GRECQUES | SÉJOUR CORFOU','Vols + Transferts + Club + Tout inclus\r\n\r\nAu départ de Paris\r\n\r\nVous aimerez :\r\n\r\nAmbiance chaleureuse, familiale et conviviale\r\nAu cœur de Gouvia avec vue sur la baie\r\nIdéal pour les familles',8,1169,'travels/1699b12b5582e832/','GR','2019-06-28 08:16:11','2019-06-28 08:16:11'),(19,'HÔTEL CRETA RESIDENCE (AVEC TRANSPORT)','Surnommée \"l\'île aux Dieux\", la Crète possède un patrimoine culturel indéniable. \r\nCette île magique réunit histoire et traditions, culture et nature, plaisirs de l\'exercice physique et de l\'esprit, joies de la table et du partage. Que l\'on plonge dans la mer ou dans l\'Antiquité, que l\'on coure les chemins escarpés ou les terrasses festives, ...',16,399,'travels/126bf3bd6f4dd00a/','GR','2019-06-28 08:16:11','2019-06-28 08:16:11'),(21,'CAMPING L\'ÉTANG DU PAYS BLANC 3 - GUÉRANDE','Sur la presqu\'île de Guérande. Idéalement situé, à la fois à proximité de la cité médiévale de Guérande, des plages de La Baule, des marais salants, du parc régional de Brière et à moins d\'1 heure de Nantes. Au calme, au coeur de la nature et à 50 m de l\'étang de Sandun. Camping : Mobil-homes, chalets, bungalows toilés, et hébergements plus atypiques comme des roulottes. Sur place, à disposition : étang privatif, piscine couverte chauffée et pataugeoire, espace bien-être avec bain à remous et sauna, mini-ferme, snack-bar. Animations : Mini-club, espace jeux et salle de jeux (flipper, billard, baby-foot), balades en poney ou en carriole, bulle gonflable pour marcher sur l\'eau, activités en journée et animations en soirée.',7,100,'travels/13a0e8341ae8b271/','FR','2019-06-28 08:18:06','2019-06-28 08:18:06');
/*!40000 ALTER TABLE `Travel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`),
  KEY `FK_USER_COUNTRY` (`country_code`),
  CONSTRAINT `FK_USER_COUNTRY` FOREIGN KEY (`country_code`) REFERENCES `Country` (`iso_code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES ('dupont.jean@mail.com','aa3c8f68b0d27359e9ecceea035d4875069ef7b0ae7be8b56c2054d3e2a5f051','Dupon','Jean','0606060606','Brest','29200','5 rue de la rue','1985-02-19','FR','5d15cb76e8c2c6.43221658','2019-06-28 08:05:43','2019-06-28 08:10:30'),('test@test.fr','15dfe842cd5eb4a591465c8e8927e16cd2b16e3ca7b4312933d763882f38270f','test','Test','0610101010','Quimper','29000','5 rue rue','2019-06-27','FR','5d15cda1c48e09.38745679','2019-06-28 08:19:45','2019-06-28 08:19:45');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

DROP USER IF EXISTS 'Ryoko'@'localhost';
CREATE USER 'Ryoko'@'localhost' IDENTIFIED BY '#grp11@Ryoko!';
GRANT ALL PRIVILEGES ON Ryoko.* TO 'Ryoko'@'localhost';

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-28  8:21:16
