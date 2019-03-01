/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.7.14 : Database - laravel_search
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`laravel_search` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `laravel_search`;

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `files` */

insert  into `files`(`id`,`name`,`image`) values (1,'phone','avatars/6BCkJGQsY8FNyGg34EbASd7a8KsKO2DusnrHn8gK.png'),(2,'phone','avatars/6p8po32D4FWd0HvnTgFYHIqa6BlE7zGCQLPw3Rsd.txt'),(3,'phone','avatars/uLGAs25jZXuj8nOppWwyUCdyayJ2zViPUSVGoyTI.png'),(4,'ASD','avatars/VUkwdexXR3cjhjpeMFfY6ymWE9TaiP1YKXg0GtI3.jpeg');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
