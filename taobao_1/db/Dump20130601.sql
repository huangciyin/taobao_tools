CREATE DATABASE  IF NOT EXISTS `taobao` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `taobao`;
-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: taobao
-- ------------------------------------------------------
-- Server version	5.5.31-0ubuntu0.12.04.1

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
-- Table structure for table `refundlist`
--

DROP TABLE IF EXISTS `refundlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refundlist` (
  `refundID` varchar(255) NOT NULL,
  `uID` varchar(255) NOT NULL,
  `created` varchar(255) NOT NULL,
  `mark` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refundlist`
--

LOCK TABLES `refundlist` WRITE;
/*!40000 ALTER TABLE `refundlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `refundlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sku`
--

DROP TABLE IF EXISTS `sku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sku` (
  `num_iid` varchar(45) NOT NULL,
  `sku_id` varchar(45) DEFAULT NULL,
  `stock` varchar(45) NOT NULL DEFAULT '0',
  `warn` varchar(45) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sku`
--

LOCK TABLES `sku` WRITE;
/*!40000 ALTER TABLE `sku` DISABLE KEYS */;
/*!40000 ALTER TABLE `sku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userID` int(128) NOT NULL AUTO_INCREMENT,
  `uID` varchar(255) NOT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `userSessionkey` varchar(255) DEFAULT NULL,
  `userAddress` varchar(255) DEFAULT NULL,
  `userTel` varchar(255) DEFAULT NULL,
  `userShopname` varchar(255) DEFAULT NULL,
  `customExpress1` varchar(255) DEFAULT NULL,
  `customExpress2` varchar(255) DEFAULT NULL,
  `customExpress3` varchar(255) DEFAULT NULL,
  `customMark1` varchar(255) DEFAULT NULL,
  `customMark2` varchar(255) DEFAULT NULL,
  `customMark3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocklist`
--

DROP TABLE IF EXISTS `stocklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocklist` (
  `uID` varchar(255) NOT NULL,
  `numID` varchar(255) NOT NULL,
  `stockalise` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocklist`
--

LOCK TABLES `stocklist` WRITE;
/*!40000 ALTER TABLE `stocklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `stocklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aftersale`
--

DROP TABLE IF EXISTS `aftersale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aftersale` (
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `uID` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `mark` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`,`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aftersale`
--

LOCK TABLES `aftersale` WRITE;
/*!40000 ALTER TABLE `aftersale` DISABLE KEYS */;
/*!40000 ALTER TABLE `aftersale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `uID` varchar(255) NOT NULL,
  `tID` varchar(255) NOT NULL,
  `created` varchar(255) DEFAULT NULL,
  `printStatus` varchar(255) DEFAULT NULL,
  `expressNum` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-01 23:17:53
