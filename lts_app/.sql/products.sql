/*
SQLyog Community v12.3.3 (64 bit)
MySQL - 5.7.14 : Database - luggage2ship
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`luggage2ship` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `luggage2ship`;

/*Table structure for table `luggage_product` */

DROP TABLE IF EXISTS `luggage_product`;

CREATE TABLE `luggage_product` (
  `product_id` int(250) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(250) unsigned DEFAULT NULL,
  `luggage_name` varchar(255) DEFAULT NULL,
  `max_count` int(10) DEFAULT NULL,
  `length` int(4) DEFAULT NULL,
  `width` int(4) DEFAULT NULL,
  `height` int(4) DEFAULT NULL,
  `weight` int(4) DEFAULT NULL,
  `li_class` varchar(255) DEFAULT NULL,
  `image_class` varchar(255) DEFAULT NULL,
  `calc_length` int(4) DEFAULT NULL,
  `calc_width` int(4) DEFAULT NULL,
  `calc_height` int(4) DEFAULT NULL,
  KEY `id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `luggage_type` */

DROP TABLE IF EXISTS `luggage_type`;

CREATE TABLE `luggage_type` (
  `id` int(250) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) DEFAULT NULL,
  `type_icon_class` varchar(255) DEFAULT NULL,
  `ul_class` varchar(255) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `prod_domestic_fee` */

DROP TABLE IF EXISTS `prod_domestic_fee`;

CREATE TABLE `prod_domestic_fee` (
  `domestic_id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `luggage_id` int(3) DEFAULT NULL,
  `country_id` int(4) DEFAULT NULL,
  `charge_weight` int(4) DEFAULT NULL,
  `domestic_express` int(4) DEFAULT NULL,
  `domestic_basic` int(4) DEFAULT NULL,
  `domestic_pattern` int(4) DEFAULT NULL,
  KEY `id` (`domestic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

/*Table structure for table `prod_international_fee` */

DROP TABLE IF EXISTS `prod_international_fee`;

CREATE TABLE `prod_international_fee` (
  `international_id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `currier_id` int(4) DEFAULT NULL,
  `luggage_id` int(3) DEFAULT NULL,
  `country_id` int(4) DEFAULT NULL,
  `international_fee` int(4) DEFAULT NULL,
  `international_pattern` int(4) DEFAULT NULL,
  KEY `id` (`international_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
