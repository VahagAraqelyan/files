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

/*Table structure for table `over_size_surcharge` */

DROP TABLE IF EXISTS `over_size_surcharge`;

CREATE TABLE `over_size_surcharge` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint(19) unsigned NOT NULL,
  `currier_id` bigint(19) unsigned NOT NULL,
  `per_lbs` int(11) DEFAULT '0',
  `min` int(11) DEFAULT '0',
  `max_lenght` int(11) DEFAULT '0',
  `max_weigth` int(11) DEFAULT '0',
  `sur_charge` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `over_size_surcharge` ADD COLUMN `type` INT(1) NULL COMMENT '0 - domestic, 1- international' AFTER `sur_charge`;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
