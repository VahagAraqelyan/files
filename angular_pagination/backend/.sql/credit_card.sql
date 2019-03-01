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

/*Table structure for table `users_credit_cards` */

DROP TABLE IF EXISTS `users_credit_cards`;

CREATE TABLE `users_credit_cards` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `holder_first_name` varchar(255) DEFAULT NULL,
  `holder_last_name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `card_number` bigint(20) DEFAULT NULL,
  `exp_mounth` int(2) DEFAULT NULL,
  `exp_year` int(4) DEFAULT NULL,
  `security_code` int(4) unsigned DEFAULT NULL,
  `country_id` bigint(19) unsigned DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state_id` bigint(19) unsigned DEFAULT NULL,
  `zip_code` int(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `card_num` int(1) DEFAULT NULL,
  `user_id` bigint(19) unsigned DEFAULT NULL,
  `ver_status` int(1) DEFAULT NULL,
  `card_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
