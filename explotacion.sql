-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: 03_explotacion
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.18.04.1
USE smartquercus;
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
-- Table structure for table `agrupacion`
--

DROP TABLE IF EXISTS `agrupacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agrupacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `explotacion_id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3C02427D1A6AAB04` (`explotacion_id`),
  CONSTRAINT `FK_3C02427D1A6AAB04` FOREIGN KEY (`explotacion_id`) REFERENCES `explotacion` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agrupacion`
--

LOCK TABLES `agrupacion` WRITE;
/*!40000 ALTER TABLE `agrupacion` DISABLE KEYS */;
INSERT INTO `agrupacion` VALUES (1,1,'1'),(2,1,'2'),(3,3,'AGRUPA_1'),(4,4,'AGRUPA_2'),(5,9,'AGRUPA_25');
/*!40000 ALTER TABLE `agrupacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `is_active` tinyint(1) NOT NULL,
  `discr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C2502824E7927C74` (`email`),
  UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_users`
--

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;
INSERT INTO `app_users` VALUES (1,'eva@iluego.com','eva','$2y$12$/jrnjzr08IHm63/8Hxa4/.ZPFqx/zpo8icdEtTTWBoHOeoIEfik1O','a:1:{i:0;s:9:\"ROLE_USER\";}',1,'user','','',''),(2,'mariay@iluego.com','maria','$2y$12$f52sY8FRqYtC6VzSZfeVruTpc4iQziD0MxZAilXOA8lFkDzo3Dnka','a:1:{i:0;s:9:\"ROLE_USER\";}',1,'user','maria','Maria','Yogurt'),(3,'lucia@iluego.com','lucia','$2y$12$A4ZyFtKchuvNhLeOMFnee.ZDZh5SB7pR5ZB7vARQ/5D8dvdz8ZtGq','a:1:{i:0;s:9:\"ROLE_USER\";}',1,'user','Lucia','Yogurt','Griego');
/*!40000 ALTER TABLE `app_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cultivo`
--

DROP TABLE IF EXISTS `cultivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cultivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cultivo`
--

LOCK TABLES `cultivo` WRITE;
/*!40000 ALTER TABLE `cultivo` DISABLE KEYS */;
INSERT INTO `cultivo` VALUES (1,'Olivar'),(2,'Viña');
/*!40000 ALTER TABLE `cultivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipo`
--

DROP TABLE IF EXISTS `equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `roma` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_adquisicion` date DEFAULT NULL,
  `fecha_ultima_inspeccion` date DEFAULT NULL,
  `bastidor` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipo`
--

LOCK TABLES `equipo` WRITE;
/*!40000 ALTER TABLE `equipo` DISABLE KEYS */;
INSERT INTO `equipo` VALUES (1,1,'Atomizador verde',1200,'1234567','2017-04-01','2017-04-01','ABCDE');
/*!40000 ALTER TABLE `equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `explotacion`
--

DROP TABLE IF EXISTS `explotacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `explotacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rexa` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roppi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `explotacion`
--

LOCK TABLES `explotacion` WRITE;
/*!40000 ALTER TABLE `explotacion` DISABLE KEYS */;
INSERT INTO `explotacion` VALUES (1,'1','OL/000/0797/17'),(2,'1','OL/000/0797/18'),(3,'1','OL/000/0797/19'),(4,'1','OL/000/0797/20'),(5,'2','OL/000/0797/21'),(6,'3','OL/000/0797/22'),(7,'4','OL/000/0797/23'),(9,'5','OL/000/0797/25');
/*!40000 ALTER TABLE `explotacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localidad`
--

DROP TABLE IF EXISTS `localidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `localidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provincia_id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4F68E0104E7121AF` (`provincia_id`),
  CONSTRAINT `FK_4F68E0104E7121AF` FOREIGN KEY (`provincia_id`) REFERENCES `provincia` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localidad`
--

LOCK TABLES `localidad` WRITE;
/*!40000 ALTER TABLE `localidad` DISABLE KEYS */;
INSERT INTO `localidad` VALUES (1,1,'Gévora'),(2,1,'Badajoz');
/*!40000 ALTER TABLE `localidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20180907183333'),('20180908063911'),('20180908065103'),('20180908074225'),('20180908075540'),('20180908081612'),('20180908082534'),('20180909075331'),('20180909083924'),('20180909091721'),('20181002062136');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parcela`
--

DROP TABLE IF EXISTS `parcela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parcela` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `localidad_id` int(11) NOT NULL,
  `sigpac_uso_id` int(11) NOT NULL,
  `agrupacion_id` int(11) NOT NULL,
  `numid` int(11) NOT NULL,
  `poligono` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parcela` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recinto` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `superficie` decimal(10,4) NOT NULL,
  `marco_plantacion` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pi` tinyint(1) NOT NULL,
  `piayuda` tinyint(1) NOT NULL,
  `volumen_copa` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A5CC444667707C89` (`localidad_id`),
  KEY `IDX_A5CC4446ED2E5089` (`sigpac_uso_id`),
  KEY `IDX_A5CC4446162972A4` (`agrupacion_id`),
  CONSTRAINT `FK_A5CC4446162972A4` FOREIGN KEY (`agrupacion_id`) REFERENCES `agrupacion` (`id`),
  CONSTRAINT `FK_A5CC444667707C89` FOREIGN KEY (`localidad_id`) REFERENCES `localidad` (`id`),
  CONSTRAINT `FK_A5CC4446ED2E5089` FOREIGN KEY (`sigpac_uso_id`) REFERENCES `sigpac_uso` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parcela`
--

LOCK TABLES `parcela` WRITE;
/*!40000 ALTER TABLE `parcela` DISABLE KEYS */;
INSERT INTO `parcela` VALUES (1,2,1,1,101,'150','13','1',3.2600,'5x7',1,1,25.00),(2,2,1,1,102,'150','14','1',1.0700,'5x7',1,1,NULL),(3,2,1,1,103,'149','4','4',0.1200,'5x7',1,1,NULL),(5,2,1,1,104,'149','11','3',0.0300,'5x7',1,1,NULL),(6,2,1,2,201,'149','11','7',1.8700,'5x7',1,1,NULL),(7,1,1,5,25,'149','15','5',2.0250,'5x7',1,1,25.00);
/*!40000 ALTER TABLE `parcela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parcela_variedad`
--

DROP TABLE IF EXISTS `parcela_variedad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parcela_variedad` (
  `parcela_id` int(11) NOT NULL,
  `variedad_id` int(11) NOT NULL,
  PRIMARY KEY (`parcela_id`,`variedad_id`),
  KEY `IDX_E9F8A4EB1491307D` (`parcela_id`),
  KEY `IDX_E9F8A4EB91391A54` (`variedad_id`),
  CONSTRAINT `FK_E9F8A4EB1491307D` FOREIGN KEY (`parcela_id`) REFERENCES `parcela` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E9F8A4EB91391A54` FOREIGN KEY (`variedad_id`) REFERENCES `variedad` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parcela_variedad`
--

LOCK TABLES `parcela_variedad` WRITE;
/*!40000 ALTER TABLE `parcela_variedad` DISABLE KEYS */;
INSERT INTO `parcela_variedad` VALUES (1,1),(2,1),(3,1),(5,2),(6,1),(7,1),(7,2);
/*!40000 ALTER TABLE `parcela_variedad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participacion`
--

DROP TABLE IF EXISTS `participacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `explotacion_id` int(11) NOT NULL,
  `rol` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_669B8D69A76ED395` (`user_id`),
  KEY `IDX_669B8D691A6AAB04` (`explotacion_id`),
  CONSTRAINT `FK_669B8D691A6AAB04` FOREIGN KEY (`explotacion_id`) REFERENCES `explotacion` (`id`),
  CONSTRAINT `FK_669B8D69A76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participacion`
--

LOCK TABLES `participacion` WRITE;
/*!40000 ALTER TABLE `participacion` DISABLE KEYS */;
INSERT INTO `participacion` VALUES (1,2,9,'TITULAR');
/*!40000 ALTER TABLE `participacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plaga`
--

DROP TABLE IF EXISTS `plaga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plaga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plaga`
--

LOCK TABLES `plaga` WRITE;
/*!40000 ALTER TABLE `plaga` DISABLE KEYS */;
INSERT INTO `plaga` VALUES (1,'Prays'),(2,'Repilo');
/*!40000 ALTER TABLE `plaga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plaga_cultivo`
--

DROP TABLE IF EXISTS `plaga_cultivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plaga_cultivo` (
  `plaga_id` int(11) NOT NULL,
  `cultivo_id` int(11) NOT NULL,
  PRIMARY KEY (`plaga_id`,`cultivo_id`),
  KEY `IDX_47E70C687744938E` (`plaga_id`),
  KEY `IDX_47E70C685F21A0D9` (`cultivo_id`),
  CONSTRAINT `FK_47E70C685F21A0D9` FOREIGN KEY (`cultivo_id`) REFERENCES `cultivo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_47E70C687744938E` FOREIGN KEY (`plaga_id`) REFERENCES `plaga` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plaga_cultivo`
--

LOCK TABLES `plaga_cultivo` WRITE;
/*!40000 ALTER TABLE `plaga_cultivo` DISABLE KEYS */;
INSERT INTO `plaga_cultivo` VALUES (1,1),(2,1),(2,2);
/*!40000 ALTER TABLE `plaga_cultivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `principio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Kenotrin','Lambda cihalotrin 2,5%');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincia`
--

DROP TABLE IF EXISTS `provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincia`
--

LOCK TABLES `provincia` WRITE;
/*!40000 ALTER TABLE `provincia` DISABLE KEYS */;
INSERT INTO `provincia` VALUES (1,'Badajoz');
/*!40000 ALTER TABLE `provincia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sigpac_uso`
--

DROP TABLE IF EXISTS `sigpac_uso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sigpac_uso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sigpac_uso`
--

LOCK TABLES `sigpac_uso` WRITE;
/*!40000 ALTER TABLE `sigpac_uso` DISABLE KEYS */;
INSERT INTO `sigpac_uso` VALUES (1,'Olivar'),(2,'Viñedo'),(3,'Viñedo - Olivar');
/*!40000 ALTER TABLE `sigpac_uso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tratamiento`
--

DROP TABLE IF EXISTS `tratamiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tratamiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registro` int(11) NOT NULL,
  `dosis_recomendada` decimal(7,4) NOT NULL,
  `unidades` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_aplicaciones` int(11) NOT NULL,
  `dosis_empleada` decimal(7,4) NOT NULL,
  `plaga_id` int(11) NOT NULL,
  `equipo_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_61A4A07C7744938E` (`plaga_id`),
  KEY `IDX_61A4A07C23BFBED` (`equipo_id`),
  KEY `IDX_61A4A07C7645698E` (`producto_id`),
  CONSTRAINT `FK_61A4A07C23BFBED` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`),
  CONSTRAINT `FK_61A4A07C7645698E` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`),
  CONSTRAINT `FK_61A4A07C7744938E` FOREIGN KEY (`plaga_id`) REFERENCES `plaga` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tratamiento`
--

LOCK TABLES `tratamiento` WRITE;
/*!40000 ALTER TABLE `tratamiento` DISABLE KEYS */;
INSERT INTO `tratamiento` VALUES (1,22958,0.0450,'VOL',4,7.0000,1,1,1);
/*!40000 ALTER TABLE `tratamiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tratamiento_parcela`
--

DROP TABLE IF EXISTS `tratamiento_parcela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tratamiento_parcela` (
  `tratamiento_id` int(11) NOT NULL,
  `parcela_id` int(11) NOT NULL,
  PRIMARY KEY (`tratamiento_id`,`parcela_id`),
  KEY `IDX_4B0FFF8F44168F7D` (`tratamiento_id`),
  KEY `IDX_4B0FFF8F1491307D` (`parcela_id`),
  CONSTRAINT `FK_4B0FFF8F1491307D` FOREIGN KEY (`parcela_id`) REFERENCES `parcela` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4B0FFF8F44168F7D` FOREIGN KEY (`tratamiento_id`) REFERENCES `tratamiento` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tratamiento_parcela`
--

LOCK TABLES `tratamiento_parcela` WRITE;
/*!40000 ALTER TABLE `tratamiento_parcela` DISABLE KEYS */;
INSERT INTO `tratamiento_parcela` VALUES (1,1),(1,2),(1,3),(1,5);
/*!40000 ALTER TABLE `tratamiento_parcela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variedad`
--

DROP TABLE IF EXISTS `variedad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cultivo_id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_850B22B35F21A0D9` (`cultivo_id`),
  CONSTRAINT `FK_850B22B35F21A0D9` FOREIGN KEY (`cultivo_id`) REFERENCES `cultivo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variedad`
--

LOCK TABLES `variedad` WRITE;
/*!40000 ALTER TABLE `variedad` DISABLE KEYS */;
INSERT INTO `variedad` VALUES (1,1,'Picual'),(2,1,'Verdial'),(3,2,'Garnacha'),(4,2,'Tempranillo - tinta');
/*!40000 ALTER TABLE `variedad` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-22  8:37:19
