-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: gocgod
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Current Database: `gocgod`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `gocgod` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `gocgod`;

--
-- Table structure for table `about__us`
--

DROP TABLE IF EXISTS `about__us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `about__us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `about__us`
--

LOCK TABLES `about__us` WRITE;
/*!40000 ALTER TABLE `about__us` DISABLE KEYS */;
INSERT INTO `about__us` VALUES (1,'Baby','Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk  ','0811139318','2016-06-29 11:43:42','2016-05-23 20:52:22');
/*!40000 ALTER TABLE `about__us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `description1` varchar(50) NOT NULL,
  `description2` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner`
--

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
INSERT INTO `banner` VALUES (1,'SOYA MILK','Susu Kacang','Terbuat dari kacang kedelai pilihan','Tanpa bahan pengawet dan pemanis buatan!',60000,'slide-2.png','2016-06-09 03:51:10','0000-00-00 00:00:00',NULL),(2,'FRUIT PUNCH','Aneka Buah','Dibuat dari aneka macam buah-buahan segar','seperti melon, semangka, jeruk, biji selasih',75000,'slide-1.png','2016-06-29 04:39:57','2016-06-28 21:39:34',NULL);
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq__question`
--

DROP TABLE IF EXISTS `faq__question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq__question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq__question`
--

LOCK TABLES `faq__question` WRITE;
/*!40000 ALTER TABLE `faq__question` DISABLE KEYS */;
INSERT INTO `faq__question` VALUES (1,'halo','bandung','2016-05-10 10:18:51','2016-05-10 03:18:51',NULL),(5,'ab','asdfsadfasdfasdf','2016-05-24 03:31:09','2016-05-23 20:30:57',NULL),(6,'a\r\n','1213jkljlk<strong>jkljlj</strong>l&nbsp;<s><em><strong>ajldsfkjklasdfjkljaskdflj</strong></em></s>','2016-06-27 04:07:26','2016-06-26 21:07:10',NULL),(8,'tes','tes','2016-06-29 04:33:46','2016-06-26 21:07:57',NULL),(9,'halo bandung','adsf','2016-06-29 04:47:03','2016-06-28 21:46:55',NULL),(12,'dasfasdfasdfasdfasdf\r\n','<strong>12321312321312</strong>\r\n','2016-06-26 21:19:41','2016-06-26 21:19:41',NULL);
/*!40000 ALTER TABLE `faq__question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__admin`
--

DROP TABLE IF EXISTS `master__admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `city_id` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `super` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ad_ci_id` (`city_id`),
  CONSTRAINT `fk_ad_ci_id` FOREIGN KEY (`city_id`) REFERENCES `master__city` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__admin`
--

LOCK TABLES `master__admin` WRITE;
/*!40000 ALTER TABLE `master__admin` DISABLE KEYS */;
INSERT INTO `master__admin` VALUES (1,'$2y$10$PdIxuztGnzEqYOyw7MWNK.laBG7qzwkeDWv4I6VXIj3NOKzAYaH0C','kevin','abc',1,'2016-06-01','tes@tes.com','12345',1,'2016-06-29 08:05:13','2016-06-29 01:05:13',NULL,'pRR3UXZrlFCEXOtWO6DxU8YGEdjFQCipAB0RI85pea6hVuHKKpT2WF5iZz4i'),(6,'$2y$10$5e2Uag0P8i5ZMXVZz6HI0.Jte8UcDXUhS3iQxP9JHVgkQ1T7BMSA6','af','sadf',1,'2016-06-08','luph.yo3l@gmail.com','12345',0,'2016-06-29 08:04:25','2016-06-29 01:04:25',NULL,'fRe7kU5wjwoN0Viuk7xXjSItfR2MdsxDVSsNKC89lpUt4iJNmYGKOVRYk5LV');
/*!40000 ALTER TABLE `master__admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__admin_information`
--

DROP TABLE IF EXISTS `master__admin_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__admin_information` (
  `admin_id` int(11) NOT NULL,
  `information` text NOT NULL,
  `information_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`information_id`),
  KEY `fk_adin_ad_id` (`admin_id`),
  CONSTRAINT `fk_adin_ad_id` FOREIGN KEY (`admin_id`) REFERENCES `master__admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__admin_information`
--

LOCK TABLES `master__admin_information` WRITE;
/*!40000 ALTER TABLE `master__admin_information` DISABLE KEYS */;
INSERT INTO `master__admin_information` VALUES (1,'adfafd',1,'2016-06-03 11:07:20','2016-06-03 04:07:20'),(6,'adfafd',4,'2016-06-03 04:00:27','2016-06-03 04:00:27');
/*!40000 ALTER TABLE `master__admin_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__agent_rating`
--

DROP TABLE IF EXISTS `master__agent_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__agent_rating` (
  `agent_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approval` int(11) NOT NULL DEFAULT '0',
  `rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rating_id`),
  KEY `fk_agrat_ag_id` (`agent_id`),
  KEY `fk_agrat_cust_id` (`customer_id`),
  CONSTRAINT `fk_agrat_ag_id` FOREIGN KEY (`agent_id`) REFERENCES `master__member` (`id`),
  CONSTRAINT `fk_agrat_cust_id` FOREIGN KEY (`customer_id`) REFERENCES `master__member` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__agent_rating`
--

LOCK TABLES `master__agent_rating` WRITE;
/*!40000 ALTER TABLE `master__agent_rating` DISABLE KEYS */;
INSERT INTO `master__agent_rating` VALUES (3,4,1,'abc',0,1,'2016-06-29 04:19:58','2016-06-28 21:19:43',NULL),(5,3,5,'bbbbb',0,2,'2016-06-29 04:20:00','2016-06-28 21:19:45',NULL);
/*!40000 ALTER TABLE `master__agent_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__bank`
--

DROP TABLE IF EXISTS `master__bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__bank`
--

LOCK TABLES `master__bank` WRITE;
/*!40000 ALTER TABLE `master__bank` DISABLE KEYS */;
INSERT INTO `master__bank` VALUES (1,'BCA','2016-06-08 10:15:57','2016-06-08 03:15:57',NULL),(2,'MANDIRI','2016-06-08 05:16:47','0000-00-00 00:00:00',NULL),(3,'DANAMON','2016-06-08 05:16:47','0000-00-00 00:00:00',NULL),(4,'BNI','2016-06-08 05:16:47','0000-00-00 00:00:00',NULL),(5,'BRI','2016-06-08 05:16:47','0000-00-00 00:00:00',NULL),(6,'CIMB','2016-06-29 04:24:59','2016-06-28 21:23:41',NULL),(7,'PERMATA','2016-06-08 05:16:47','0000-00-00 00:00:00',NULL),(8,'MEGA','2016-06-08 05:16:47','0000-00-00 00:00:00',NULL),(9,'OCBC','2016-06-08 05:16:47','0000-00-00 00:00:00',NULL),(10,'123','2016-06-08 10:08:46','2016-06-08 03:08:46','2016-06-08 03:08:46');
/*!40000 ALTER TABLE `master__bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__city`
--

DROP TABLE IF EXISTS `master__city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__city`
--

LOCK TABLES `master__city` WRITE;
/*!40000 ALTER TABLE `master__city` DISABLE KEYS */;
INSERT INTO `master__city` VALUES (1,'jakarta','2016-05-24 03:46:28','2016-05-23 20:46:28',NULL),(3,'bandung','2016-05-24 03:44:49','2016-05-23 20:44:34','0000-00-00 00:00:00'),(10,'1','2016-06-02 11:24:19','2016-05-23 20:49:18','0000-00-00 00:00:00'),(11,'bandung','2016-06-02 04:24:44','2016-06-02 04:24:44',NULL),(12,'tegal','2016-06-29 04:35:24','2016-06-28 21:35:24','2016-06-28 21:35:24'),(13,'tegal','2016-06-03 07:33:18','2016-06-03 00:33:18','2016-06-03 00:33:18'),(14,'Korea','2016-06-07 04:19:31','2016-06-07 04:19:31',NULL),(15,'Jepang','2016-06-07 21:45:03','2016-06-07 21:45:03',NULL);
/*!40000 ALTER TABLE `master__city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__cut_off_date`
--

DROP TABLE IF EXISTS `master__cut_off_date`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__cut_off_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cut_off` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__cut_off_date`
--

LOCK TABLES `master__cut_off_date` WRITE;
/*!40000 ALTER TABLE `master__cut_off_date` DISABLE KEYS */;
INSERT INTO `master__cut_off_date` VALUES (1,4,'2016-06-28 05:09:29','2016-06-27 22:09:29');
/*!40000 ALTER TABLE `master__cut_off_date` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__member`
--

DROP TABLE IF EXISTS `master__member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `city_id` int(11) NOT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'Indonesia',
  `zipcode` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `status_user` int(11) NOT NULL DEFAULT '1',
  `verification` int(11) NOT NULL DEFAULT '0',
  `balance` int(11) DEFAULT NULL,
  `bank_account` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(255) NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mem_ci_id` (`city_id`),
  KEY `fk_ma_me_bank` (`bank_id`),
  CONSTRAINT `fk_ma_me_bank` FOREIGN KEY (`bank_id`) REFERENCES `master__bank` (`bank_id`),
  CONSTRAINT `fk_mem_ci_id` FOREIGN KEY (`city_id`) REFERENCES `master__city` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__member`
--

LOCK TABLES `master__member` WRITE;
/*!40000 ALTER TABLE `master__member` DISABLE KEYS */;
INSERT INTO `master__member` VALUES (3,'af','nomaden',1,'Indonesia','14460','0000-00-00','a@a.com','021','$2y$10$2YlV2rYohCI3aukWpkawTul5zERrS1uiXkTGHnxWF0naMP2G1yoKu',0,1,0,'','2016-07-11 02:24:14','2016-07-10 19:24:14','W4sWrhzSh4ZKg4lW5mdNb8JUP5MybYjnOGOBIfPzgWtpBFBfLY1ZbJdKlL7v',NULL),(4,'b','',1,'Indonesia','','0000-00-00','b@b.com','','$2y$10$V.FqluggCpwDaWNJyhfqluFomZ2PVA2Hm0wCBg01fFJp33PphpDuK',0,1,0,'123123','2016-07-11 02:42:41','2016-07-10 19:42:41','6AsI9VzduqOZ3cBF6coAGvBT0ZDxIDxwpo2Q8HPCxYU13JEZIgkw9luy0TSG',4),(5,'Aurelia','Komplek pakuwon blok N no 10',14,'Indonesia','','2016-02-17','aureliarianto@aurelia.com','08999940888','$2y$10$7p0b4onetwj/TgIoXJ1LZ.G.ijd2KSx9daM0Pc0g.CSs228LsKMw2',0,1,80000,'6557788','2016-06-30 09:40:21','2016-06-29 04:19:09','J9hltwk0hubZM9usOhrq5XVkkVZtVkiLMD6H4IKVGicizyysymBc3Ysr4Uo2',4),(6,'Rianto','komplek pakuwon blok apa aja',1,'Indonesia','','2016-06-30','rianto@rianto.com','0812981098','$2y$10$2YlV2rYohCI3aukWpkawTul5zERrS1uiXkTGHnxWF0naMP2G1yoKu',1,1,NULL,NULL,'2016-06-30 09:40:21','2016-06-27 02:14:23','PRUy11IsMLXHLqQ2PvnqUnyYgQ44eN083MaUTD74N9fekUSoWrtNrPdwFFmC',NULL),(7,'Lia','komplek pakuwon blok apa aja',1,'Indonesia','','2016-06-16','lia@lia.com','1','$2y$10$MNNb.j.K/0JqabgAQplqLeZxuwdOB3VygzeDVZjkUZV0uFiHW7CtW',1,1,NULL,NULL,'2016-07-12 03:04:23','2016-07-11 20:04:23','epcYcFQ7SuokE9N5vDyuRVOsjqwrKrCJSL4wNs1Bd8o8zpgUbhS3hEKNMgUB',NULL),(8,'a','a',15,'Indonesia','','2016-06-30','niko95kus@yahoo.com','1','$2y$10$WUk22rUr2PkxrrgRDNQZZORGkB25HOSfkb.h/YJy014reBhuWzTgi',1,1,NULL,NULL,'2016-06-30 09:40:21','2016-06-07 21:45:26','1aFfSDgxMCNCxvJzhCLZd65Jn6RqH0SA9gb9k8XW2aslwuCJgnVElV3lS6hE',NULL),(11,'user','Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk',1,'Indonesia','','1995-11-16','user@user.com','0811139318','$2y$10$ZiDJI3Eu/x5dBPjmAo5A6.qnwQ5i9lOo1Vbvu08NKQDWkpFARJ8ou',1,1,NULL,NULL,'2016-06-30 09:40:21','2016-06-29 22:42:43','wF20Vu2JSg6JYqgRhpeax8tZbNKH6i4ujKXRA7psVtS0Q0aL61lXAv4Bkozz',NULL),(12,'Aurelia Rianto','Komplek pakuwon blok N no 3',1,'Indonesia','11460','1995-08-27','aureliarianto.27@gmail.com','08999940821','$2y$10$DFeZMTDZOAceUhz9tEh3YeAssY83wV9d3lSXrxh4WTJFjlg.kM0AO',1,0,NULL,NULL,'2016-06-30 21:33:28','2016-06-30 21:33:28','',NULL),(13,'GoCGoD','Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk',1,'Indonesia','14460','1995-07-11','gocgod@gocgod.com','0811139318','$2y$10$TJwwuMko5r2/vM8djmN/xuNgN7VkhR8J4dXZQcX2InLdLdx0LODP2',1,1,NULL,NULL,'2016-07-11 10:32:47','2016-07-11 03:32:47','tnqEAhxwmgbvSl2YE4QQOCV97xoM4AjUags0WHf4GieG4sHmI7Jdb4rRoqQg',NULL);
/*!40000 ALTER TABLE `master__member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__req_agent`
--

DROP TABLE IF EXISTS `master__req_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__req_agent` (
  `reqagent_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) NOT NULL,
  `status_confirm` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bank_account` varchar(100) NOT NULL,
  `member_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`reqagent_id`),
  KEY `fk_req_bank_id` (`bank_id`),
  KEY `fk_member_id` (`member_id`),
  CONSTRAINT `fk_member_id` FOREIGN KEY (`member_id`) REFERENCES `master__member` (`id`),
  CONSTRAINT `fk_req_bank_id` FOREIGN KEY (`bank_id`) REFERENCES `master__bank` (`bank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__req_agent`
--

LOCK TABLES `master__req_agent` WRITE;
/*!40000 ALTER TABLE `master__req_agent` DISABLE KEYS */;
INSERT INTO `master__req_agent` VALUES (1,4,0,'2016-06-29 04:22:25','2016-06-28 21:22:15','123123',4,NULL),(2,1,0,'2016-07-11 19:48:12','2016-07-11 19:48:12','123123',7,NULL);
/*!40000 ALTER TABLE `master__req_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__tx_balance`
--

DROP TABLE IF EXISTS `master__tx_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__tx_balance` (
  `balance_id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `amountMoney` int(11) NOT NULL,
  `balance_type` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_id` int(11) DEFAULT NULL,
  `statusTransfer` int(11) DEFAULT NULL,
  PRIMARY KEY (`balance_id`),
  KEY `fk_txbal_ag_id` (`agent_id`),
  KEY `fk_tx_orderid` (`order_id`),
  CONSTRAINT `fk_tx_orderid` FOREIGN KEY (`order_id`) REFERENCES `transaction__order` (`order_id`),
  CONSTRAINT `fk_txbal_ag_id` FOREIGN KEY (`agent_id`) REFERENCES `master__member` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__tx_balance`
--

LOCK TABLES `master__tx_balance` WRITE;
/*!40000 ALTER TABLE `master__tx_balance` DISABLE KEYS */;
INSERT INTO `master__tx_balance` VALUES (1,5,100000,1,'2016-06-07 05:15:14','0000-00-00 00:00:00',NULL,NULL),(2,5,50000,1,'2016-06-07 05:25:56','0000-00-00 00:00:00',NULL,NULL),(3,5,150000,0,'2016-06-07 08:12:12','0000-00-00 00:00:00',NULL,1),(4,5,20000,0,'2016-06-10 10:59:55','2016-06-10 03:59:55',NULL,1),(5,5,10000,0,'2016-06-10 11:19:37','2016-06-10 04:19:37',NULL,1),(6,5,20000,0,'2016-06-27 04:23:02','2016-06-26 21:23:02',NULL,1),(7,5,80000,0,'2016-06-07 02:57:35','2016-06-07 02:57:35',NULL,0),(8,5,80000,0,'2016-06-07 02:58:14','2016-06-07 02:58:14',NULL,0),(9,5,20000,0,'2016-06-10 10:52:36','2016-06-10 03:52:36',NULL,1),(10,5,20,1,'2016-06-28 08:01:57','2016-06-28 08:01:57',2,0);
/*!40000 ALTER TABLE `master__tx_balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master__user_activations`
--

DROP TABLE IF EXISTS `master__user_activations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master__user_activations` (
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master__user_activations`
--

LOCK TABLES `master__user_activations` WRITE;
/*!40000 ALTER TABLE `master__user_activations` DISABLE KEYS */;
/*!40000 ALTER TABLE `master__user_activations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password__resets`
--

DROP TABLE IF EXISTS `password__resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password__resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password__resets`
--

LOCK TABLES `password__resets` WRITE;
/*!40000 ALTER TABLE `password__resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password__resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product__category`
--

DROP TABLE IF EXISTS `product__category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product__category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product__category`
--

LOCK TABLES `product__category` WRITE;
/*!40000 ALTER TABLE `product__category` DISABLE KEYS */;
INSERT INTO `product__category` VALUES (1,'minuman','','2016-05-13 08:55:19','2016-05-13 01:55:19',NULL),(2,'makanan','','2016-06-29 03:54:27','2016-06-28 20:54:27','2016-06-28 20:54:27'),(3,'qqqqq','','2016-05-20 09:25:16','2016-05-20 02:25:16','2016-05-20 02:25:16');
/*!40000 ALTER TABLE `product__category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product__testimonial`
--

DROP TABLE IF EXISTS `product__testimonial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product__testimonial` (
  `testimonial_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `testimonial` varchar(500) NOT NULL,
  `approval` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`testimonial_id`),
  KEY `fk_protes_id` (`id`),
  KEY `fk_protes_var_id` (`varian_id`),
  CONSTRAINT `fk_protes_id` FOREIGN KEY (`id`) REFERENCES `master__member` (`id`),
  CONSTRAINT `fk_protes_var_id` FOREIGN KEY (`varian_id`) REFERENCES `product__varian` (`varian_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product__testimonial`
--

LOCK TABLES `product__testimonial` WRITE;
/*!40000 ALTER TABLE `product__testimonial` DISABLE KEYS */;
INSERT INTO `product__testimonial` VALUES (1,3,1,'aaa',1,'2016-06-29 04:18:02','2016-06-28 20:57:32',NULL),(2,3,1,'bbb',0,'2016-06-29 03:58:22','2016-06-28 20:58:15',NULL),(3,4,1,'ccc',1,'2016-06-29 04:18:04','2016-06-28 20:58:00',NULL),(4,5,2,'asd',0,'2016-06-29 03:58:07','2016-06-28 20:55:55',NULL);
/*!40000 ALTER TABLE `product__testimonial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product__varian`
--

DROP TABLE IF EXISTS `product__varian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product__varian` (
  `varian_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `varian_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `weight` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`varian_id`),
  KEY `fk_provar_cat_id` (`category_id`),
  CONSTRAINT `fk_provar_cat_id` FOREIGN KEY (`category_id`) REFERENCES `product__category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product__varian`
--

LOCK TABLES `product__varian` WRITE;
/*!40000 ALTER TABLE `product__varian` DISABLE KEYS */;
INSERT INTO `product__varian` VALUES (1,1,'Soya Milk',60000,999,'soya_milk.jpg','Soya milk terbuat dari kacang kedelai pilihan , minuman bergizi dan berprotein sangat tinggi\r\nTanpa bahan pengawet! Dan pemanis buatan\r\nSangat cocok untuk anak-anak, dewasa, dan org tua . Kualitas terjamin!',2,'2016-07-12 02:49:37','0000-00-00 00:00:00',NULL),(2,1,'Cin Cau',60000,999,'cin_cau.jpg','Manfaat air cin cau cukup beragam sudah biasa di gunakan dalam pengobatan tradisional untuk obat batuk, tekanan darah tinggi, diare, sembelit, menurunkan demam , mengobati panas dalam, menjaga sistem pencernaan , mengatasi perut kembung .\r\nAir cin cau hitam juga sangat membantu bagi anda yg sedang menjalani program diet .',2,'2016-06-28 02:24:03','2016-06-27 19:24:03',NULL),(3,1,'Honey Pine',75000,999,'honey_pine.jpg','Sari buah nanas ini sangat bermanfaat buat kecantikan karna di buat tanpa bahan pengawet dan gula, bener2 murni dan fress \r\nManfaat sari buat nanas \r\n1. Menjaga kesehatan mata\r\n2. Meningkatkan imunitas\r\n3. Membantu pencernaan\r\n5. Mencegah hipertensi\r\n6. Meredakan mual\r\n7. Menguatkan tulang\r\n8. Memperbaiki kulit kaki\r\n9. Melembabkan kulit\r\n10. Mencerna kandungan lemak pada makanan Yang kita makan',2,'2016-07-12 02:49:37','0000-00-00 00:00:00',NULL),(4,1,'Guava',75000,999,'guava.jpg','Guava adalah sari buah jambu pilihan , yg di proses secara higienis tanpa bahan pengawet dan gula, rasanya benar2 alami seperti makan buah aslinya \r\nManfaat sari guava diantaranya yaitu \r\n1. Mengandung vitamin C yg sangat di butuhkan Oleh tubuh \r\n2. Mengandung serat alami \r\n3.Melancarkan pencernaan seperti susah BAB, Sembelit serta menbuang zat-zat berbahaya di Dalam usus\r\n4.Membuat kulit lebih cerah dan lembut',2,'2016-07-12 02:49:37','0000-00-00 00:00:00',NULL),(5,1,'Fruit Punch',75000,999,'fruit_punch.jpg','Fruit Punch Aneka Buah adalah minuman yang dibuat dari aneka macam buah-buahan segar seperti melon, semangka, jeruk, biji selasih dan air soda. Buah-buahan memanglah sangat dianjurkan untuk dikonsumsi tubuh karena memiliki sejuta manfaat yang beragam bagi kesehatan. Seperti buah semangka yang memiliki manfaat menjaga kesehatan jantung, mata dan tulang, menangkal radikal bebas, meningkatkan sistem kekebalan tubuh, membantu meningkatkan aliran urine dan mengurangi lemak pada tubuh. Selain semangka, biji selasih yang turut digunakan sebagai bahan pelengkpnya juga memiliki manfaat bagi tubuh antara lain dapat mengobati radang lambung, menyembuhkan sakit gigi, baik untuk menghaluskan kulit wajah, sebagai obat sakit kepala dan lain sebagainya.',2,'2016-07-12 02:49:37','0000-00-00 00:00:00',NULL),(6,1,'Sirsak',60000,999,'sirsak.jpg','\r\nManfaat jus sirsak sangat luar biasa bagi kesehatan seperti untuk diet, kulit, kanker, dan banyak lagi yang harus Anda ketahui. Buah sirsak merupakan jenis buah yang banyak disukai karena rasanya yang nikmat dan menyegarkan. Selain rasanya yang nikmat dan segar, buah sirsak mengandung manfaat yang sangat berkhasiat dalam mengatasi berbagai masalah kesehatan. Buah sirsak dapat dikonsumsi langsung buahnya atau dijadikan minuman jus yang lebih mudah diserap tubuh, sehingga sangat baik untuk saluran pencernaan.\r\n\r\n',1,'2016-07-12 02:49:37','0000-00-00 00:00:00',NULL),(7,1,'Kacang Hijau',60000,999,'kacang_hijau.jpg','Manfaat sari kacang hijau \r\n1.Meningkatkan penyerapan nutrisi\r\n2. Mencegah penyakit jantung & stroke\r\n3.Membersihkan pencernaan\r\n4.Mengatasi anemia\r\n5.Menjaga berat badan\r\n6.Membantu pertumbuhan sel organ, otot & otak\r\nTampa bahan pengawet !!!!',2,'2016-07-12 02:49:37','0000-00-00 00:00:00',NULL),(8,1,'Liang Teh',75000,999,'liang_teh.jpg','\r\nLiang teh merupakan minuman yang mempunyai manfaat serta khasiat yang banyak bagi kesehatan tubuh. Selain itu, liang teh mempunyai rasa yang enak dan banyak digemari oleh semua kalangan baik anak – anak, remaja dan orang tua. Liang teh merupakan jenis minuman yang dapat disajikan dalam keadaan hangat maupun dingin. Kandungan didalamnya dapat meredakan panas dalam dan mengatasi masalah sistem pencernaan tubuh. Minuman herbal yang berasal dari China ini memiliki jenis warna dan rasa yang sangat bervariatif sesuai dengan jenis tanaman yang digunakan sebagai bahan pembuat liang teh.\r\n\r\n',2,'2016-07-12 02:49:37','0000-00-00 00:00:00',NULL),(9,1,'Lime Watz',75000,999,'lime_watz.jpg','Membantu menurunkan berat badan\r\nSari lemon kerap disertakan dalam diet penurunan berat badan. Biasanya, sari lemon dicampurkan dengan air hangat dan madu. Tak hanya sehat, lemon juga rendah kalori, bahkan termasuk yang terendah di antara buah citrus lainnya. Sekitar 100 g lemon hanya mengandung 29 kalori. Lemon pun bebas kolesterol, lemak jenuh, dan memiliki indeks glikemik rendah. Lemon juga kaya serat pangan sehingga baik dikonsumsi Anda yang ingin memangkas berat badan.\r\nLime Watz itu campuran Lemon , madu , kiwi dan Semangka kuning.',2,'2016-07-12 02:49:37','0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `product__varian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction__order`
--

DROP TABLE IF EXISTS `transaction__order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction__order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `status_payment` int(11) NOT NULL DEFAULT '0',
  `ship_address` varchar(500) NOT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'Indonesia',
  `zipcode` varchar(50) NOT NULL,
  `ship_city_id` int(11) NOT NULL,
  `status_confirmed` int(11) NOT NULL DEFAULT '0',
  `status_shipping` int(11) NOT NULL DEFAULT '0',
  `shipping_date` date NOT NULL,
  `group_id` int(11) NOT NULL,
  `shipping_fee` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `who` varchar(50) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_traor_cus_id` (`customer_id`),
  KEY `fk_traor_ag_id` (`agent_id`),
  KEY `fk_or_ci_id` (`ship_city_id`),
  CONSTRAINT `fk_or_ci_id` FOREIGN KEY (`ship_city_id`) REFERENCES `master__city` (`city_id`),
  CONSTRAINT `fk_traor_ag_id` FOREIGN KEY (`agent_id`) REFERENCES `master__member` (`id`),
  CONSTRAINT `fk_traor_cus_id` FOREIGN KEY (`customer_id`) REFERENCES `master__member` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction__order`
--

LOCK TABLES `transaction__order` WRITE;
/*!40000 ALTER TABLE `transaction__order` DISABLE KEYS */;
INSERT INTO `transaction__order` VALUES (1,7,3,'2016-06-02 00:00:00',0,'sunrise','Indonesia','',1,0,0,'2016-06-19',1,10000,10,'2016-06-29 03:45:14','2016-06-12 11:25:44','single'),(2,4,5,'2016-06-03 00:00:00',0,'green garden','Indonesia','',3,0,0,'2016-06-01',2,0,20,'2016-06-29 03:45:33','2016-06-12 09:34:23','subscribe'),(3,7,3,'2016-06-16 00:00:00',1,'abc','Indonesia','',1,0,0,'2016-06-22',3,5000,135000,'2016-06-29 03:47:11','2016-06-28 20:47:11','single'),(4,7,3,'2016-06-13 11:26:09',0,'komplek pakuwon blok apa aja','Indonesia','',1,0,0,'2016-07-05',4,10000,145000,'2016-06-27 06:13:44','2016-06-12 21:32:26','single'),(6,3,3,'2016-06-29 11:05:33',0,'nomaden','Indonesia','',1,0,0,'2016-07-08',5,0,0,'2016-06-28 21:05:33','2016-06-28 21:05:33','single'),(7,3,3,'2016-06-29 11:06:12',0,'nomaden','Indonesia','',1,0,0,'2016-07-08',6,0,0,'2016-06-28 21:06:12','2016-06-28 21:06:12','single'),(8,3,3,'2016-06-29 11:07:26',0,'nomaden','Indonesia','',1,0,0,'2016-07-05',7,0,0,'2016-06-28 21:07:26','2016-06-28 21:07:26','single'),(9,3,3,'2016-06-29 11:07:29',0,'nomaden','Indonesia','',1,0,0,'2016-07-05',8,0,0,'2016-06-28 21:07:29','2016-06-28 21:07:29','single'),(10,3,3,'2016-06-29 11:07:29',0,'nomaden','Indonesia','',1,0,0,'2016-07-08',9,0,0,'2016-06-28 21:07:29','2016-06-28 21:07:29','single'),(11,3,3,'2016-06-29 11:13:23',0,'nomaden','Indonesia','',1,0,0,'2016-07-08',10,0,0,'2016-06-28 21:13:23','2016-06-28 21:13:23','single'),(12,3,3,'2016-06-29 11:15:02',0,'nomaden','Indonesia','',1,0,0,'2016-07-05',11,0,0,'2016-06-28 21:15:02','2016-06-28 21:15:02','single'),(13,11,4,'2016-06-30 14:33:18',0,'Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk','Indonesia','1',1,0,0,'2016-07-14',12,10000,10000,'2016-06-30 00:33:18','2016-06-30 00:33:18','single'),(14,3,4,'2016-07-01 14:09:01',0,'nomaden','Indonesia','14460',1,0,0,'2016-07-05',13,0,570000,'2016-07-01 00:09:01','2016-07-01 00:09:01','single'),(15,3,4,'2016-07-01 14:10:13',0,'nomaden','Indonesia','14460',1,0,0,'2016-07-06',14,0,255000,'2016-07-01 00:10:13','2016-07-01 00:10:13','subcriber'),(16,3,4,'2016-07-01 14:10:13',0,'nomaden','Indonesia','14460',1,0,0,'2016-07-13',14,0,255000,'2016-07-01 00:10:13','2016-07-01 00:10:13','subcriber'),(17,3,4,'2016-07-01 14:46:13',0,'nomaden','Indonesia','14460',1,0,0,'2016-07-04',15,0,255000,'2016-07-01 00:46:13','2016-07-01 00:46:13','subcriber'),(18,3,4,'2016-07-01 14:46:13',0,'nomaden','Indonesia','14460',1,0,0,'2016-07-11',15,0,255000,'2016-07-01 00:46:13','2016-07-01 00:46:13','subcriber'),(19,7,4,'2016-07-11 09:43:37',0,'komplek pakuwon blok apa aja','Indonesia','111',1,0,0,'2016-07-18',16,0,75000,'2016-07-10 19:43:37','2016-07-10 19:43:37','subcriber'),(20,7,4,'2016-07-11 09:43:37',0,'komplek pakuwon blok apa aja','Indonesia','111',1,0,0,'2016-07-25',16,0,75000,'2016-07-10 19:43:37','2016-07-10 19:43:37','subcriber'),(21,7,4,'2016-07-11 09:44:37',0,'komplek pakuwon blok apa aja','Indonesia','1111',1,0,0,'2016-07-18',17,0,75000,'2016-07-10 19:44:37','2016-07-10 19:44:37','subcriber'),(22,7,4,'2016-07-11 09:44:37',0,'komplek pakuwon blok apa aja','Indonesia','1111',1,0,0,'2016-07-25',17,0,75000,'2016-07-10 19:44:37','2016-07-10 19:44:37','subcriber'),(23,7,4,'2016-07-11 09:48:36',0,'komplek pakuwon blok apa aja','Indonesia','1',1,0,0,'2016-07-18',18,0,60000,'2016-07-10 19:48:36','2016-07-10 19:48:36','subcriber'),(24,7,4,'2016-07-11 09:48:36',0,'komplek pakuwon blok apa aja','Indonesia','1',1,0,0,'2016-07-25',18,0,60000,'2016-07-10 19:48:36','2016-07-10 19:48:36','subcriber'),(25,7,4,'2016-07-11 09:50:34',0,'komplek pakuwon blok apa aja','Indonesia','1',1,0,0,'2016-07-18',19,10000,70000,'2016-07-10 19:50:34','2016-07-10 19:50:34','single'),(26,13,4,'2016-07-11 10:52:34',0,'Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk','Indonesia','14460',1,0,0,'2016-07-18',20,10000,70000,'2016-07-10 20:52:34','2016-07-10 20:52:34','single'),(27,13,4,'2016-07-11 11:04:39',0,'Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk','Indonesia','14460',1,0,0,'2016-07-18',21,0,135000,'2016-07-10 21:04:39','2016-07-10 21:04:39','subcriber'),(28,13,4,'2016-07-11 11:04:39',0,'Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk','Indonesia','14460',1,0,0,'2016-07-25',21,0,135000,'2016-07-10 21:04:39','2016-07-10 21:04:39','subcriber'),(29,13,4,'2016-07-11 11:05:13',0,'Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk','Indonesia','14460',1,0,0,'2016-07-18',22,0,135000,'2016-07-10 21:05:13','2016-07-10 21:05:13','subcriber'),(30,13,4,'2016-07-11 11:05:14',0,'Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk','Indonesia','14460',1,0,0,'2016-07-25',22,0,135000,'2016-07-10 21:05:14','2016-07-10 21:05:14','subcriber'),(31,13,4,'2016-07-11 13:27:11',0,'Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk','Indonesia','14460',1,0,0,'2016-07-19',23,0,135000,'2016-07-10 23:27:11','2016-07-10 23:27:11','subcriber'),(32,13,4,'2016-07-11 13:27:11',0,'Ruko The Centro Citywalk Metro Broadway blok A6, Pantai Indah Kapuk','Indonesia','14460',1,0,0,'2016-07-26',23,0,135000,'2016-07-10 23:27:11','2016-07-10 23:27:11','subcriber'),(33,7,4,'2016-07-12 09:39:06',0,'komplek pakuwon blok apa aja','Indonesia','123',1,0,0,'2016-07-18',24,0,135000,'2016-07-12 02:39:06','2016-07-12 02:39:06','subcriber'),(34,7,4,'2016-07-12 09:39:06',0,'komplek pakuwon blok apa aja','Indonesia','123',1,0,0,'2016-07-25',24,0,135000,'2016-07-12 02:39:06','2016-07-12 02:39:06','subcriber'),(35,7,4,'2016-07-12 09:39:08',0,'komplek pakuwon blok apa aja','Indonesia','123',1,0,0,'2016-07-18',25,0,0,'2016-07-12 02:39:08','2016-07-12 02:39:08','subcriber'),(36,7,4,'2016-07-12 09:39:08',0,'komplek pakuwon blok apa aja','Indonesia','123',1,0,0,'2016-07-25',25,0,0,'2016-07-12 02:39:08','2016-07-12 02:39:08','subcriber'),(37,7,4,'2016-07-12 09:40:09',0,'komplek pakuwon blok apa aja','Indonesia','098',1,0,0,'2016-07-18',26,0,60000,'2016-07-12 02:40:09','2016-07-12 02:40:09','subcriber'),(38,7,4,'2016-07-12 09:40:09',0,'komplek pakuwon blok apa aja','Indonesia','098',1,0,0,'2016-07-25',26,0,60000,'2016-07-12 02:40:09','2016-07-12 02:40:09','subcriber');
/*!40000 ALTER TABLE `transaction__order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction__order_confirmation`
--

DROP TABLE IF EXISTS `transaction__order_confirmation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction__order_confirmation` (
  `confirmation_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `confirmation_status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`confirmation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction__order_confirmation`
--

LOCK TABLES `transaction__order_confirmation` WRITE;
/*!40000 ALTER TABLE `transaction__order_confirmation` DISABLE KEYS */;
INSERT INTO `transaction__order_confirmation` VALUES (1,1,'2016-06-29',10000,'kevin','123',0,'2016-06-29 03:22:51','0000-00-00 00:00:00'),(2,2,'2016-07-28',50000,'aurelia','9876',0,'2016-06-29 03:45:06','0000-00-00 00:00:00'),(3,3,'2016-06-06',20000,'kevin k','55555',1,'2016-06-29 03:47:11','2016-06-28 20:47:11'),(4,4,'2016-06-30',40000,'aurelia rianto','11111',0,'2016-06-29 03:44:58','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `transaction__order_confirmation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction__order_detail`
--

DROP TABLE IF EXISTS `transaction__order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction__order_detail` (
  `order_id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `varian_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`order_id`,`varian_id`),
  KEY `fk_orde_or_id` (`order_id`),
  KEY `fk_orde_var_id` (`varian_id`),
  CONSTRAINT `fk_orde_or_id` FOREIGN KEY (`order_id`) REFERENCES `transaction__order` (`order_id`),
  CONSTRAINT `fk_orde_var_id` FOREIGN KEY (`varian_id`) REFERENCES `product__varian` (`varian_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction__order_detail`
--

LOCK TABLES `transaction__order_detail` WRITE;
/*!40000 ALTER TABLE `transaction__order_detail` DISABLE KEYS */;
INSERT INTO `transaction__order_detail` VALUES (1,2,60000,2,'2016-05-24 10:20:11','0000-00-00 00:00:00'),(2,2,60000,5,'2016-06-09 08:16:09','0000-00-00 00:00:00'),(2,4,75000,2,'2016-06-09 08:10:55','0000-00-00 00:00:00'),(3,2,60000,1,'2016-06-09 09:55:41','0000-00-00 00:00:00'),(3,7,75000,1,'2016-06-09 09:55:41','0000-00-00 00:00:00'),(4,2,60000,1,'2016-06-12 21:26:10','2016-06-12 21:26:10'),(4,3,75000,1,'2016-06-12 21:26:10','2016-06-12 21:26:10'),(6,1,0,10,'2016-06-28 21:05:33','2016-06-28 21:05:33'),(6,2,0,3,'2016-06-28 21:05:33','2016-06-28 21:05:33'),(7,1,0,10,'2016-06-28 21:06:12','2016-06-28 21:06:12'),(7,2,0,3,'2016-06-28 21:06:12','2016-06-28 21:06:12'),(8,3,0,1,'2016-06-28 21:07:26','2016-06-28 21:07:26'),(9,3,0,1,'2016-06-28 21:07:29','2016-06-28 21:07:29'),(10,1,0,10,'2016-06-28 21:07:29','2016-06-28 21:07:29'),(10,2,0,3,'2016-06-28 21:07:29','2016-06-28 21:07:29'),(11,1,0,10,'2016-06-28 21:13:23','2016-06-28 21:13:23'),(11,2,0,3,'2016-06-28 21:13:23','2016-06-28 21:13:23'),(12,3,0,1,'2016-06-28 21:15:02','2016-06-28 21:15:02'),(14,2,60000,2,'2016-07-01 00:09:01','2016-07-01 00:09:01'),(14,3,75000,6,'2016-07-01 00:09:02','2016-07-01 00:09:02'),(15,2,60000,3,'2016-07-01 00:10:13','2016-07-01 00:10:13'),(15,5,75000,1,'2016-07-01 00:10:13','2016-07-01 00:10:13'),(16,2,60000,3,'2016-07-01 00:10:14','2016-07-01 00:10:14'),(16,5,75000,1,'2016-07-01 00:10:14','2016-07-01 00:10:14'),(17,2,60000,2,'2016-07-01 00:46:13','2016-07-01 00:46:13'),(17,3,75000,1,'2016-07-01 00:46:13','2016-07-01 00:46:13'),(17,7,60000,1,'2016-07-01 00:46:13','2016-07-01 00:46:13'),(18,2,60000,2,'2016-07-01 00:46:13','2016-07-01 00:46:13'),(18,3,75000,1,'2016-07-01 00:46:13','2016-07-01 00:46:13'),(18,7,60000,1,'2016-07-01 00:46:14','2016-07-01 00:46:14'),(19,3,75000,1,'2016-07-10 19:43:37','2016-07-10 19:43:37'),(20,3,75000,1,'2016-07-10 19:43:37','2016-07-10 19:43:37'),(21,4,75000,1,'2016-07-10 19:44:37','2016-07-10 19:44:37'),(22,4,75000,1,'2016-07-10 19:44:37','2016-07-10 19:44:37'),(23,2,60000,1,'2016-07-10 19:48:36','2016-07-10 19:48:36'),(24,2,60000,1,'2016-07-10 19:48:36','2016-07-10 19:48:36'),(25,2,60000,1,'2016-07-10 19:50:34','2016-07-10 19:50:34'),(26,1,60000,1,'2016-07-10 20:52:34','2016-07-10 20:52:34'),(27,2,60000,1,'2016-07-10 21:04:39','2016-07-10 21:04:39'),(27,5,75000,1,'2016-07-10 21:04:39','2016-07-10 21:04:39'),(28,2,60000,1,'2016-07-10 21:04:39','2016-07-10 21:04:39'),(28,5,75000,1,'2016-07-10 21:04:39','2016-07-10 21:04:39'),(29,2,60000,1,'2016-07-10 21:05:14','2016-07-10 21:05:14'),(29,5,75000,1,'2016-07-10 21:05:14','2016-07-10 21:05:14'),(30,2,60000,1,'2016-07-10 21:05:14','2016-07-10 21:05:14'),(30,5,75000,1,'2016-07-10 21:05:14','2016-07-10 21:05:14'),(31,1,60000,1,'2016-07-10 23:27:11','2016-07-10 23:27:11'),(31,8,75000,1,'2016-07-10 23:27:11','2016-07-10 23:27:11'),(32,1,60000,1,'2016-07-10 23:27:11','2016-07-10 23:27:11'),(32,8,75000,1,'2016-07-10 23:27:11','2016-07-10 23:27:11'),(33,2,60000,1,'2016-07-12 02:39:06','2016-07-12 02:39:06'),(33,5,75000,1,'2016-07-12 02:39:06','2016-07-12 02:39:06'),(34,2,60000,1,'2016-07-12 02:39:06','2016-07-12 02:39:06'),(34,5,75000,1,'2016-07-12 02:39:06','2016-07-12 02:39:06'),(37,1,60000,1,'2016-07-12 02:40:09','2016-07-12 02:40:09'),(38,1,60000,1,'2016-07-12 02:40:09','2016-07-12 02:40:09');
/*!40000 ALTER TABLE `transaction__order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction__sample_detail`
--

DROP TABLE IF EXISTS `transaction__sample_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction__sample_detail` (
  `request_id` int(11) NOT NULL,
  `varian_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`request_id`,`varian_id`),
  KEY `fk_orde_or_id` (`request_id`),
  KEY `fk_orde_var_id` (`varian_id`),
  CONSTRAINT `fk_sample_req_id` FOREIGN KEY (`request_id`) REFERENCES `transaction__sample_request` (`request_id`),
  CONSTRAINT `fk_sample_var_id` FOREIGN KEY (`varian_id`) REFERENCES `product__varian` (`varian_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction__sample_detail`
--

LOCK TABLES `transaction__sample_detail` WRITE;
/*!40000 ALTER TABLE `transaction__sample_detail` DISABLE KEYS */;
INSERT INTO `transaction__sample_detail` VALUES (1,3,1,'2016-05-24 10:15:00','2016-05-10 17:00:00'),(4,1,10,'2016-05-24 04:49:32','0000-00-00 00:00:00'),(4,2,3,'2016-05-24 04:49:32','0000-00-00 00:00:00'),(5,1,2,'2016-07-01 03:08:40','2016-07-01 03:08:40'),(5,2,2,'2016-07-01 03:08:40','2016-07-01 03:08:40'),(5,4,1,'2016-07-01 03:08:40','2016-07-01 03:08:40'),(7,5,25,'2016-07-11 20:08:11','2016-07-11 20:08:11');
/*!40000 ALTER TABLE `transaction__sample_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction__sample_request`
--

DROP TABLE IF EXISTS `transaction__sample_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction__sample_request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `event_venue` varchar(100) NOT NULL,
  `event_description` varchar(1000) NOT NULL,
  `request_date` datetime NOT NULL,
  `shipping_date` date NOT NULL,
  `approval` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`request_id`),
  KEY `fk_sample_agent_id` (`agent_id`),
  CONSTRAINT `fk_sample_agent_id` FOREIGN KEY (`agent_id`) REFERENCES `master__member` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction__sample_request`
--

LOCK TABLES `transaction__sample_request` WRITE;
/*!40000 ALTER TABLE `transaction__sample_request` DISABLE KEYS */;
INSERT INTO `transaction__sample_request` VALUES (1,3,'iseng aja','2016-07-05','alsut','rame','2016-05-18 17:27:22','2016-07-05',0,'2016-06-29 04:15:09','2016-06-28 21:15:02',NULL),(4,3,'','2016-07-23','','','2016-05-20 15:37:01','2016-07-08',0,'2016-06-29 04:13:35','2016-06-28 21:13:23',NULL),(5,3,'a','2016-07-05','a','a','2016-07-05 00:00:00','0000-00-00',0,'2016-07-01 03:08:03','2016-07-01 03:08:03',NULL),(6,3,'a','2016-07-18','a','a','2016-07-18 00:00:00','0000-00-00',0,'2016-07-11 20:04:49','2016-07-11 20:04:49',NULL),(7,3,'poipoi','2016-07-18','poi','poi','2016-07-12 10:08:02','2016-07-18',0,'2016-07-12 03:08:02','2016-07-12 03:08:02',NULL);
/*!40000 ALTER TABLE `transaction__sample_request` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-12 10:41:12
