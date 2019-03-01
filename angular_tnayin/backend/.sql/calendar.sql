

DROP TABLE IF EXISTS `holidays_calendar`;

CREATE TABLE `holidays_calendar` (
  `country_id` int(9) DEFAULT NULL,
  `day` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `weekends_calendar` */

DROP TABLE IF EXISTS `weekends_calendar`;

CREATE TABLE `weekends_calendar` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `mon` tinyint(4) DEFAULT NULL,
  `tue` tinyint(4) DEFAULT NULL,
  `wed` tinyint(4) DEFAULT NULL,
  `thu` tinyint(4) DEFAULT NULL,
  `fri` tinyint(4) DEFAULT NULL,
  `sat` tinyint(4) DEFAULT NULL,
  `sun` tinyint(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
