DROP TABLE IF EXISTS `lists`;

CREATE TABLE `lists` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `title` varchar(27) NOT NULL,
  `position` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `lists` */

insert  into `lists`(`id`,`title`,`position`,`isActive`) values (1,'profile_user_documents',1,1);

/*Table structure for table `lists_data` */

DROP TABLE IF EXISTS `lists_data`;

CREATE TABLE `lists_data` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_list` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT '1',
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `isActive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_list` (`id_list`),
  KEY `id_order` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `lists_data` */

insert  into `lists_data`(`id`,`id_list`,`position`,`title`,`isActive`) values (1,1,1,'Credit Card',1),(2,1,2,'ID',1),(3,1,3,'Passport',1),(4,1,4,'Travel Ticket',1),(5,1,5,'Hotel Reservation',1),(6,1,6,'Other Doc',1);

