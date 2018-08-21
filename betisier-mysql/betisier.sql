-- MySQL dump 10.16  Distrib 10.1.23-MariaDB, for debian-linux-gnueabihf (armv7l)
--
-- Host: localhost    Database: betisier
-- ------------------------------------------------------
-- Server version	10.1.23-MariaDB-9+deb9u1

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

--
-- Current Database: `betisier`
--

/*!40000 DROP DATABASE IF EXISTS `betisier`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `betisier` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `betisier`;

--
-- Table structure for table `citation`
--

DROP TABLE IF EXISTS `citation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `citation` (
  `cit_num` int(11) NOT NULL AUTO_INCREMENT,
  `per_num` int(11) NOT NULL,
  `per_num_valide` int(11) DEFAULT NULL,
  `per_num_etu` int(11) NOT NULL,
  `cit_libelle` tinytext NOT NULL,
  `cit_date` date NOT NULL,
  `cit_valide` bit(1) NOT NULL DEFAULT b'0',
  `cit_date_valide` date DEFAULT NULL,
  `cit_date_depo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `citation_pk` (`cit_num`),
  KEY `est_auteur_fk` (`per_num`),
  KEY `valide_fk` (`per_num_valide`),
  KEY `depose_fk` (`per_num_etu`),
  CONSTRAINT `citation_ibfk_1` FOREIGN KEY (`per_num`) REFERENCES `personne` (`per_num`),
  CONSTRAINT `citation_ibfk_2` FOREIGN KEY (`per_num_valide`) REFERENCES `personne` (`per_num`),
  CONSTRAINT `citation_ibfk_3` FOREIGN KEY (`per_num_etu`) REFERENCES `etudiant` (`per_num`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citation`
--

LOCK TABLES `citation` WRITE;
/*!40000 ALTER TABLE `citation` DISABLE KEYS */;
INSERT INTO `citation` VALUES (1,55,1,53,'Tous les 4, vous commencez à me casser les pieds !!!','2015-10-03','','2015-10-23','2015-10-02 22:00:00'),(2,38,53,38,'Les notes, c\'est comme l\'eau : plus on pompe, plus ça monte','2015-10-24','\0','2015-10-24','2015-10-23 22:00:00'),(3,56,1,54,'C plus fort que toi','2015-10-19','','2015-10-19','2015-10-18 22:00:00'),(4,38,53,38,'Ce qui fait marcher l\'informatique, c\'est la fumée car lorsque la fumée sort du pc, plus rien ne fonctionne','2015-10-24','\0','2015-10-25','2015-10-25 22:00:00'),(19,55,55,3,'Et surtout notez bien ce que je viens d\'effacer !	\r\n							\r\n			','2015-11-04','','2018-04-11','2015-11-01 13:50:53'),(36,1,NULL,3,'Qu\'est ce qu\'il me baragouine ce loulou ? ','2015-11-04','\0',NULL,'2015-11-02 12:01:18');
/*!40000 ALTER TABLE `citation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departement`
--

DROP TABLE IF EXISTS `departement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departement` (
  `dep_num` int(11) NOT NULL AUTO_INCREMENT,
  `dep_nom` varchar(30) NOT NULL,
  `vil_num` int(11) NOT NULL,
  PRIMARY KEY (`dep_num`),
  KEY `vil_num` (`vil_num`),
  CONSTRAINT `departement_ibfk_1` FOREIGN KEY (`vil_num`) REFERENCES `ville` (`vil_num`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departement`
--

LOCK TABLES `departement` WRITE;
/*!40000 ALTER TABLE `departement` DISABLE KEYS */;
INSERT INTO `departement` VALUES (1,'Informatique',7),(2,'GEA',6),(3,'GEA',7),(4,'SRC',7),(5,'HSE',5),(6,'Génie civil',16);
/*!40000 ALTER TABLE `departement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `division`
--

DROP TABLE IF EXISTS `division`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `division` (
  `div_num` int(11) NOT NULL AUTO_INCREMENT,
  `div_nom` varchar(30) NOT NULL,
  PRIMARY KEY (`div_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `division`
--

LOCK TABLES `division` WRITE;
/*!40000 ALTER TABLE `division` DISABLE KEYS */;
INSERT INTO `division` VALUES (1,'Année 1'),(2,'Année 2'),(3,'Année Spéciale'),(4,'Licence Professionnelle');
/*!40000 ALTER TABLE `division` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etudiant` (
  `per_num` int(11) NOT NULL,
  `dep_num` int(11) NOT NULL,
  `div_num` int(11) NOT NULL,
  PRIMARY KEY (`per_num`),
  KEY `dep_num` (`dep_num`),
  KEY `div_num` (`div_num`),
  CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`per_num`) REFERENCES `personne` (`per_num`),
  CONSTRAINT `etudiant_ibfk_2` FOREIGN KEY (`dep_num`) REFERENCES `departement` (`dep_num`),
  CONSTRAINT `etudiant_ibfk_3` FOREIGN KEY (`div_num`) REFERENCES `division` (`div_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiant`
--

LOCK TABLES `etudiant` WRITE;
/*!40000 ALTER TABLE `etudiant` DISABLE KEYS */;
INSERT INTO `etudiant` VALUES (3,2,2),(38,6,1),(39,4,4),(53,1,1),(54,3,2),(58,1,2),(59,2,2),(64,2,1);
/*!40000 ALTER TABLE `etudiant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fonction`
--

DROP TABLE IF EXISTS `fonction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fonction` (
  `fon_num` int(11) NOT NULL AUTO_INCREMENT,
  `fon_libelle` varchar(30) NOT NULL,
  PRIMARY KEY (`fon_num`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fonction`
--

LOCK TABLES `fonction` WRITE;
/*!40000 ALTER TABLE `fonction` DISABLE KEYS */;
INSERT INTO `fonction` VALUES (1,'Directeur'),(2,'Chef de département'),(3,'Technicien'),(4,'Secrètaire'),(5,'Ingénieur'),(6,'Imprimeur'),(7,'Enseignant'),(8,'Chercheur');
/*!40000 ALTER TABLE `fonction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mot`
--

DROP TABLE IF EXISTS `mot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mot` (
  `mot_id` int(11) NOT NULL AUTO_INCREMENT,
  `mot_interdit` text NOT NULL,
  PRIMARY KEY (`mot_id`),
  FULLTEXT KEY `mot_interdit` (`mot_interdit`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mot`
--

LOCK TABLES `mot` WRITE;
/*!40000 ALTER TABLE `mot` DISABLE KEYS */;
INSERT INTO `mot` VALUES (1,'sexe'),(2,'merde'),(3,'toutou'),(4,'gestion'),(5,'mathématique');
/*!40000 ALTER TABLE `mot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personne`
--

DROP TABLE IF EXISTS `personne`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personne` (
  `per_num` int(11) NOT NULL AUTO_INCREMENT,
  `per_nom` varchar(30) NOT NULL,
  `per_prenom` varchar(30) NOT NULL,
  `per_tel` char(14) NOT NULL,
  `per_mail` varchar(30) NOT NULL,
  `per_admin` int(11) NOT NULL,
  `per_login` varchar(20) NOT NULL,
  `per_pwd` varchar(100) NOT NULL,
  PRIMARY KEY (`per_num`),
  UNIQUE KEY `per_login` (`per_login`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personne`
--

LOCK TABLES `personne` WRITE;
/*!40000 ALTER TABLE `personne` DISABLE KEYS */;
INSERT INTO `personne` VALUES (1,'Marley  ','Bob  ','0555555555','Bob@unilim.fr',0,'Bob ','2aa01d6e15df17ce5c07eb5e22052b06'),(3,'Duchemin    ','Paul    ','0555555554','paul.d@yahoo.fr',0,'Paul    ','2aa01d6e15df17ce5c07eb5e22052b06'),(38,'Michu  ','Marcel  ','0555555555','Michu@sfr.fr',0,'Marcel  ','2aa01d6e15df17ce5c07eb5e22052b06'),(39,'Renard ','Pierrot ','0655555555','Pierrot@gmail.fr',0,'sql ','2aa01d6e15df17ce5c07eb5e22052b06'),(53,'Delmas    ','Sophie    ','0789562314','Sophie@unilim.fr',0,'Soso','2aa01d6e15df17ce5c07eb5e22052b06'),(54,'Dupuy ','Pascale ','0554565859','pascale@free.fr',0,'Pascale ','2aa01d6e15df17ce5c07eb5e22052b06'),(55,'Chastagner       ','Michel       ','0555555555','Michel.C@yahoo.fr',1,'mc','2aa01d6e15df17ce5c07eb5e22052b06'),(56,'Monediere  ','Thierrry  ','0555555552','Th.mo@orange.fr',0,'TM  ','2aa01d6e15df17ce5c07eb5e22052b06'),(58,'Yves  ','Quentin  ','0555555550','Y.Q@hotmail.fr',0,'yves  ','2aa01d6e15df17ce5c07eb5e22052b06'),(59,'Lassont  ','Florian  ','0555555553','Florain.L@hotmail.fr',0,'florian  ','2aa01d6e15df17ce5c07eb5e22052b06'),(63,'Dumont ','Jacques ','0555555554','jacques.dumont@unilim.fr',0,'jd ','2aa01d6e15df17ce5c07eb5e22052b06'),(64,'Martin ','Martine ','0555555555','martine.martin@unilim.fr',0,'mm','2aa01d6e15df17ce5c07eb5e22052b06'),(67,'Beldonne','Isabelle','0555555554','Bel.isa@yahoo.fr',1,'riri','2aa01d6e15df17ce5c07eb5e22052b06');
/*!40000 ALTER TABLE `personne` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pwd`
--

DROP TABLE IF EXISTS `pwd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pwd` (
  `pwd_num` int(11) NOT NULL AUTO_INCREMENT,
  `pwd_libelle` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`pwd_num`)
) ENGINE=InnoDB AUTO_INCREMENT=369 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pwd`
--

LOCK TABLES `pwd` WRITE;
/*!40000 ALTER TABLE `pwd` DISABLE KEYS */;
INSERT INTO `pwd` VALUES (1,'111111'),(2,'11111111'),(3,'112233'),(4,'121212'),(5,'123123'),(6,'123456'),(7,'1234567'),(8,'12345678'),(9,'131313'),(10,'232323'),(11,'654321'),(12,'666666'),(13,'696969'),(14,'777777'),(15,'7777777'),(16,'8675309'),(17,'987654'),(18,'aaaaaa'),(19,'abc123'),(20,'abcdef'),(21,'abgrtyu'),(22,'access'),(23,'access14'),(24,'action'),(25,'albert'),(26,'alexis'),(27,'amanda'),(28,'amateur'),(29,'andrea'),(30,'andrew'),(31,'angela'),(32,'angels'),(33,'animal'),(34,'anthony'),(35,'apollo'),(36,'apples'),(37,'arsenal'),(38,'arthur'),(39,'asdfgh'),(40,'ashley'),(41,'august'),(42,'austin'),(43,'badboy'),(44,'bailey'),(45,'banana'),(46,'barney'),(47,'baseball'),(48,'batman'),(49,'beaver'),(50,'beavis'),(51,'bigdaddy'),(52,'bigdog'),(53,'birdie'),(54,'bitches'),(55,'biteme'),(56,'blazer'),(57,'blonde'),(58,'blondes'),(59,'bond007'),(60,'bonnie'),(61,'booboo'),(62,'booger'),(63,'boomer'),(64,'boston'),(65,'brandon'),(66,'brandy'),(67,'braves'),(68,'brazil'),(69,'bronco'),(70,'broncos'),(71,'bulldog'),(72,'buster'),(73,'butter'),(74,'butthead'),(75,'calvin'),(76,'camaro'),(77,'cameron'),(78,'canada'),(79,'captain'),(80,'carlos'),(81,'carter'),(82,'casper'),(83,'charles'),(84,'charlie'),(85,'cheese'),(86,'chelsea'),(87,'chester'),(88,'chicago'),(89,'chicken'),(90,'cocacola'),(91,'coffee'),(92,'college'),(93,'compaq'),(94,'computer'),(95,'cookie'),(96,'cooper'),(97,'corvette'),(98,'cowboy'),(99,'cowboys'),(100,'crystal'),(101,'dakota'),(102,'dallas'),(103,'daniel'),(104,'danielle'),(105,'debbie'),(106,'dennis'),(107,'diablo'),(108,'diamond'),(109,'doctor'),(110,'doggie'),(111,'dolphin'),(112,'dolphins'),(113,'donald'),(114,'dragon'),(115,'dreams'),(116,'driver'),(117,'eagle1'),(118,'eagles'),(119,'edward'),(120,'einstein'),(121,'erotic'),(122,'extreme'),(123,'falcon'),(124,'fender'),(125,'ferrari'),(126,'firebird'),(127,'fishing'),(128,'florida'),(129,'flower'),(130,'flyers'),(131,'football'),(132,'forever'),(133,'freddy'),(134,'freedom'),(135,'gandalf'),(136,'gateway'),(137,'gators'),(138,'gemini'),(139,'george'),(140,'giants'),(141,'ginger'),(142,'golden'),(143,'golfer'),(144,'gordon'),(145,'gregory'),(146,'guitar'),(147,'gunner'),(148,'hammer'),(149,'hannah'),(150,'hardcore'),(151,'harley'),(152,'heather'),(153,'helpme'),(154,'hockey'),(155,'hooters'),(156,'horney'),(157,'hotdog'),(158,'hunter'),(159,'hunting'),(160,'iceman'),(161,'iloveyou'),(162,'internet'),(163,'IUTIUT'),(164,'iwantu'),(165,'jackie'),(166,'jackson'),(167,'jaguar'),(168,'jasmine'),(169,'jasper'),(170,'jennifer'),(171,'jeremy'),(172,'jessica'),(173,'johnny'),(174,'johnson'),(175,'jordan'),(176,'joseph'),(177,'joshua'),(178,'junior'),(179,'justin'),(180,'killer'),(181,'knight'),(182,'ladies'),(183,'lakers'),(184,'lauren'),(185,'leather'),(186,'legend'),(187,'letmein'),(188,'little'),(189,'london'),(190,'lovers'),(191,'maddog'),(192,'madison'),(193,'maggie'),(194,'magnum'),(195,'marine'),(196,'marlboro'),(197,'martin'),(198,'marvin'),(199,'master'),(200,'matrix'),(201,'matthew'),(202,'maverick'),(203,'maxwell'),(204,'melissa'),(205,'member'),(206,'mercedes'),(207,'merlin'),(208,'michael'),(209,'michelle'),(210,'mickey'),(211,'midnight'),(212,'miller'),(213,'mistress'),(214,'monica'),(215,'monkey'),(216,'monster'),(217,'morgan'),(218,'mother'),(219,'mountain'),(220,'muffin'),(221,'murphy'),(222,'mustang'),(223,'naked'),(224,'nascar'),(225,'nathan'),(226,'naughty'),(227,'ncc1701'),(228,'newyork'),(229,'nicholas'),(230,'nicole'),(231,'nipple'),(232,'nipples'),(233,'oliver'),(234,'orange'),(235,'packers'),(236,'panther'),(237,'panties'),(238,'parker'),(239,'password'),(240,'password1'),(241,'password12'),(242,'password123'),(243,'patrick'),(244,'peaches'),(245,'peanut'),(246,'pepper'),(247,'phantom'),(248,'phoenix'),(249,'player'),(250,'please'),(251,'pookie'),(252,'porsche'),(253,'prince'),(254,'princess'),(255,'private'),(256,'purple'),(257,'pussies'),(258,'qazwsx'),(259,'qwerty'),(260,'qwertyui'),(261,'rabbit'),(262,'rachel'),(263,'racing'),(264,'raiders'),(265,'rainbow'),(266,'ranger'),(267,'rangers'),(268,'rebecca'),(269,'redskins'),(270,'redsox'),(271,'redwings'),(272,'richard'),(273,'robert'),(274,'rocket'),(275,'rosebud'),(276,'runner'),(277,'rush2112'),(278,'russia'),(279,'samantha'),(280,'sammy'),(281,'samson'),(282,'sandra'),(283,'saturn'),(284,'scooby'),(285,'scooter'),(286,'scorpio'),(287,'scorpion'),(288,'secret'),(289,'sexsex'),(290,'shadow'),(291,'shannon'),(292,'shaved'),(293,'sierra'),(294,'silver'),(295,'skippy'),(296,'slayer'),(297,'smokey'),(298,'snoopy'),(299,'soccer'),(300,'sophie'),(301,'spanky'),(302,'sparky'),(303,'spider'),(304,'squirt'),(305,'srinivas'),(306,'startrek'),(307,'starwars'),(308,'steelers'),(309,'steven'),(310,'sticky'),(311,'stupid'),(312,'success'),(313,'summer'),(314,'sunshine'),(315,'superman'),(316,'surfer'),(317,'swimming'),(318,'sydney'),(319,'taylor'),(320,'tennis'),(321,'teresa'),(322,'tester'),(323,'testing'),(324,'theman'),(325,'thomas'),(326,'thunder'),(327,'thx1138'),(328,'tiffany'),(329,'tigers'),(330,'tigger'),(331,'tomcat'),(332,'topgun'),(333,'TOUTOU'),(334,'toyota'),(335,'travis'),(336,'trouble'),(337,'trustno1'),(338,'tucker'),(339,'turtle'),(340,'twitter'),(341,'united'),(342,'vagina'),(343,'victor'),(344,'victoria'),(345,'viking'),(346,'voodoo'),(347,'voyager'),(348,'walter'),(349,'warrior'),(350,'welcome'),(351,'whatever'),(352,'william'),(353,'willie'),(354,'wilson'),(355,'winner'),(356,'winston'),(357,'winter'),(358,'wizard'),(359,'xavier'),(360,'xxxxxx'),(361,'xxxxxxxx'),(362,'yamaha'),(363,'yankee'),(364,'yankees'),(365,'yellow'),(366,'zxcvbn'),(367,'zxcvbnm'),(368,'zzzzzz');
/*!40000 ALTER TABLE `pwd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salarie`
--

DROP TABLE IF EXISTS `salarie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salarie` (
  `per_num` int(11) NOT NULL,
  `sal_telprof` varchar(20) NOT NULL,
  `fon_num` int(11) NOT NULL,
  PRIMARY KEY (`per_num`),
  KEY `fon_num` (`fon_num`),
  CONSTRAINT `salarie_ibfk_1` FOREIGN KEY (`per_num`) REFERENCES `personne` (`per_num`),
  CONSTRAINT `salarie_ibfk_2` FOREIGN KEY (`fon_num`) REFERENCES `fonction` (`fon_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salarie`
--

LOCK TABLES `salarie` WRITE;
/*!40000 ALTER TABLE `salarie` DISABLE KEYS */;
INSERT INTO `salarie` VALUES (1,'0123456978',4),(55,'0654237865',7),(56,'0654237864',8),(63,'0654237860',2),(67,'0654237860',2);
/*!40000 ALTER TABLE `salarie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ville`
--

DROP TABLE IF EXISTS `ville`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ville` (
  `vil_num` int(11) NOT NULL AUTO_INCREMENT,
  `vil_nom` varchar(100) NOT NULL,
  PRIMARY KEY (`vil_num`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ville`
--

LOCK TABLES `ville` WRITE;
/*!40000 ALTER TABLE `ville` DISABLE KEYS */;
INSERT INTO `ville` VALUES (5,'Tulle'),(6,'Brive'),(7,'Limoges'),(8,'Guéret'),(9,'Périgueux'),(10,'Bordeaux'),(11,'Paris'),(12,'Toulouse'),(13,'Lyon'),(14,'Poitiers'),(15,'Ambazac'),(16,'Egletons');
/*!40000 ALTER TABLE `ville` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote` (
  `cit_num` int(11) NOT NULL,
  `per_num` int(11) NOT NULL,
  `vot_valeur` int(11) NOT NULL,
  PRIMARY KEY (`cit_num`,`per_num`),
  KEY `vote_ibfk_3` (`per_num`),
  CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`cit_num`) REFERENCES `citation` (`cit_num`),
  CONSTRAINT `vote_ibfk_3` FOREIGN KEY (`per_num`) REFERENCES `etudiant` (`per_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote`
--

LOCK TABLES `vote` WRITE;
/*!40000 ALTER TABLE `vote` DISABLE KEYS */;
INSERT INTO `vote` VALUES (1,38,15),(2,39,8),(3,3,20),(3,38,2),(3,54,20),(4,39,12),(19,3,20);
/*!40000 ALTER TABLE `vote` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-19 15:57:25
