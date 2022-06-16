CREATE DATABASE  IF NOT EXISTS `dbestacionamento` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbestacionamento`;
-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: dbestacionamento
-- ------------------------------------------------------
-- Server version	8.0.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tblcliente`
--

DROP TABLE IF EXISTS `tblcliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblcliente` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(180) NOT NULL,
  `telefone` varchar(22) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcliente`
--

LOCK TABLES `tblcliente` WRITE;
/*!40000 ALTER TABLE `tblcliente` DISABLE KEYS */;
INSERT INTO `tblcliente` VALUES (1,'Julia','101010'),(2,'Julio','202020'),(3,'Judas','303030'),(4,'Jonas','404040'),(5,'Joana','505050'),(6,'Josi','606060'),(7,'Thales',''),(8,'Thales',''),(9,'Thales s',''),(10,'Thales Santos','4002-8922'),(11,'Thales Santos','4002-8922'),(12,'Thales Santos','4002-8922'),(13,'Thales Santos','4002-8922'),(14,'Thales Santos','4002-8922'),(15,'Thales Santos','4002-8922'),(16,'Thales Santos','4002-8922'),(17,'Thales Santos','4002-8922'),(18,'Thales Santos','4002-8922'),(19,'Thales Santos','4002-8922'),(20,'Thales Santos','4002-8922'),(21,'Thales Santos','4002-8922'),(22,'Thales Santos','4002-8922'),(23,'Thales Santos','4002-8922'),(24,'Thales Santos','4002-8922'),(25,'Thales Santos','4002-8922'),(26,'Thales Santos','4002-8922'),(27,'Thales Santos','4002-8922'),(28,'Thales Santos','4002-8922'),(29,'Thales Santos','4002-8922'),(30,'Thales Santos','4002-8922'),(31,'Thales Santos','4002-8922'),(32,'Thales Santos','4002-8922'),(33,'Thales Santos','4002-8922'),(34,'Thales Santos','4002-8922'),(35,'Thales Santos','4002-8922'),(36,'Thales Santos','4002-8922'),(37,'Thales Santos','4002-8922'),(38,'Thales Santos','4002-8922'),(39,'Thales Santos','4002-8922'),(40,'Thales Santos','4002-8922'),(41,'Thales Santos','4002-8922'),(42,'Thales Santos','4002-8922'),(43,'Thales Santos','4002-8922'),(44,'Thales Santos','4002-8922'),(45,'Thales Santos','4002-8922'),(46,'Thales Santos','4002-8922'),(47,'Thales Santos','4002-8922'),(48,'Thales Santos','4002-8922'),(49,'Thales Santos','4002-8922'),(50,'Thales Santos','4002-8922'),(51,'Thales Santos','4002-8922'),(52,'Thales Santos','4002-8922'),(53,'Thales Santos','4002-8922'),(54,'Thales Santos','4002-8922'),(55,'Thales Santos','4002-8922'),(56,'Thales Santos','4002-8922'),(57,'Thales Santos','4002-8922'),(58,'Thales Santos','4002-8922'),(59,'Thales Santos','4002-8922'),(60,'Thales Santos','4002-8922'),(61,'Thales Santos','4002-8922'),(62,'Thales Santos','4002-8922'),(63,'Thales Santos','4002-8922'),(64,'Thales Santos','4002-8922'),(65,'Thales Santos','4002-8922'),(66,'Thales Santos','4002-8922'),(67,'Thales Santos','4002-8922'),(68,'Thales Santos','4002-8922'),(69,'Thales Santos','4002-8922'),(70,'Thales Santos','4002-8922'),(71,'Thales Santos','4002-8922'),(72,'Thales Santos','4002-8922'),(73,'Thales Santos','4002-8922'),(74,'Thales Santos','4002-8922'),(75,'Thales Santos','4002-8922'),(76,'Thales Santos','4002-8922'),(77,'Thales Santos','4002-8922'),(78,'Thales Santos','4002-8922'),(79,'Thales Santos','4002-8922'),(80,'Thales Santos','4002-8922'),(81,'Thales Santos','4002-8922');
/*!40000 ALTER TABLE `tblcliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcor`
--

DROP TABLE IF EXISTS `tblcor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblcor` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcor`
--

LOCK TABLES `tblcor` WRITE;
/*!40000 ALTER TABLE `tblcor` DISABLE KEYS */;
INSERT INTO `tblcor` VALUES (1,'Preto'),(2,'Cinza'),(3,'Branco'),(4,'Vermelho'),(5,'Marrom'),(6,'Amarelo');
/*!40000 ALTER TABLE `tblcor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcorredor`
--

DROP TABLE IF EXISTS `tblcorredor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblcorredor` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(10) NOT NULL,
  `idSetor` int unsigned NOT NULL,
  `ativo` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Setor_Corredor` (`idSetor`),
  CONSTRAINT `FK_Setor_Corredor` FOREIGN KEY (`idSetor`) REFERENCES `tblsetor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcorredor`
--

LOCK TABLES `tblcorredor` WRITE;
/*!40000 ALTER TABLE `tblcorredor` DISABLE KEYS */;
INSERT INTO `tblcorredor` VALUES (1,'c',1,1),(3,'frita',1,1);
/*!40000 ALTER TABLE `tblcorredor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblmovimentacao`
--

DROP TABLE IF EXISTS `tblmovimentacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblmovimentacao` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `dataEntrada` date NOT NULL,
  `dataSaida` date DEFAULT NULL,
  `horaEntrada` time NOT NULL,
  `horaSaida` time DEFAULT NULL,
  `idVaga` int unsigned NOT NULL,
  `idVeiculo` int unsigned NOT NULL,
  `valor` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Vaga_Movimentacao` (`idVaga`),
  KEY `FK_Veiculo_Movimentacao` (`idVeiculo`),
  CONSTRAINT `FK_Vaga_Movimentacao` FOREIGN KEY (`idVaga`) REFERENCES `tblvaga` (`id`),
  CONSTRAINT `FK_Veiculo_Movimentacao` FOREIGN KEY (`idVeiculo`) REFERENCES `tblveiculo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmovimentacao`
--

LOCK TABLES `tblmovimentacao` WRITE;
/*!40000 ALTER TABLE `tblmovimentacao` DISABLE KEYS */;
INSERT INTO `tblmovimentacao` VALUES (1,'2022-06-02',NULL,'18:48:00',NULL,1,1,NULL),(2,'2022-06-02',NULL,'18:48:00',NULL,1,1,NULL),(3,'2022-06-02',NULL,'18:48:00',NULL,1,1,NULL),(4,'2022-06-02',NULL,'18:48:00',NULL,1,1,NULL),(5,'2022-06-02',NULL,'18:48:00',NULL,1,1,NULL),(6,'2022-06-02',NULL,'18:48:00',NULL,1,1,NULL),(7,'2022-06-07',NULL,'11:05:16',NULL,1,3,NULL),(8,'2022-06-11',NULL,'12:57:58',NULL,5,38,NULL),(9,'2022-06-11',NULL,'12:58:45',NULL,5,42,NULL),(10,'2022-06-11',NULL,'13:00:18',NULL,6,43,NULL),(11,'2022-06-11',NULL,'13:07:40',NULL,4,44,NULL),(12,'2022-06-11','2022-06-11','13:09:45','14:00:10',3,46,28.7),(13,'2022-06-11',NULL,'13:18:05',NULL,4,49,NULL),(14,'2022-06-11','2022-06-11','13:21:42','14:29:49',6,51,48.7),(15,'2022-06-11','2022-06-11','14:43:07','14:43:34',4,53,28.7),(16,'2022-06-11','2022-06-11','14:45:11','14:45:18',1,55,28.7),(17,'2022-06-11','2022-06-11','14:46:01','14:46:08',1,57,28.7),(18,'2022-06-11','2022-06-11','14:46:40','14:46:46',1,58,28.7),(19,'2022-06-11','2022-06-11','14:47:46','14:47:52',1,59,28.7),(20,'2022-06-11','2022-06-11','14:48:09','14:48:15',1,61,28.7),(21,'2022-06-11','2022-06-11','14:49:21','14:49:32',1,62,28.7),(22,'2022-06-11','2022-06-11','14:49:55','14:50:04',1,64,28.7),(23,'2022-06-11','2022-06-11','14:50:20','14:50:29',1,65,28.7),(24,'2022-06-11','2022-06-11','17:40:39','17:41:03',1,66,28.7),(25,'2022-06-11','2022-06-11','17:50:04','17:50:12',1,67,28.7),(26,'2022-06-11','2022-06-11','20:29:17','20:36:25',1,68,28.7),(27,'2022-06-11',NULL,'20:39:04',NULL,1,69,NULL),(28,'2022-06-11','2022-06-12','20:40:11','16:08:59',2,71,70),(29,'2022-06-12',NULL,'16:09:02',NULL,2,73,NULL);
/*!40000 ALTER TABLE `tblmovimentacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpiso`
--

DROP TABLE IF EXISTS `tblpiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblpiso` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(10) NOT NULL,
  `ativo` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpiso`
--

LOCK TABLES `tblpiso` WRITE;
/*!40000 ALTER TABLE `tblpiso` DISABLE KEYS */;
INSERT INTO `tblpiso` VALUES (1,'1',1);
/*!40000 ALTER TABLE `tblpiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpreco`
--

DROP TABLE IF EXISTS `tblpreco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblpreco` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `primeiraHora` double NOT NULL,
  `demaisHoras` double NOT NULL,
  `idTipoVeiculo` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_TipoVeiculo_Preco` (`idTipoVeiculo`),
  CONSTRAINT `FK_TipoVeiculo_Preco` FOREIGN KEY (`idTipoVeiculo`) REFERENCES `tbltipoveiculo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpreco`
--

LOCK TABLES `tblpreco` WRITE;
/*!40000 ALTER TABLE `tblpreco` DISABLE KEYS */;
INSERT INTO `tblpreco` VALUES (4,28.7,20,8),(5,40,30,9),(6,15,10,7);
/*!40000 ALTER TABLE `tblpreco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsetor`
--

DROP TABLE IF EXISTS `tblsetor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblsetor` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(10) NOT NULL,
  `idPiso` int unsigned NOT NULL,
  `ativo` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Piso_Setor` (`idPiso`),
  CONSTRAINT `FK_Piso_Setor` FOREIGN KEY (`idPiso`) REFERENCES `tblpiso` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsetor`
--

LOCK TABLES `tblsetor` WRITE;
/*!40000 ALTER TABLE `tblsetor` DISABLE KEYS */;
INSERT INTO `tblsetor` VALUES (1,'A06',1,1);
/*!40000 ALTER TABLE `tblsetor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbltipoveiculo`
--

DROP TABLE IF EXISTS `tbltipoveiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbltipoveiculo` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltipoveiculo`
--

LOCK TABLES `tbltipoveiculo` WRITE;
/*!40000 ALTER TABLE `tbltipoveiculo` DISABLE KEYS */;
INSERT INTO `tbltipoveiculo` VALUES (7,'moto'),(8,'carro'),(9,'ônibus'),(10,'vam'),(11,'lancha'),(12,'helicoptero');
/*!40000 ALTER TABLE `tbltipoveiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblvaga`
--

DROP TABLE IF EXISTS `tblvaga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblvaga` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL,
  `idCorredor` int unsigned NOT NULL,
  `idTipoVeiculo` int unsigned NOT NULL,
  `ativo` tinyint NOT NULL,
  `ocupada` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Corredor_Vaga` (`idCorredor`),
  KEY `FK_TipoVeiculo_Vaga` (`idTipoVeiculo`),
  CONSTRAINT `FK_Corredor_Vaga` FOREIGN KEY (`idCorredor`) REFERENCES `tblcorredor` (`id`),
  CONSTRAINT `FK_TipoVeiculo_Vaga` FOREIGN KEY (`idTipoVeiculo`) REFERENCES `tbltipoveiculo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblvaga`
--

LOCK TABLES `tblvaga` WRITE;
/*!40000 ALTER TABLE `tblvaga` DISABLE KEYS */;
INSERT INTO `tblvaga` VALUES (1,'B09',1,8,1,1),(2,'b010',3,7,1,1),(3,'b010',3,7,1,0),(4,'b012',3,7,1,0),(5,'teste',3,8,1,0),(6,'api',3,8,1,0),(7,'api01',1,8,0,0),(8,'api',3,8,1,0),(10,'api02',1,8,1,0);
/*!40000 ALTER TABLE `tblvaga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblveiculo`
--

DROP TABLE IF EXISTS `tblveiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblveiculo` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `placa` varchar(45) NOT NULL,
  `fabricante` varchar(80) NOT NULL,
  `modelo` varchar(80) NOT NULL,
  `idCor` int unsigned NOT NULL,
  `idTipoVeiculo` int unsigned NOT NULL,
  `idCliente` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_Cor_Veiculo` (`idCor`),
  KEY `FK_TipoVeiculo_Veiculo` (`idTipoVeiculo`),
  KEY `FK_Cliente_Veiculo` (`idCliente`),
  CONSTRAINT `FK_Cliente_Veiculo` FOREIGN KEY (`idCliente`) REFERENCES `tblcliente` (`id`),
  CONSTRAINT `FK_Cor_Veiculo` FOREIGN KEY (`idCor`) REFERENCES `tblcor` (`id`),
  CONSTRAINT `FK_TipoVeiculo_Veiculo` FOREIGN KEY (`idTipoVeiculo`) REFERENCES `tbltipoveiculo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblveiculo`
--

LOCK TABLES `tblveiculo` WRITE;
/*!40000 ALTER TABLE `tblveiculo` DISABLE KEYS */;
INSERT INTO `tblveiculo` VALUES (1,'aaa-111','ford','fordKa',4,8,3),(2,'ddd-111','ford','fordKa',6,11,6),(3,'bbb-111','honda','CB300',2,7,2),(4,'ccc-111','Kawasaki','Kawasaki',1,8,1),(5,'ccc-111','renalt','van',1,10,5),(6,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,13),(7,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,14),(8,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,15),(9,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,16),(10,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,17),(11,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,18),(12,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,19),(13,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,20),(14,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,21),(15,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,22),(16,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,23),(17,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,24),(18,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,25),(19,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,27),(20,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,28),(21,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,29),(22,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,30),(23,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,31),(24,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,32),(25,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,33),(26,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,34),(27,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,35),(28,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,36),(29,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,37),(30,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,38),(31,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,39),(32,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,40),(33,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,41),(34,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,42),(35,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,43),(36,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,44),(37,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,45),(38,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,46),(39,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,47),(40,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,48),(41,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,49),(42,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,50),(43,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,51),(44,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,52),(45,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,53),(46,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,54),(47,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,55),(48,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,56),(49,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,57),(50,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,58),(51,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,59),(52,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,60),(53,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,61),(54,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,62),(55,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,63),(56,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,64),(57,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,65),(58,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,66),(59,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,67),(60,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,68),(61,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,69),(62,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,70),(63,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,71),(64,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,72),(65,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,73),(66,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,74),(67,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,75),(68,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,76),(69,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,77),(70,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,78),(71,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,79),(72,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,80),(73,'aaaa-000','chevrolet','Cruze LTZ 2.0',1,8,81);
/*!40000 ALTER TABLE `tblveiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'dbestacionamento'
--

--
-- Dumping routines for database 'dbestacionamento'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-13 11:55:34
