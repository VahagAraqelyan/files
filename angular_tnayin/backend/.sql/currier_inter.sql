

DROP TABLE IF EXISTS `currier_comment`;

CREATE TABLE `currier_comment` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(9) unsigned NOT NULL,
  `type` int(1) DEFAULT NULL COMMENT '0-international, 1-domestic',
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `international_doc_files` */

DROP TABLE IF EXISTS `international_doc_files`;

CREATE TABLE `international_doc_files` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(9) unsigned DEFAULT NULL,
  `doc_type_id` int(5) unsigned DEFAULT NULL,
  `show_doc_name` varchar(255) DEFAULT NULL,
  `doc_file_name` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
