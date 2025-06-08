-- -- MySQL dump 10.13  Distrib 9.2.0, for macos15.2 (arm64)
-- --
-- -- Host: localhost    Database: FindMyPlace
-- -- ------------------------------------------------------
-- -- Server version	9.2.0

-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!50503 SET NAMES utf8mb4 */;
-- /*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
-- /*!40103 SET TIME_ZONE='+00:00' */;
-- /*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
-- /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
-- /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- --
-- -- Table structure for table `category`
-- --

-- DROP TABLE IF EXISTS `category`;
-- /*!40101 SET @saved_cs_client     = @@character_set_client */;
-- /*!50503 SET character_set_client = utf8mb4 */;
-- CREATE TABLE `category` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `name` varchar(100) NOT NULL,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- /*!40101 SET character_set_client = @saved_cs_client */;

-- --
-- -- Dumping data for table `category`
-- --

-- LOCK TABLES `category` WRITE;
-- /*!40000 ALTER TABLE `category` DISABLE KEYS */;
-- /*!40000 ALTER TABLE `category` ENABLE KEYS */;
-- UNLOCK TABLES;

-- --
-- -- Table structure for table `contact_messages`
-- --

-- DROP TABLE IF EXISTS `contact_messages`;
-- /*!40101 SET @saved_cs_client     = @@character_set_client */;
-- /*!50503 SET character_set_client = utf8mb4 */;
-- CREATE TABLE `contact_messages` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `name` varchar(300) NOT NULL,
--   `email` varchar(200) NOT NULL,
--   `message` text NOT NULL,
--   `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
--   PRIMARY KEY (`id`),
--   CONSTRAINT `contact_messages_user_FK` FOREIGN KEY (`id`) REFERENCES `user` (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- /*!40101 SET character_set_client = @saved_cs_client */;

-- --
-- -- Dumping data for table `contact_messages`
-- --

-- LOCK TABLES `contact_messages` WRITE;
-- /*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
-- /*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
-- UNLOCK TABLES;

-- --
-- -- Table structure for table `favorites`
-- --

-- DROP TABLE IF EXISTS `favorites`;
-- /*!40101 SET @saved_cs_client     = @@character_set_client */;
-- /*!50503 SET character_set_client = utf8mb4 */;
-- CREATE TABLE `favorites` (
--   `id` int NOT NULL,
--   `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
--   KEY `favorites_user_FK` (`id`),
--   CONSTRAINT `favorites_listings_FK` FOREIGN KEY (`id`) REFERENCES `listings` (`id`),
--   CONSTRAINT `favorites_user_FK` FOREIGN KEY (`id`) REFERENCES `user` (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- /*!40101 SET character_set_client = @saved_cs_client */;

-- --
-- -- Dumping data for table `favorites`
-- --

-- LOCK TABLES `favorites` WRITE;
-- /*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
-- /*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
-- UNLOCK TABLES;

-- --
-- -- Table structure for table `listing_images`
-- --

-- DROP TABLE IF EXISTS `listing_images`;
-- /*!40101 SET @saved_cs_client     = @@character_set_client */;
-- /*!50503 SET character_set_client = utf8mb4 */;
-- CREATE TABLE `listing_images` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `image_url` varchar(255) NOT NULL,
--   PRIMARY KEY (`id`),
--   CONSTRAINT `listing_images_listings_FK` FOREIGN KEY (`id`) REFERENCES `listings` (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- /*!40101 SET character_set_client = @saved_cs_client */;

-- --
-- -- Dumping data for table `listing_images`
-- --

-- LOCK TABLES `listing_images` WRITE;
-- /*!40000 ALTER TABLE `listing_images` DISABLE KEYS */;
-- /*!40000 ALTER TABLE `listing_images` ENABLE KEYS */;
-- UNLOCK TABLES;

-- --
-- -- Table structure for table `listings`
-- --

-- DROP TABLE IF EXISTS `listings`;
-- /*!40101 SET @saved_cs_client     = @@character_set_client */;
-- /*!50503 SET character_set_client = utf8mb4 */;
-- CREATE TABLE `listings` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `title` varchar(255) NOT NULL,
--   `description` text NOT NULL,
--   `price` decimal(15,2) NOT NULL,
--   `location` varchar(255) NOT NULL,
--   `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
--   `photo_path` varchar(255) NULL,
--   PRIMARY KEY (`id`),
--   CONSTRAINT `listings_category_FK` FOREIGN KEY (`id`) REFERENCES `category` (`id`),
--   CONSTRAINT `listings_user_FK` FOREIGN KEY (`id`) REFERENCES `user` (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- /*!40101 SET character_set_client = @saved_cs_client */;

-- --
-- -- Dumping data for table `listings`
-- --

-- LOCK TABLES `listings` WRITE;
-- /*!40000 ALTER TABLE `listings` DISABLE KEYS */;
-- /*!40000 ALTER TABLE `listings` ENABLE KEYS */;
-- UNLOCK TABLES;

-- --
-- -- Table structure for table `saved_searches`
-- --

-- DROP TABLE IF EXISTS `saved_searches`;
-- /*!40101 SET @saved_cs_client     = @@character_set_client */;
-- /*!50503 SET character_set_client = utf8mb4 */;
-- CREATE TABLE `saved_searches` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `user_id` int NOT NULL,
--   `search_query` text NOT NULL,
--   `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
--   PRIMARY KEY (`id`),
--   KEY `user_id` (`user_id`),
--   CONSTRAINT `saved_searches_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- /*!40101 SET character_set_client = @saved_cs_client */;

-- --
-- -- Dumping data for table `saved_searches`
-- --

-- LOCK TABLES `saved_searches` WRITE;
-- /*!40000 ALTER TABLE `saved_searches` DISABLE KEYS */;
-- /*!40000 ALTER TABLE `saved_searches` ENABLE KEYS */;
-- UNLOCK TABLES;

-- --
-- -- Table structure for table `user`
-- --

-- DROP TABLE IF EXISTS `user`;
-- /*!40101 SET @saved_cs_client     = @@character_set_client */;
-- /*!50503 SET character_set_client = utf8mb4 */;
-- CREATE TABLE `user` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `full_name` varchar(300) NOT NULL,
--   `email` varchar(200) NOT NULL,
--   `password` varchar(255) NOT NULL,
--   `phone_number` varchar(50) DEFAULT NULL,
--   `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
--   `role` enum('buyer','seller','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
--   PRIMARY KEY (`id`),
--   UNIQUE KEY `User_UNIQUE` (`email`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- /*!40101 SET character_set_client = @saved_cs_client */;

-- --
-- -- Dumping data for table `user`
-- --

-- LOCK TABLES `user` WRITE;
-- /*!40000 ALTER TABLE `user` DISABLE KEYS */;
-- /*!40000 ALTER TABLE `user` ENABLE KEYS */;
-- UNLOCK TABLES;

-- --
-- -- Table structure for table `user_profiles`
-- --

-- DROP TABLE IF EXISTS `user_profiles`;
-- /*!40101 SET @saved_cs_client     = @@character_set_client */;
-- /*!50503 SET character_set_client = utf8mb4 */;
-- CREATE TABLE `user_profiles` (
--   `user_id` int NOT NULL,
--   `profile_picture_url` varchar(255) DEFAULT NULL,
--   `bio` text,
--   `location` varchar(255) DEFAULT NULL,
--   PRIMARY KEY (`user_id`),
--   CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- /*!40101 SET character_set_client = @saved_cs_client */;

-- --
-- -- Dumping data for table `user_profiles`
-- --

-- LOCK TABLES `user_profiles` WRITE;
-- /*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
-- /*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
-- UNLOCK TABLES;
-- /*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

-- /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
-- /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
-- /*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- -- Dump completed on 2025-04-04 13:39:05
