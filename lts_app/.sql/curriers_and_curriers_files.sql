/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.7.14 : Database - cn_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cn_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `cn_db`;

/*Table structure for table `curriers_files` */

DROP TABLE IF EXISTS `curriers_files`;

CREATE TABLE `curriers_files` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint(19) unsigned DEFAULT NULL,
  `currier_id` bigint(19) unsigned DEFAULT NULL,
  `type` int(1) NOT NULL COMMENT '1 - international, 2 - domestic',
  `name` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `lts_currier` */

DROP TABLE IF EXISTS `lts_currier`;

CREATE TABLE `lts_currier` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `currier_name` varchar(255) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
