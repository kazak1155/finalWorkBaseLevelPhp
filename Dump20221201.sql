-- MySQL dump 10.13  Distrib 5.7.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cloud_storage
-- ------------------------------------------------------
-- Server version	5.7.38-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_file_idx` (`user`),
  CONSTRAINT `user_file` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'11',1,'1','2001-01-01'),(2,'22',2,'2','2002-02-02'),(3,'33',3,'3','2003-03-03');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_admin`
--

DROP TABLE IF EXISTS `menu_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_admin`
--

LOCK TABLES `menu_admin` WRITE;
/*!40000 ALTER TABLE `menu_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_user`
--

DROP TABLE IF EXISTS `menu_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_user`
--

LOCK TABLES `menu_user` WRITE;
/*!40000 ALTER TABLE `menu_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'ivan','ivanov','$2y$10$RNfilcfMVgPpX/l7IAfBNuRBnNj6aesjHYM.TO73kmgrTj875SiCm','111@mail.com','2001-01-01',NULL,'user'),(2,'petr','petrov','$2y$10$lCNPFif03QGj2SlLdxkSZe3liiBfH4eebwg2r0Yb1D0UpqUPS20P2','222@mail.com','2002-02-02','2022-11-20','administrator'),(3,'semen','semenov','$2y$10$YiYsDTB5YfN8L3N0DAvfQOCpBUVKJ4K5dtwzTynpjeoYBjvaVflfm','333@mail.com','2003-03-03',NULL,'user'),(4,'andrey','andreev','$2y$10$Tt10htkln1MaacrRjtHDmuIG1fjmjN1t0THdKqzktQXriRBPkZ/Sy','444@mail.com','2003-04-04',NULL,'administrator'),(5,'alexandr','alexandrov','$2y$10$ASRBS1bXGw37hWiQ.klRLOjv80vSXmmnQQEzjMwaI2EI4SArvP0Cm','555@mail.com','2003-05-05',NULL,'user'),(6,'test1','test1','$2y$10$IgcsMJcVCPSQCy0pUuKBMuucIJzf6zvb33F373S8HJ63o5KApAlsC','test1@mail.com','2003-06-06',NULL,'user'),(7,'test2','test2','$2y$10$31K1C3Sc9kykEjP1ZyIOb.lgtTfbtd1o9fMWEAjFH73i1N2rASGvK','test2@mail.com','2003-07-07',NULL,'user'),(8,'test3','test3','$2y$10$SXJETJW/OBoOzjfYfWsK2.SynTfwqUeD2Um2lTns5GAB0178mXyB6','test3@mail.com','2003-08-08',NULL,'user');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-01 13:50:09
