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

/*Table structure for table `country_profile` */

DROP TABLE IF EXISTS `country_profile`;

CREATE TABLE `country_profile` (
  `profile_id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `currier_id` bigint(19) unsigned NOT NULL,
  `country_iso` varchar(20) DEFAULT NULL,
  `domestic` tinyint(1) DEFAULT '0',
  `intern_out` tinyint(1) DEFAULT '0',
  `intern_in` tinyint(1) DEFAULT '0',
  `hotline` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `partner_web` varchar(255) DEFAULT NULL,
  `user_name_p` varchar(255) DEFAULT NULL,
  `password_p` varchar(255) DEFAULT NULL,
  `custom_value` float DEFAULT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8303 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
