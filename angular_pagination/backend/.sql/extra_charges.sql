
DROP TABLE IF EXISTS `extra_domestic_insurance`;

CREATE TABLE `extra_domestic_insurance` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(9) unsigned NOT NULL,
  `insurance_amount` int(9) DEFAULT NULL,
  `insurance_fee` int(9) DEFAULT NULL,
  `location` int(1) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

/*Table structure for table `extra_international_insurance` */

DROP TABLE IF EXISTS `extra_international_insurance`;

CREATE TABLE `extra_international_insurance` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(5) unsigned NOT NULL,
  `insurance_amount` int(9) DEFAULT NULL,
  `insurance_fee` int(9) DEFAULT NULL,
  `location` int(1) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

/*Table structure for table `extra_pickup_fee` */

DROP TABLE IF EXISTS `extra_pickup_fee`;

CREATE TABLE `extra_pickup_fee` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(5) unsigned NOT NULL,
  `domestic_basic` int(9) DEFAULT NULL,
  `domestic_express` int(9) NOT NULL,
  `international` int(9) DEFAULT NULL,
  `saturday_pickup` int(9) DEFAULT NULL,
  `saturday_delivery` int(9) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Table structure for table `extra_processing_fee` */

DROP TABLE IF EXISTS `extra_processing_fee`;

CREATE TABLE `extra_processing_fee` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `item_processing` int(9) DEFAULT NULL,
  `cruise_processing` int(9) DEFAULT NULL,
  `cancelation_fee` int(9) DEFAULT NULL,
  `country_id` int(9) unsigned NOT NULL,
  `date` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
