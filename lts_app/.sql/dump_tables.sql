DROP TABLE IF EXISTS `captcha`;

CREATE TABLE `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` bigint(19) unsigned NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=MyISAM AUTO_INCREMENT=894 DEFAULT CHARSET=utf8;

/*Data for the table `captcha` */

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `groups` */

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `login_attempts` */

/*Table structure for table `lts_country` */

DROP TABLE IF EXISTS `lts_country`;

CREATE TABLE `lts_country` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) DEFAULT NULL,
  `iso2` varchar(5) DEFAULT NULL,
  `iso3` varchar(5) DEFAULT NULL,
  `calling_code` varchar(9) DEFAULT NULL,
  `SortOrder` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=239 DEFAULT CHARSET=utf8;

/*Data for the table `lts_country` */

insert  into `lts_country`(`id`,`country`,`iso2`,`iso3`,`calling_code`,`SortOrder`,`status`) values (1,'Afghanistan','AF','AFG','',0,1),(2,'Albania','AL','ALB','',0,1),(3,'Algeria','DZ','DZA','',0,1),(4,'American Samoa','AS','ASM','',0,1),(5,'Andorra','AD','AND','',0,1),(6,'Angola','AO','AGO','',0,1),(7,'Anguilla','AI','AIA','',0,1),(8,'Antarctica','AQ','ATA','',0,1),(9,'Antigua & Barbuda','AG','ATG','',0,1),(10,'Argentina','AR','ARG','',0,1),(11,'Armenia','AM','ARM','',0,1),(12,'Aruba','AW','ABW','',0,1),(13,'Australia','AU','AUS','',0,1),(14,'Austria','AT','AUT','',0,1),(15,'Azerbaijan','AZ','AZE','',0,1),(16,'Bahamas','BS','BHS','',0,1),(17,'Bahrain','BH','BHR','',0,1),(18,'Bangladesh','BD','BGD','',0,1),(19,'Barbados','BB','BRB','',0,1),(20,'Belarus','BY','BLR','',0,1),(21,'Belgium','BE','BEL','',0,1),(22,'Belize','BZ','BLZ','',0,1),(23,'Benin','BJ','BEN','',0,1),(24,'Bermuda','BM','BMU','',0,1),(25,'Bhutan','BT','BTN','',0,1),(26,'Bolivia','BO','BOL','',0,1),(27,'Bosnia-Herzegovina','BA','BIH','',0,1),(28,'Botswana','BW','BWA','',0,1),(29,'Brazil','BR','BRA','',0,1),(30,'British Virgin Islands','VG','VGB','',0,1),(31,'Brunei','BN','BRN','',0,1),(32,'Bulgaria','BG','BGR','',0,1),(33,'Burkina Faso','BF','BFA','',0,1),(34,'Burundi','BI','BDI','',0,1),(35,'Cambodia','KH','KHM','',0,1),(36,'Cameroon','CM','CMR','',0,1),(37,'Canada','CA','CAN','',1,1),(38,'Cape Verde','CV','CPV','',0,1),(39,'Cayman Islands','KY','CYM','',0,1),(40,'Central Africa','CF','CAF','',0,1),(41,'Chadf','','','',0,0),(42,'Chile','CL','CHL','',0,1),(43,'China','CN','CHN','',0,1),(44,'Colombia','CO','COL','',0,1),(45,'Comoros','KM','COM','',0,1),(46,'Congo','CG','COG','',0,1),(47,'Congo (Dem. Rep.)','','','',0,0),(48,'Cook Islands','CK','COK','',0,1),(49,'Costa Rica','CR','CRI','',0,1),(50,'Croatia','HR','HRV','',0,1),(51,'Cuba','CU','CUB','',0,1),(52,'Cyprus','CY','CYP','',0,1),(53,'Czech Republic','CZ','CZE','',0,1),(54,'Denmark','DK','DNK','',0,1),(55,'Djibouti','DJ','DJI','',0,1),(56,'Dominica','DM','DMA','',0,1),(57,'Dominican Republic','DO','DOM','',0,1),(58,'East Timor','','','',0,0),(59,'Ecuador','EC','ECU','',0,1),(60,'Egypt','EG','EGY','',0,1),(61,'El Salvador','SV','SLV','',0,1),(62,'Equatorial Guinea','GQ','GNQ','',0,1),(63,'Eritrea','ER','ERI','',0,1),(64,'Estonia','EE','EST','',0,1),(65,'Ethiopia','ET','ETH','',0,1),(66,'External Territories of Australia','','','',0,0),(67,'Falkland Islands and dependencies','','','',0,0),(68,'Faroe Islands','FO','FRO','',0,1),(69,'Fiji','FJ','FJI','',0,1),(70,'Finland','FI','FIN','',0,1),(71,'France','FR','FRA','',0,1),(72,'French Guiana','GF','GUF','',0,1),(73,'French Polynesia','PF','PYF','',0,1),(74,'Gabon','GA','GAB','',0,1),(75,'Gambia','GM','GMB','',0,1),(76,'Georgia','GE','GEO','',0,1),(77,'Germany','DE','DEU','',0,1),(78,'Ghana','GH','GHA','',0,1),(79,'Gibraltar','GI','GIB','',0,1),(80,'Greece','GR','GRC','',0,1),(81,'Greenland','GL','GRL','',0,1),(82,'Grenada','GD','GRD','',0,1),(83,'Guadeloupe','','','',0,0),(84,'Guam','GU','GUM','',0,1),(85,'Guatemala','GT','GTM','',0,1),(86,'Guernsey and Alderney','','','',0,0),(87,'Guinea','GN','GIN','',0,1),(88,'Guinea Bissau','GW','GNB','',0,1),(89,'Guyana','GY','GUY','',0,1),(90,'Haiti','HT','HTI','',0,1),(91,'Honduras','HN','HND','',0,1),(92,'Hungary','HU','HUN','',0,1),(93,'Iceland','IS','ISL','',0,1),(94,'India','IN','IND','+91',0,1),(95,'Indonesia','ID','IDN','',0,1),(96,'Iran','IR','IRN','',0,1),(97,'Iraq','IQ','IRQ','',0,1),(98,'Ireland','IE','IRL','',0,1),(99,'Israel','IL','ISR','',0,1),(100,'Italy','IT','ITA','',0,1),(101,'Ivory Coast','','','',0,0),(102,'Jamaica','JM','JAM','',0,1),(103,'Japan','JP','JPN','',0,1),(104,'Jersey','JE','JEY','',0,1),(105,'Jordan','JO','JOR','',0,1),(106,'Kazakhstan','KZ','KAZ','',0,1),(107,'Kenya','KE','KEN','',0,1),(108,'Kiribati','KI','KIR','',0,1),(109,'Korea (North)','KP','PRK','',0,1),(110,'Korea (South)','KR','KOR','',0,1),(111,'Kuwait','KW','KWT','',0,1),(112,'Kyrgyzstan','KG','KGZ','',0,1),(113,'Laos','LA','LAO','',0,1),(114,'Latvia','LV','LVA','',0,1),(115,'Lebanon','LB','LBN','',0,1),(116,'Lesotho','LS','LSO','',0,1),(117,'Liberia','LR','LBR','',0,1),(118,'Libya','LY','LBY','',0,1),(119,'Liechtenstein','LI','LIE','',0,1),(120,'Lithuania','LT','LTU','',0,1),(121,'Luxembourg','LU','LUX','',0,1),(122,'Macedonia','MK','MKD','',0,1),(123,'Madagascar','MG','MDG','',0,1),(124,'Malawi','MW','MWI','',0,1),(125,'Malaysia','MY','MYS','',0,1),(126,'Maldives','MV','MDV','',0,1),(127,'Mali','ML','MLI','',0,1),(128,'Malta','MT','MLT','',0,1),(129,'Man (Isle of)','','','',0,0),(130,'Marshall Islands','MH','MHL','',0,1),(131,'Martinique','MQ','MTQ','',0,1),(132,'Mauritania','MR','MRT','',0,1),(133,'Mauritius','MU','MUS','',0,1),(134,'Mayotte','YT','MYT','',0,1),(135,'Mexico','MX','MEX','',0,1),(136,'Micronesia','FM','FSM','',0,1),(137,'Moldova','','','',0,0),(138,'Monaco','MC','MCO','',0,1),(139,'Mongolia','MN','MNG','',0,1),(140,'Montserrat','MS','MSR','',0,1),(141,'Morocco','MA','MAR','',0,1),(142,'Mozambique','MZ','MOZ','',0,1),(143,'Myanmar','','','',0,0),(144,'Namibia','NA','NAM','',0,1),(145,'Nauru','NR','NRU','',0,1),(146,'Nepal','NP','NPL','',0,1),(147,'Netherlands','NL','NLD','',0,1),(148,'Netherlands Antilles','','','',0,0),(149,'New Caledonia','NC','NCL','',0,1),(150,'New Zealand','NZ','NZL','',0,1),(151,'Nicaragua','NI','NIC','',0,1),(152,'Niger','NE','NER','',0,1),(153,'Nigeria','NG','NGA','',0,1),(154,'Niue','NU','NIU','',0,1),(155,'Norfolk','','','',0,0),(156,'Northern Mariana Islands','MP','MNP','',0,1),(157,'Norway','NO','NOR','',0,1),(158,'Oman','OM','OMN','',0,1),(159,'Pakistan','PK','PAK','',0,1),(160,'Palau','PW','PLW','',0,1),(161,'Palestine','PS','PSE','',0,1),(162,'Panama','PA','PAN','',0,1),(163,'Papua New Guinea','PG','PNG','',0,1),(164,'Paraguay','PY','PRY','',0,1),(165,'Peru','PE','PER','',0,1),(166,'Philippines','PH','PHL','',0,1),(167,'Poland','PL','POL','',0,1),(168,'Portugal','PT','PRT','',0,1),(169,'Puerto Rico','PR','PRI','',0,1),(170,'Qatar','QA','QAT','',0,1),(171,'Reunion','RE','REU','',0,1),(172,'Romania','RO','ROU','',0,1),(173,'Russia','RU','RUS','',0,1),(174,'Rwanda','RW','RWA','',0,1),(175,'Sahara','','','',0,0),(176,'Saint Helena','SH','SHN','',0,1),(177,'Saint Kitts and Nevis','KN','KNA','',0,1),(178,'Saint Lucia','LC','LCA','',0,1),(179,'Saint Pierre & Miquelon','PM','SPM','',0,1),(180,'Saint Vincent and the Grenadines','VC','VCT','',0,1),(181,'Samoa','WS','WSM','',0,1),(182,'San Marino','SM','SMR','',0,1),(183,'Sao Tome and Principe','ST','STP','',0,1),(184,'Saudi Arabia','SA','SAU','',0,1),(185,'Senegal','SN','SEN','',0,1),(186,'Serbia and Montenegro','','','',0,0),(187,'Seychelles','SC','SYC','',0,1),(188,'Sierra Leone','SL','SLE','',0,1),(189,'Singapore','SG','SGP','',0,1),(190,'Slovakia','SK','SVK','',0,1),(191,'Slovenia','SI','SVN','',0,1),(192,'Smaller Territories of Chile','','','',0,0),(193,'Smaller Territories of Norway','','','',0,0),(194,'Smaller Territories of the UK','','','',0,0),(195,'Smaller Territories of the US','','','',0,0),(196,'Solomon Islands','SB','SLB','',0,1),(197,'Somalia','SO','SOM','',0,1),(198,'South Africa','ZA','ZAF','',0,1),(199,'Spain','ES','ESP','',0,1),(200,'Sri Lanka','LK','LKA','',0,1),(201,'Sudan','SD','SDN','',0,1),(202,'Suriname','SR','SUR','',0,1),(203,'Svalbard and Jan Mayen','SJ','SJM','',0,1),(204,'Swaziland','SZ','SWZ','',0,1),(205,'Sweden','SE','SWE','',0,1),(206,'Switzerland','CH','CHE','',0,1),(207,'Syria','SY','SYR','',0,1),(208,'Taiwan','TW','TWN','',0,1),(209,'Tajikistan','TJ','TJK','',0,1),(210,'Tanzania','TZ','TZA','',0,1),(211,'Terres Australes','','','',0,0),(212,'Thailand','TH','THA','',0,1),(213,'Tago','','','',0,0),(214,'Tokelau','TK','TKL','',0,1),(215,'Tonga','TO','TON','',0,1),(216,'Trinidad and Tobago','TT','TTO','',0,1),(217,'Tunisia','TN','TUN','',0,1),(218,'Turkey','TR','TUR','',0,1),(219,'Turkmenistan','TM','TKM','',0,1),(220,'Turks and Caicos Islands','TC','TCA','',0,1),(221,'Tuvalu','TV','TUV','',0,1),(222,'Uganda','UG','UGA','',0,1),(223,'Ukraine','UA','UKR','',0,1),(224,'United Arab Emirates','AE','ARE','',0,1),(225,'United Kingdom','GB','GBR','',0,1),(226,'United States (USA)','US','USA','+1',2,1),(227,'Uruguay','UY','URY','',0,1),(228,'Uzbekistan','UZ','UZB','',0,1),(229,'Vanuatu','VU','VUT','',0,1),(230,'Vatican','VA','VAT','',0,1),(231,'Venezuela','VE','VEN','',0,1),(232,'Vietnam','VN','VNM','',0,1),(233,'Virgin Islands of the United States','VI','VIR','',0,1),(234,'Wallis & Futuna','WF','WLF','',0,1),(235,'Yemen','YE','YEM','',0,1),(236,'Zambia','ZM','ZMB','',0,1),(237,'Zimbabwe','ZW','ZWE','',0,1),(238,'Hong Kong','HK','HK','+852',0,1);

/*Table structure for table `lts_usa_zipcode` */

DROP TABLE IF EXISTS `lts_usa_zipcode`;

CREATE TABLE `lts_usa_zipcode` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `zip` bigint(19) NOT NULL,
  `primary_city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `full_state` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83510 DEFAULT CHARSET=utf8;

/*Data for the table `lts_usa_zipcode` */


/*Table structure for table `users_groups` */

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `country` varchar(255) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `users_groups` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;