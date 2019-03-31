-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: dailyactivity
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

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
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(6) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(3) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (146,2,'Lorem ipsum dolor sit amet',3,'2019-08-29'),(147,2,'Nullam ipsum felis',2,'2019-10-24'),(148,2,'Nullam eget ante sodales',4,'2019-05-25'),(149,1,'Cras mollis facilisis arcu nec ornare',3,'2019-07-19'),(150,1,'Quisque convallis arcu nunc',5,'2019-06-12'),(151,11,'Morbi id nulla id erat viverra viverra',2,'2019-10-25'),(152,10,'Curabitur nec vestibulum nibh',2,'2019-09-26'),(153,9,'Vivamus laoreet faucibus maximus',3,'2019-06-28'),(154,12,' Sed viverra justo ac porttitor congue',5,'2019-07-18'),(155,4,'Aliquam ac finibus orci vitae convallis leo',3,'2019-06-17');
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activities_tags`
--

DROP TABLE IF EXISTS `activities_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities_tags` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(6) NOT NULL,
  `tag_id` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=310 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities_tags`
--

LOCK TABLES `activities_tags` WRITE;
/*!40000 ALTER TABLE `activities_tags` DISABLE KEYS */;
INSERT INTO `activities_tags` VALUES (293,146,91),(294,146,92),(295,147,93),(296,147,94),(297,148,91),(298,148,95),(299,148,96),(300,149,97),(301,149,98),(302,150,99),(303,151,100),(304,151,101),(305,152,102),(306,153,94),(307,153,103),(308,154,91),(309,155,99);
/*!40000 ALTER TABLE `activities_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (91,'ipsum'),(92,'dolor'),(93,'felis'),(94,'lorem'),(95,'sodales'),(96,'eget'),(97,'ornare'),(98,'facilisis'),(99,'convallis'),(100,'erat'),(101,'viverra'),(102,'vestibulum'),(103,'maximus');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `account_type` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'5f4dcc3b5aa765d61d8327deb882cf99','leader@test.com',1),(2,'5f4dcc3b5aa765d61d8327deb882cf99','user@test.com',0),(3,'5f4dcc3b5aa765d61d8327deb882cf99','user1@test.com',0),(4,'5f4dcc3b5aa765d61d8327deb882cf99','user2@test.com',0),(5,'5f4dcc3b5aa765d61d8327deb882cf99','user3@test.com',0),(6,'5f4dcc3b5aa765d61d8327deb882cf99','user4@test.com',0),(7,'5f4dcc3b5aa765d61d8327deb882cf99','user5@test.com',0),(8,'5f4dcc3b5aa765d61d8327deb882cf99','user6@test.com',0),(9,'5f4dcc3b5aa765d61d8327deb882cf99','user7@test.com',0),(10,'5f4dcc3b5aa765d61d8327deb882cf99','user8@test.com',0),(11,'5f4dcc3b5aa765d61d8327deb882cf99','user9@test.com',0),(12,'5f4dcc3b5aa765d61d8327deb882cf99','user10@test.com',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_info`
--

DROP TABLE IF EXISTS `users_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_info` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(6) NOT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_info`
--

LOCK TABLES `users_info` WRITE;
/*!40000 ALTER TABLE `users_info` DISABLE KEYS */;
INSERT INTO `users_info` VALUES (1,1,'Claudiu','Buruiana'),(2,2,'Adrian','Mircea'),(3,3,'Marla','Singer'),(4,4,'Robert','Paulson'),(5,5,'Angel','Face'),(6,6,'Raymond','Hessel'),(7,7,'Richard','Chesler'),(8,8,'Riley','Wilde'),(9,9,'Andy','Dufresne'),(10,10,'Warden','Norton'),(11,11,'Ellis','Boyd'),(12,12,'Bogs','Diamond');
/*!40000 ALTER TABLE `users_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-31 22:06:41
