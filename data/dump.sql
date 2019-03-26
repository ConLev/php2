-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: geek_brains
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `parentId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `isActive` (`isActive`),
  KEY `parentId` (`parentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'img/1.jpg',28,'Картинка 1',0),(2,'img/2.jpg',2,'Картинка 2',0),(3,'img/3.jpg',0,'Картинка 3',0),(4,'img/4.jpg',0,'Картинка 4',0),(5,'img/5.jpg',0,'Картинка 5',0),(6,'img/6.jpg',1,'Картинка 6',0),(7,'img/7.jpg',0,'Картинка 7',0),(8,'img/8.jpg',5,'Картинка 8',0);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1 - активен, 2 - неактивен, 3- оплачен, 4 - доставлен',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordersProducts`
--

DROP TABLE IF EXISTS `ordersProducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordersProducts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 - активен, 2 - неактивен, 3 - удален, 4 - подтвержден',
  PRIMARY KEY (`id`),
  KEY `orderId` (`orderId`,`productId`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordersProducts`
--

LOCK TABLES `ordersProducts` WRITE;
/*!40000 ALTER TABLE `ordersProducts` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordersProducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(11,2) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'img/no-image.jpeg',
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `categoryId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `isActive` (`isActive`),
  KEY `categoryId` (`categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Продукт 1','Описание продукта 1',100.00,'img/1.jpg','2019-03-25 18:38:23',NULL,1,0),(2,'Новый товар','Описание',13.00,'img/no-image.jpeg','2019-03-25 18:38:23',NULL,1,0),(3,'Еще один продукт','Описание',1111.00,'img/no-image.jpeg','2019-03-25 18:38:23',NULL,1,0),(4,'Еще один продукт','Описание',1111.00,'img/no-image.jpeg','2019-03-25 18:38:23',NULL,1,0),(5,'С картинкой','Описание',999.00,'img/3.jpg','2019-03-25 18:38:23',NULL,1,0),(6,'Товар с картинкой','Описание',999.00,'img/2.jpg','2019-03-25 18:38:23',NULL,1,0),(7,'Товар с картинкой','Описание',999.00,'img/4.jpg','2019-03-25 18:38:23',NULL,1,0),(8,'Товар с картинкой','Описание',999.00,'img/5.jpg','2019-03-25 18:38:23',NULL,1,0),(9,'Товар с картинкой','Товар с картинкой',11111111.00,'img/6.jpg','2019-03-25 18:38:23',NULL,1,0),(10,'Товар с картинкой','Товар с картинкой',11111111.00,'img/7.jpg','2019-03-25 18:38:23',NULL,1,0),(11,'Товар с картинкой','Товар с картинкой',11111111.00,'img/8.jpg','2019-03-25 18:38:23',NULL,1,0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '0 - обычный юзер, 1 - админ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-26 10:59:44
