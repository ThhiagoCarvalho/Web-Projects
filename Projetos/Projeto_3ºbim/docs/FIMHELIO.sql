CREATE DATABASE  IF NOT EXISTS `mydb` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mydb`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mydb
-- ------------------------------------------------------
-- Server version	8.3.0

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
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `idCategoria` int unsigned NOT NULL AUTO_INCREMENT,
  `nomeCategoria` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idCategoria`),
  UNIQUE KEY `ID_Categoria_UNIQUE` (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Jantar Romantico'),(3,'Baladas '),(4,'Passeio ao Ar livre'),(7,'lua de mel'),(15,'restaurante luxuoso'),(16,'lazer'),(17,'Restaurantes');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opcoes`
--

DROP TABLE IF EXISTS `opcoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opcoes` (
  `idOpcoes` int unsigned NOT NULL AUTO_INCREMENT,
  `localizacaoOpcao` varchar(45) NOT NULL,
  `horarioFucionamento` varchar(45) NOT NULL,
  `custoEstimado` varchar(45) NOT NULL,
  `nomeOpcao` varchar(45) NOT NULL,
  `Categoria_idCategoria` int unsigned NOT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idOpcoes`),
  UNIQUE KEY `idOpcoes_UNIQUE` (`idOpcoes`),
  KEY `fk_Opcoes_Categoria1_idx` (`Categoria_idCategoria`),
  CONSTRAINT `fk_Opcoes_Categoria1` FOREIGN KEY (`Categoria_idCategoria`) REFERENCES `categoria` (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcoes`
--

LOCK TABLES `opcoes` WRITE;
/*!40000 ALTER TABLE `opcoes` DISABLE KEYS */;
INSERT INTO `opcoes` VALUES (32,'Rio de Janeiro','12h - 23h','R$45.0','Restaurante Sabor & Arte',17,'Restaurante com culinária contemporânea e ambiente sofisticado.'),(33,'São Paulo','11h - 23h','R$25','Hamburgueria Big Taste',17,'Hamburgueria artesanal com ingredientes frescos e opções vegetarianas.'),(34,'Curitiba','10h - 21h','R$15','Sorveteria Delícias Geladas',17,'Sorveteria com uma grande variedade de sabores e coberturas.'),(35,'Belo Horizonte','06h - 18h','R$10','Padaria Pão Quente',17,'Padaria tradicional com pães frescos e café da manhã completo.'),(36,'Florianópolis','12h - 22h','R$30','Cantina do Italiano',17,'Cantina italiana com massas feitas à mão e ambiente aconchegante.'),(37,'Brasília','08h - 18h','Gratuito','Parque da Cidade',16,'Parque amplo com áreas verdes, trilhas e espaços para piquenique.'),(38,'Rio de Janeiro','14h - 23h','R$30','Cinema Cineplex',16,'Cinema com as últimas novidades em filmes e opções de snacks.'),(39,'São Paulo','09h - 21h','R$50','Clube Recreativo',16,'Clube com piscinas, quadras esportivas e área para churrasco.'),(40,'Porto Alegre','10h - 17h','R$20','Museu de Arte Moderna',16,'Museu com exposições permanentes e temporárias de arte moderna.'),(41,'Curitiba','19h - 23h','R$40','Teatro Central',16,'Teatro com peças clássicas e modernas, além de eventos culturais.'),(42,'Angra dos Reis','09h - 17h','R$100','Passeio de Barco',4,'Passeio de barco pelas ilhas paradisíacas de Angra dos Reis.'),(43,'Rio de Janeiro','08h - 17h','R$50','Trilha da Pedra Bonita',4,'Trilha com vista panorâmica para a cidade e o mar.'),(44,'Salvador','10h - 16h','R$80','Tour Histórico',4,'Tour guiado pelos principais pontos históricos da cidade.'),(45,'Curitiba','09h - 18h','R$15','Jardim Botânico',4,'Passeio por belos jardins e estufas de plantas exóticas.'),(46,'Chapada dos Veadeiros','08h - 16h','R$60','Cachoeira da Serra',4,'Passeio com trilha e banho em cachoeiras de águas cristalinas.'),(47,'São Paulo','23h - 05h','R$100','Boate Lux',3,'Balada luxuosa com DJ\'s internacionais e ambiente sofisticado.'),(48,'Rio de Janeiro','21h - 02h','R$50','Pub Irish Rock',3,'Pub com música ao vivo, cervejas artesanais e clima descontraído.'),(49,'Curitiba','00h - 06h','R$80','Club Electro Beats',3,'Balada eletrônica com os melhores DJs da cena underground.'),(50,'Florianópolis','22h - 03h','R$40','Bar da Praia',3,'Bar à beira-mar com música ao vivo e drinks especiais.'),(51,'Belo Horizonte','21h - 02h','R$90','Rooftop Sky Lounge',3,'Balada em rooftop com vista panorâmica e música de qualidade.'),(52,'São Paulo','19h - 23h','R$200','Ristorante Elegante',1,'Restaurante sofisticado com ambiente romântico e vista panorâmica.'),(53,'Rio de Janeiro','20h - 22h','R$150','Bistrô do Amor',1,'Bistrô acolhedor, ideal para um jantar à luz de velas.'),(54,'Curitiba','19h - 23h','R$180','Candlelight Dinner',1,'Experiência de jantar à luz de velas com pratos gourmet e música ao vivo.'),(55,'Florianópolis','18h - 22h','R$170','Oasis do Romance',1,'Restaurante à beira-mar com menu exclusivo para casais.'),(56,'Belo Horizonte','20h - 23h','R$160','Casa do Jantar',1,'Ambiente intimista com pratos refinados e atendimento personalizado.'),(57,'Búzios','10h - 22h','R$1.500','Resort Paraíso',7,'Resort luxuoso com pacotes especiais para lua de mel, incluindo jantares e passeios.'),(58,'Gramado','12h - 20h','R$1.200','Vila do Amor',7,'Pousada romântica com suítes privativas e serviços exclusivos para casais.'),(59,'Porto de Galinhas','09h - 21h','R$1.800','Hotel Romance',7,'Hotel cinco estrelas com pacotes de lua de mel que incluem spa e jantares especiais.'),(60,'Chapada dos Veadeiros','11h - 19h','R$1.000','Pousada Encantada',7,'Pousada charmosa com vistas espetaculares e pacotes de lua de mel personalizados.'),(61,'Fernando de Noronha','10h - 22h','R$2.000','Resort das Estrelas',7,'Resort exclusivo com experiências de lua de mel em um paraíso tropical.'),(62,'São Paulo','19h - 23h','R$500','Palácio Gourmet',15,'Restaurante de alta gastronomia com pratos sofisticados e serviço impecável.'),(63,'Rio de Janeiro','20h - 22h','R$450','La Belle Époque',15,'Restaurante francês elegante com ambiente refinado e culinária de classe mundial.'),(64,'Curitiba','18h - 23h','R$550','Caviar & Champagne',15,'Estabelecimento renomado oferecendo pratos exclusivos e uma seleção de champanhes.'),(65,'Florianópolis','19h - 23h','R$480','Gastronomia Suprema',15,'Restaurante luxuoso com menu degustação e vista panorâmica do litoral.'),(66,'Belo Horizonte','19h - 22h','R$470','Sabor Imperial',15,'Restaurante sofisticado com pratos gourmet e um ambiente de luxo e conforto.');
/*!40000 ALTER TABLE `opcoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `idUsuario` int unsigned NOT NULL AUTO_INCREMENT,
  `dataDate` varchar(45) NOT NULL,
  `Categoria_idCategoria` int unsigned NOT NULL,
  `nomeUsuario` varchar(45) NOT NULL,
  `emailUsuario` varchar(45) NOT NULL,
  `senhaUsuario` varchar(45) DEFAULT NULL,
  `idade` int DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `idUsuario_UNIQUE` (`idUsuario`),
  KEY `fk_Usuario_Categoria_idx` (`Categoria_idCategoria`),
  CONSTRAINT `fk_Usuario_Categoria` FOREIGN KEY (`Categoria_idCategoria`) REFERENCES `categoria` (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (18,'12/213',7,'thiago','thiago@ex','123',71),(19,'12/213',7,'thiago','thiago@ex','123',71),(26,'12/32/32',1,'bruno','baaaraunox@htmail','1f32aa4c9a1d2ea010adcf2348166a04',17),(27,'12/32/32',1,'thiagoADIM','thiagoADIM@htmail','827ccb0eea8a706c4c34a16891f84e7b',17),(28,'12/32/32',1,'thiagoADIM','thiagoADIM@htmail','827ccb0eea8a706c4c34a16891f84e7b',17),(34,'123/123/2',7,'thiago','thiagoExample','d9b1d7db4cd6e70935368a1efb10e377',17),(35,'2008-03-11',15,'thiago','thiagoExample@dada','827ccb0eea8a706c4c34a16891f84e7b',17),(36,'2008-03-11',1,'Cesar','cesar@gmail','827ccb0eea8a706c4c34a16891f84e7b',17),(37,'12/32/32',1,'julio','julio@htmail','827ccb0eea8a706c4c34a16891f84e7b',17),(38,'1111-11-11',1,'ceare','ceare@gmail','827ccb0eea8a706c4c34a16891f84e7b',17),(39,'1111-11-11',1,'DUDU','thiagoADIM@dwa','827ccb0eea8a706c4c34a16891f84e7b',17),(40,'1111-11-11',1,'thiago','dada@gma','827ccb0eea8a706c4c34a16891f84e7b',17),(42,'2008-03-11',7,'nicolas','nicolas@gmail','827ccb0eea8a706c4c34a16891f84e7b',17),(43,'2008-03-11',7,'nicolas','nicolas@gmail','827ccb0eea8a706c4c34a16891f84e7b',17),(44,'2008-01-11',7,'jose','jose@gmail','827ccb0eea8a706c4c34a16891f84e7b',17),(45,'2007-08-06',1,'heitor','heitor@gmail','827ccb0eea8a706c4c34a16891f84e7b',17),(46,'2007-03-11',7,'giovanne','giovanne@gmial','827ccb0eea8a706c4c34a16891f84e7b',17),(47,'2024-09-04',1,'nicolas','nicolas@gmail','827ccb0eea8a706c4c34a16891f84e7b',17),(48,'2024-09-03',16,'aisimnesf','aisimnesf@gmail.com','827ccb0eea8a706c4c34a16891f84e7b',17),(49,'2024-09-04',3,'tthiago','tt@gmail','827ccb0eea8a706c4c34a16891f84e7b',17),(50,'2024-09-04',4,'nicolau','nicolau@gmail.com','827ccb0eea8a706c4c34a16891f84e7b',17),(51,'2024-09-06',17,'awdawd','dwadawdawd','827ccb0eea8a706c4c34a16891f84e7b',17),(52,'2024-09-06',16,'dawdawdawd','aaaaaaaaaaa','827ccb0eea8a706c4c34a16891f84e7b',17),(53,'2024-09-04',1,'mindee','mindeeaa','827ccb0eea8a706c4c34a16891f84e7b',17),(54,'2024-09-04',7,'DUDU','thiagoExample@dada','827ccb0eea8a706c4c34a16891f84e7b',17),(55,'2024-09-04',15,'helio','heliozera','827ccb0eea8a706c4c34a16891f84e7b',30),(56,'2024-09-06',15,'helio','heliozera123','827ccb0eea8a706c4c34a16891f84e7b',30),(57,'2024-09-06',1,'thiago','thiago321','827ccb0eea8a706c4c34a16891f84e7b',17),(58,'2024-09-07',4,'thiago','thiagoa','827ccb0eea8a706c4c34a16891f84e7b',30),(59,'2024-09-07',16,'DUDU123','DUDU1234','827ccb0eea8a706c4c34a16891f84e7b',30),(60,'2024-09-06',7,'DUDU','tt@gmail','827ccb0eea8a706c4c34a16891f84e7b',30),(61,'2024-09-04',7,'thiago','thiagoADIM@htmail.outolok','827ccb0eea8a706c4c34a16891f84e7b',17),(62,'2024-09-07',3,'helio','cesar@gmail','827ccb0eea8a706c4c34a16891f84e7b',30),(63,'2024-09-06',3,'thiago','jose@gmail','827ccb0eea8a706c4c34a16891f84e7b',30),(64,'2024-09-06',3,'dwdadawdaw','dawdawdawdawd','827ccb0eea8a706c4c34a16891f84e7b',30),(65,'2024-09-07',3,'aaaaaaaaa','aaaaaaaaaaaaaaa','827ccb0eea8a706c4c34a16891f84e7b',30),(66,'',3,'Nicolas','Nicolas@gmail.comn','827ccb0eea8a706c4c34a16891f84e7b',18),(67,'2024-09-05',3,'Nicolas','Nicolas@gmail.comn','827ccb0eea8a706c4c34a16891f84e7b',18),(68,'12/32/32',1,'julio','julio@htmai','827ccb0eea8a706c4c34a16891f84e7b',17),(69,'11/03/21',1,'thiago1','Nicolassss@gmail.comn','202cb962ac59075b964b07152d234b70',17),(71,'11/03/21',1,'thiago1','thiago1@example.com','202cb962ac59075b964b07152d234b70',17),(72,'11/03/21',1,'thiago1','Nicolas@gmail.comnmm','202cb962ac59075b964b07152d234b70',17),(73,'11/03/21',1,'thiago1','testeapenas','202cb962ac59075b964b07152d234b70',17),(74,'11/03/21',1,'thiago1','testeapenas@gmial.com','202cb962ac59075b964b07152d234b70',17),(75,'11/03/21',1,'thiago1','testeapenas@gmial.com','12345',17),(76,'11/03/21',1,'thiago1','testeapenas@gmiial.com','12345',17),(77,'11/03/21',1,'thiago1','Nicolas@gmail.com','202cb962ac59075b964b07152d234b70',17),(78,'11/03/21',1,'thiago1','Nicolas@gmail.commm','202cb962ac59075b964b07152d234b70',17),(79,'11/03/21',1,'thiago1','Nicolas@gmail.comwdadaw','202cb962ac59075b964b07152d234b70',17),(80,'11/03/21',1,'thiago1','Nicolas@gmail.commmdwa','202cb962ac59075b964b07152d234b70',17),(81,' 11/03/21 ',1,'thiago1',' Nicolas@gmail.com','9e2ea51c88cb50d60cbbff8d267cd93f',17),(82,' 11/03/21 ',1,'thiago1',' Nicolas@gmail.commm','9e2ea51c88cb50d60cbbff8d267cd93f',17),(83,'11/03/21',1,'thiago1','thiago@ex','202cb962ac59075b964b07152d234b70',17),(84,'11/03/21',1,'thiago1','thiago@ex','202cb962ac59075b964b07152d234b70',17),(85,'11/03/21',1,'thiago1','thiago@ex232','202cb962ac59075b964b07152d234b70',17),(86,'11/03/21',1,'thiago1','thiago@exemple222','202cb962ac59075b964b07152d234b70',17),(87,'11/03/21',1,'thiago1','thiago@exemple2221234','202cb962ac59075b964b07152d234b70',17),(88,'11/03/21',1,'maria','maria@example.com','827ccb0eea8a706c4c34a16891f84e7b',17),(89,'11/03/21',1,'joao','joao@example.com','caf1a3dfb505ffed0d024130f58c5cfa',19),(90,'11/03/21',1,'ana','ana@example.com','01cfcd4f6b8770febfb40cb906715822',20),(91,'11/03/21',1,'carlo','carlos@example.com','202cb962ac59075b964b07152d234b70',21),(92,'11/03/21',1,'lucas','lucas@example.com','caf1a3dfb505ffed0d024130f58c5cfa',23),(93,'2024-09-08',17,'thiago','heitorCruz@gmail.com','827ccb0eea8a706c4c34a16891f84e7b',17),(94,'12/32/32',1,'funciona','funciona@funciona','827ccb0eea8a706c4c34a16891f84e7b',17),(95,'2024-10-07',1,'finalboss','finalboss@gmail.com','01cfcd4f6b8770febfb40cb906715822',17);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-07 20:18:58
